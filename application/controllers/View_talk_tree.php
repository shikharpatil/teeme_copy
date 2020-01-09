<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: view_Discussion.php
	* Description 		  	: A class file used to show the workspace/document discussion.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/discussionManager.php,views/login.php,views/view_Discussion.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 17-09-2008				Vinaykant Sahu						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to how the workspace/document discussion.
* @author   Ideavate Solutions (www.ideavate.com)
*/
class view_talk_tree extends CI_Controller 
{
	
	function Discussion($treeId)
	{
		parent::__Construct();
				
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
			$myperentId=0;
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');							
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');			

			$arrDiscussionDetails	= $this->discussion_db_manager->getDiscussionDetailsByTreeId($treeId);
		
			$pId=$arrDiscussionDetails['nodes'];
			if($pId){
				$arrparent=  $this->discussion_db_manager->getDiscussionPerent($pId);
				$myperentId= $this->discussion_db_manager->getPerentInfo($arrparent['nodeId']);
				
			}else{
				$arrparent=false;
			}
			$arrUser			= $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);
			$arrReplay			= $this->discussion_db_manager->getAllRepalyDetails($treeId);
			
			$arrDiscussionViewPage['DiscussionTitle'] = $arrDiscussionDetails['name'];
			$arrDiscussionViewPage['treeId'] = $treeId;
			$arrDiscussionViewPage['DiscussionCreatedDate'] = $arrDiscussionDetails['createdDate'];
			$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
			$arrDiscussionViewPage['DiscussionUserId'] = $arrDiscussionDetails['userId'];
			$arrDiscussionViewPage['position'] = 0;
			$arrDiscussionViewPage['margin'] = 0;
			$arrDiscussionViewPage['DiscussionReply'] = $arrReplay;
			$arrDiscussionViewPage['DiscussionPerent'] = $arrparent;
			$arrDiscussionViewPage['perentId'] = $pId;
			$arrDiscussionViewPage['myperentId'] = $myperentId;
			$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
			$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
			$this->load->view('common/talk/view_discussion', $arrDiscussionViewPage);
		}
	}
	function node( $treeId )
	{		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails']	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();				
			$this->load->model('container/discussion_container');
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/discussion_db_manager');	
			$this->load->model('dal/notes_db_manager');	
			$this->load->model('dal/contact_list');
			
			//echo "treeid= " .$treeId; exit;
		
			if($treeId)
			{
			   if($this->uri->segment(10)!='')
			   {
				$arrDiscussionViewPage['latest']=$this->uri->segment(10);
			   }
			
				$arrDiscussions1=$this->discussion_db_manager->getTalkNodesByTree($treeId);	
			
				$arrDiscussionDetails	= $this->discussion_db_manager->getDiscussionDetailsByTreeId($treeId);
				$arrDocumentDetails = $this->document_db_manager->getDocumentDetailsByTreeId($arrDiscussionDetails['parentTreeId']);

				//Update talk tree name by it's attached leaf or seed id
				$isSeedTalk = $this->uri->segment(9);
				
				$treeType = $this->identity_db_manager->getTreeTypeByTreeId($arrDiscussionDetails['parentTreeId']);	
				
				$leafId = $this->discussion_db_manager->getLeafIdByLeafTreeId ($treeId);
				//echo "leafid= " .$leafId; exit;
				//echo "isseedtalk= " .$isSeedTalk; exit;
					if ($isSeedTalk==1)
					{
						$this->discussion_db_manager->updateTalkTreeNameByLeafTreeId ($leafId,$treeId,1);
						$arrDiscussionViewPage['artifactType']=1;
						$arrDiscussionViewPage['artifactId']=$this->uri->segment(8);
					}
					else if ($isSeedTalk=='')
					{
						//echo "<li>leafid= " .$leafId; 
						//echo "<li>treeId= " .$treeId; 
						//echo "<li>treeType= " .$treeType; 
						//exit;
						$this->discussion_db_manager->updateTalkTreeNameByLeafTreeId ($leafId,$treeId,0,$treeType);
						$arrDiscussionViewPage['artifactType']=2;
					}
				// Update talk tree name by it's attached leaf or seed id
				//exit;
				
				$pId=$arrDiscussionDetails['nodes'];
				if($isSeedTalk) {
					$arrDiscussionViewPage['DiscussionPerent']=$this->discussion_db_manager->getDiscussionPerent1($arrDiscussionDetails['parentTreeId']);
				}
				else
				{
					$arrDiscussionViewPage['DiscussionPerent']=$this->discussion_db_manager->getDiscussionPerent1($arrDiscussionDetails['id']);
				}
				
				$arrDiscussionViewPage['pnodeId']=$pId;
				$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
				$arrDiscussionViewPage['arrDocumentDetails']=$arrDocumentDetails;
				$arrDiscussionViewPage['treeId']=$treeId;
				$arrDiscussionViewPage['isSeedTalk']=$isSeedTalk;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);
				$arrDiscussionViewPage['talkNodeId']= $_GET['talkNodeId'];	
				$talknodeId = $_GET['talkNodeId'];
				
				if ($isSeedTalk=='')
				{
					$arrDiscussionViewPage['artifactId']=$talknodeId;
				}
				
				if($this->uri->segment(8))
				{
					$latestTreeVersion 	= $this->discussion_db_manager->getTreeLatestVersionByTreeId($this->uri->segment(8));
					
					$treeType = $this->identity_db_manager->getTreeTypeByTreeId($this->uri->segment(8));
					$arrDiscussionViewPage['treeType'] = $treeType;
				}
				if($talknodeId!='')
				{
					if (($objIdentity->checkLeafNewVersion($talknodeId) == 0) && $latestTreeVersion==1)
					{
						$arrDiscussionViewPage['latestLeafVersion']	= 1;
					}
					
					$nodeSuccessor = $this->identity_db_manager->checkLeafNewVersion($talknodeId);
					$currentLeafStatus = $this->document_db_manager->getLeafStatusByNodeId($talknodeId);
					$arrDiscussionViewPage['nodeSuccessor']=$nodeSuccessor;
					$arrDiscussionViewPage['successorLeafStatus']='';
					$arrDiscussionViewPage['currentLeafStatus']=$currentLeafStatus['leafStatus'];
					if($nodeSuccessor!=0 && $nodeSuccessor!='')
					{
						$successorLeafStatus = $this->document_db_manager->getLeafStatusByNodeId($nodeSuccessor);
						$arrDiscussionViewPage['successorLeafStatus']=$successorLeafStatus['leafStatus'];
					}
					
				}
				
				if($arrDiscussionViewPage['workSpaceType'] == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
				}
				$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();
				//exit;
						
				// Parv - Set Tree Update Count from database
				$this->identity_db_manager->setTreeUpdateCount($treeId);	
				if($leafId!='')
				{
					$talkClearNodeId = $this->identity_db_manager->getNodeIdByLeafId($leafId);
					if($talkClearNodeId !='')
					{
						$arrDiscussionViewPage['talkClearNodeId']	= $talkClearNodeId;
					}
				}
					
				$showOption = 1;
				if($showOption == 1)
				{
					$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
					//exit;
					
					//Check leaf status start
						$talkParentTreeId = $this->uri->segment(8);
						$arrDiscussionViewPage['currentTreeId'] = $this->uri->segment(8);
						$arrDiscussionViewPage['leafId'] = $leafId;
						
						$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($talkParentTreeId);
						
						$contactStatus = '';
						if($treeType==5)
						{
							$Contactdetail = $this->contact_list->getlatestContactDetails($talkParentTreeId);
							$contactStatus = $Contactdetail['sharedStatus'];
						}
						
						$workSpaceId = $arrDiscussionViewPage['workSpaceId'];			
						if(($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!='' && $contactStatus!=1)		
						{
							$arrDiscussionViewPage['spaceMoved'] = '1';
						}
						
						if($treeType==1 && $isSeedTalk=='')
						{
							$arrDiscussionViewPage['leafAlertNo'] = '';
							$arrDiscussionViewPage['leafAlertMsg'] = '';
						
							$currentNodeOrder = $this->identity_db_manager->getNodePositionByNodeId($talknodeId);
							$arrDiscussionViewPage['currentNodeOrder'] = $currentNodeOrder;
							$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($talkParentTreeId, $currentNodeOrder);
							$arrDiscussionViewPage['parentLeafId'] = $leafParentData['parentLeafId'];
							$contributors 				= $this->document_db_manager->getDocsContributors($talkParentTreeId);
				
							$contributorsUserId			= array();	
							foreach($contributors  as $userData)
							{
								$contributorsUserId[] 	= $userData['userId'];	
							}
					
							//Get leaf reserved users
							$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
							$resUserIds = array();
							if(count($reservedUsers)>0)
							{
								foreach($reservedUsers  as $resUserData)
								{
									$resUserIds[] = $resUserData['userId']; 
								}
							}
							
							//Check leaf new version is created or not
							if($nodeSuccessor>0)
							{
								$arrDiscussionViewPage['leafAlertNo'] = 2;
								$arrDiscussionViewPage['leafAlertMsg'] = $this->lang->line('txt_new_version_leaf_created');
							}	
							
							//Check user resevation status
							//if (!in_array($_SESSION['userId'],$contributorsUserId) || (!in_array($_SESSION['userId'], $resUserIds) && count($resUserIds)!=0 && $currentLeafStatus['leafStatus'] == 'publish') || (!in_array($_SESSION['userId'], $resUserIds) && $currentLeafStatus['leafStatus'] == 'draft'))
							if ((!in_array($_SESSION['userId'], $resUserIds) && $currentLeafStatus['leafStatus'] == 'draft'))
							{
									$arrDiscussionViewPage['leafAlertNo'] = 1;
									$arrDiscussionViewPage['leafAlertMsg'] = $this->lang->line('txt_remove_from_reserved_list');
									$arrDiscussionViewPage['leafDraftReserveStatus'] = 1;
							}
							
							//Check leaf discard status
							if($currentLeafStatus['leafStatus']=='discarded')
							{
								$arrDiscussionViewPage['leafAlertNo'] = 3;
								$arrDiscussionViewPage['leafAlertMsg'] = $this->lang->line('txt_leaf_has_discarded');
							}	
							
							//Check leaf publish status
							/*if($currentLeafStatus['leafStatus']=='publish' && $treeLeafStatus == 'draft')
							{
								$arrTag['leafAlertNo'] = 4;
								$arrTag['leafAlertMsg'] = $this->lang->line('txt_leaf_made_final');
							}*/	
							
							if($latestTreeVersion != 1)
							{
								$arrDiscussionViewPage['leafAlertNo'] = 6;
								$arrDiscussionViewPage['leafAlertMsg'] = $this->lang->line('txt_new_version_tree_created');
							}
						}
						
						if(($treeType==4 || $treeType==6) && $isSeedTalk=='')
						{
							/*$contributors 	= $this->notes_db_manager->getNotesContributors($talkParentTreeId);
				
							$contributorsUserId	= array();	
							foreach($contributors  as $userData)
							{
								$contributorsUserId[] 	= $userData['userId'];	
							}
							
							if (!in_array($_SESSION['userId'],$contributorsUserId))
							{
								$arrDiscussionViewPage['leafDraftReserveStatus'] = 1;
							}*/
						}
					//Check leaf status end
					
					if($_COOKIE['ismobile'])
					{
						$this->load->view('common/talk/view_talk_tree_for_mobile', $arrDiscussionViewPage); 
					}
					else
					{					
						$this->load->view('common/talk/view_talk_tree', $arrDiscussionViewPage); 
					}
				}
				
			}else{						
				$userId	= $_SESSION['userId'];
				$arrDiscussions['arrDiscussions'] = $this->discussion_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
				$arrDiscussions['workSpaceId'] = $this->uri->segment(4);
				$arrDiscussions['workSpaceType'] = $this->uri->segment(6);
				if($_COOKIE['ismobile'])
				{
					$this->load->view('common/talk/view_talk_tree_for_mobile', $arrDiscussions);
				}
				else
				{		
					$this->load->view('common/talk/view_talk_tree', $arrDiscussions);
				}
			}
		}
	}
	
	function Talk_reply($nodeId){
		parent::__Construct();
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
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();			
			$this->load->model('container/discussion_container');
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/discussion_db_manager');	
			if($nodeId){
				$arrparent=  $this->discussion_db_manager->getPerentInfo($nodeId);
				
				$arrDiscussionViewPage['arrparent']=$arrparent;
				$arrDiscussionViewPage['counter']=0;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['arrDiscussions']=array();
				$arrDiscussionViewPage['workSpaceId'] 	= $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				if($arrDiscussionViewPage['workSpaceType'] == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
				}
				$arrDiscussionViewPage['treeId'] = $this->tag_db_manager->getTreeIdByNodeId($nodeId); 
				$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();				
				$arrDiscussionViewPage['treeDetails']	= $this->discussion_db_manager->getDiscussionDetailsByTreeId($arrDiscussionViewPage['treeId']);	
				$arrDiscussionViewPage['arrDocumentDetails']= $this->document_db_manager->getDocumentDetailsByTreeId($arrDiscussionViewPage['treeDetails']['parentTreeId']);

				// Parv - Set Tree Update Count from database
				$this->identity_db_manager->setTreeUpdateCount($arrDiscussionViewPage['treeId']);				
				
				if(isset($_SESSION['nodes']))
				{
						foreach($_SESSION['nodes'] as $key=>$val)
						{						
							$tree = $this->tag_db_manager->getTreeIdByNodeId($val); 
							if ($arrDiscussionViewPage['treeId']!=$tree)
								unset($_SESSION['nodes'][$key]);
						}	
					$nodeCount =  count($_SESSION['nodes']);
					if(!in_array($nodeId, $_SESSION['nodes']))
					{
						$_SESSION['nodes'][$nodeCount] = $nodeId; 	
					}
					else
					{
						foreach($_SESSION['nodes'] as $key=>$val)
						{						
							if($val == $nodeId)
							{
								$curNodeId = $key;
								break;
							}		
						}
						for($i = $curNodeId+1; $i<$nodeCount; $i++)
						{
							unset($_SESSION['nodes'][$i]);
						}	
					}
				}
				else
				{
					$_SESSION['nodes'][0] = $nodeId;
				}		
				$this->load->view('common/talk/view_talk_tree_nodes', $arrDiscussionViewPage);
			}
		}
	}
	
	function Discussion_reply($nodeId){
		parent::__Construct();
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
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();			
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');	
			if($nodeId){
				$arrparent=  $this->discussion_db_manager->getPerentInfo($nodeId);
				$arrDiscussionViewPage['arrparent']=$arrparent;
				$arrDiscussionViewPage['counter']=0;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['arrDiscussions']=array();
				$arrDiscussionViewPage['workSpaceId'] 	= $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				if($arrDiscussionViewPage['workSpaceType'] == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
				}
				$arrDiscussionViewPage['treeId'] = $this->tag_db_manager->getTreeIdByNodeId($nodeId); 
				$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();				
				$arrDiscussionViewPage['treeDetails']	= $this->discussion_db_manager->getDiscussionDetailsByTreeId($arrDiscussionViewPage['treeId']);	
				if(isset($_SESSION['nodes']))
				{
					$nodeCount =  count($_SESSION['nodes']);
					if(!in_array($nodeId, $_SESSION['nodes']))
					{
						$_SESSION['nodes'][$nodeCount] = $nodeId; 	
					}
					else
					{
						foreach($_SESSION['nodes'] as $key=>$val)
						{						
							if($val == $nodeId)
							{
								$curNodeId = $key;
								break;
							}		
						}
						for($i = $curNodeId+1; $i<$nodeCount; $i++)
						{
							unset($_SESSION['nodes'][$i]);
						}	
					}
				}
				else
				{
					$_SESSION['nodes'][0] = $nodeId;
				}		
				$this->load->view('common/talk/view_talk_tree_nodes', $arrDiscussionViewPage);
			}
		}
	}
	function readDiscussion($leafId){
		parent::__Construct();
				
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('dal/tag_db_manager');							
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();		
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');	
			 $this->discussion_db_manager->insertDiscussionLeafView($leafId,$_SESSION['userId']);
			 $rs=$this->discussion_db_manager->checkDiscussionLeafView($leafId,$_SESSION['userId']);
			 if($rs){
			 	echo $this->lang->line('txt_read');
			 }else{
			 	echo $this->lang->line('txt_unread');
			 }
		}
	}
	
	function real_talk($treeId)
	{		
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails']	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');
			$this->load->model('dal/tag_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$objIdentity->updateLogin();				
			$this->load->model('container/discussion_container');
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/discussion_db_manager');	
			if($treeId)
			{		 
				if($_COOKIE['ismobile'])
				{
					$arrDiscussions1=$this->discussion_db_manager->getTalkNodesByTreeRealTalk($treeId,$_SESSION['talkTimeStamp']);
				}
				else
				{	
					//Commented above code for talk chat real time response and remove time stamp b'coz it is not showing latest content
					$arrDiscussions1=$this->discussion_db_manager->getTalkNodesByTreeRealTalk($treeId,'');
				}
			
				$_SESSION['talkTimeStamp']=$this->time_manager->getGMTTime();
				$arrDiscussionDetails	= $this->discussion_db_manager->getDiscussionDetailsByTreeId($treeId);
	
				$arrDocumentDetails = $this->document_db_manager->getDocumentDetailsByTreeId($arrDiscussionDetails['parentTreeId']);
	
				// Update talk tree name by it's attached leaf or seed id
				$isSeedTalk = $this->uri->segment(9);
				
				$treeType = $this->identity_db_manager->getTreeTypeByTreeId($arrDiscussionDetails['parentTreeId']);	
	
				$leafId = $this->discussion_db_manager->getLeafIdByLeafTreeId ($treeId);
				
				//echo "isseedtalk= " .$isSeedTalk; exit;
				
				if ($isSeedTalk==1)
				{
					//echo "here bhenchod= " .$leafId; exit;
					$this->discussion_db_manager->updateTalkTreeNameByLeafTreeId ($leafId,$treeId,1);
				}
				else if ($isSeedTalk=='')
				{
/*						echo "<li>leafid= " .$leafId; 
						echo "<li>treeId= " .$treeId; 
						echo "<li>treeType= " .$treeType; 
						exit;*/
					$this->discussion_db_manager->updateTalkTreeNameByLeafTreeId ($leafId,$treeId,0,$treeType);
				}
				// Update talk tree name by it's attached leaf or seed id

			
				$pId=$arrDiscussionDetails['nodes'];
				if($pId) {
					$DiscussionPerent1=$this->discussion_db_manager->getDiscussionPerent($pId);
					$arrDiscussionViewPage['DiscussionPerent']=$DiscussionPerent1;
				}
				
				$arrDiscussionViewPage['pnodeId']=$pId;
				$arrDiscussionViewPage['arrDiscussionDetails']=$arrDiscussionDetails;
				$arrDiscussionViewPage['arrDocumentDetails']=$arrDocumentDetails;
				$arrDiscussionViewPage['treeId']=$treeId;
				$arrDiscussionViewPage['isSeedTalk']=$isSeedTalk;
				$arrDiscussionViewPage['position']=0;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(6);	
				if($arrDiscussionViewPage['workSpaceType'] == 1)
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getWorkSpaceMembersByWorkSpaceId($arrDiscussionViewPage['workSpaceId']);						
				}
				else
				{	
					$arrDiscussionViewPage['workSpaceMembers']	= $objIdentity->getSubWorkSpaceMembersBySubWorkSpaceId($arrDiscussionViewPage['workSpaceId']);				
				}
				$arrDiscussionViewPage['tagCategories']	= $this->tag_db_manager->getTagCategories();
				
						
				// Parv - Set Tree Update Count from database
				$this->identity_db_manager->setTreeUpdateCount($treeId);	
					
						
				$showOption = 1;
				if($showOption == 1)
				{
					$arrDiscussionViewPage['arrDiscussions']=$arrDiscussions1;
					$arrDiscussionViewPage['realTimeTalkDivIds'] = $_GET['realTimeTalkDivIds'];
					if($_COOKIE['ismobile'])
					{
						$this->load->view('common/talk/view_talk_tree_comments_for_mobile', $arrDiscussionViewPage);
					}
					else
					{	
						$this->load->view('common/talk/view_talk_tree_comments', $arrDiscussionViewPage);
					}
				}
				
			}else{
						
				$userId	= $_SESSION['userId'];			
				$arrDiscussions['arrDiscussions'] = $this->discussion_db_manager->getTreesByworkSpaceId($this->uri->segment(4),$this->uri->segment(6),$userId);
				$arrDiscussions['workSpaceId'] = $this->uri->segment(4);	
				$arrDiscussions['workSpaceType'] = $this->uri->segment(6);	
				if($_COOKIE['ismobile'])
				{
					$this->load->view('common/talk/view_talk_tree_for_mobile', $arrDiscussions);	
				}
				else
				{	
					$this->load->view('common/talk/view_talk_tree', $arrDiscussions);	
				}
			}	
		}
	}
	
	function setTalkCount($leafTreeId)
	{
	 
	   $this->load->model('dal/discussion_db_manager');	
		echo $this->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);
	}
	/*<!--Added by Surbhi IV -->	*/
	function setLastTalk($leafTreeId)
	{
	    $this->load->model('dal/discussion_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/identity_db_manager');					
		$objIdentity	= $this->identity_db_manager;	
		
		$talk=$this->discussion_db_manager->getLastTalkByTreeId($leafTreeId);
		$formatted_talk = $this->identity_db_manager->formatContent($talk[0]->contents,300,1);
		
/*		if(strip_tags($talk[0]->contents))
		{
			$userDetails = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);
			$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));
		}*/
		if($formatted_talk)
		{
			$userDetails = $this->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);
			if(!empty($userDetails))
			{
			$latestTalk=$formatted_talk."\n".$userDetails['userTagName']."\t\t".$this->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));
			}
			else
			{
				$latestTalk='Talk';
			}
		}
		else
		{
			$latestTalk='Talk';
		}		
		echo html_entity_decode($latestTalk,ENT_QUOTES);		
	}
	/*<!--End of Added by Surbhi IV -->	*/
	
}?>