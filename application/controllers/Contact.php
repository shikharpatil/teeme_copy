<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ ?><?php
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: Contact.php
	* Description 		  	: A class file used to show the Contact list.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/discussionManager.php,views/login.php,views/Discussion.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 7-12-2008				Vinaykant Sahu						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to show the  Contact list
* @author   Ideavate Solutions (www.ideavate.com)
*/ 
class Contact extends CI_Controller {

	function Contact()
	{
		parent::__Construct();	
	}
	
	function index($treeId=0)
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
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();
					
			$this->load->model('dal/contact_list');		
				
			$userId	= $_SESSION['userId'];	
			$workSpaceId = $this->uri->segment(4);	
			$workSpaceType = $this->uri->segment(6);
			$placeType=$workSpaceType+2;
			
			$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
			/*<!-- Added By Surbhi IV-->*/
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
				$_SESSION['sortBy'] 	= 4;
			}
			/*<!--End of Added By Surbhi IV-->*/
			/*<!--Changed By Surbhi IV-->*/	
			$arrTree['contact_list'] = $this->contact_list->getContectList($workSpaceId, $workSpaceType,$userId,$_SESSION['sortBy'],$_SESSION['sortOrder']);
			/*<!--End of Changed By Surbhi IV-->*/	
			$arrTree['manager']=$rs;
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
			$arrTree['treeId'] =$treeId;
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('contact/contact_for_mobile', $arrTree);
			}
			else
			{
				$this->load->view('contact/contact', $arrTree);
			}	
		}
	}
	function contactDetails($treeId)
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
			$objIdentity = $this->identity_db_manager;
			$this->load->model('dal/time_manager');	
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/discussion_db_manager');	
			$this->load->model('dal/notes_db_manager');
			$this->load->model('dal/contact_list');	
			$userId = $_SESSION['userId'];
			$workSpaceId = $this->uri->segment(4);		
			$workSpaceType = $this->uri->segment(6);
			
			//Space tree type code start
			$spaceNameDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			if ($workSpaceId!=0 && $spaceNameDetails['workSpaceName']!='Try Teeme')
			{
				$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('5',$workSpaceId);
				if($treeTypeStatus==1)
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
				}
			}
			//Space tree type code end
			
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));	*/
				//Manoj: get memcache object
				$memc=$objIdentity->createMemcacheObject();
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'contact'.$treeId;	
				
				$memc->delete($memCacheId); 
				$value = $memc->get( $memCacheId );
				
				
				if(!$value)
				{	
					$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

					$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
					$value = $memc->get($memCacheId);
			
						if ($value == '')
						{
							$value = $contactNotes;
						}
				}
								
				if ($value)
				{	
				
					// tempary code //
					$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,$workSpaceId, $workSpaceType);		

					$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
					$value = $memc->get($memCacheId);
			
						if ($value == '')
						{
							$value = $contactNotes;
						}
					// tempary code //	
					$arrTree['ContactNotes'] = $value;				
				}
	
		$arrTree['Contactdetail'] = $this->contact_list->getlatestContactDetails($treeId);
		
			/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
			
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3) && $arrTree['Contactdetail']['sharedStatus']!=1)
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && $arrTree['Contactdetail']['sharedStatus']!=1)
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
			
			/*Added by Dashrath- used for update session value for show share icon green*/
			if ($workSpaceId==0)
			{
				$this->load->model('dal/identity_db_manager');
				$this->identity_db_manager->updateSharedTreeStatusSession($treeId);
			}
			/*Dashrath- code end*/
		
		//Edit Autonumbering
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
		
		$arrTree['workSpaceId'] = $this->uri->segment(4);		
		$arrTree['workSpaceType'] = $this->uri->segment(6);
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
		
		$arrTree['treeId'] = $treeId;
		$arrTree['position']=1;
		//$arrTree['countryDetails'] 		= $this->identity_db_manager->getCountries();
		
		$arrTree['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
		
		$arrTree['originator'] = $objIdentity->getUserDetailsByUserId($arrTree['Contactdetail']['userId']);
		
		$arrTree['treeDetail'] = $this->notes_db_manager->getNotes($treeId);
		
		$this->load->model("dal/document_db_manager");
		$this->load->model("dal/chat_db_manager");
		$arrTree['contactContributors']	= $this->document_db_manager->getLeafAuthorsByLeafIds($treeId);

		
		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);		
				
		if($this->uri->segment(7) == 2)
		{
			$arrTree['ContactNotes'] = $this->contact_list->getlatestContactNote($treeId);
			
			//arun-  start  code for sorting
				
				//Sorting array by diffrence 
				foreach ($arrTree['ContactNotes'] as $key => $row)
				{
					$diff[$key]  = $row['orderingDate'];
				}
	
				
				array_multisort($diff,SORT_DESC,$arrTree['ContactNotes']);
		
				//arun- end code of sorting
			if($_COOKIE['ismobile'])
			{
			  $this->load->view('contact/contact_details_calendar_for_mobile', $arrTree);		
			}	
			else
			{
			   $this->load->view('contact/contact_details_calendar', $arrTree);
			}   
		}
		else if($this->uri->segment(7) == 3)
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
				if($_GET['ajax'])
				{
				   	$this->load->view('contact/view_tag_leaves_for_mobile', $arrDiscussionViewPage);
			    }
				else
				{
			    	$this->load->view('contact/contact_details_tag_for_mobile', $arrTree);		
				}
			}	
			else
			{		
			   if($_GET['ajax']){
				   	$this->load->view('contact/view_tag_leaves', $arrDiscussionViewPage);
			   }
			   else{
					$this->load->view('contact/contact_details_tag', $arrTree);
			   }
			}  
		}
		else if($this->uri->segment(7) == 4)
		{
			if($_COOKIE['ismobile'])
			{
			  $this->load->view('contact/contact_details_link_for_mobile', $arrTree);		
			}	
			else
			{
			  $this->load->view('contact/contact_details_link', $arrTree);
			}  
		}
		else if($this->uri->segment(7) == 5)
		{
		    if($_COOKIE['ismobile'])
			{
			  $this->load->view('contact/contact_details_share_for_mobile', $arrTree);		
			}	
			else
			{	
			   $this->load->view('contact/contact_details_share', $arrTree);
			}   
		}
		else if($this->uri->segment(7) == 7)
		{
			$talkDetails=$this->identity_db_manager->getTalkTreesByParentTreeId($treeId);
			$arrTree['talkDetails']=$talkDetails;
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('contact/contact_details_talk_for_mobile', $arrTree);		
			}	
			else
			{	
			   $this->load->view('contact/contact_details_talk', $arrTree);
			}   
		}			
		else
		{ 
		
			if($_SESSION['flag_for_edit_contact'] == 1)
			{
			   $arrTree['flag']=1;
			   unset($_SESSION['flag_for_edit_contact']);
			}
			else
			{
			    $arrTree['flag']=0;
			}
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('contact/contact_details_for_mobile', $arrTree);		
			}	
			else
			{
			   $this->load->view('contact/contact_details', $arrTree);
			}   
		}
		} // end else
	}
	function getMyDetails($treeId){
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
				
		$this->load->model('dal/contact_list');		
			
		$userId	= $_SESSION['userId'];	
		
		$arrTree['Contactdetail'] = $this->contact_list->getlatestContactDetails($treeId);	
		
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		$arrTree['treeId'] = $treeId;
		if($this->uri->segment(6) == 2)
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->uri->segment(4));				
		}
		else
		{
			$arrTree['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->uri->segment(4));				
		}		
		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();	
		$this->load->view('contact/contact_details', $arrTree);
		
	}
	
	function getMyDetailsByNode($nodeId){
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
				
		$this->load->model('dal/contact_list');		
			
		$userId	= $_SESSION['userId'];	
		
		$arrTree['Contactdetail'] = $this->contact_list->getContactDetailsByNode($nodeId);	
		
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
		$arrTree['tagCategories']	= $this->tag_db_manager->getTagCategories();	
		$arrTree['treeId'] = $this->tag_db_manager->getTreeIdByContactId($nodeId);		
		$this->load->view('contact/contact_details', $arrTree);
		
	}
	
	
	function getMyNotes($treeId,$start=0){
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
				
		$this->load->model('dal/contact_list');		
			
		$userId	= $_SESSION['userId'];	
		
		$arrTree['ContactNotes'] = $this->contact_list->getlatestContactNote($treeId, $start);	
		$arrTree['totalcontact'] = $this->contact_list->totalContactNote($treeId);
		$arrTree['workSpaceId'] = $this->uri->segment(5);	
		$arrTree['workSpaceType'] = $this->uri->segment(7);
		$arrTree['count'] =0;
		$arrTree['actual'] =$start;
		$arrTree['start'] =$start;
		$arrTree['end'] =$start+5;
		if($arrTree['totalcontact'] < $arrTree['end']){
			$arrTree['end']=$arrTree['totalcontact'];
		}
		
		$this->load->view('contact/contact_notes', $arrTree);
		
	}
	
	function getMyNotesByNode($nodeId){
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
				
		$this->load->model('dal/contact_list');		
			
		$userId	= $_SESSION['userId'];	
		
		$arrTree['ContactNotes'] = $this->contact_list->getContactNoteBuyId($nodeId);	
		
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		
		$this->load->view('contact/contact_notes', $arrTree);
		
	}

	function getContactTags($nodeId){
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
		$this->load->model('dal/contact_list');					
		$userId	= $_SESSION['userId'];			
		$arrTree['ContactNotes'] = $this->contact_list->getContactNoteBuyId($nodeId);			
		$arrTree['workSpaceId'] = $this->uri->segment(4);	
		$arrTree['workSpaceType'] = $this->uri->segment(6);
	
		$arrTree['tags'] 		= $this->tag_db_manager->getTagsByContactId( $nodeId );		
		
		$this->load->view('contact/contact_tags', $arrTree);
		
	}
	
	function addMyNotes($treeId){
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
		$this->load->model('dal/notes_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
		
		$objTime	 = $this->time_manager;
				
		$this->load->model('dal/contact_list');		
			
		$userId	= $_SESSION['userId'];	
	
		if($this->input->post('reply')){
			
			$note=$this->input->post($this->input->post('editorname1'));
			
	
			$nodeOrder = $this->input->post('nodeOrder');
			
			
			$workSpaceId = $this->uri->segment(4);	
			$workSpaceType = $this->uri->segment(6);
			
			$createdDate = $objTime->getGMTTime();
			$rs=$this->contact_list->insertNote($treeId,$note,$userId,$nodeOrder,$workSpaceId,$workSpaceType,$createdDate);	

			/****** Parv - Craete new Talk Tree ******/

			$this->load->model('dal/discussion_db_manager');
		
			$objDiscussion = $this->discussion_db_manager;

			$discussionTitle = $this->identity_db_manager->formatContent($note,200,1); 
			$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
			
		


			$discussionTreeId = $this->db->insert_id();
		
			$objDiscussion->insertLeafTree ($rs,$discussionTreeId);	
			  $this->identity_db_manager->updateTreeModifiedDate($treeId, $createdDate);
			
			/******* End - Create new Talk Tree ******/				
			
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree	


		
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
				//Manoj: get memcache object
				$memc=$objIdentity->createMemcacheObject();
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'contact'.$treeId;	
				
				$memc->delete($memCacheId); 
				$value = $memc->get( $memCacheId );
				
				
					if(!$value)
					{	
						$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

						$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
							
							if ($value == '')
							{
								$value = $contactNotes;
							}
					}					
					if ($value)
					{	
					
					    // tempary code //
						$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

						$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
				
							if ($value == '')
							{
								$value = $contactNotes;
							}
						// tempary code //	
						$arrTree['ContactNotes'] = $value;				
					}
					
					
					//Manoj: Insert leaf create notification start
								$notificationDetails=array();

								/*Added by Dashrath- Insert data*/
								$notificationData['data']=$discussionTitle;
								$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
								$notificationDetails['notification_data_id']=$notification_data_id;
								/*Dashrath- end code*/
													
								$notification_url='';
								
								$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($treeId);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='2';
								$notificationDetails['action_id']='1';

								//Added by dashrath
								$notificationDetails['parent_object_id']='2';
								$notificationDetails['parent_tree_id']=$treeId;
								
								if($treeType=='5')
								{
								//$notificationDetails['url']='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
								$notificationDetails['url']='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$rs.'#contactLeafContent'.$rs;
								//'contact/contactDetails/2501/44/type/1/?node=2999#contactLeafContent2999';
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
					
		
		$arrTree['Contactdetail'] = $this->contact_list->getlatestContactDetails($treeId);
		
			/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
			
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3) && $arrTree['Contactdetail']['sharedStatus']!=1)
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && $arrTree['Contactdetail']['sharedStatus']!=1)
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
		
		$arrTree['workSpaceId'] = $this->uri->segment(4);		
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		$arrTree['treeId'] = $treeId;
		$arrTree['position']=1;
		//$arrTree['countryDetails'] 		= $this->identity_db_manager->getCountries();
		
		$arrTree['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
		
		$arrTree['originator'] = $objIdentity->getUserDetailsByUserId($arrTree['Contactdetail']['userId']);
		
		$arrTree['treeDetail'] = $this->notes_db_manager->getNotes($treeId);

		
		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);
		/*Manoj: added condition for mobile */		
		if($_COOKIE['ismobile'])
		{	
			$this->load->view('contact/view_contact_list_update_for_mobile.php', $arrTree);
		}
		else
		{  		
			$this->load->view('contact/view_contact_list_update.php', $arrTree);
		}
		/*Manoj: code end */		
		}else{
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
				//Manoj: get memcache object
				$memc=$objIdentity->createMemcacheObject();
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'contact'.$treeId;	
				
				$memc->delete($memCacheId); 
				$value = $memc->get( $memCacheId );
				
				
					if(!$value)
					{	
						$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

						$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
						
							if ($value == '')
							{
								$value = $contactNotes;
							}
					}					
					if ($value)
					{	
					
					    // tempary code //
						$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

						$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
						
							if ($value == '')
							{
								$value = $contactNotes;
							}
						// tempary code //	
						$arrTree['ContactNotes'] = $value;				
					}
		
		$arrTree['Contactdetail'] = $this->contact_list->getlatestContactDetails($treeId);
		
			/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
			
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3) && $arrTree['Contactdetail']['sharedStatus']!=1)
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && $arrTree['Contactdetail']['sharedStatus']!=1)
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
		
			$arrTree['workSpaceId'] = $this->uri->segment(4);		
			$arrTree['workSpaceType'] = $this->uri->segment(6);
			$arrTree['treeId'] = $treeId;
			$arrTree['position']=1;
			//$arrTree['countryDetails'] 		= $this->identity_db_manager->getCountries();
			
			$arrTree['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
				
			$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
			
			$arrTree['originator'] = $objIdentity->getUserDetailsByUserId($arrTree['Contactdetail']['userId']);
	
			
			// Parv - Set Tree Update Count from database
			$this->identity_db_manager->setTreeUpdateCount($treeId);		
		
			/*Manoj: added condition for mobile */		
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('contact/view_contact_list_update_for_mobile.php', $arrTree);
			}
			else
			{  		
				$this->load->view('contact/view_contact_list_update.php', $arrTree);
			}
			/*Manoj: code end */
			//$this->load->view('contact/view_contact_list_update.php', $arrTree);
		
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
		$this->load->model('dal/notes_db_manager');					
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();
		$workSpaceId 	= $this->uri->segment(4);	
		$workSpaceType 	= $this->uri->segment(6);	
			
		$this->load->model('dal/contact_list');		
			
		$userId	= $_SESSION['userId'];
		
		
		if($this->input->post('reply')){
			
			/*Added by Dashrath- Used for timeline and notification content*/
			$node_data = $this->identity_db_manager->getNodeDetailsByNodeId($this->input->post('nodeId'));
			$old_node_data = $node_data['contents'];
			/*Dashrath- code end*/

			$editedDate = $this->time_manager->getGMTTime();
			
			$note=$this->input->post($this->input->post('editorname1'));
			$rs=$this->contact_list->editNotesContents($treeId,$this->input->post('nodeId'),$note,$userId,$editedDate);	
			
			$this->tag_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				
				
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree	
			
			// Parv - Update the seed title of the Talk associated with this node
			$leafTreeId	= $this->identity_db_manager->getLeafTreeIdByLeafId($this->input->post('nodeId'));
			$this->identity_db_manager->updateDocumentName($leafTreeId, $note);
			
		
			$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree					
			
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
				//Manoj: get memcache object
				$memc=$objIdentity->createMemcacheObject();	
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'contact'.$treeId;	
				
				$memc->delete($memCacheId); 
				$value = $memc->get( $memCacheId );
				
				
					if(!$value)
					{	
						$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

						$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
				
							if ($value == '')
							{
								$value = $contactNotes;
							}
					}					
					if ($value)
					{	
					
					    // tempary code //
						$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

						$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
						
							if ($value == '')
							{
								$value = $contactNotes;
							}
						// tempary code //	
						$arrTree['ContactNotes'] = $value;				
					}
		
		$arrTree['Contactdetail'] = $this->contact_list->getlatestContactDetails($treeId);
		
		
		
			/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
			
			if ($workSpaceId!=0)
			{
				if ($workSpaceType==1)
				{
					if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3) && $arrTree['Contactdetail']['sharedStatus']!=1)
					{
						$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
						redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
					}
				}
				else if ($workSpaceType==2)
				{
					if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && $arrTree['Contactdetail']['sharedStatus']!=1)
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

		/*Added by Dashrath- Add for send notification*/
		$this->editContactLeafNotification($treeId, $workSpaceId, $workSpaceType, $this->input->post('nodeId'),$old_node_data);
		/*Dashrath- code end*/
		
		$arrTree['workSpaceId'] = $this->uri->segment(4);		
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		$arrTree['treeId'] = $treeId;
		$arrTree['position']=1;
		//$arrTree['countryDetails'] 		= $this->identity_db_manager->getCountries();
		
		$arrTree['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
		
		$arrTree['originator'] = $objIdentity->getUserDetailsByUserId($arrTree['Contactdetail']['userId']);
		
		$arrTree['treeDetail'] = $this->notes_db_manager->getNotes($treeId);

		
		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);		
	
		/*Manoj: added condition for mobile */		
		if($_COOKIE['ismobile'])
		{	
			$this->load->view('contact/view_contact_list_update_for_mobile.php', $arrTree);
		}
		else
		{  		
			$this->load->view('contact/view_contact_list_update.php', $arrTree);
		}
		/*Manoj: code end */
		//$this->load->view('contact/view_contact_list_update.php', $arrTree);
	
		}else{
		    
				/*$memc = new Memcached;
				$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	
				//Manoj: get memcache object
				$memc=$objIdentity->createMemcacheObject();
				$memCacheId = 'wp'.$_SESSION['workPlaceId'].'contact'.$treeId;	
				
				$memc->delete($memCacheId); 
				$value = $memc->get( $memCacheId );
				
				
					if(!$value)
					{	
						$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

						$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
				
							if ($value == '')
							{
								$value = $contactNotes;
							}
					}					
					if ($value)
					{	
					    // tempary code //
						$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

						$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
						$value = $memc->get($memCacheId);
						
							if ($value == '')
							{
								$value = $contactNotes;
							}
						// tempary code //	
						$arrTree['ContactNotes'] = $value;				
					}
		
		$arrTree['Contactdetail'] = $this->contact_list->getlatestContactDetails($treeId);
		
		/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
		
		if ($workSpaceId!=0)
		{
			if ($workSpaceType==1)
			{
				if (!$objIdentity->isWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && !$objIdentity->checkManager($_SESSION['userId'],$workSpaceId ,3) && $arrTree['Contactdetail']['sharedStatus']!=1)
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
				}
			}
			else if ($workSpaceType==2)
			{
				if (!$objIdentity->isSubWorkSpaceMember($workSpaceId ,$_SESSION['userId']) && $arrTree['Contactdetail']['sharedStatus']!=1)
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
		
		$arrTree['workSpaceId'] = $this->uri->segment(4);		
		$arrTree['workSpaceType'] = $this->uri->segment(6);
		$arrTree['treeId'] = $treeId;
		$arrTree['position']=1;
		//$arrTree['countryDetails'] 		= $this->identity_db_manager->getCountries();
		
		$arrTree['workPlaceMembers'] = $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
		$arrTree['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	
		
		$arrTree['originator'] = $objIdentity->getUserDetailsByUserId($arrTree['Contactdetail']['userId']);

		
		// Parv - Set Tree Update Count from database
		$this->identity_db_manager->setTreeUpdateCount($treeId);		

		/*Manoj: added condition for mobile */		
		if($_COOKIE['ismobile'])
		{	
			$this->load->view('contact/view_contact_list_update_for_mobile.php', $arrTree);
		}
		else
		{  		
			$this->load->view('contact/view_contact_list_update.php', $arrTree);
		}
		/*Manoj: code end */
		//$this->load->view('contact/view_contact_list_update.php', $arrTree);
	
		}
		
	}
		
	function editContact($treeId=0)
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
		$this->load->model('dal/notification_db_manager');								
		
		$objIdentity	= $this->identity_db_manager;	
		$objTime	 = $this->time_manager;
		
		$objIdentity->updateLogin();
		
		$userId	= $_SESSION['userId'];
		
		$workSpaceId = $this->uri->segment(4);	
		$workSpaceType = $this->uri->segment(6);
		
		$placeType=$workSpaceType+2;
		
		$rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);


				
		$this->load->model('dal/contact_list');		
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
		 $arrTree['manager']=$rs;
		 $arrTree['treeId']=$treeId;
		 $arrTree['workSpaceId'] = $this->uri->segment(4);	
		 $arrTree['workSpaceType'] = $this->uri->segment(6);
		 $arrTree['error']='';
		 
		if($this->input->post('reply')){
			
			$postdata=array(
					'title'=>$this->input->post('title'),
					'firstname'=>$this->input->post('firstname'),
					'middlename'=>$this->input->post('middlename'),
					'lastname'=>$this->input->post('lastname'),
					'name'=>$this->input->post('display_name'),
					'designation'=>$this->input->post('designation'),
					'company'=>$this->input->post('company'),
					'website'=>$this->input->post('website'),
					'email'=>$this->input->post('email'),
					'fax'=>$this->input->post('fax'),
					'mobile'=>$this->input->post('mobile'),
					'landline'=>$this->input->post('landlineno'),
					'address'=>$this->input->post('address'),
					'address2'=>$this->input->post('address2'),
					'city'=>$this->input->post('city'),
					'state'=>$this->input->post('state'),
					'country'=>$this->input->post('country'),
					'zipcode'=>$this->input->post('zipcode'),
					'comments'=>$this->input->post('comments'),
					'sharedStatus'=>$this->input->post('sharedStatus'),
					'other'=>$this->input->post('other')
					);
			if($treeId){
				
					$cid=$this->contact_list->updateContact($treeId, $postdata);
					$_SESSION['flag_for_edit_contact']=1;
					
					//Manoj: Insert tree edit notification start
					$notificationDetails=array();
										
					$notification_url='';
					
					$notification_url= $this->identity_db_manager->getLinkByLinkedTreeId($treeId);
					
					$notificationDetails['created_date']=$objTime->getGMTTime();
					$notificationDetails['object_id']='1';
					$notificationDetails['action_id']='2';

					//Added by dashrath
					$notificationDetails['parent_object_id']='1';
					$notificationDetails['parent_tree_id']=$treeId;
					
					//$notificationDetails['url']=$notification_url[0];
					
					$notificationDetails['url'] = 'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
					
					if($notificationDetails['url']!='')	
					{		
						$notificationDetails['workSpaceId']= $workSpaceId;
					$notificationDetails['workSpaceType']= $workSpaceType;
						$notificationDetails['object_instance_id']=$treeId;
						$notificationDetails['user_id']=$_SESSION['userId'];
						$notification_id = $this->notification_db_manager->set_notification($notificationDetails);
						
						if($notification_id!='')
									{
									
										$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$treeId);
									
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
															
															//Insert application mode notification here
															
															$setAppNotificationDispatch=$this->notification_db_manager->set_notification_dispatch($notificationDispatchDetails);
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
					//Manoj: Insert tree edit notification end
										
				 	redirect('/contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
			
			}else{
				$name=$postdata['name'];
				$checkDisplayname = $this->contact_list->checkUniqueContact($name);
				if($checkDisplayname){
					$treeId=$this->contact_list->insertNewContact($name,$this->uri->segment(4),$this->uri->segment(6),$userId,$objTime->getGMTTime(), $postdata);
					
					/****** Parv - Craete new Talk Tree ******/

					$this->load->model('dal/discussion_db_manager');
				
					$objDiscussion = $this->discussion_db_manager;
				
					$discussionTitle = $this->identity_db_manager->formatContent($name,200,1); 
					$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
					$discussionTreeId = $this->db->insert_id();
				
					$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);	
					
					/******* End - Create new Talk Tree ******/	

					redirect('/contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}else{					
					$arrTree['error']=$this->lang->line('msg_user_tag_exist');
					
					$arrTree['Contactdetail']=$postdata;
					//$arrTree['countryDetails'] = $this->identity_db_manager->getCountries();
					if($_COOKIE['ismobile'])
					{	
						$this->load->view('contact/contact_edit_for_mobile', $arrTree);
					}
					else
					{
					    $this->load->view('contact/contact_edit', $arrTree);
					}	
				}
			}
		}else{
			if($treeId){
				$arrTree['Contactdetail'] = $this->contact_list->getlatestContactDetails($treeId);
			}else{
				$postdata=array(
					'title'=>'',
					'firstname'=>'',
					'middlename'=>'',
					'lastname'=>'',
					'name'=>'',
					'designation'=>'',
					'company'=>'',
					'email'=>'',
					'fax'=>'',
					'mobile'=>'',
					'landline'=>'',
					'address'=>'',
					'address2'=>'',
					'city'=>'',
					'state'=>'',
					'country'=>'',
					'zipcode'=>'',
					'comments'=>'',	
					'sharedStatus'=>'' ,
					'other'=>''
					);
				$arrTree['Contactdetail']=$postdata;
			}			
			//$arrTree['countryDetails'] 	= $this->identity_db_manager->getCountries();
			if($_COOKIE['ismobile'])
			{	
				$this->load->view('contact/contact_edit_for_mobile', $arrTree);
			}
			else
			{
			    $this->load->view('contact/contact_edit', $arrTree);
			}	
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
			
			if ($this->identity_db_manager->isShared($treeId))
			{
				$result = $this->identity_db_manager->updateShareTrees ($treeId, $members);
			}
			else
			{
				$result = $this->identity_db_manager->insertShareTrees ($treeId, $members);
			}

				
			if ($result)
			{
			
				$treeShareMembers = array_filter($treeShareMembers);
			
				$this->identity_db_manager->updateTreeSharedStatus ($treeId);
				
				if((count($treeShareMembers)==1 && (in_array($_SESSION['userId'],$treeShareMembers))) || (count($treeShareMembers)==0))
				{
					$this->identity_db_manager->removeTreeSharedStatus ($treeId);
				}
				
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
									
									$notification_url = 'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$treeId;
									
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
								
								/*Added by Dashrath- Add for check unshare user count*/
								$unShareUserIdArray = [];
								foreach($sharedMembersIds as $userData)
								{
									if($userData['userId']!='')
									{
										if(!in_array($userData['userId'],$treeShareMembers))
										{
											if($userData['userId']!=$_SESSION['userId'])
											{
												$unShareUserIdArray[] = $userData['userId'];
											}
										}
									}
								}
								/*Dashrath- code end*/

								/*Added by Dashrath- Add if condition for check unshare user count*/
								if(count($unShareUserIdArray) > 0)
								{
									$notificationDetails=array();
									
									/*Added by Dashrath- add for data insert in event data table*/
									$i=0;
									if(count($unShareUserIdArray)>2)
									{
										$totalUsersCount1 = count($unShareUserIdArray)-2;	
										$otherTxt1=str_replace('{notificationCount}', $totalUsersCount1 ,$this->lang->line('txt_notification_user_count'));
									}
									foreach($unShareUserIdArray as $user_id1)
									{
										if($i<2)
										{
											if($user_id1!='')
											{
												$getUserName1 = $this->identity_db_manager->getUserDetailsByUserId($user_id1);
												if($getUserName1['userTagName']!='')
												{
													$unsharedMemberNameArray[] = $getUserName1['userTagName'];
												}
											}
										}
										$i++;
									}	
									$recepientUserName1=implode(', ',$unsharedMemberNameArray).' '.$otherTxt1;
									$notificationData['data']=$recepientUserName1;
									//print_r($notificationData['data']);
									//exit;
									$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
									$notificationDetails['notification_data_id']=$notification_data_id;
									/*Dashrath- code end*/
														
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
								}
								/*Dashrath- code end*/ 
				
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
				redirect('contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_tree_not_shared'); 
				
				redirect('contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/5', 'location');
			}
		
		}	
	}
	
	
	//function for import contact from csv
	function importContact()
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
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/contact_list');	
			$objIdentity	= $this->identity_db_manager;	
			$objTime	 = $this->time_manager;
		
			$objIdentity->updateLogin();
		
			$userId	= $_SESSION['userId'];
		
			$workSpaceId = $this->uri->segment(4);	
		    $workSpaceType = $this->uri->segment(6);
		
			$placeType=$workSpaceType+2;
			
		    $rs=$this->identity_db_manager->getManagerStatus($userId, $workSpaceId, $placeType);
		
				
			$this->load->model('dal/contact_list');		
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
		 $arrTree['manager']=$rs;
		 $arrTree['treeId']=$treeId;
		 $arrTree['workSpaceId'] = $this->uri->segment(4);	
		 $arrTree['workSpaceType'] = $this->uri->segment(6);
		 $arrTree['error']='';
			
														
			 $total_records=0;
			 $failed_records=0;
			 
			 $sharedStatus='';
			 if($workSpaceId==0)
			 {
			 	 $sharedStatus=2;
			 }
			if(isset($_FILES['contact']['name'])  )
			{ 
			
				$checkFileType= substr(strrchr($_FILES["contact"]["name"],'.'),1);
		
			    if($checkFileType=='vcf' )
				{   
				   
					$this->load->model('dal/contact_vcard_parse');
					$timeStamp = date("ymdhisu");
					$vcffile = basename($_FILES['contact']['name']);
					$file = $timeStamp."_".$vcffile;	
				 	$uploadPath = 'uploads'.DIRECTORY_SEPARATOR.$file;
					
					if (move_uploaded_file($_FILES['contact']['tmp_name'], $uploadPath)) {
					
					
						$cardinfo=$this->contact_vcard_parse->fromFile($this->config->item('root_dir').DIRECTORY_SEPARATOR.$uploadPath);
						
						$fullname = ($cardinfo[0][FN][0][value][0][0]);
		 
						$name=explode(" ",$fullname);
						$firstname=$name[0];
						$lastname=$name[1];
						$company=$cardinfo[0][ORG][0][value][0][0]==''?'company name':$cardinfo[0][ORG][0][value][0][0];
				
						
						 if(firstname!='' &&  $lastname!='' && $company!='')
						 {
						
						$postdata=array(
							'title'=>$fullname,
							'firstname'=>$firstname,
							'middlename'=>'',
							'lastname'=>$lastname,
							'name'=>$fullname,
							'designation'=>$cardinfo[0][TITLE][0][value][0][0],
							'company'=>$company,
							'website'=>'',
							'email'=>$cardinfo[0][EMAIL][0][value][0][0],
							'fax'=>'',
							'mobile'=>$cardinfo[0][TEL][1][value][0][0],
							'landline'=>$cardinfo[0][TEL][0][value][0][0],
							'address'=>$cardinfo[0][ADR][0][value][0][0]." ".$cardinfo[0][ADR][0][value][1][0]." ".$cardinfo[0][ADR][0][value][2][0]." ".$cardinfo[0][ADR][0][value][3][0]." ".$cardinfo[0][ADR][0][value][4][0]." ".$cardinfo[0][ADR][0][value][5][0]." ".$cardinfo[0][ADR][0][value][6][0],
							'address2'=>$cardinfo[0][ADR][1][value][0][0]." ".$cardinfo[0][ADR][1][value][1][0]." ".$cardinfo[0][ADR][1][value][2][0]." ".$cardinfo[0][ADR][1][value][3][0]." ".$cardinfo[0][ADR][1][value][4][0]." ".$cardinfo[0][ADR][1][value][5][0]." ".$cardinfo[0][ADR][1][value][6][0],
							'city'=>'',
							'state'=>'',
							'country'=>'',
							'zipcode'=>'',
							'comments'=>'',
							'sharedStatus'=>$sharedStatus,
							'other'=>''
							);
						
							unlink($this->config->item('root_dir').DIRECTORY_SEPARATOR.$uploadPath);
							
							$tag_name=$this->contact_list->generateaUniqueContactTagName($firstname,$lastname); 
							
							$treeId=$this->contact_list->insertNewContact($tag_name,$workSpaceId,$workSpaceType,$userId,date("Y-m-d h:i:s"), $postdata);
											
									$successUserRecords=$successUserRecords .$record[0].",".$record[1].",".trim($record[2],"\n \r ,").",".$tag_name.",Success \n";
											
									/****** Parv - Craete new Talk Tree ******/

								$this->load->model('dal/discussion_db_manager');
							
								$objDiscussion = $this->discussion_db_manager;
							
					
								$discussionTitle = $this->identity_db_manager->formatContent($tag_name,200,1);
								$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
							
								$discussionTreeId = $this->db->insert_id();
							
								$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);	
								
								/******* End - Create new Talk Tree ******/	
							
						
						
					
						redirect('/contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
						}
						else
						{
						
						$_SESSION['message']=$this->lang->line('Msg_First_name_last_name_and_company_name_required_in_vcf_file');
						redirect('/contact/importContact/0/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
						
						}
					
					}
						
				} 
				elseif($checkFileType=='csv')
				{
				  
					//load model	 
					$this->load->model('dal/csvreader');
				
					$csv = new csvreader();
					
					$timeStamp = date("ymdhisu");
					
					$failedUser='';
					
					$successUserRecords='';
					
					$basefile = basename($_FILES['contact']['name']);
					$file = $timeStamp."_".$basefile;	
				    $uploadPath = 'uploads'.DIRECTORY_SEPARATOR.$file;
					
				
					if (move_uploaded_file($_FILES['contact']['tmp_name'], $uploadPath)) 
					{
					
						$csv_array = $csv->parse_file($this->config->item('root_dir').DIRECTORY_SEPARATOR.$uploadPath);
				
						
					 	foreach($csv_array as $key=>$record )
					 	{
					  		if($key!=0)
					   		{ 
							    $tag_name='';
								++$total_records;
					
							    if($record[0]!='' &&  $record[1]!='' && $record[2]!='' )
								{						   
									if($record[3]=='' || preg_match("(^[A-Za-z0-9_\+-]+(\.[A-Za-z0-9_\+-]+)*@[a-z0-9-]+)", $record[3]))
									{
										if(preg_match("/^([+ ()-0123456789_-])*$/", $record[4]) && preg_match("/^([+ ()-0123456789_-])*$/", trim($record[5],"\n \r ,")) )
										{
										
											
										
										//function generates unique tag name
										$tag_name=$this->contact_list->generateaUniqueContactTagName($record[1],trim($record[2],"\n \r ,")); 
										
										$postdata=array(
										'title'=>'',
										'firstname'=>$record[1],
										'middlename'=>'',
										'lastname'=>trim($record[2],"\n \r ,"),
										'name'=>$tag_name,
										'designation'=>'',
										'company'=>$record[0],
										'website'=>'',
										'email'=>$record[3],
										'fax'=>'',
										'mobile'=>trim($record[5],"\n \r ,"),
										'landline'=>$record[4],
										'address'=>'',
										'address2'=>'',
										'city'=>'',
										'state'=>'',
										'country'=>'',
										'zipcode'=>'',
										'comments'=>'',
										'sharedStatus'=>$sharedStatus,
										'other'=>''
										);		
											
										$treeId=$this->contact_list->insertNewContact($tag_name,$workSpaceId,$workSpaceType,$userId,date("Y-m-d h:i:s"), $postdata);
												
										$successUserRecords=$successUserRecords .$record[0].",".$record[1].",".$record[2].",".$tag_name.",".$record[3].",".$record[4].",".trim($record[5],"\n \r ,").",Success \n";
												
										/****** Parv - Craete new Talk Tree ******/
	
									$this->load->model('dal/discussion_db_manager');
								
									$objDiscussion = $this->discussion_db_manager;
								
									//$discussionTitle = strip_tags($tag_name); 
									$discussionTitle = $this->identity_db_manager->formatContent($tag_name,200,1);
									$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
								
									$discussionTreeId = $this->db->insert_id();
								
									$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);	
									
									/******* End - Create new Talk Tree ******/	
	
									 
											
										}
										else
										{
											++$failed_records;
											$failedUser=$failedUser .$record[0].",".$record[1].",".$record[2].",".$tag_name.",".$record[3].",".$record[4].",".trim($record[5],"\n \r ,").",ERROR:Either telphone or mobile no. not valid \n";
										} 
									}
									else
									{
										++$failed_records;
										$failedUser=$failedUser .$record[0].",".$record[1].",".$record[2].",".$tag_name.",".$record[3].",".$record[4].",".trim($record[5],"\n \r ,").",ERROR:Invalid Email id\n";
									
									}											
										
								}
								else
								{
									++$failed_records;
										$failedUser=$failedUser .$record[0].",".$record[1].",".$record[2].",".$tag_name.",".$record[3].",".$record[4].",".trim($record[5],"\n \r ,").",ERROR:All mendotory feilds are required\n";
								}
									 
					   		}
							
							
							
					 	}
						
					
						
						$arrTree['failedUser']=$failedUser;
						
						$arrTree['successUserRecords']=$successUserRecords;
						
						
						
						$_SESSION['message']= $this->lang->line('Msg_contacts_added_suceesfully');
				
					}
					
					
					
					unlink($this->config->item('root_dir').DIRECTORY_SEPARATOR.$uploadPath);
					
		
							
					
				}
				else
				{
				  
					//select valid file set message
					$_SESSION['message']=$this->lang->line('error_select_valid_file');
					
					
				}
			
				
				$arrTree['failed_records']=$failed_records;	
						
		       $arrTree['total_records']=$total_records;		 
		}
			 
		
		
   		$this->load->view('contact/contact_bulk_edit',$arrTree);
   
						
		}		
	
	
	}
	
	function downloads($timeStamp)
	{
	   
		header('Content-Type: application/csv'); //Outputting the file as a csv file
		header('Content-Disposition: attachment; filename=error_registration.csv');
		//Defining the name of the file and suggesting the browser to offer a 'Save to disk ' option
		header('Pragma: no-cache');

		echo $this->input->post('contents',true); //Reading the contents of the file
		
		
	}


	//Added by Dashrath : code start
	function deleteLeaf()
	{
		$leafId = $this->input->post('leafId');							
		$workSpaceId = $this->input->post('workSpaceId');		
		$workSpaceType = $this->input->post('workSpaceType');
		$treeId = $this->input->post('treeId');

		$this->load->model('dal/document_db_manager');
		$lockStatus = $this->document_db_manager->checkLeafLockStatus($leafId);
		

		if($lockStatus == 1)
		{
			echo 'lock';
		}
		else
		{
			$this->load->model('dal/identity_db_manager');						
		    $objIdentity	= $this->identity_db_manager;
			if($objIdentity->deleteLeaf($leafId))
			{
				
				// update the chat details in memcache
				// $memc=$objIdentity->createMemcacheObject();
				// $memCacheId = 'wp'.$_SESSION['workPlaceId'].'contact'.$treeId;	
				
				// $memc->delete($memCacheId);

				// $this->load->model('dal/contact_list');

				// $contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$_SESSION['userId'],  $workSpaceId, $workSpaceType);		

				// $memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);

			
				$this->load->model('dal/notification_db_manager');								
				$objNotification = $this->notification_db_manager;

				//2 use for leaf object
				$objectId = 2;
				//3 use for delete action
				$actionId = 3;
				//get nodeId by leafId
				$nodeId = $this->identity_db_manager->getNodeIdByLeafId($leafId);

				$objNotification->sendCommonNotification($treeId, $workSpaceId, $workSpaceType, $nodeId, $objectId, $actionId);

				$this->load->model('dal/time_manager');
				$editedDate = $this->time_manager->getGMTTime();
			
				$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);

				//Update tree update count
				$this->load->model('dal/document_db_manager');
				$this->document_db_manager->updateTreeUpdateCount($treeId);	

				echo true;
			}
			else
			{
				echo false;
			}

		}
	}
	// Dashrath : code end

	/*Added by Dashrath- editContactLeafNotification function start*/
	function editContactLeafNotification($treeId, $workSpaceId, $workSpaceType, $rs,$old_node_data)
	{

		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$this->load->model('dal/tag_db_manager');	
		$this->load->model('dal/notification_db_manager');	
		$this->load->model('dal/notes_db_manager');						
		$objIdentity	= $this->identity_db_manager;	
		$objTime	 = $this->time_manager;
		$this->load->model('dal/contact_list');

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
		
		if($treeType=='5')
		{
		//$notificationDetails['url']='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
		$notificationDetails['url']='contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/?node='.$rs.'#contactLeafContent'.$rs;
		//'contact/contactDetails/2501/44/type/1/?node=2999#contactLeafContent2999';
		}
		
		if($notificationDetails['url']!='')	
		{	
			/*Added by Dashrath- Insert data*/
			$notificationData['data']=$old_node_data;
			$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
			$notificationDetails['notification_data_id']=$notification_data_id;
			/*Dashrath- end code*/

			$notificationDetails['workSpaceId']= $workSpaceId;
			$notificationDetails['workSpaceType']= $workSpaceType;
			$notificationDetails['object_instance_id']=$rs;
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
	}
	/*Dashrath- editContactLeafNotification function end*/		

}?>