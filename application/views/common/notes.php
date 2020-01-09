<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

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

class Notes extends Controller {



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

			

		$this->load->view('notes', $arrTree);

	

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
								$memc=$this->identity_db_manager->createMemcacheObject();

								$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	

								

								$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	



								$memc->set($memCacheId, $contactDetail);

								

								//close set memcache ///	

								

								/******* End - Create new Talk Tree ******/	

								

								$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Originator's Tree

				

			//$rs=$this->notes_db_manager->insertNote($treeId,$note,$userId);	

			 redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');

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

			$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));	*/
			
			//Manoj: get memcache object	
			$memc=$this->identity_db_manager->createMemcacheObject();

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
								$memc=$this->identity_db_manager->createMemcacheObject();

								$memCacheId = 'wp'.$_SESSION['workPlaceId'].'notes'.$treeId;	

								

								$contactDetail=$this->notes_db_manager->gettNotesByTree($treeId);	



								$memc->set($memCacheId, $contactDetail);

								

								//close set memcache ///	

								

								/******* End - Create new Talk Tree ******/	

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

			 redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');

		}else{

			 redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');

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

			$name=$this->input->post('name');

			$note=$this->input->post('replyDiscussion');

				$createDate = date("Y-m-d h:i:s");

  				if(trim($this->input->post('startTime')) != '')

				{

					$createDate = $this->input->post('startTime');	

				} 

				

				$createDate = $this->time_manager->getGMTTime(); 

				if ($this->input->post('autonumbering')=='on')

				{

					$autonumbering = 1;

				}

				else

				{

					$autonumbering = 0;

				}

					

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

					if($this->input->post('workSpaceId') == 0)

					{		

						$workSpaceMembers	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);

					}

					else

					{			

						if($this->input->post('workSpaceType') == 1)

						{	

							$workSpaceMembers	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($this->input->post('workSpaceId'));						

						}

						else

						{	

							$workSpaceMembers	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($this->input->post('workSpaceId'));				

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

					redirect('/notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	

				}	

			

		}else{

			

			$this->load->view('new_notes', $arrTree);

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

			$this->load->view('notes_details_calendar', $arrTree);

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



			$this->load->view('notes_details_tag', $arrTree);

		}

		else if($showOption == 4)

		{

			$this->load->view('notes_details_link', $arrTree);

		}

		else if($showOption == 5)

		{

			$this->load->view('notes_details_share', $arrTree);

		}

		else if($showOption == 7)

		{

			$talkDetails=$this->identity_db_manager->getTalkTreesByParentTreeId($treeId);

			$arrTree['talkDetails']=$talkDetails;

			$this->load->view('notes_details_talk', $arrTree);

		}

		else

		{

			$this->load->view('notes_details', $arrTree);

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

			

			$this->load->view('notes_details', $arrTree);

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



			$treeId = $this->input->post('treeId');

			/*if (in_array(0,$this->input->post('users')))

			{

				$workPlaceMembers	= $this->identity_db_manager->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);

				

					foreach($workPlaceMembers as $userData)

					{

						$workPlaceMembersArray [] = $userData['userId'];

					}

				$members = implode (",",$workPlaceMembersArray);	

			}

			else

			{*/

				$members = implode (",",array_filter($this->input->post('users')));

			/*}*/

			$members .= ", ".$_SESSION['userId'];

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

					$this->identity_db_manager->updateTreeSharedStatus ($treeId);

					

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

					

					$_SESSION['errorMsg'] = $this->lang->line('msg_tree_shared'); 

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



}?>