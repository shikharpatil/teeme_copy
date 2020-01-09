<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_document.php
	* Description 		  	: A class file used to view the document details
	* External Files called	: models/dal/document_db_manager.php, models/dal/identity_db_manager.php, models/dal/time_manager.php, models/container/leaf.php, views/view_document.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 13-08-2008				Nagalingam						Created the file.		
	* 25-11-2008				Nagalinagm						Modified the file
	**********************************************************************************************************/
/**
* A PHP class file used to view the dcoument
* @author   Ideavate Solutions (www.ideavate.com)
*/
class View_document extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
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
			/*$objMemCache = new Memcached;
			$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
			

			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/discussion_db_manager');	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');
			$this->load->model('dal/notes_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();				
			$this->load->model('container/document');
			$this->load->model('dal/document_db_manager');	
			$this->load->model('dal/chat_db_manager');	
	
			$treeId 	= $this->input->get('treeId');
			
			/*$nodeDetails		= $this->document_db_manager->getDocTreeNodesByTreeId($treeId);
			echo '<pre>';
			print_r($nodeDetails);
			exit;*/
			
			//Manoj: get memcache object	
			$objMemCache=$this->identity_db_manager->createMemcacheObject();

			/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
			$workSpaceId 	= $this->uri->segment(3);
			$workSpaceType  = $this->uri->segment(5);
			
			//Space tree type code start
			$spaceNameDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			if ($workSpaceId!=0 && $spaceNameDetails['workSpaceName']!='Try Teeme')
			{
				$treeTypeStatus = $this->identity_db_manager->if_is_tree_enabled('1',$workSpaceId);
				if($treeTypeStatus==1)
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_no_access_space');
					redirect('no_access/index/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}
			}
			//Space tree type code end
			
/*				if ($treeId=='')
				{
					$treeId = filter_var($this->uri->segment(6), FILTER_SANITIZE_NUMBER_INT);
				}*/
			
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

			$_SESSION['treeId'] = $treeId;
			$option 	= $this->input->get('viewOption');
			$doc	 	= $this->input->get('doc');
			$spaceManager='';
								
			$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($treeId);	
			$arrUser			= $this->document_db_manager->getUserDetailsByUserId($arrDocumentDetails['userId']);
			if($doc == 'new')
			{
				$arrLastLeafDetails	= $this->document_db_manager->getLastLeafDetailsByTreeId($treeId);	
				$nodeId 			= $arrLastLeafDetails['nodeId'];
				$leafId 			= $arrLastLeafDetails['leafId'];
				$leafOrder 			= $arrLastLeafDetails['leafOrder'];				
				$whoFocus 			= ( 2 * $arrLastLeafDetails['totalLeafs'] )-1;
				$arrDocViewPage = array('arrDocumentDetails' => $arrDocumentDetails,'arrUser' => $arrUser,'arrLastLeafDetails' => $arrLastLeafDetails,'nodeId' => $nodeId,'leafId' => $leafId,'leafOrder' => $leafOrder,'whoFocus' => $whoFocus, 'treeId' =>$treeId);	
			}
			else
			{ 
				$arrDocViewPage = array('arrDocumentDetails' => $arrDocumentDetails,'arrUser' => $arrUser, 'treeId' =>$treeId);
			}
			$arrDocViewPage['workSpaceId'] = $this->uri->segment(3);
			$arrDocViewPage['workSpaceType'] = $this->uri->segment(5);	
			
			if($arrDocViewPage['workSpaceType'] == 1)
			{	
				$arrDocViewPage['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($arrDocViewPage['workSpaceId']);
				$arrDocViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDocViewPage['workSpaceId']);						
			}
			else
			{	
				$arrDocViewPage['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($arrDocViewPage['workSpaceId']);
				$arrDocViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDocViewPage['workSpaceId']);				
			}
			
			$arrDocViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();
			
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
			
			$arrDocViewPage['treeDetail'] = $this->notes_db_manager->getNotes($treeId);
			
			if($this->input->get('seqId') != '')
			{
				$arrDocViewPage['sequenceTagId']	= $this->input->get('seqId');
			}
			else
			{
				$arrDocViewPage['sequenceTagId']	= 0;
			}
			
			if($subWorkSpaceId > 0)
			{
				$tmpWorkSpaceId = $subWorkSpaceId;
				$tmpWorkSpaceType = 2;
			}
			else if($workSpaceType == 2)
			{
				$tmpWorkSpaceId = $workSpaceId;
				$tmpWorkSpaceType = 2;
			}
			else
			{
				$tmpWorkSpaceId = $workSpaceId;
				$tmpWorkSpaceType = 1;
			}
			if($this->identity_db_manager->getManagerStatus($_SESSION['userId'], $tmpWorkSpaceId, ($tmpWorkSpaceType+2)))
			{ 
			 $spaceManager=1;
			}
			
			/*Changed by Dashrath- Comment old code and add new code below(remove $spaceManager from parameter)*/
			// $arrDocViewPage['workSpaces'] = $objIdentity->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'],$spaceManager );
			$arrDocViewPage['workSpaces'] = $objIdentity->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId']);

			$arrDocViewPage['treeId'] = $treeId;	
			$viewOption = 1;
			
			//Manoj: Get all contributors in document tree start
			$contributors 				= $this->document_db_manager->getDocsContributors($treeId);

			$contributorsTagName		= array();
			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
				$contributorsUserId[] 	= $userData['userId'];	
			}
	
			$arrDocViewPage['contributorsTagName'] = $contributorsTagName;
			$arrDocViewPage['contributorsUserId'] = $contributorsUserId;
			//Manoj: Get all contributors in document tree end
			
			// Parv - Set Tree Update Count from database
			$this->document_db_manager->setTreeUpdateCount($treeId);
				
			$arrDocViewPage['documentDetails'] 	= $this->document_db_manager->getNodesByTreeFromDB($treeId);	
			$arrDocViewPage['documentContributors']	= $this->document_db_manager->getLeafAuthorsByLeafIds($treeId);
			$arrDocViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			$filterOpt = $this->input->post("filterOpt");
			
			$arrDocViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);	

			/*Added by Dashrath- used in auto numbering dispaly logic*/
			$_SESSION['document_refresh'] = 1;
			/*Dashrath- code end*/

			/*Added by Dashrath- used for update session value for show share icon green*/
			if ($workSpaceId==0)
			{
				$this->load->model('dal/identity_db_manager');
				$this->identity_db_manager->updateSharedTreeStatusSession($treeId);
			}
			/*Dashrath- code end*/

			if($this->input->get('option') != '')
			{
				$viewOption = $this->input->get('option');
			}	
			if($_COOKIE['ismobile'])
			{
			    if($viewOption == 2)
				{
					$this->load->view('document/view_document_calendar_for_mobile', $arrDocViewPage);
				}	
				elseif($viewOption == 3)
				{
					$this->load->view('document/view_document_tag_for_mobile', $arrDocViewPage);
				}	
				elseif($viewOption == 4)
				{
					$this->load->view('document/view_document_link_for_mobile', $arrDocViewPage);
				}
				elseif($viewOption == 5)
				{
					$this->load->view('document/view_document_share_for_mobile', $arrDocViewPage);
				}
				elseif($viewOption == 7)
				{
					$talkDetails=$this->identity_db_manager->getTalkTreesByParentTreeIdDoc($treeId);
					$arrDocViewPage['talkDetails']=array_reverse($talkDetails);
					
					$this->load->view('document/view_document_talk_for_mobile', $arrDocViewPage);
				}
				else
				{
					$this->load->view('document/view_document_for_mobile', $arrDocViewPage);
				}	
			}	
			else
			{
				if($viewOption == 2)
				{
					$this->load->view('document/view_document_calendar', $arrDocViewPage);
				}	
				elseif($viewOption == 3)
				{
					if($_GET['ajax']){
						if($filterOpt){
							$this->load->view('document/view_tag_leaves_filter', $arrDocViewPage);
						}
						else{
							$this->load->view('document/view_tag_leaves', $arrDocViewPage);
						}
						
					}
					else{
						$this->load->view('document/view_document_tag', $arrDocViewPage);
					}
				}	
				elseif($viewOption == 4)
				{
					$this->load->view('document/view_document_link', $arrDocViewPage);
				}
				elseif($viewOption == 5)
				{
					$this->load->view('document/view_document_share', $arrDocViewPage);
				}
				elseif($viewOption == 7)
				{
					$talkDetails=$this->identity_db_manager->getTalkTreesByParentTreeIdDoc($treeId);
					$arrDocViewPage['talkDetails']=array_reverse($talkDetails);
					$this->load->view('document/view_document_talk', $arrDocViewPage);
				}
				else
				{
					$this->load->view('document/view_document', $arrDocViewPage);
				}
			}
		}
	}
	
	function index2()
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
			/*$objMemCache = new Memcached;
			$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
			

			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/discussion_db_manager');	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();				
			$this->load->model('container/document');
			$this->load->model('dal/document_db_manager');	
			$this->load->model('dal/notes_db_manager');
	
			//Manoj: get memcache object	
			$objMemCache=$this->identity_db_manager->createMemcacheObject();
	
			$treeId 	= $this->input->get('treeId');
			
				if ($treeId=='')
				{
					$treeId = filter_var($this->uri->segment(6), FILTER_SANITIZE_NUMBER_INT);
				}
				
			/* Begin: Parv  - Restrict access to the tree if not member of the space/subspace */
			$workSpaceId 	= $this->uri->segment(3);
			$workSpaceType  = $this->uri->segment(5);
			
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
				$mySpaceId = $objIdentity->getWorkspaceIdByTreeId($treeId);
				if($mySpaceId==0)
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
			}
			/* End: Parv  - Restrict access to the tree if not member of the space/subspace */

			$_SESSION['treeId'] = $treeId;
			$option 	= $this->input->get('viewOption');
			$doc	 	= $this->input->get('doc');
			$spaceManager='';
								
			$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($treeId);	

			$arrUser			= $this->document_db_manager->getUserDetailsByUserId($arrDocumentDetails['userId']);
			if($doc == 'new')
			{
				$arrLastLeafDetails	= $this->document_db_manager->getLastLeafDetailsByTreeId($treeId);	
				$nodeId 			= $arrLastLeafDetails['nodeId'];
				$leafId 			= $arrLastLeafDetails['leafId'];
				$leafOrder 			= $arrLastLeafDetails['leafOrder'];				
				$whoFocus 			= ( 2 * $arrLastLeafDetails['totalLeafs'] )-1;
				$arrDocViewPage = array('arrDocumentDetails' => $arrDocumentDetails,'arrUser' => $arrUser,'arrLastLeafDetails' => $arrLastLeafDetails,'nodeId' => $nodeId,'leafId' => $leafId,'leafOrder' => $leafOrder,'whoFocus' => $whoFocus, 'treeId' =>$treeId);	
			}
			else
			{
				$arrDocViewPage = array('arrDocumentDetails' => $arrDocumentDetails,'arrUser' => $arrUser, 'treeId' =>$treeId);
			}
			$arrDocViewPage['workSpaceId'] = $this->uri->segment(3);
			$arrDocViewPage['workSpaceType'] = $this->uri->segment(5);	
			
			if($arrDocViewPage['workSpaceType'] == 1)
			{	
				$arrDocViewPage['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($arrDocViewPage['workSpaceId']);
				$arrDocViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDocViewPage['workSpaceId']);						
			}
			else
			{	
				$arrDocViewPage['workSpaceDetails'] = $this->identity_db_manager->getWorkSpaceDetailsBySubWorkSpaceId($arrDocViewPage['workSpaceId']);
				$arrDocViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDocViewPage['workSpaceId']);				
			}
			$arrDocViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();	
			if($this->input->get('seqId') != '')
			{
				$arrDocViewPage['sequenceTagId']	= $this->input->get('seqId');
			}
			else
			{
				$arrDocViewPage['sequenceTagId']	= 0;
			}
			
			if($subWorkSpaceId > 0)
			{
				$tmpWorkSpaceId = $subWorkSpaceId;
				$tmpWorkSpaceType = 2;
			}
			else if($workSpaceType == 2)
			{
				$tmpWorkSpaceId = $workSpaceId;
				$tmpWorkSpaceType = 2;
			}
			else
			{
				$tmpWorkSpaceId = $workSpaceId;
				$tmpWorkSpaceType = 1;
			}
			if($this->identity_db_manager->getManagerStatus($_SESSION['userId'], $tmpWorkSpaceId, ($tmpWorkSpaceType+2)))
			{ 
			 $spaceManager=1;
			}
			
			$arrDocViewPage['treeDetail'] = $this->notes_db_manager->getNotes($treeId);

			/*Changed by Dashrath- Comment old code and add new code below(remove $spaceManager from parameter)*/
			// $arrDocViewPage['workSpaces'] = $objIdentity->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'],$spaceManager );
			$arrDocViewPage['workSpaces'] = $objIdentity->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId']);

			$arrDocViewPage['treeId'] = $treeId;	
			$viewOption = 1;
			
			
			// Parv - Set Tree Update Count from database
			$this->document_db_manager->setTreeUpdateCount($treeId);
				
			$arrDocViewPage['documentDetails'] 	= $this->document_db_manager->getNodesByTreeFromDB($treeId);	
			
			$arrDocViewPage['workPlaceMembers']	= $objIdentity->getWorkPlaceMembersByWorkPlaceId($_SESSION['workPlaceId']);
			
			$arrDocViewPage['sharedMembers']	= $objIdentity->getSharedMembersByTreeId($treeId);				
			//Manoj: Get all contributors in document tree start
			$contributors 				= $this->document_db_manager->getDocsContributors($treeId);

			$contributorsTagName		= array();
			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsTagName[] 	= $userData['userTagName'];
				$contributorsUserId[] 	= $userData['userId'];	
			}
	
			$arrDocViewPage['contributorsTagName'] = $contributorsTagName;
			$arrDocViewPage['contributorsUserId'] = $contributorsUserId;
			//Manoj: Get all contributors in document tree end
			$this->load->view('document/view_document_container', $arrDocViewPage);
		}
	}
	
	
	function checkTreeUpdateCount ($treeId,$workSpaceId,$workSpaceType,$talk=0)
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
			$this->load->model('dal/document_db_manager');
			$objTree	= $this->document_db_manager;
			$dbUpdateCount = $objTree->getTreeUpdateCount ($treeId);
			$userUpdateCount = $_SESSION['treeUpdateCount'.$treeId];

			if ($dbUpdateCount == $userUpdateCount)		
			{
				echo '';
			}
			else
			{
				$latestTreeVersion = $objTree->checkTreeLatestVersion($treeId);
				$totalCount = $dbUpdateCount-$userUpdateCount;
				
				if ($latestTreeVersion == 1)
					if ($talk==1)
					{
						echo "<a href='javascript:void(0);' onClick='window.location.reload();'><span>".$this->lang->line('txt_Update')."</span></a>";
					}
					else
					{
						echo "<a href='javascript:void(0);' onClick='window.location.reload();'></a>";
					}
				else
				{
					$childTreeId = $objTree->hasChild($treeId);
					echo "<a href='".base_url()."view_document/index/".$workSpaceId."/type/".$workSpaceType."/?treeId=".$childTreeId."&doc=exist' class='blue-link-underline'><span></span></a>"; 		
				}
			}
		}
	}
	
	
	function checkTreeUpdateCountNew ($treeId,$workSpaceId,$workSpaceType,$talk=0)
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
			$this->load->model('dal/document_db_manager');
			$objTree	= $this->document_db_manager;
			$dbUpdateCount = $objTree->getTreeUpdateCount ($treeId);
			$userUpdateCount = $_SESSION['treeUpdateCount'.$treeId];
			
			/*Commented by Dashrath- Comment old code and add new code below with some changes*/
			// if($dbUpdateCount == $userUpdateCount )		
			// {
			// 	echo '0';
			// }
			// else
			// {
			//     echo '1';
			// }

			/*Added by Dashrath- Add this code for tree update count and draft leaf count*/
			if($dbUpdateCount == $userUpdateCount )		
			{
				$treeUpdateCountResult = '0';
			}
			else
			{
			    $treeUpdateCountResult = '1';
			}

			//get draft leaf data for check old and new count for green D icon in seed header
			$this->load->model('dal/identity_db_manager');
			$draftLeafs = $this->identity_db_manager->getDraftLeafsByTreeId($treeId);
			$userDraftLeafCount = $_SESSION['draftLeafCount'.$treeId.$_SESSION['userId']];
			if(count($draftLeafs) == $userDraftLeafCount)		
			{
				$draftLeafCountResult = '0';
			}
			else
			{
			    $draftLeafCountResult = '1';
			}

			//check tree shared for update share icon in myspace
			$shareTreeStatusResult = 0;
			if($workSpaceId==0)
			{
				if ($this->identity_db_manager->isShared($treeId))
				{
					$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($treeId);	
					if (in_array($_SESSION['userId'],$sharedMembers))
					{
						$sharedStatus = 'share';		
					}
					else
					{
						$sharedStatus = 'unshare';
					}
				}

				$userShareTreeStatus = $_SESSION['shareTreeStatus'.$treeId.$_SESSION['userId']];
				if($sharedStatus == $userShareTreeStatus)		
				{
					$shareTreeStatusResult = '0';
				}
				else
				{
				    $shareTreeStatusResult = '1';
				}
			} 

			echo $treeUpdateCountResult.'|||||'.$draftLeafCountResult.'|||||'.$shareTreeStatusResult;
			/*Dashrath- code end*/
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
			$this->load->model('dal/notes_db_manager');	

			$treeId =  $this->uri->segment(3);
			$workSpaceId =  $this->uri->segment(4);
			$workSpaceType =  $this->uri->segment(6);
			
			$sharedMembersIds = $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
			
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
				//$members = implode (",",array_filter($this->input->post('users')));
			/*}*/
			
			$members = $this->input->post('list');
			
			$selected_members = $members;
			
			$treeShareMembers = explode(',',$members);
			
			if(!in_array($_SESSION['userId'],$treeShareMembers))
			{
				$members .= ", ".$_SESSION['userId'];
			}
			
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
				
				if ($selected_members!='')
				{
					$this->identity_db_manager->updateTreeSharedStatus ($treeId);
				}
				
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
													if($user_id!='')
													{
														$getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
														if($getUserName['userTagName']!='')
														{
															$sharedMemberNameArray[] = $getUserName['userTagName'];
														}
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
									
									$notification_url = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$treeId;
									
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
															if($userIds!='')
															{
																$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userIds);
															}
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
								*/		
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
															if($userData['userId']!='')
															{
																$userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userData['userId']);
															}
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
					
					//Remove contributors 
					$contributors = $this->notes_db_manager->getNotesContributors($treeId);

					foreach($contributors  as $userData)
					{ 
						if(!in_array($userData['userId'],$treeShareMembers) && ($_SESSION['userId']!=$userData['userId']))
						{
							$this->identity_db_manager->deleteNotesUsersFromShared($treeId,$userData['userId']);
						}
					}
				}
				
				//Manoj: unshare tree member notification
				
				$_SESSION['successMsg'] = $this->lang->line('msg_tree_shared'); 
				redirect('view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&option=5', 'location');
			}
			else
			{
				$_SESSION['errorMsg'] = $this->lang->line('msg_tree_not_shared'); 
				redirect('view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&option=5', 'location');	
			}
		
		}	
	}

	/*Added by Dashrath- documentAddPositionView function start*/
	function documentAddPositionView()
	{
		$arrData['treeId']	= $this->uri->segment(3);
		$arrData['workSpaceId']	= $this->uri->segment(4);
		$arrData['workSpaceType']	= $this->uri->segment(6);
		
		if($arrData['treeId']>0)
		{
			$this->load->model('dal/document_db_manager');
			$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($arrData['treeId']);
			$arrData['position'] =  $arrDocumentDetails['position'];
		}
		$this->load->view('document/document_add_position', $arrData);
	}
	/*documentAddPositionView function end*/

	/*Added by Dashrath- documentAddPositionView function start*/
	function documentAddPositionSet()
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

			$treeId   =  $this->input->post('treeId');
			$workSpaceId = $this->input->post('workSpaceId');
			$workSpaceType = $this->input->post('workSpaceType');

			/*1 for anywhere, 2 for top, 3 for bottom, 4 for top and bottom*/
			$position = $this->input->post('position');

			$res = $this->identity_db_manager->documentAddPositionUpdate($treeId, $workSpaceId, $workSpaceType, $position);

			if($res)
			{
				echo 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist';
			}
			else
			{
				echo 'error';
			}	
		}

	}
	/*documentAddPositionView function end*/
	
	/*Added by Dashrath- getDraftLeafsDetail function start*/
	function getDraftLeafsDetail($treeId)
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
			$arrDetails['draftLeafs'] = $this->identity_db_manager->getDraftLeafsByTreeId($treeId);

			//Used in update draft icon in seed header
			$_SESSION['draftLeafCount'.$treeId.$_SESSION['userId']] = count($arrDetails['draftLeafs']);

			$this->load->view('document/draft_leaf_view', $arrDetails);
		}

	}
	/*getDraftLeafsDetail function end*/

	/*Added by Dashrath- autoNumberingView function start*/
	function autoNumberingView()
	{
		$arrData['treeId']	= $this->uri->segment(3);
		$arrData['workSpaceId']	= $this->uri->segment(4);
		$arrData['workSpaceType']	= $this->uri->segment(6);
		
		if($arrData['treeId']>0)
		{
			$this->load->model('dal/document_db_manager');
			$arrDocumentDetails	= $this->document_db_manager->getDocumentDetailsByTreeId($arrData['treeId']);
			$arrData['autonumbering'] =  $arrDocumentDetails['autonumbering'];
			
		}
		$this->load->view('common/auto_numbering_view', $arrData);
	}
	/*autoNumberingView function end*/

	/*Added by Dashrath- autoNumberingUpdateByAjax function start*/
	function autoNumberingUpdateByAjax()
	{
		$treeId = $this->input->post('treeId');
		$autonumbering = $this->input->post('autonumbering');

		$this->load->model('dal/identity_db_manager');

		$res = $this->identity_db_manager->updateTreeAutonumbering($treeId,$autonumbering);

		echo $res;

	}
	/*autoNumberingUpdateByAjax function end*/

	/*Added by Dashrath- getDraftLeafDataCount function start*/
	function getDraftLeafDataCount($treeId)
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
			$arrDetails['draftLeafs'] = $this->identity_db_manager->getDraftLeafsByTreeId($treeId);

			echo count($arrDetails['draftLeafs']);
		}
	}
	/*getDraftLeafDataCount function end*/
}
?>
