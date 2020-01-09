<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: show_artifact_links.php
	* Description 		  	: A class file used to show the linked artifact links
	* External Files called	: models/dal/identity_db_manager.php, models/dal/time_manager.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 17-03-2009			Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
*  A class file used to show the linked artifact links
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Show_artifact_links extends CI_Controller 
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
			$this->load->model('dal/identity_db_manager');		
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/notes_db_manager');		
			$this->load->model('dal/contact_list');
							
			$objIdentity			= $this->identity_db_manager;	
			$nodeId 				= $this->uri->segment(3);	
			$artifactType 			= $this->uri->segment(4);				
			$workspaceId 			= $this->uri->segment(5);		
			$workspaceType 			= $this->uri->segment(6);
			$linkType				= $this->uri->segment(7);	
			$nodeOrder				= $this->uri->segment(8);
			$latestVersion			= $this->uri->segment(9);	
			$open					= $this->uri->segment(10);	
			
			
			$linkSpanOrder			= $nodeOrder;						
			$artifactLinks			= array();
			$arrDetails				= array();
			$docArtifactLinks 		= array();
			$docArtifactLinks2		= array();
			$docArtifactLinks3 		= array();
			$docArtifactNotLinks 	= array();
			$docArtifactNotLinks2 	= array();
			$disArtifactLinks 		= array();
			$disArtifactLinks2 		= array();
			$disArtifactLinks3 		= array();
			$disArtifactNotLinks 	= array();
			$disArtifactNotLinks2 	= array();
			$chatArtifactLinks 		= array();
			$chatArtifactLinks2 	= array();
			$chatArtifactLinks3 	= array();
			$chatArtifactNotLinks 	= array();
			$chatArtifactNotLinks2 	= array();
			$activityArtifactLinks 	= array();
			$activityArtifactLinks2 = array();	
			$activityArtifactLinks3 = array();		
			$activityArtifactNotLinks 	= array();
			$activityArtifactNotLinks2 	= array();	
			$notesArtifactLinks 	= array();
			$notesArtifactLinks2 	= array();
			$notesArtifactLinks3 	= array();	
			$notesArtifactNotLinks 	= array();
			$notesArtifactNotLinks2	= array();
			$arrDocNotTreeIds = array();	
			$arrDisNotTreeIds = array();
			$arrChatNotTreeIds = array();
			$arrActivityNotTreeIds = array();	
			$arrNotesNotTreeIds = array();	
			$artifactNewLink 		= '';	
			$dispLabel = '';
			$mainTreeId =$this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
			
			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 1, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$docCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 1, $linkType,$lastLogin);
			
			$arrDocTreeIds = array();	
			if(count($docTrees) > 0)
			{
				$i = 1;	
				foreach($docTrees as $data)
				{	
					$treeName = $data['name'];
					$arrDocTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Document');
					}					
					$docArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workspaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
			
					$docArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}					
			}
			if(count($docCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($docCurrentTrees as $data)
				{	
					$treeName = $data['name'];
					$arrDocTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Document');
					}					
					$docArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					
					$i++;
				}					
			}
	
			$arrDocTreeIds[sizeof($arrDocTreeIds)] =0;
			$docNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(1, $workspaceId, $workspaceType, $arrDocTreeIds,$mainTreeId);	
			if(count($docNotLinkedTrees) > 0)
			{
				$i = 1;		
				$show = 0;		
				foreach($docNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
	
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);	
						
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$arrDocNotTreeIds[] = $data['treeId'];				
							$docArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($data['name'])).'</span>'; 	

							$docArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($data['name']));
							$docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
						}
					}
					else
					{
						$arrDocNotTreeIds[] = $data['treeId'];				
						$docArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($data['name'])).'</span>'; 	

						$docArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($data['name']));
						$docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
					}
					$i++;
				}	
				asort ($docArtifactNotLinks2);		
			}		
			$docArtifactNewLink 		= '<a href="'.base_url().'document_new/index/'.$workspaceId.'/type/'.$workspaceType.'/'.$nodeId.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';	
			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 2, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$disCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 2, $linkType,$lastLogin);
			
			$arrDisTreeIds = array();
			if(count($disTrees) > 0)
			{
				$i = 1;	
				foreach($disTrees as $data)
				{	
					$treeName = $data['name'];	
					$arrDisTreeIds[] = $data['treeId'];
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Discussion');
					}													
					$disArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	

					$disArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}					
			}
			
			if(count($disCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($disCurrentTrees as $data)
				{	
					$treeName = $data['name'];	
					$arrDisTreeIds[] = $data['treeId'];
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Discussion');
					}													
					$disArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}					
			}

			$arrDisTreeIds[sizeof($arrDisTreeIds)] =0;
			$disArtifactNewLink 		= '<a href="'.base_url().'new_discussion/start_Discussion/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$disNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(2, $workspaceId, $workspaceType, $arrDisTreeIds,$mainTreeId);	
			if(count($disNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($disNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree

					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$treeName = $data['name'];
							$arrDisNotTreeIds[] = $data['treeId'];		
							if(trim($data['name']) == '')
							{
								$treeName = $this->lang->line('txt_Discussion');	
							}			
							$disArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	

							$disArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
						}
					}
					else
					{
						$treeName = $data['name'];
						$arrDisNotTreeIds[] = $data['treeId'];		
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Discussion');	
						}			
						$disArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	

						$disArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}

					$i++;
				}
				asort ($disArtifactNotLinks2);						
			}		

			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 3, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$chatCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 3, $linkType,$lastLogin);
			
			$arrChatTreeIds = array();
			if(count($chatTrees) > 0)
			{
				$i = 1;	
				foreach($chatTrees as $data)
				{
					$treeName = $data['name'];	
					$arrChatTreeIds[] = $data['treeId'];	
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Chat');	
					}									
					$chatArtifactLinks[] = '<a href="'.base_url().'view_chat/chat_view/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	

					$chatArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					
					$i++;
				}						
			}
			
			if(count($chatCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($chatCurrentTrees as $data)
				{
					$treeName = $data['name'];	
					$arrChatTreeIds[] = $data['treeId'];	
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Chat');	
					}									
					$chatArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}						
			}

			$arrChatTreeIds[sizeof($arrChatTreeIds)] =0;
			$chatArtifactNewLink 	= '<a href="'.base_url().'new_chat/start_Chat/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$chatNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(3, $workspaceId, $workspaceType, $arrChatTreeIds,$mainTreeId);	
			if(count($chatNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($chatNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$treeName = $data['name'];	
							$arrChatNotTreeIds[] = $data['treeId'];		
							if(trim($data['name']) == '')
							{
								$treeName = $this->lang->line('txt_Chat');	
							}			
							$chatArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 
							$chatArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
						}
					}
					else
					{
						$treeName = $data['name'];	
						$arrChatNotTreeIds[] = $data['treeId'];		
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Chat');	
						}			
						$chatArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 
						$chatArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}
					$i++;
				}
				asort ($chatArtifactNotLinks2);							
			}		
			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 4, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$activityCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 4, $linkType,$lastLogin);
			
			$arrActivityTreeIds = array();		
			if(count($activityTrees) > 0)
			{
				$i = 1;	
				foreach($activityTrees as $data)
				{
					$treeName = $data['name'];	
					$arrActivityTreeIds[] = $data['treeId'];		
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Activity');	
					}															
					$activityArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'/1" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
					$activityArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}						
			}
			if(count($activityCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($activityCurrentTrees as $data)
				{
					$treeName = $data['name'];	
					$arrActivityTreeIds[] = $data['treeId'];		
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Activity');	
					}															
					$activityArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}						
			}

			$arrActivityTreeIds[sizeof($arrActivityTreeIds)] = 0;
			$activityArtifactNewLink 	= '<a href="'.base_url().'new_task/start_Task/'.$nodeId.'/index/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$activityNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(4, $workspaceId, $workspaceType, $arrActivityTreeIds,$mainTreeId);	
			if(count($activityNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($activityNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree

					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
							if ((in_array($_SESSION['userId'],$sharedMembers)))
							{
								$treeName = $data['name'];	
								$arrActivityNotTreeIds[] = $data['treeId'];	
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Activity');	
								}			
								$activityArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	

								$activityArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
							}
					}
					else
					{
						$treeName = $data['name'];	
						$arrActivityNotTreeIds[] = $data['treeId'];	
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Activity');	
						}			
						$activityArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	

						$activityArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}

					$i++;
				}
				asort ($activityArtifactNotLinks2);							
			}
			
			
			$arrNotesTreeIds = array();			
			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 6, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$notesCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 6, $linkType,$lastLogin);
			
			if(count($notesTrees) > 0)
			{
				$i = 1;	
				foreach($notesTrees as $data)
				{	
					$treeName = $data['name'];
					$arrNotesTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Notes');
					}											
					$notesArtifactLinks[] = '<a href="'.base_url().'notes/Details/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	

					$notesArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}	
									
			}
			
			if(count($notesCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($notesCurrentTrees as $data)
				{	
					$treeName = $data['name'];
					$arrNotesTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Notes');
					}											
					$notesArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}						
			}
			

			$arrNotesTreeIds[sizeof($arrNotesTreeIds)] =0;
			$notesArtifactNewLink 	= '<a href="'.base_url().'notes/New_Notes/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$notesNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(6, $workspaceId, $workspaceType, $arrNotesTreeIds,$mainTreeId);	
			if(count($notesNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($notesNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
							if ((in_array($_SESSION['userId'],$sharedMembers)))
							{
								$treeName = $data['name'];	
								$arrNotesNotTreeIds[] = $data['treeId'];
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Notes');	
								}			
								$notesArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	

								$notesArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
							}
					}
					else
					{
						$treeName = $data['name'];	
						$arrNotesNotTreeIds[] = $data['treeId'];
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Notes');	
						}			
						$notesArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	

						$notesArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}
					
					$i++;
				}
				asort ($notesArtifactNotLinks2);							
			}	
			
			
			
			$arrContactTreeIds = array();			
			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 5, $linkType);

			$lastLogin = $this->identity_db_manager->getLastLogin();
			$contactCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 5, $linkType,$lastLogin);
			
			if(count($contactTrees) > 0)
			{
				$i = 1;	
				foreach($contactTrees as $data)
				{	
					$treeName = $data['name'];
					$arrContactTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Contacts');
					}											
					$contactArtifactLinks[] = '<a href="'.base_url().'contact/contactDetails/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	

					$contactArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}						
			}
			
			if(count($contactCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($contactCurrentTrees as $data)
				{	
					$treeName = $data['name'];
					$arrContactTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Contacts');
					}											
					$contactArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}						
			}
			

			$arrContactTreeIds[sizeof($arrContactTreeIds)] =0;
			$contactArtifactNewLink = '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$contactNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(5, $workspaceId, $workspaceType, $arrContactTreeIds,$mainTreeId);	

			if(count($contactNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($contactNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree

					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
							if ((in_array($_SESSION['userId'],$sharedMembers)))
							{
								$treeName = $data['name'];	
								$arrContactNotTreeIds[] = $data['treeId'];
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Contacts');	
								}			
								$contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
								$contactArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
							}
					}
					else
					{
						$treeName = $data['name'];	
						$arrContactNotTreeIds[] = $data['treeId'];
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Contacts');	
						}			
						$contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	

						$contactArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}
					
					$i++;
				}
				asort ($contactArtifactNotLinks2);						
			}	


			$arrImportFileIds = array();			
			$importFile 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($nodeId,$linkType);
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$importCurrentFile = $this->identity_db_manager->getCurrentLinkedExternalDocsByArtifactNodeId($nodeId,$linkType,$lastLogin);
			
			if(count($importFile) > 0)
			{
				$i = 1;	
				foreach($importFile as $data)
				{	
					$docName = $data['docName'];
					$arrImportFileIds[] = $data['docId'];	
					if(trim($docName) == '')
					{
						$docName = $this->lang->line('txt_Files');
					}											
					/*Commented by Dashrath- commented old code add new changes code below*/
					// $importArtifactLinks[] = "<a href=".base_url()."ext_file/index/".$data['docId']." target=_blank>".$docName.'_v'.$data['version']."</a>";
					// $importArtifactLinks2[$data['docId']] = html_entity_decode(strip_tags($docName)).'_v'.$data['version'];

					/*Added by Dashrath- change docCaption to docName and remove version add*/
					$importArtifactLinks[] = "<a href=".base_url()."ext_file/index/".$data['docId']." target=_blank>".$docName."</a>";
					$importArtifactLinks2[$data['docId']] = html_entity_decode(strip_tags($docName));
					/*Dashrath- code end*/

					$i++;
				}						
			}
			
			if(count($importCurrentFile) > 0)
			{
				$i = 1;	
				foreach($importCurrentFile as $data)
				{	
					$docName = $data['docName'];
					$arrImportFileIds[] = $data['docId'];	
					if(trim($docName) == '')
					{
						$docName = $this->lang->line('txt_Files');
					}
					/*Commented by Dashrath- commented old code add new changes code below*/											
					// $importArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['docId']." value=".$data['docId'].">".html_entity_decode(strip_tags($docName)).'_v'.$data['version']."</option>";

					/*Added by Dashrath- change docCaption to docName and remove version add*/
					$importArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['docId']." value=".$data['docId'].">".html_entity_decode(strip_tags($docName))."</option>";
					/*Dashrath- code end*/

					$i++;
				}						
			}
			
			$arrImportFileIds[sizeof($arrImportFileIds)] =0;
			$importArtifactNewLink 	= '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$importNotLinkedFile 	= $this->identity_db_manager->getNotLinkedExternalDocsByArtifactNodeId(7, $workspaceId, $workspaceType, $arrImportFileIds);	
			

			if(count($importNotLinkedFile) > 0)
			{
				$i = 1;	
				foreach($importNotLinkedFile as $data)
				{		
					// Parv - Allowing linking to current tree
					$docName = $data['docName'];	
					$arrImportNotFileIds[] = $data['docId'];
					if(trim($data['docName']) == '')
					{
						$fileName = $this->lang->line('txt_Files');	
					}	
					/*Commented by Dashrath- commented old code add new changes code below*/		
					// $importArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['docId'].'" onClick="changeBackgroundSpan2('.$data['docId'].','.$linkSpanOrder.')">'.$docName.'_v'.$data['version'].'</span>'; 	
					// $importArtifactNotLinks2[$data['docId']] = html_entity_decode(strip_tags($docName)).'_v'.$data['version'];

					/*Added by Dashrath- change docCaption to docName and remove version add*/
					$importArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['docId'].'" onClick="changeBackgroundSpan2('.$data['docId'].','.$linkSpanOrder.')">'.$docName.'</span>'; 	
					$importArtifactNotLinks2[$data['docId']] = html_entity_decode(strip_tags($docName));
					/*Dashrath- code end*/

					$i++;
				}
				asort ($importArtifactNotLinks2);		
			}				

			$arrImportedUrls 	= $this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($nodeId,$artifactType);
			
			$indivisualUrl = array();
			if(count($arrImportedUrls) > 0)
			{
				foreach($arrImportedUrls as $key=>$value)
				{
					$indivisualUrl[]="<a target='_blank' href='".$value['url']."' >".$value['title']."</a>";
					$importedUrlsIds[] = $key;
				}
			}

			/*Added by Dashrath- Get all folders*/
			$foldersDetailDocs = $this->identity_db_manager->getFolders($workspaceId, $workspaceType);
			$arrDetails['foldersDetailDocs'] 			= $foldersDetailDocs;
			/*Dashrath- code end*/

			/*Added by Dashrath- import folder section start*/
			$arrImportFolderIds = array();			
			$importFolder 	= $this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($nodeId,$linkType);
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$importCurrentFolder = $this->identity_db_manager->getCurrentLinkedExternalFoldersByArtifactNodeId($nodeId,$linkType,$lastLogin);
			
			if(count($importFolder) > 0)
			{
				$i = 1;	
				foreach($importFolder as $data)
				{	
					$folderName = $data['folderName'];
					$arrImportFolderIds[] = $data['folderId'];	
					if(trim($folderName) == '')
					{
						$folderName = $this->lang->line('txt_Folders');
					}											
					
					// $importArtifactLinksFolder[] = $folderName;
					$importArtifactLinksFolder[] = "<a href=".base_url()."external_docs/index/".$workspaceId."/type/".$workspaceType."/1/".$data['folderId']." target=_blank>".$folderName."</a>";

					$importArtifactLinksFolder2[$data['folderId']] = html_entity_decode(strip_tags($folderName));
					
					$i++;
				}						
			}
			
			if(count($importCurrentFolder) > 0)
			{
				$i = 1;	
				foreach($importCurrentFolder as $data)
				{	
					$folderName = $data['folderName'];
					$arrImportFolderIds[] = $data['folderId'];	
					if(trim($folderName) == '')
					{
						$folderName = $this->lang->line('txt_Folders');
					}
					
					$i++;
				}						
			}

			$arrImportFolderIds[sizeof($arrImportFolderIds)] =0;
									
			$importNotLinkedFolder	= $this->identity_db_manager->getNotLinkedExternalFoldersByArtifactNodeId(7, $workspaceId, $workspaceType, $arrImportFolderIds);	
			

			if(count($importNotLinkedFolder) > 0)
			{
				$i = 1;	
				foreach($importNotLinkedFolder as $data)
				{		
					$folderName = $data['folderName'];	
					$arrImportNotFolderIds[] = $data['folderId'];
					if(trim($data['folderName']) == '')
					{
						$folderName = $this->lang->line('txt_Folders');	
					}	
					
					$importArtifactNotLinksFolder2[$data['folderId']] = html_entity_decode(strip_tags($folderName));

					$i++;
				}
				asort ($importArtifactNotLinksFolder2);		
			}

			// echo '<pre>';
			// print_r($arrImportNotFolderIds);die;		
			/*Dashrath- import folder section end*/

			/*Added by Dashrath- get root folder details*/
			$rootFolderDetails = $this->identity_db_manager->getRootFolderDetails($workspaceId, $workspaceType);
			$arrDetails['rootFolderName'] 			= $rootFolderDetails['name'];
			$arrDetails['rootFolderId'] 			= $rootFolderDetails['folderId'];

			if(!$arrDetails['rootFolderId']>0)
			{
				$arrDetails['rootFolderId'] = 0;
			}
			/*Dashrath- code end*/
			
			$arrDetails['importedUrls'] 			= $indivisualUrl;	
			$arrDetails['docArtifactLinks'] 		= $docArtifactLinks;
			$arrDetails['docArtifactLinks2'] 		= $docArtifactLinks2;
			$arrDetails['docArtifactLinks3'] 		= $docArtifactLinks3;
			$arrDetails['docArtifactNotLinks'] 		= $docArtifactNotLinks;		
			$arrDetails['docArtifactNotLinks2'] 	= $docArtifactNotLinks2;	
			$arrDetails['disArtifactLinks'] 		= $disArtifactLinks;
			$arrDetails['disArtifactLinks2'] 		= $disArtifactLinks2;
			$arrDetails['disArtifactLinks3'] 		= $disArtifactLinks3;
			$arrDetails['disArtifactNotLinks'] 		= $disArtifactNotLinks;
			$arrDetails['disArtifactNotLinks2'] 	= $disArtifactNotLinks2;	
			$arrDetails['chatArtifactLinks'] 		= $chatArtifactLinks;
			$arrDetails['chatArtifactLinks2'] 		= $chatArtifactLinks2;
			$arrDetails['chatArtifactLinks3'] 		= $chatArtifactLinks3;
			$arrDetails['chatArtifactNotLinks'] 	= $chatArtifactNotLinks;
			$arrDetails['chatArtifactNotLinks2'] 	= $chatArtifactNotLinks2;
			$arrDetails['activityArtifactLinks'] 	= $activityArtifactLinks;
			$arrDetails['activityArtifactLinks2'] 	= $activityArtifactLinks2;
			$arrDetails['activityArtifactLinks3'] 	= $activityArtifactLinks3;
			$arrDetails['activityArtifactNotLinks'] = $activityArtifactNotLinks;
			$arrDetails['activityArtifactNotLinks2'] = $activityArtifactNotLinks2;
			$arrDetails['notesArtifactLinks'] 		= $notesArtifactLinks;
			$arrDetails['notesArtifactLinks2'] 		= $notesArtifactLinks2;
			$arrDetails['notesArtifactLinks3'] 		= $notesArtifactLinks3;
			$arrDetails['notesArtifactNotLinks'] 	= $notesArtifactNotLinks;
			$arrDetails['notesArtifactNotLinks2'] 	= $notesArtifactNotLinks2;
			$arrDetails['contactArtifactLinks'] 		= $contactArtifactLinks;
			$arrDetails['contactArtifactLinks2'] 		= $contactArtifactLinks2;
			$arrDetails['contactArtifactLinks3'] 		= $contactArtifactLinks3;
			$arrDetails['contactArtifactNotLinks'] 	= $contactArtifactNotLinks;
			$arrDetails['contactArtifactNotLinks2'] 	= $contactArtifactNotLinks2;
			
			$arrDetails['importArtifactLinks'] 		= $importArtifactLinks;
			$arrDetails['importArtifactLinks2'] 		= $importArtifactLinks2;
			$arrDetails['importArtifactLinks3'] 		= $importArtifactLinks3;
			$arrDetails['importArtifactNotLinks'] 	= $importArtifactNotLinks;
			$arrDetails['importArtifactNotLinks2'] 	= $importArtifactNotLinks2;
			
				
			$arrDetails['docArtifactNewLink'] 		= $docArtifactNewLink;		
			$arrDetails['disArtifactNewLink'] 		= $disArtifactNewLink;
			$arrDetails['chatArtifactNewLink'] 		= $chatArtifactNewLink;
			$arrDetails['activityArtifactNewLink'] 	= $activityArtifactNewLink;
			$arrDetails['notesArtifactNewLink'] 	= $notesArtifactNewLink;
			$arrDetails['contactArtifactNewLink'] 		= $contactArtifactNewLink;
			$arrDetails['workspaceId'] = $workspaceId;
			$arrDetails['workspaceType'] = $workspaceType;
			$arrDetails['nodeId'] = $nodeId;
			$arrDetails['linkType'] = $linkType;
			$arrDetails['nodeOrder'] = $nodeOrder;	
			$arrDetails['linkSpanOrder'] = $linkSpanOrder;
			$arrDetails['arrDocTreeIds'] = $arrDocNotTreeIds;	
			$arrDetails['arrDisTreeIds'] = $arrDisNotTreeIds;		
			$arrDetails['arrChatTreeIds'] = $arrChatNotTreeIds;	
			$arrDetails['arrActivityTreeIds'] = $arrActivityNotTreeIds;	
			$arrDetails['arrNotesTreeIds'] = $arrNotesNotTreeIds;
			$arrDetails['arrContactTreeIds'] = $arrContactNotTreeIds;
			$arrDetails['arrImportFileIds']	= $arrImportNotFileIds;

			/*Added by Dashrath- used for folder link*/
			$arrDetails['arrImportFolderIds'] = $arrImportNotFolderIds;
			$arrDetails['importArtifactLinksFolder2'] = $importArtifactLinksFolder2;
			$arrDetails['importArtifactNotLinksFolder2']  = $importArtifactNotLinksFolder2;
			$arrDetails['importArtifactLinksFolder'] = $importArtifactLinksFolder;
			/*Dashrath- code end*/

			$arrDetails['latestVersion']=$this->uri->segment(9); 
			$arrDetails['mainTreeId'] = $mainTreeId;
			$arrDetails['open'] = $open;
			$arrDetails['treeId']=$data['treeId'];
			$arrDetails['artifactType']=$artifactType; 
			
			//get space tree list
			$arrDetails['spaceTreeDetails']	= $this->identity_db_manager->get_space_tree_type_id($workspaceId);
			
			$arrDetails['leafClearStatus']	= $this->identity_db_manager->getLeafClearStatus($nodeId,'clear_link');
			
			//Check latest version of tree
			$nodeSuccessor = $this->identity_db_manager->checkLeafNewVersion($nodeId);
			$currentLeafStatus = $this->document_db_manager->getLeafStatusByNodeId($nodeId);
			$arrDetails['nodeSuccessor']=$nodeSuccessor;
			$arrDetails['successorLeafStatus']='';
			$arrDetails['currentLeafStatus']=$currentLeafStatus['leafStatus'];
			if($nodeSuccessor!=0 && $nodeSuccessor!='')
			{
				$successorLeafStatus = $this->document_db_manager->getLeafStatusByNodeId($nodeSuccessor);
				$arrDetails['successorLeafStatus']=$successorLeafStatus['leafStatus'];
			}
			
			$currentTreeId = $this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
			$latestTreeVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($currentTreeId);
			$arrDetails['latestTreeVersion']=$latestTreeVersion;
			
			$treeType = $this->identity_db_manager->getTreeTypeByTreeId($currentTreeId);
			$arrDetails['treeType'] = $treeType;
			$arrDetails['currentTreeId']=$currentTreeId;
			
			if($nodeId !='')
			{
				if($artifactType==1)
				{
					$arrDetails['leafTreeId']	= $this->document_db_manager->getLeafTreeIdByLeafId($nodeId,1);
				}
				else
				{
					$arrDetails['leafOwnerData']	= $this->identity_db_manager->getLeafIdByNodeId($nodeId);
					$arrDetails['leafId'] = $arrDetails['leafOwnerData']['id'];
					
					if($treeType == 1)
					{
						$arrDetails['leafTreeId']	= $this->document_db_manager->getLeafTreeIdByLeafId($arrDetails['leafOwnerData']['id']);
					}
					else
					{
						$arrDetails['leafTreeId']	= $this->document_db_manager->getLeafTreeIdByLeafId($nodeId);
					}
				}
			}
			
			//Check leaf status start
			if($artifactType==1)
			{
				$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($nodeId);
			}
			else
			{
				$treeMoveSpaceId = $objIdentity->getWorkspaceIdByTreeId($currentTreeId);
			}
			
			$contactStatus = '';
			if($treeType==5)
			{
				$Contactdetail = $this->contact_list->getlatestContactDetails($currentTreeId);
				$contactStatus = $Contactdetail['sharedStatus'];
			}
			
			$workSpaceId = $workspaceId;			
			if(($treeMoveSpaceId != $workSpaceId) && $treeMoveSpaceId!='' && $workSpaceId!='' && $contactStatus!=1)		
			{
				$arrDetails['spaceMoved'] = '1';
			}
			
			if($treeType==1 && $artifactType==2)
			{
				$arrDetails['leafAlertNo'] = '';
				$arrDetails['leafAlertMsg'] = '';
			
			    $currentNodeOrder = $this->identity_db_manager->getNodePositionByNodeId($nodeId);
				$arrDetails['currentNodeOrder'] = $currentNodeOrder;
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($currentTreeId, $currentNodeOrder);
				$arrDetails['parentLeafId'] = $leafParentData['parentLeafId'];
				
				$contributors 				= $this->document_db_manager->getDocsContributors($currentTreeId);
	
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
					$arrDetails['leafAlertNo'] = 2;
					$arrDetails['leafAlertMsg'] = $this->lang->line('txt_new_version_leaf_created');
				}
				
				//Check user resevation status
				//if (!in_array($_SESSION['userId'],$contributorsUserId) || (!in_array($_SESSION['userId'], $resUserIds) && count($resUserIds)!=0 && $currentLeafStatus['leafStatus'] == 'publish') || (!in_array($_SESSION['userId'], $resUserIds) && $currentLeafStatus['leafStatus'] == 'draft'))
				if ((!in_array($_SESSION['userId'], $resUserIds) && $currentLeafStatus['leafStatus'] == 'draft'))
				{
						$arrDetails['leafAlertNo'] = 1;
						$arrDetails['leafAlertMsg'] = $this->lang->line('txt_remove_from_reserved_list');
						$arrDetails['leafDraftReserveStatus'] = 1;
				}
				
				//Check leaf discard status
				if($currentLeafStatus['leafStatus']=='discarded')
				{
					$arrDetails['leafAlertNo'] = 3;
					$arrDetails['leafAlertMsg'] = $this->lang->line('txt_leaf_has_discarded');
				}	
				
				//Check leaf publish status
				/*if($currentLeafStatus['leafStatus']=='publish' && $treeLeafStatus == 'draft')
				{
					$arrTag['leafAlertNo'] = 4;
					$arrTag['leafAlertMsg'] = $this->lang->line('txt_leaf_made_final');
				}*/	
				
				if($latestTreeVersion != 1)
				{
					$arrDetails['leafAlertNo'] = 6;
					$arrDetails['leafAlertMsg'] = $this->lang->line('txt_new_version_tree_created');
				}
			}
			
			if(($treeType==4 || $treeType==6) && $artifactType==2)
			{
				/*$contributors 	= $this->notes_db_manager->getNotesContributors($currentTreeId);
				
				$contributorsUserId	= array();	
				foreach($contributors  as $userData)
				{
					$contributorsUserId[] 	= $userData['userId'];	
				}
				
				if (!in_array($_SESSION['userId'],$contributorsUserId))
				{
					$arrDetails['leafDraftReserveStatus'] = 1;
				}*/
			}
			//Check leaf status end
			
			if($_COOKIE['ismobile'])
			{
			   $this->load->view('common/links/show_artifact_links_for_mobile', $arrDetails);
			}
			else
			{
			   $this->load->view('common/links/show_artifact_links', $arrDetails);
			}
			   
		}
	}
	
	function apply ()
	{
			$this->load->model('dal/notification_db_manager');	
			$this->load->model('dal/identity_db_manager');
			//Manoj: load time manager
			$this->load->model('dal/time_manager');
			$linkCreatedDate	= $this->time_manager->getGMTTime();
			$objTime		= $this->time_manager;	
			//Manoj load time manager end
			$objIdentity	= $this->identity_db_manager;	
			$objNotification = $this->notification_db_manager;
			$this->load->model('dal/timeline_db_manager');
		
			$sectionType	= $this->input->post('sectionType');
			$nodeId			= $this->input->post('nodeId');
			$linkType		= $this->input->post('linkType');
			$linkSpanOrder	= $this->input->post('linkSpanOrder');
			$mainTreeId		= $this->input->post('mainTreeId');
			$docLinks		= $this->input->post('doclinks',true);
			
			$ownerId = $_SESSION['userId'];
			
			if($docLinks!='')
			{
				$docLinks=explode(",",$docLinks);
			}
			 
			$importLinks	= $this->input->post('importlinks');
			if($importLinks!='')
			{
				$importLinks=explode(",",$importLinks);
			}

			/*Added by Dashrath- used for folder link*/
			$importFolderLinks	= $this->input->post('importFolderlinks');

			if($importFolderLinks!='')
			{
				$importFolderLinks=explode(",",$importFolderLinks);
			}
			/*Dashrath- code end*/

			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$latestVersion = $this->input->post('latestVersion');
			$sectionLinkIds = $this->input->post('sectionLinkIds');
			$docSectionLinkIds = $this->input->post('docSectionLinkIds');
			$disSectionLinkIds = $this->input->post('disSectionLinkIds');
			$chatSectionLinkIds = $this->input->post('chatSectionLinkIds');
			$notesSectionLinkIds = $this->input->post('notesSectionLinkIds');
			$activitySectionLinkIds = $this->input->post('activitySectionLinkIds');
			$contactSectionLinkIds = $this->input->post('contactSectionLinkIds');
			$importSectionLinkIds = $this->input->post('importSectionLinkIds');
            
            /*Added by Dashrath- used for folder link*/
			$importSectionLinkFolderIds = $this->input->post('importSectionLinkFolderIds');
			/*Dashrath- code end*/

			$sectionChecked = array();
			$sectionChecked = explode(',',$this->input->post('sectionChecked'));

			$appliedDocLinkIds = array();
			$appliedDocLinkIds = $this->input->post('appliedDocLinkIds');
			
			$docLinkIds = implode(",",$docLinks);

			$importLinkIds = implode(",",$importLinks);
			
			/*Added by Dashrath- used for folder link*/
			$importFolderLinksIds = implode(",",$importFolderLinks);
			/*Dashrath- code end*/

			if (empty($sectionLinkIds) && $sectionType=='doc')
			{
				$sectionLinkIds = $docSectionLinkIds;
			}
			if (empty($sectionLinkIds) && $sectionType=='dis')
			{
				$sectionLinkIds = $disSectionLinkIds;
			}
			if (empty($sectionLinkIds) && $sectionType=='chat')
			{
				$sectionLinkIds = $chatSectionLinkIds;
			}
			if (empty($sectionLinkIds) && $sectionType=='notes')
			{
				$sectionLinkIds = $notesSectionLinkIds;
			}
			if (empty($sectionLinkIds) && $sectionType=='activity')
			{
				$sectionLinkIds = $activitySectionLinkIds;
			}
			if (empty($sectionLinkIds) && $sectionType=='contact')
			{
				$sectionLinkIds = $contactSectionLinkIds;
			}

			$this->identity_db_manager->removeLinks ($sectionLinkIds,$nodeId,$linkType);
			
			$importType =  $this->input->post('linkTypeId');
			if($importType == 'import')
			{
				$this->identity_db_manager->removeExternalLinks ($importSectionLinkIds,$nodeId,$linkType);
			}

			/*Added by Dashrath- used for folder link remove*/
			if($importType == 'importFolder')
			{
				$this->identity_db_manager->removeExternalFolderLinks ($importSectionLinkFolderIds,$nodeId,$linkType);
			}
			/*Dashrath- code end*/

			if ($docLinkIds)
			{
				$sectionLinks = explode (",",$sectionLinkIds);
					
				foreach($docLinks as $key=>$value)
				{		
					if ((!empty($value)) && (in_array($value,$sectionLinks)))
					{
						$this->identity_db_manager->addLinks ($value,$nodeId,$linkType,$linkCreatedDate,$ownerId);       //Manoj: Added extra parameter linkCreatedDate

						/*Added by Dashrath- make added link ids array for notification*/
						$docLinks1[] = $value;
						/*Dashrath- code end*/
					}
				}
				//$this->identity_db_manager->updateTreeLinksMemCache($workSpaceId,$workSpaceType);
				$_SESSION['errorMsg'] = 'Link(s) applied successfully';	
				
					
			}
			if($importType == 'import')
			{
				if ($importLinkIds)
				{   
					if ($this->identity_db_manager->addExternalLinks ($importLinkIds,$nodeId,$linkType,$ownerId))
					{
						$_SESSION['errorMsg'] = 'Link(s) applied successfully';
					}
				}
			}

			/*Added by Dashrath- used for folder link add*/
			if($importType == 'importFolder')
			{
				if ($importFolderLinksIds)
				{   
					if ($this->identity_db_manager->addExternalFolderLinks ($importFolderLinksIds,$nodeId,$linkType,$ownerId))
					{
						$_SESSION['errorMsg'] = 'Link(s) applied successfully';
					}
				}
			}
			/*Dashrath- code end*/

			//$this->identity_db_manager->updateFileLinksMemCache($workSpaceId,$workSpaceType);
			
			/*Changed by Dashrath- Add $importFolderLinksIds in if condition*/
			if(($importLinkIds && $importType=='import') || ($docLinkIds && count($docLinks1)>0) || ($importFolderLinksIds && $importType=='importFolder')){
			
			//Manoj: Insert link apply notification start
								
								$tree_id=$this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
								
								//Add post tag change details start
								if($tree_id==0)
								{
										//3 for add tag in post change table
										$change_type=4;
										$postChangeStatus = $this->timeline_db_manager->add_post_change_details($change_type,$objTime->getGMTTime(),$nodeId,$_SESSION['userId'],$workSpaceId,$workSpaceType);
										$postOrderChange = $this->timeline_db_manager->change_post_order($nodeId,$objTime->getGMTTime());
								}
								//Add post tag change details end
				
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($tree_id);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='7';
								$notificationDetails['action_id']='4';

								/*Added by Dashrath- Check object is tree or leaf*/
								if($linkType==1)
								{
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$nodeId;
								}
								else if($linkType==2)
								{
									if($tree_id==0)
									{
										$notificationDetails['parent_object_id']='3';
									}
									else
									{
										$notificationDetails['parent_object_id']='2';
										$notificationDetails['parent_tree_id']=$tree_id;
									}
								}
								/*Dashrath- code end*/
								
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
								if($linkType==1)
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
								
								//Add link data
										/*echo '===test===';
										print_r($docLinks);
										exit;*/

										/*Added by Dashrath- add if condtion*/
										if($importType=='import' && $importLinkIds!='')
										{
											$importLinkIds1 = explode(",", $importLinkIds);
											$linkIdArray=array_reverse($importLinkIds1);
											$i=0;
											if(count($linkIdArray)>2)
											{
												$totalLinkCount = count($linkIdArray)-2;	
												$otherTxt=str_replace('{notificationCount}', $totalLinkCount ,$this->lang->line('txt_notification_count'));
											}
											foreach($importLinkIds1 as $link_id)
											{
												if($i<2)
												{
													$getLinkName = $this->identity_db_manager->getExternalFileDetailsById($link_id);

													$getLinkName = $getLinkName['docName'];
													$getLinkName=strip_tags($getLinkName);
													if(strlen($getLinkName) > 20)
													{
														$getLinkName = substr($getLinkName, 0, 20) . "..."; 
													}
													if($getLinkName!='')
													{
														$LinkNameArray[] = '"'.$getLinkName.'"';
													}
												}
												$i++;
											}	
											$linkName=implode(', ',$LinkNameArray).' '.$otherTxt;
										}
										/*Dashrath- code end*/

										if($importType=='importFolder' && $importFolderLinksIds!='')
										{
											$importFolderLinksIds1 = explode(",", $importFolderLinksIds);
											$linkIdArray=array_reverse($importFolderLinksIds1);
											$i=0;
											if(count($linkIdArray)>2)
											{
												$totalLinkCount = count($linkIdArray)-2;	
												$otherTxt=str_replace('{notificationCount}', $totalLinkCount ,$this->lang->line('txt_notification_count'));
											}
											foreach($importFolderLinksIds1 as $link_id)
											{
												if($i<2)
												{
													$getLinkName = $this->identity_db_manager->getFolderNameByFolderId($link_id);

													$getLinkName=strip_tags($getLinkName);
													if(strlen($getLinkName) > 20)
													{
														$getLinkName = substr($getLinkName, 0, 20) . "..."; 
													}
													if($getLinkName!='')
													{
														$LinkNameArray[] = '"'.$getLinkName.'"';
													}
												}
												$i++;
											}	
											$linkName=implode(', ',$LinkNameArray).' '.$otherTxt;
										}
										/*Dashrath- code end*/

										/*Changed by Dashrath- only add if condtion check*/
										if($importType!='import' && $importType!='importFolder' && count($docLinks1)>0)
										{
											$linkIdArray=array_reverse($docLinks1);
											$i=0;
											if(count($linkIdArray)>2)
											{
												$totalLinkCount = count($linkIdArray)-2;	
												$otherTxt=str_replace('{notificationCount}', $totalLinkCount ,$this->lang->line('txt_notification_count'));
											}
											foreach($docLinks1 as $link_id)
											{
												if($i<2)
												{
													$getLinkName = $this->notification_db_manager->getTreeNameByTreeId($link_id);
													$getLinkName=strip_tags($getLinkName);
													if(strlen($getLinkName) > 20)
													{
														$getLinkName = substr($getLinkName, 0, 20) . "..."; 
													}
													if($getLinkName!='')
													{
														$LinkNameArray[] = '"'.$getLinkName.'"';
													}
												}
												$i++;
											}	
											$linkName=implode(', ',$LinkNameArray).' '.$otherTxt;
										}
										//echo $linkName.'===test==';
										//exit;
										
										$notificationData['data']=$linkName;
										$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
										$notificationDetails['notification_data_id']=$notification_data_id;
							//Add link data end
								
								/*if($notificationDetails['url']!='')	
								{*/	
									if($linkType==1)
									{
										$objectInstanceId=$tree_id;
									}	
									else if($linkType==2)
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
										//get originator id
										$importType =  $this->input->post('linkTypeId');
										if($importType == 'import')
										{
											$importedFileIdArray = explode (",",$importLinkIds);
											foreach($importedFileIdArray as $value)
											{	 			
												$tag = $value;
												$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$tag);
												if($originatorUserId!='')
												{
													$originatorIdArray[] = $originatorUserId;
												}
											}
											
										}
										

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
															if ($tree_type_val=='') $tree_type = 'post';
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
				
				$membersList = $objIdentity->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
					
				foreach($membersList as $mem){
					switch($sectionType){
						
					case 'doc':
							$typeId = 8;
							 break;
					case 'chat':
							$typeId = 9;
							 break;
					case 'activity':
							$typeId = 10;
							 break;
					case 'notes':
							$typeId = 11;
							 break;
					case 'contact':
							$typeId = 12;
							 break;
					default:
							if($importlinks){
								$typeId = 13;
							}
							else{
								$typeId = 14;
							}
							 break;
					}
					$userId = $mem['userId'];	
					//notification feature code(temporarily disabled)
					/*$notifySubscriptions 	= $objNotification->getUserSubscriptions($typeId,$userId);
					if($notifySubscriptions['types']){
						$notificationMail 		= $objNotification->getNotificationTypes($typeId);
						
						$userDetail = $objIdentity->getUserDetailsByUserId($userId);
						
						$to 	 = $userDetail['userName'];//"monika.singh@ideavate.com";
						
						$subject = $notificationMail[0]["template_subject"];
						$body    = $notificationMail[0]["template_body"];
						$treeId=$this->input->post('treeId');	
						//$body    = $body."</ br>"."<a href='".base_url()."view_document/index/$workSpaceId/type/1/&treeId=$treeId&doc=exist'>Click here</a> to view";						
						
						$returnUrl = $_POST['returnUrl'];
								
						
						$url = "<a href='$returnUrl'>$returnUrl</a>";
						//$url = "<a href='".base_url()."view_document/index/".$workSpaceId."/type/".$workSpaceType."/&treeId=".$treeId."&doc=".$this->uri->segment(4)."'>".base_url()."view_document/index/".$workSpaceId."/type/".$workSpaceType."/&treeId=".$treeId."&doc=".$this->uri->segment(4)."</a>";
						$body = str_replace ('{$url}',$url,$body);
						//$body  = substr($body,0,$first)." ".$_POST['curContent']." ".substr($body,$last+1);
						//$body  = $body."</ br>"."<a href='".base_url()."'>Click here</a> to view";
						$params = array('subject'=>$subject,'body'=>$body,'optionId'=>0,'userId'=>$userId,'workspaceId'=>$workSpaceId);
						$notification  = $objNotification->addNotification($params);
						$param = array("to"=>$to,"subject"=>$subject,"body"=>$body);
						//$objNotification->sendNotification($param);
										
					}*/
				}
			}
			
			$link = 'show_artifact_links/index/'.$nodeId.'/'.$linkType.'/'.$workSpaceId.'/'.$workSpaceType.'/'.$linkType.'/'.$linkSpanOrder.'/'.$latestVersion.'/open';
			redirect($link,'location');					
	}
	
	function countAppliedLinks($treeId,$nodeId,$artifactType,$nodeType)
	{
		 if($artifactType==1)
		 	$id=$treeId;
		 else
		 	$id=$nodeId;
		
		$this->load->model('dal/identity_db_manager');
		$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($id,1,$artifactType); 
		
		$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($id,2,$artifactType);
		$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($id,3,$artifactType);
		$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($id,4,$artifactType);
		$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($id,5,$artifactType);
		$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($id,6,$artifactType);
		$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($id, $artifactType);	
		
		echo sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7);
		
	}
	
	
	function searchLinksByKeyword()
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
			$this->load->model('dal/tag_db_manager');						
			$objIdentity			= $this->identity_db_manager;	
			$nodeId 				= $this->uri->segment(3);	
			$artifactType 			= $this->uri->segment(4);				
			$workspaceId 			= $this->uri->segment(5);		
			$workspaceType 			= $this->uri->segment(6);
			$linkType				= $this->uri->segment(7);	
			$nodeOrder				= $this->uri->segment(8);
			$latestVersion			= $this->uri->segment(9);	
			$open					= $this->uri->segment(10);	
			$searchLinks			= $this->input->post('searchLinks',true);
			

			$linkSpanOrder			= $nodeOrder;						
			$artifactLinks			= array();
			$arrDetails				= array();
			$docArtifactLinks 		= array();
			$docArtifactLinks2		= array();
			$docArtifactLinks3 		= array();
			$docArtifactNotLinks 	= array();
			$docArtifactNotLinks2 	= array();
			$disArtifactLinks 		= array();
			$disArtifactLinks2 		= array();
			$disArtifactLinks3 		= array();
			$disArtifactNotLinks 	= array();
			$disArtifactNotLinks2 	= array();
			$chatArtifactLinks 		= array();
			$chatArtifactLinks2 	= array();
			$chatArtifactLinks3 	= array();
			$chatArtifactNotLinks 	= array();
			$chatArtifactNotLinks2 	= array();
			$activityArtifactLinks 	= array();
			$activityArtifactLinks2 = array();	
			$activityArtifactLinks3 = array();		
			$activityArtifactNotLinks 	= array();
			$activityArtifactNotLinks2 	= array();
			$notesArtifactLinks 	= array();
			$notesArtifactLinks2 	= array();
			$notesArtifactLinks3 	= array();	
			$notesArtifactNotLinks 	= array();
			$notesArtifactNotLinks2	= array();
			$arrDocNotTreeIds = array();	
			$arrDisNotTreeIds = array();
			$arrChatNotTreeIds = array();
			$arrActivityNotTreeIds = array();	
			$arrNotesNotTreeIds = array();	
			$artifactNewLink 		= '';	
			$dispLabel = '';
			$mainTreeId =$this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
			
			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 1, $linkType);
			
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$docCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 1, $linkType,$lastLogin);
			
			$arrDocTreeIds = array();	
			if(count($docTrees) > 0)
			{
				$i = 1;	
				foreach($docTrees as $data)
				{	
					$treeName = $data['name'];
					$arrDocTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Document');
					}					
					$docArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workspaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.strip_tags($treeName).'</a>'; 	
					$docArtifactLinks2[$data['treeId']] = strip_tags($treeName);
					$i++;
				}					
			}
			
			if(count($docCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($docCurrentTrees as $data)
				{	
					$treeName = $data['name'];
					$arrDocTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Document');
					}					
					$docArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".strip_tags($treeName)."</option>";
					
					$i++;
				}					
			}
			
			$arrDocTreeIds[sizeof($arrDocTreeIds)] =0;
			$docNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(1, $workspaceId, $workspaceType, $arrDocTreeIds,$mainTreeId);	
			
			if(count($docNotLinkedTrees) > 0)
			{
				$i = 1;		
				$show = 0;		
				foreach($docNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);	
						
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$arrDocNotTreeIds[] = $data['treeId'];				
							$docArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($data['name']).'</span>'; 	
		
							$docArtifactNotLinks2[$data['treeId']] = strip_tags($data['name']);
							$docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
						}
					}
					else
					{
						$arrDocNotTreeIds[] = $data['treeId'];				
						$docArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($data['name']).'</span>'; 	
						$docArtifactNotLinks2[$data['treeId']] = strip_tags($data['name']);
						$docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
					}
					$i++;
				}	
				asort ($docArtifactNotLinks2);
					
			}		
			$docArtifactNewLink 		= '<a href="'.base_url().'document_new/index/'.$workspaceId.'/type/'.$workspaceType.'/'.$nodeId.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';	
			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 2, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$disCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 2, $linkType,$lastLogin);
			
			$arrDisTreeIds = array();
			if(count($disTrees) > 0)
			{
				$i = 1;	
				foreach($disTrees as $data)
				{	
					$treeName = $data['name'];	
					$arrDisTreeIds[] = $data['treeId'];
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Discussion');
					}													
					$disArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.strip_tags($treeName).'</a>'; 	
					$disArtifactLinks2[$data['treeId']] = strip_tags($treeName);
					$i++;
				}					
			}
			
			if(count($disCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($disCurrentTrees as $data)
				{	
					$treeName = $data['name'];	
					$arrDisTreeIds[] = $data['treeId'];
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Discussion');
					}													
					$disArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".strip_tags($treeName)."</option>";
					$i++;
				}					
			}
		
			$arrDisTreeIds[sizeof($arrDisTreeIds)] =0;
			$disArtifactNewLink 		= '<a href="'.base_url().'new_discussion/start_Discussion/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$disNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(2, $workspaceId, $workspaceType, $arrDisTreeIds,$mainTreeId);	
			if(count($disNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($disNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
							if ((in_array($_SESSION['userId'],$sharedMembers)))
							{
								$treeName = $data['name'];
								$arrDisNotTreeIds[] = $data['treeId'];		
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Discussion');	
								}			
								$disArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 	
								$disArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
							}
					}
					else
					{
						$treeName = $data['name'];
						$arrDisNotTreeIds[] = $data['treeId'];		
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Discussion');	
						}			
						$disArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 	
						$disArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
					}

					$i++;
				}
				asort ($disArtifactNotLinks2);						
			}		
			
			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 3, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$chatCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 3, $linkType,$lastLogin);
			
			$arrChatTreeIds = array();
			if(count($chatTrees) > 0)
			{
				$i = 1;	
				foreach($chatTrees as $data)
				{
					$treeName = $data['name'];	
					$arrChatTreeIds[] = $data['treeId'];	
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Chat');	
					}									
					$chatArtifactLinks[] = '<a href="'.base_url().'view_chat/chat_view/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.strip_tags($treeName).'</a>'; 	
					$chatArtifactLinks2[$data['treeId']] = strip_tags($treeName);
					
					$i++;
				}						
			}
			
			if(count($chatCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($chatCurrentTrees as $data)
				{
					$treeName = $data['name'];	
					$arrChatTreeIds[] = $data['treeId'];	
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Chat');	
					}									
					$chatArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".strip_tags($treeName)."</option>";
					$i++;
				}						
			}
		
			$arrChatTreeIds[sizeof($arrChatTreeIds)] =0;
			$chatArtifactNewLink 	= '<a href="'.base_url().'new_chat/start_Chat/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$chatNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(3, $workspaceId, $workspaceType, $arrChatTreeIds,$mainTreeId);	
			if(count($chatNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($chatNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
							if ((in_array($_SESSION['userId'],$sharedMembers)))
							{
								$treeName = $data['name'];	
								$arrChatNotTreeIds[] = $data['treeId'];		
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Chat');	
								}			
								$chatArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 
								$chatArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
							}
					}
					else
					{
						$treeName = $data['name'];	
						$arrChatNotTreeIds[] = $data['treeId'];		
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Chat');	
						}			
						$chatArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 
						$chatArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
					}
					$i++;
				}
				asort ($chatArtifactNotLinks2);							
			}		
			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 4, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$activityCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 4, $linkType,$lastLogin);
			
			$arrActivityTreeIds = array();		
			if(count($activityTrees) > 0)
			{
				$i = 1;	
				foreach($activityTrees as $data)
				{
					$treeName = $data['name'];	
					$arrActivityTreeIds[] = $data['treeId'];		
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Activity');	
					}															
					$activityArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'/1" target="_blank">'.strip_tags($treeName).'</a>'; 	
					$activityArtifactLinks2[$data['treeId']] = strip_tags($treeName);
					$i++;
				}						
			}
			if(count($activityCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($activityCurrentTrees as $data)
				{
					$treeName = $data['name'];	
					$arrActivityTreeIds[] = $data['treeId'];		
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Activity');	
					}															
					$activityArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".strip_tags($treeName)."</option>";
					$i++;
				}						
			}
		
			$arrActivityTreeIds[sizeof($arrActivityTreeIds)] = 0;
			$activityArtifactNewLink 	= '<a href="'.base_url().'new_task/start_Task/'.$nodeId.'/index/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$activityNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(4, $workspaceId, $workspaceType, $arrActivityTreeIds,$mainTreeId);	
			if(count($activityNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($activityNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$treeName = $data['name'];	
							$arrActivityNotTreeIds[] = $data['treeId'];	
							if(trim($data['name']) == '')
							{
								$treeName = $this->lang->line('txt_Activity');	
							}			
							$activityArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 	
							$activityArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
						}
					}
					else
					{
						$treeName = $data['name'];	
						$arrActivityNotTreeIds[] = $data['treeId'];	
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Activity');	
						}			
						$activityArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 	
						$activityArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
					}

					$i++;
				}
				asort ($activityArtifactNotLinks2);							
			}
			
			
			$arrNotesTreeIds = array();			
			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 6, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$notesCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 6, $linkType,$lastLogin);
			
			if(count($notesTrees) > 0)
			{
				$i = 1;	
				foreach($notesTrees as $data)
				{	
					$treeName = $data['name'];
					$arrNotesTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Notes');
					}											
					$notesArtifactLinks[] = '<a href="'.base_url().'notes/Details/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.strip_tags($treeName).'</a>'; 	
					$notesArtifactLinks2[$data['treeId']] = strip_tags($treeName);
					$i++;
				}	
									
			}
			
			if(count($notesCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($notesCurrentTrees as $data)
				{	
					$treeName = $data['name'];
					$arrNotesTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Notes');
					}											
					$notesArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".strip_tags($treeName)."</option>";
					$i++;
				}						
			}
			
			$arrNotesTreeIds[sizeof($arrNotesTreeIds)] =0;
			$notesArtifactNewLink 	= '<a href="'.base_url().'notes/New_Notes/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$notesNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(6, $workspaceId, $workspaceType, $arrNotesTreeIds,$mainTreeId);	
			if(count($notesNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($notesNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
							if ((in_array($_SESSION['userId'],$sharedMembers)))
							{
								$treeName = $data['name'];	
								$arrNotesNotTreeIds[] = $data['treeId'];
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Notes');	
								}			
								$notesArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 	
								$notesArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
							}
					}
					else
					{
						$treeName = $data['name'];	
						$arrNotesNotTreeIds[] = $data['treeId'];
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Notes');	
						}			
						$notesArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 	
						$notesArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
					}
					
					$i++;
				}
				asort ($notesArtifactNotLinks2);							
			}	
			
			
			
			$arrContactTreeIds = array();			
			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 5, $linkType);
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$contactCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 5, $linkType,$lastLogin);
			
			if(count($contactTrees) > 0)
			{
				$i = 1;	
				foreach($contactTrees as $data)
				{	
					$treeName = $data['name'];
					$arrContactTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Contacts');
					}											
					$contactArtifactLinks[] = '<a href="'.base_url().'contact/contactDetails/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.strip_tags($treeName).'</a>'; 	
					$contactArtifactLinks2[$data['treeId']] = strip_tags($treeName);
					$i++;
				}						
			}
			
			if(count($contactCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($contactCurrentTrees as $data)
				{	
					$treeName = $data['name'];
					$arrContactTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Contacts');
					}											
					$contactArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".strip_tags($treeName)."</option>";
					$i++;
				}						
			}
			
			$arrContactTreeIds[sizeof($arrContactTreeIds)] =0;
			$contactArtifactNewLink = '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$contactNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(5, $workspaceId, $workspaceType, $arrContactTreeIds,$mainTreeId);	
	
			if(count($contactNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($contactNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
							if ((in_array($_SESSION['userId'],$sharedMembers)))
							{
								$treeName = $data['name'];	
								$arrContactNotTreeIds[] = $data['treeId'];
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Contacts');	
								}			
								$contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 	
								$contactArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
							}
					}
					else
					{
						$treeName = $data['name'];	
						$arrContactNotTreeIds[] = $data['treeId'];
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Contacts');	
						}			
						$contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.strip_tags($treeName).'</span>'; 	
						$contactArtifactNotLinks2[$data['treeId']] = strip_tags($treeName);
					}
					
					$i++;
				}
				asort ($contactArtifactNotLinks2);						
			}	


			$arrImportFileIds = array();			
			$importFile 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($nodeId,$linkType);
	
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$importCurrentFile = $this->identity_db_manager->getCurrentLinkedExternalDocsByArtifactNodeId($nodeId,$linkType,$lastLogin);
			
			if(count($importFile) > 0)
			{
				$i = 1;	
				foreach($importFile as $data)
				{	
					$docName = $data['docName'];
					$arrImportFileIds[] = $data['docId'];	
					if(trim($docName) == '')
					{
						$docName = $this->lang->line('txt_Files');
					}											
					
					/*Commented by Dashrath- commented old code add new changes code below*/
					// $importArtifactLinks[] = "<a href=".base_url()."ext_file/index/".$data['docId']." target=_blank>".$docName.'_v'.$data['version']."</a>";
	
					// $importArtifactLinks2[$data['docId']] = strip_tags($docName).'_v'.$data['version'];

					/*Added by Dashrath- change docCaption to docName and remove version add*/
					$importArtifactLinks[] = "<a href=".base_url()."ext_file/index/".$data['docId']." target=_blank>".$docName."</a>";
	
					$importArtifactLinks2[$data['docId']] = strip_tags($docName);
					/*Dashrath- code end*/

					$i++;
				}						
			}
			
			if(count($importCurrentFile) > 0)
			{
				$i = 1;	
				foreach($importCurrentFile as $data)
				{	
					$docName = $data['docName'];
					$arrImportFileIds[] = $data['docId'];	
					if(trim($docName) == '')
					{
						$docName = $this->lang->line('txt_Files');
					}
					/*Commented by Dashrath- commented old code add new changes code below*/											
					// $importArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['docId']." value=".$data['docId'].">".strip_tags($docName).'_v'.$data['version']."</option>";

					/*Added by Dashrath- change docCaption to docName and remove version add*/
					$importArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['docId']." value=".$data['docId'].">".strip_tags($docName)."</option>";
					/*Dashrath- code end*/

					$i++;
				}						
			}
			
			$arrImportFileIds[sizeof($arrImportFileIds)] =0;
			$importArtifactNewLink 	= '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$importNotLinkedFile 	= $this->identity_db_manager->getNotLinkedExternalDocsByArtifactNodeId(7, $workspaceId, $workspaceType, $arrImportFileIds);	
			
			if(count($importNotLinkedFile) > 0)
			{
				$i = 1;	
				foreach($importNotLinkedFile as $data)
				{		
					// Parv - Allowing linking to current tree
					$docName = $data['docName'];	
					$arrImportNotFileIds[] = $data['docId'];
					if(trim($data['docName']) == '')
					{
						$fileName = $this->lang->line('txt_Files');	
					}

					/*Commented by Dashrath- commented old code add new changes code below*/		
					// $importArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['docId'].'" onClick="changeBackgroundSpan2('.$data['docId'].','.$linkSpanOrder.')">'.$docName.'_v'.$data['version'].'</span>'; 	
					// $importArtifactNotLinks2[$data['docId']] = strip_tags($docName).'_v'.$data['version'];

					/*Added by Dashrath- change docCaption to docName and remove version add*/
					$importArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['docId'].'" onClick="changeBackgroundSpan2('.$data['docId'].','.$linkSpanOrder.')">'.$docName.'</span>'; 	
					$importArtifactNotLinks2[$data['docId']] = strip_tags($docName);
					/*Dashrath- code end*/

					$i++;
				}
				asort ($importArtifactNotLinks2);		
			}				
	
			
			/*Added by Dashrath- import folder section start*/
			$arrImportFolderIds = array();			
			$importFolder 	= $this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($nodeId,$linkType);
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$importCurrentFolder = $this->identity_db_manager->getCurrentLinkedExternalFoldersByArtifactNodeId($nodeId,$linkType,$lastLogin);
			
			if(count($importFolder) > 0)
			{
				$i = 1;	
				foreach($importFolder as $data)
				{	
					$folderName = $data['folderName'];
					$arrImportFolderIds[] = $data['folderId'];	
					if(trim($folderName) == '')
					{
						$folderName = $this->lang->line('txt_Folders');
					}											
					
					$importArtifactLinksFolder2[$data['folderId']] = html_entity_decode(strip_tags($folderName));
					
					$i++;
				}						
			}
			
			if(count($importCurrentFolder) > 0)
			{
				$i = 1;	
				foreach($importCurrentFolder as $data)
				{	
					$folderName = $data['folderName'];
					$arrImportFolderIds[] = $data['folderId'];	
					if(trim($folderName) == '')
					{
						$folderName = $this->lang->line('txt_Folders');
					}
					
					$i++;
				}						
			}

			$arrImportFolderIds[sizeof($arrImportFolderIds)] =0;
									
			$importNotLinkedFolder	= $this->identity_db_manager->getNotLinkedExternalFoldersByArtifactNodeId(7, $workspaceId, $workspaceType, $arrImportFolderIds);	
			

			if(count($importNotLinkedFolder) > 0)
			{
				$i = 1;	
				foreach($importNotLinkedFolder as $data)
				{		
					$folderName = $data['folderName'];	
					$arrImportNotFolderIds[] = $data['folderId'];
					if(trim($data['folderName']) == '')
					{
						$folderName = $this->lang->line('txt_Folders');	
					}	
					
					$importArtifactNotLinksFolder2[$data['folderId']] = html_entity_decode(strip_tags($folderName));

					$i++;
				}
				asort ($importArtifactNotLinksFolder2);		
			}	
			/*Dashrath- import folder section end*/
		}
         $documentSearched='';
		 $disSearched='';
		 $chatSearched='';
		 $chatSearched='';
		 $activitySearched='';
		 $contactSearched='';
		 $importFileSearched='';
		 $importFolderSearched='';
		
		
		
		
		if($this->input->post('documentType')=='docs')
		{
			if(count($docArtifactLinks2) > 0)
			{
			 	foreach($docArtifactLinks2 as $key=>$value)
				{ 
					 if(preg_match('/^'.$searchLinks."/i",trim($value)))
					 { 
						$documentSearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'" checked="checked"/><span class="clsCheckedTags" >'.$value.'</span><br />';
					 }
				}
			}
			
			if(count($docArtifactNotLinks2) > 0)
			{
			   foreach($docArtifactNotLinks2 as $key=>$value)
			   {
				   	if(preg_match("/^".$searchLinks."/i",trim($value)))
					{
						$documentSearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'"  />'.$value.'<br />';
					}
			   }	
			}
			echo $documentSearched; 
		}
		elseif($this->input->post('documentType')=='chat')
		{    
			if(count($chatArtifactLinks2) > 0)
			{
				foreach($chatArtifactLinks2 as $key=>$value)
				{
					if(preg_match('/^'.$searchLinks."/i",trim($value)))
					{ 
						$chatSearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'" checked="checked"/><span class="clsCheckedTags" >'.$value.'</span><br />';
					}	
				}
			}
			if(count($chatArtifactNotLinks2) > 0)
			{
				foreach($chatArtifactNotLinks2 as $key=>$value)
				{
					if(preg_match('/^'.$searchLinks."/i",trim($value)))
					{ 
						$chatSearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'" />'.$value.'<br />';
					}	
				}
			}
		  echo $chatSearched; 
		
		}
		
		elseif($this->input->post('documentType')=='activity')
		{
			if(count($activityArtifactLinks2) > 0)
			{
				foreach($activityArtifactLinks2 as $key=>$value)
				{
					if(preg_match('/^'.$searchLinks."/i",trim($value)))
					{ 
						$activitySearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'" checked="checked"/><span class="clsCheckedTags" >'.$value.'</span><br />';
					}	
				}
			}
			if(count($activityArtifactNotLinks2) > 0)
			{
				foreach($activityArtifactNotLinks2 as $key=>$value)
				{
					if(preg_match('/^'.$searchLinks."/i",trim($value)))
					{ 
						$activitySearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'"  />'.$value.'<br />';
					}	
				}
			}
			
			echo $activitySearched; 
		}
		elseif($this->input->post('documentType')=='notes')
		{
		
			if(count($notesArtifactLinks2) > 0)
			{
				foreach($notesArtifactLinks2 as $key=>$value)
				{
					if(preg_match('/^'.$searchLinks."/i",trim($value)))
					{ 
						$notesSearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'" checked="checked"/><span class="clsCheckedTags" >'.$value.'</span><br />';
					}
				}
			}
			if(count($notesArtifactNotLinks2) > 0)
			{
				foreach($notesArtifactNotLinks2 as $key=>$value)
				{
					if(preg_match('/^'.$searchLinks."/i",trim($value)))
					{ 
						$notesSearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'" />'.$value.'<br />';
					}	
				}
			}
			echo $notesSearched; 
		}
		elseif($this->input->post('documentType')=='contact')
		{
			if(count($contactArtifactLinks2) > 0)
			{
				foreach($contactArtifactLinks2 as $key=>$value)
				{
				
					if(preg_match('/^'.$searchLinks."/i",trim($value)))
					{ 
						$contactSearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'" checked="checked"/><span class="clsCheckedTags" >'.$value.'</span><br />';
					}	
				}
			}
			if(count($contactArtifactNotLinks2) > 0)
			{
				foreach($contactArtifactNotLinks2 as $key=>$value)
				{
					if(preg_match('/^'.$searchLinks."/i",trim($value)))
					{ 
						$contactSearched.='<input type="checkbox" name="doclinks" id="doclinks" value="'.$key.'"   />'.$value.'<br />';
					}
				}
			}

			echo $contactSearched; 
		}
		elseif($this->input->post('documentType')=='import')
		{
				 if(count($importArtifactLinks2) > 0)
				{
					foreach($importArtifactLinks2 as $key=>$value)
					{
						if(preg_match('/^'.$searchLinks."/i",trim($value)))
						{ 
							/*Commented by Dashrath- Add new code below commented code*/
						    /*$importFileSearched.='<input type="checkbox" name="importlinks" id="importlinks" value="'.$key.'" checked="checked"/><span class="clsCheckedTags" >'.$value.'</span><br />';*/

						    /*Added by Dashrath- get folder id by docId*/
							$folderId	= $this->identity_db_manager->getFolderIdByDocId($key);
							$importFileSearched.='<span class="folId'.$folderId.'" style="display: none;">';

							$importFileSearched.='<input type="checkbox" name="importlinks" id="importlinks" value="'.$key.'" checked="checked"/><span class="clsCheckedTags" >'.$value.'</span><br />';

							$importFileSearched.= '</span>';
							/*Dashrath- code end*/
						}
					}
				}
				if(count($importArtifactNotLinks2) > 0)
				{
					/*Added by Surbhi IV for sorting*/
					/*Commeted by Dashrath- file repeted by same name*/
					// $importArtifactNotLinks2_lowercase = array_map('strtolower', $importArtifactNotLinks2);
					// $importArtifactNotLinks2_lowercase1 = array_map('strtolower', $importArtifactNotLinks2);
					// array_multisort($importArtifactNotLinks2_lowercase, SORT_ASC, SORT_STRING, $importArtifactNotLinks2);
					/*End of Added by Surbhi IV for sorting*/
					foreach($importArtifactNotLinks2 as $key=>$value)
					{
						if(preg_match('/^'.$searchLinks."/i",$value))
						{ 
							/*Added by Surbhi IV for sorting*/
							/*Commeted by Dashrath- file repeted by same name*/
							// $array_search=array_search(strtolower($value),$importArtifactNotLinks2_lowercase1);
							/*End of Added by Surbhi IV for sorting*/

							/*Commented by Dashrath- Add new code below commented code*/
							/*$importFileSearched.='<input type="checkbox" name="importlinks" id="importlinks" value="'.$array_search.'"  />'.$value.'<br />';*/

							/*Added by Dashrath- get folder id by docId*/
							$folderId	= $this->identity_db_manager->getFolderIdByDocId($key);
							$importFileSearched.='<span class="folId'.$folderId.'" style="display: none;">';

							$importFileSearched.='<input type="checkbox" name="importlinks" id="importlinks" value="'.$key.'"  />'.$value.'<br />';

							$importFileSearched.= '</span>';
							/*Dashrath- code end*/
						}
					}
				}
				  echo $importFileSearched; 
		}
		elseif($this->input->post('documentType')=='importFolder')
		{
				if(count($importArtifactLinksFolder2) > 0)
				{
					foreach($importArtifactLinksFolder2 as $key=>$value)
					{
						if(preg_match('/^'.$searchLinks."/i",trim($value)))
						{ 
							$importFolderSearched.='<input type="checkbox" name="importFolderlinks" id="importFolderlinks" value="'.$key.'" checked="checked"/><span class="clsCheckedTags" >'.$value.'</span><br />';
						}		
					}
				}
				if(count($importArtifactNotLinksFolder2) > 0)
				{
					foreach($importArtifactNotLinksFolder2 as $key=>$value)
					{
						if(preg_match('/^'.$searchLinks."/i",$value))
						{ 
							$importFolderSearched.='<input type="checkbox" name="importFolderlinks" id="importFolderlinks" value="'.$key.'"  />'.$value.'<br />';
						}
					}
				}

				echo $importFolderSearched; 
		}
		
		
		
	}
	
	function getAppliedLinks()
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
			$this->load->model('dal/tag_db_manager');						
			$objIdentity			= $this->identity_db_manager;	
			$nodeId 				= $this->uri->segment(3);	
			$artifactType 			= $this->uri->segment(4);				
			$workspaceId 			= $this->uri->segment(5);		
			$workspaceType 			= $this->uri->segment(6);
			$linkType				= $this->uri->segment(7);	
			$nodeOrder				= $this->uri->segment(8);
			$latestVersion			= $this->uri->segment(9);	
			$open					= $this->uri->segment(10);	
			

			$linkSpanOrder			= $nodeOrder;						
			$artifactLinks			= array();
			$arrDetails				= array();
			$docArtifactLinks 		= array();
			$docArtifactLinks2		= array();
			$docArtifactLinks3 		= array();
			$docArtifactNotLinks 	= array();
			$docArtifactNotLinks2 	= array();
			$disArtifactLinks 		= array();
			$disArtifactLinks2 		= array();
			$disArtifactLinks3 		= array();
			$disArtifactNotLinks 	= array();
			$disArtifactNotLinks2 	= array();
			$chatArtifactLinks 		= array();
			$chatArtifactLinks2 	= array();
			$chatArtifactLinks3 	= array();
			$chatArtifactNotLinks 	= array();
			$chatArtifactNotLinks2 	= array();
			$activityArtifactLinks 	= array();
			$activityArtifactLinks2 = array();	
			$activityArtifactLinks3 = array();		
			$activityArtifactNotLinks 	= array();
			$activityArtifactNotLinks2 	= array();	
			$notesArtifactLinks 	= array();
			$notesArtifactLinks2 	= array();
			$notesArtifactLinks3 	= array();	
			$notesArtifactNotLinks 	= array();
			$notesArtifactNotLinks2	= array();
			$arrDocNotTreeIds = array();	
			$arrDisNotTreeIds = array();
			$arrChatNotTreeIds = array();
			$arrActivityNotTreeIds = array();	
			$arrNotesNotTreeIds = array();	
			$artifactNewLink 		= '';	
			$dispLabel = '';
			$mainTreeId =$this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
			
			$docTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 1, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$docCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 1, $linkType,$lastLogin);
			
			$arrDocTreeIds = array();	
			if(count($docTrees) > 0)
			{
				$i = 1;	
				foreach($docTrees as $data)
				{	
					$treeName = $data['name'];
					$arrDocTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Document');
					}					
					$docArtifactLinks[] = '<a href="'.base_url().'view_document/index/'.$workspaceId.'/type/'.$workspaceType.'/?treeId='.$data['treeId'].'&doc=exist" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
				
					$docArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}					
			}
			if(count($docCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($docCurrentTrees as $data)
				{	
					$treeName = $data['name'];
					$arrDocTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Document');
					}					
					$docArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					
					$i++;
				}					
			}
			
			$arrDocTreeIds[sizeof($arrDocTreeIds)] =0;
			$docNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(1, $workspaceId, $workspaceType, $arrDocTreeIds,$mainTreeId);	
			if(count($docNotLinkedTrees) > 0)
			{
				$i = 1;		
				$show = 0;		
				foreach($docNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);	
						
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$arrDocNotTreeIds[] = $data['treeId'];				
							$docArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($data['name'])).'</span>'; 	
							$docArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($data['name']));
							$docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
						}
					}
					else
					{
						$arrDocNotTreeIds[] = $data['treeId'];				
						$docArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($data['name'])).'</span>'; 	
						$docArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($data['name']));
						$docArtifactNotLinks2[$data['treeId']] = str_replace ("&gt;"," ",$docArtifactNotLinks2[$data['treeId']]);
					}
				
					$i++;
				}	
				asort ($docArtifactNotLinks2);		
			}		
			$docArtifactNewLink 		= '<a href="'.base_url().'document_new/index/'.$workspaceId.'/type/'.$workspaceType.'/'.$nodeId.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';	
			$disTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 2, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$disCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 2, $linkType,$lastLogin);
			
			$arrDisTreeIds = array();
			if(count($disTrees) > 0)
			{
				$i = 1;	
				foreach($disTrees as $data)
				{	
					$treeName = $data['name'];	
					$arrDisTreeIds[] = $data['treeId'];
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Discussion');
					}													
					$disArtifactLinks[] = '<a href="'.base_url().'view_discussion/node/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.strip_tags($treeName).'</a>'; 	
					$disArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}					
			}
			
			if(count($disCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($disCurrentTrees as $data)
				{	
					$treeName = $data['name'];	
					$arrDisTreeIds[] = $data['treeId'];
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Discussion');
					}													
					$disArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}					
			}
			
			$arrDisTreeIds[sizeof($arrDisTreeIds)] =0;
			$disArtifactNewLink 		= '<a href="'.base_url().'new_discussion/start_Discussion/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$disNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(2, $workspaceId, $workspaceType, $arrDisTreeIds,$mainTreeId);	
			if(count($disNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($disNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$treeName = $data['name'];
							$arrDisNotTreeIds[] = $data['treeId'];		
							if(trim($data['name']) == '')
							{
								$treeName = $this->lang->line('txt_Discussion');	
							}			
							$disArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
							$disArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
						}
					}
					else
					{
						$treeName = $data['name'];
						$arrDisNotTreeIds[] = $data['treeId'];		
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Discussion');	
						}			
						$disArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
						$disArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}

					$i++;
				}
				asort ($disArtifactNotLinks2);						
			}		
			
			$chatTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 3, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$chatCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 3, $linkType,$lastLogin);
			
			$arrChatTreeIds = array();
			if(count($chatTrees) > 0)
			{
				$i = 1;	
				foreach($chatTrees as $data)
				{
					$treeName = $data['name'];	
					$arrChatTreeIds[] = $data['treeId'];	
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Chat');	
					}									
					$chatArtifactLinks[] = '<a href="'.base_url().'view_chat/chat_view/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
					
					$chatArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					
					$i++;
				}						
			}
			
			if(count($chatCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($chatCurrentTrees as $data)
				{
					$treeName = $data['name'];	
					$arrChatTreeIds[] = $data['treeId'];	
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Chat');	
					}									
					$chatArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}						
			}

			$arrChatTreeIds[sizeof($arrChatTreeIds)] =0;
			$chatArtifactNewLink 	= '<a href="'.base_url().'new_chat/start_Chat/'.$nodeId.'/0/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$chatNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(3, $workspaceId, $workspaceType, $arrChatTreeIds,$mainTreeId);	
			if(count($chatNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($chatNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$treeName = $data['name'];	
							$arrChatNotTreeIds[] = $data['treeId'];		
							if(trim($data['name']) == '')
							{
								$treeName = $this->lang->line('txt_Chat');	
							}			
							$chatArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 

							$chatArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
						}
					}
					else
					{
						$treeName = $data['name'];	
						$arrChatNotTreeIds[] = $data['treeId'];		
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Chat');	
						}			
						$chatArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 
					
						$chatArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}
					$i++;
				}
				asort ($chatArtifactNotLinks2);							
			}		
			$activityTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 4, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$activityCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 4, $linkType,$lastLogin);
			
			$arrActivityTreeIds = array();		
			if(count($activityTrees) > 0)
			{
				$i = 1;	
				foreach($activityTrees as $data)
				{
					$treeName = $data['name'];	
					$arrActivityTreeIds[] = $data['treeId'];		
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Activity');	
					}															
					$activityArtifactLinks[] = '<a href="'.base_url().'view_task/node/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'/1" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
		
					$activityArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}						
			}
			if(count($activityCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($activityCurrentTrees as $data)
				{
					$treeName = $data['name'];	
					$arrActivityTreeIds[] = $data['treeId'];		
					if(trim($data['name']) == '')
					{
						$treeName = $this->lang->line('txt_Activity');	
					}															
					$activityArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}						
			}
		
			$arrActivityTreeIds[sizeof($arrActivityTreeIds)] = 0;
			$activityArtifactNewLink 	= '<a href="'.base_url().'new_task/start_Task/'.$nodeId.'/index/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$activityNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(4, $workspaceId, $workspaceType, $arrActivityTreeIds,$mainTreeId);	
			if(count($activityNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($activityNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$treeName = $data['name'];	
							$arrActivityNotTreeIds[] = $data['treeId'];	
							if(trim($data['name']) == '')
							{
								$treeName = $this->lang->line('txt_Activity');	
							}			
							$activityArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
							$activityArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
						}
					}
					else
					{
						$treeName = $data['name'];	
						$arrActivityNotTreeIds[] = $data['treeId'];	
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Activity');	
						}			
						$activityArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
						$activityArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}

					$i++;
				}
				asort ($activityArtifactNotLinks2);							
			}
			
			
			$arrNotesTreeIds = array();			
			$notesTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 6, $linkType);
			
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$notesCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 6, $linkType,$lastLogin);
			
			if(count($notesTrees) > 0)
			{
				$i = 1;	
				foreach($notesTrees as $data)
				{	
					$treeName = $data['name'];
					$arrNotesTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Notes');
					}											
					$notesArtifactLinks[] = '<a href="'.base_url().'notes/Details/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
					$notesArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}	
									
			}
			
			if(count($notesCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($notesCurrentTrees as $data)
				{	
					$treeName = $data['name'];
					$arrNotesTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Notes');
					}											
					$notesArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}						
			}
			
			$arrNotesTreeIds[sizeof($arrNotesTreeIds)] =0;
			$notesArtifactNewLink 	= '<a href="'.base_url().'notes/New_Notes/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$notesNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(6, $workspaceId, $workspaceType, $arrNotesTreeIds,$mainTreeId);	
			if(count($notesNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($notesNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree
					
					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
						if ((in_array($_SESSION['userId'],$sharedMembers)))
						{
							$treeName = $data['name'];	
							$arrNotesNotTreeIds[] = $data['treeId'];
							if(trim($data['name']) == '')
							{
								$treeName = $this->lang->line('txt_Notes');	
							}			
							$notesArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
							$notesArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
						}
					}
					else
					{
						$treeName = $data['name'];	
						$arrNotesNotTreeIds[] = $data['treeId'];
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Notes');	
						}			
						$notesArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
						$notesArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}
					
					$i++;
				}
				asort ($notesArtifactNotLinks2);							
			}	
			
			
			
			$arrContactTreeIds = array();			
			$contactTrees 	= $this->identity_db_manager->getLinkedTreesByArtifactNodeId($nodeId, 5, $linkType);
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$contactCurrentTrees = $this->identity_db_manager->getCurrentLinkedTreesByArtifactNodeId($nodeId, 5, $linkType,$lastLogin);
			
			if(count($contactTrees) > 0)
			{
				$i = 1;	
				foreach($contactTrees as $data)
				{	
					$treeName = $data['name'];
					$arrContactTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Contacts');
					}											
					$contactArtifactLinks[] = '<a href="'.base_url().'contact/contactDetails/'.$data['treeId'].'/'.$workspaceId.'/type/'.$workspaceType.'" target="_blank">'.html_entity_decode(strip_tags($treeName)).'</a>'; 	
					$contactArtifactLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					$i++;
				}						
			}
			
			if(count($contactCurrentTrees) > 0)
			{
				$i = 1;	
				foreach($contactCurrentTrees as $data)
				{	
					$treeName = $data['name'];
					$arrContactTreeIds[] = $data['treeId'];	
					if(trim($treeName) == '')
					{
						$treeName = $this->lang->line('txt_Contacts');
					}											
					$contactArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['treeId']." value=".$data['treeId'].">".html_entity_decode(strip_tags($treeName))."</option>";
					$i++;
				}						
			}
			
			$arrContactTreeIds[sizeof($arrContactTreeIds)] =0;
			$contactArtifactNewLink = '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$contactNotLinkedTrees 	= $this->identity_db_manager->getNotLinkedTreesByArtifactNodeId(5, $workspaceId, $workspaceType, $arrContactTreeIds,$mainTreeId);	
			
			if(count($contactNotLinkedTrees) > 0)
			{
				$i = 1;	
				foreach($contactNotLinkedTrees as $data)
				{		
					// Parv - Allowing linking to current tree

					if ($data['isShared']==1)
					{
						$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($data['treeId']);
							if ((in_array($_SESSION['userId'],$sharedMembers)))
							{
								$treeName = $data['name'];	
								$arrContactNotTreeIds[] = $data['treeId'];
								if(trim($data['name']) == '')
								{
									$treeName = $this->lang->line('txt_Contacts');	
								}			
								$contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
								$contactArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
							}
					}
					else
					{
						$treeName = $data['name'];	
						$arrContactNotTreeIds[] = $data['treeId'];
						if(trim($data['name']) == '')
						{
							$treeName = $this->lang->line('txt_Contacts');	
						}			
						$contactArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['treeId'].'" onClick="changeBackgroundSpan2('.$data['treeId'].','.$linkSpanOrder.')">'.html_entity_decode(strip_tags($treeName)).'</span>'; 	
						$contactArtifactNotLinks2[$data['treeId']] = html_entity_decode(strip_tags($treeName));
					}
					
					$i++;
				}
				asort ($contactArtifactNotLinks2);						
			}	


			$arrImportFileIds = array();			
			$importFile 	= $this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($nodeId,$linkType);

			$lastLogin = $this->identity_db_manager->getLastLogin();
			$importCurrentFile = $this->identity_db_manager->getCurrentLinkedExternalDocsByArtifactNodeId($nodeId,$linkType,$lastLogin);
			
			if(count($importFile) > 0)
			{
				$i = 1;	
				foreach($importFile as $data)
				{	
					$docName = $data['docName'];
					$arrImportFileIds[] = $data['docId'];	
					if(trim($docName) == '')
					{
						$docName = $this->lang->line('txt_Files');
					}											

					/*Commented by Dashrath- commented old code add new changes code below*/
					// $importArtifactLinks[] = "<a href=".base_url()."ext_file/index/".$data['docId']." target=_blank>".$docName.'_v'.$data['version']."</a>";

					// $importArtifactLinks2[$data['docId']] = html_entity_decode(strip_tags($docName)).'_v'.$data['version'];

					/*Added by Dashrath- change docCaption to docName and remove version add*/
					$importArtifactLinks[] = "<a href=".base_url()."ext_file/index/".$data['docId']." target=_blank>".$docName."</a>";

					$importArtifactLinks2[$data['docId']] = html_entity_decode(strip_tags($docName));
					/*Dashrath- code end*/

					$i++;
				}						
			}
			
			if(count($importCurrentFile) > 0)
			{
				$i = 1;	
				foreach($importCurrentFile as $data)
				{	
					$docName = $data['docName'];
					$arrImportFileIds[] = $data['docId'];	
					if(trim($docName) == '')
					{
						$docName = $this->lang->line('txt_Files');
					}

					/*Commented by Dashrath- commented old code add new changes code below*/											
					// $importArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['docId']." value=".$data['docId'].">".html_entity_decode(strip_tags($docName)).'_v'.$data['version']."</option>";

					/*Added by Dashrath- change docCaption to docName and remove version add*/
					$importArtifactLinks3[] = "<option id=node3".$linkSpanOrder."linkTree".$data['docId']." value=".$data['docId'].">".html_entity_decode(strip_tags($docName))."</option>";
					/*Dashrath- code end*/

					$i++;
				}						
			}
			
			$arrImportFileIds[sizeof($arrImportFileIds)] =0;
			$importArtifactNewLink 	= '<a href="'.base_url().'contact/editContact/'.$nodeId.'/'.$workspaceId.'/type/'.$workspaceType.'/'.$linkType.'/link" target="_blank" class="current"><span>'.$this->lang->line('txt_Create_New').'</span></a>';						
			$importNotLinkedFile 	= $this->identity_db_manager->getNotLinkedExternalDocsByArtifactNodeId(7, $workspaceId, $workspaceType, $arrImportFileIds);	
			
			if(count($importNotLinkedFile) > 0)
			{
				$i = 1;	
				foreach($importNotLinkedFile as $data)
				{		
					// Parv - Allowing linking to current tree
					$docName = $data['docName'];	
					$arrImportNotFileIds[] = $data['docId'];
					if(trim($data['docName']) == '')
					{
						$fileName = $this->lang->line('txt_Files');	
					}

					/*Commented by Dashrath- commented old code add new changes code below*/
					// $importArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['docId'].'" onClick="changeBackgroundSpan2('.$data['docId'].','.$linkSpanOrder.')">'.$docName.'_v'.$data['version'].'</span>'; 	
					// $importArtifactNotLinks2[$data['docId']] = html_entity_decode(strip_tags($docName)).'_v'.$data['version'];

					/*Added by Dashrath- change docCaption to docName and remove version add*/
					$importArtifactNotLinks[] = '<span style="cursor:pointer;" id="node'.$linkSpanOrder.'linkTree'.$data['docId'].'" onClick="changeBackgroundSpan2('.$data['docId'].','.$linkSpanOrder.')">'.$docName.'</span>'; 	
					$importArtifactNotLinks2[$data['docId']] = html_entity_decode(strip_tags($docName));
					/*Dashrath- code end*/

					$i++;
				}
				asort ($importArtifactNotLinks2);		
			}				
			

			/*Added by Dashrath- import folder section start*/
			$arrImportFolderIds = array();			
			$importFolder 	= $this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($nodeId,$linkType);
			$lastLogin = $this->identity_db_manager->getLastLogin();
			$importCurrentFolder = $this->identity_db_manager->getCurrentLinkedExternalFoldersByArtifactNodeId($nodeId,$linkType,$lastLogin);
			
			if(count($importFolder) > 0)
			{
				$i = 1;	
				foreach($importFolder as $data)
				{	
					$folderName = $data['folderName'];
					$arrImportFolderIds[] = $data['folderId'];	

					if(trim($folderName) == '')
					{
						$folderName = $this->lang->line('txt_Folders');
					}											
					
					// $importArtifactLinksFolder[] = $data['folderName'];
					$importArtifactLinksFolder[] = "<a href=".base_url()."external_docs/index/".$workspaceId."/type/".$workspaceType."/1/".$data['folderId']." target=_blank>".$folderName."</a>";

					$importArtifactLinksFolder2[$data['folderId']] = html_entity_decode(strip_tags($folderName));
					
					$i++;
				}						
			}
			
			if(count($importCurrentFolder) > 0)
			{
				$i = 1;	
				foreach($importCurrentFolder as $data)
				{	
					$folderName = $data['folderName'];
					$arrImportFolderIds[] = $data['folderId'];

					if(trim($folderName) == '')
					{
						$folderName = $this->lang->line('txt_Folders');
					}
					
					$i++;
				}						
			}

			$arrImportFolderIds[sizeof($arrImportFolderIds)] =0;
									
			$importNotLinkedFolder	= $this->identity_db_manager->getNotLinkedExternalFoldersByArtifactNodeId(7, $workspaceId, $workspaceType, $arrImportFolderIds);	
			

			if(count($importNotLinkedFolder) > 0)
			{
				$i = 1;	
				foreach($importNotLinkedFolder as $data)
				{		
					$folderName = $data['folderName'];	
					$arrImportNotFolderIds[] = $data['folderId'];
					if(trim($data['folderName']) == '')
					{
						$folderName = $this->lang->line('txt_Folders');	
					}	
					
					$importArtifactNotLinksFolder2[$data['folderId']] = html_entity_decode(strip_tags($folderName));

					$i++;
				}
				asort ($importArtifactNotLinksFolder2);		
			}	
			/*Dashrath- import folder section end*/

			$arrImportedUrls 	= $this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($nodeId,$artifactType);	
			
			if(count($docArtifactLinks2) > 0)
			{
				foreach($docArtifactLinks2 as $key=>$value)
				{
					$docSectionLinkIds[] = $key;
				}
			}
			if(count($docArtifactNotLinks2) > 0)
			{
				foreach($docArtifactNotLinks2 as $key=>$value)
				{
					$docSectionLinkIds[] = $key;
				}
			}
		
		
			if(count($disArtifactLinks2) > 0)
			{
				foreach($disArtifactLinks2 as $key=>$value)
				{
					$disSectionLinkIds[] = $key;
				}
			}
			if(count($disArtifactNotLinks2) > 0)
			{
				foreach($disArtifactNotLinks2 as $key=>$value)
				{
					$disSectionLinkIds[] = $key;
				}
			}
			if(count($chatArtifactLinks2) > 0)
			{
				foreach($chatArtifactLinks2 as $key=>$value)
				{
					$chatSectionLinkIds[] = $key;
				}
			}
			if(count($chatArtifactNotLinks2) > 0)
			{
				foreach($chatArtifactNotLinks2 as $key=>$value)
				{
					$chatSectionLinkIds[] = $key;
				}
			}

			if(count($activityArtifactLinks2) > 0)
			{
				foreach($activityArtifactLinks2 as $key=>$value)
				{
					$activitySectionLinkIds[] = $key;
				}
			}
			if(count($activityArtifactNotLinks2) > 0)
			{
				foreach($activityArtifactNotLinks2 as $key=>$value)
				{
					$activitySectionLinkIds[] = $key;
				}
			}
			
		
		
			if(count($notesArtifactLinks2) > 0)
			{
				foreach($notesArtifactLinks2 as $key=>$value)
				{
					$notesSectionLinkIds[] = $key;
				}
			}
			if(count($notesArtifactNotLinks2) > 0)
			{
				foreach($notesArtifactNotLinks2 as $key=>$value)
				{
					$notesSectionLinkIds[] = $key;
				}
			}
		
		
			if(count($contactArtifactLinks2) > 0)
			{
				foreach($contactArtifactLinks2 as $key=>$value)
				{
					$contactSectionLinkIds[] = $key;
				}
			}
			if(count($contactArtifactNotLinks2) > 0)
			{
				foreach($contactArtifactNotLinks2 as $key=>$value)
				{
					$contactSectionLinkIds[] = $key;
				}
			}

			if(count($importArtifactLinks2) > 0)
			{
				foreach($importArtifactLinks2 as $key=>$value)
				{
					$importSectionLinkIds[] = $key;
					$sectionChecked[] = $key;
				}
			}
			if(count($importArtifactNotLinks2) > 0)
			{
				foreach($importArtifactNotLinks2 as $key=>$value)
				{
					$importSectionLinkIds[] = $key;
				}
			}

			/*Added by Dashrath- used for folder link*/
			if(count($importArtifactLinksFolder2) > 0)
			{
				foreach($importArtifactLinksFolder2 as $key=>$value)
				{
					$importSectionLinkFolderIds[] = $key;
					$sectionCheckedFolder[] = $key;
				}
			}
			if(count($importArtifactNotLinksFolder2) > 0)
			{
				foreach($importArtifactNotLinksFolder2 as $key=>$value)
				{
					$importSectionLinkFolderIds[] = $key;
				}
			}
			/*Dashrath- code end*/

			if(count($arrImportedUrls) > 0)
			{
				foreach($arrImportedUrls as $key=>$value)
				{
					$indivisualUrl[]="<a target='_blank' href='".$value['url']."' >".$value['title']."</a>";
					$importedUrlsIds[] = $key;
				}
			}
			
			$leafClearStatus	= $this->identity_db_manager->getLeafClearStatus($nodeId,'clear_link');
			
			if($leafClearStatus == 1 && $leafClearStatus != '')
			{
				$var .= '<div class="clearMsgLinkPadding">'.$this->lang->line('txt_clear_prev_link_obj_msg').'</div>';
			}	
		
			/*Changed by Dashrath- Add $importArtifactLinksFolder in if condition for check count*/
			if((count($docArtifactLinks)+count($disArtifactLinks)+count($chatArtifactLinks)+count($activityArtifactLinks)+count($notesArtifactLinks)+count($contactArtifactLinks)+count($importArtifactLinks)+count($arrImportedUrls)+count($importArtifactLinksFolder))>0)
			{
			
				if($nodeId !='')
				{
					$leafOwnerData	= $this->identity_db_manager->getLeafIdByNodeId($nodeId);
				}
			
				if($leafClearStatus == 0 && $leafClearStatus != '' && $leafOwnerData['userId']==$_SESSION['userId'])
				{
			
				$var.= '<div style="margin-top:1%;"><input type="button" name="clear" value="'.$this->lang->line('txt_clear_prev_link_obj').'" onclick="clearLinks('.$nodeId.');" /></div><div class="clearLoader" id="clearLoader"></div>';
				
				}
				
				if(count($docArtifactLinks) > 0)	
				{	
					$var.='<div style="margin-top:10px;">'.$this->lang->line('txt_Document').': '.implode(', ', $docArtifactLinks).'</div>';
				}
			
				if(count($disArtifactLinks) > 0)	
				{	
					$var.='<div style="margin-top:10px;">'.$this->lang->line('txt_Discussions').': '.implode(', ', $disArtifactLinks).'</div>';
				}
				
				if(count($chatArtifactLinks) > 0)	
				{	
					$var.='<div style="margin-top:10px;">'.$this->lang->line('txt_Chat').': '.implode(', ', $chatArtifactLinks).'</div>';
				}	
			
				if(count($activityArtifactLinks) > 0)	
				{	
					$var.='<div style="margin-top:10px;">'.$this->lang->line('txt_Task').': '.implode(', ', $activityArtifactLinks).'</div>';
				}
				if(count($notesArtifactLinks) > 0)	
				{	
					$var.='<div style="margin-top:10px;">'.$this->lang->line('txt_Notes').': '.implode(', ', $notesArtifactLinks).'</div>';
				}
				if(count($contactArtifactLinks) > 0)	
				{	
					$var.='<div style="margin-top:10px;">'.$this->lang->line('txt_Contacts').': '.implode(', ', $contactArtifactLinks).'</div>';
				}
				if(count($importArtifactLinks) > 0)	
				{	
					$var.='<div style="margin-top:10px;">'.$this->lang->line('txt_Files').': '.implode(', ', $importArtifactLinks).'</div>';
				}

				/*Added by Dashrath- used for display linked folder name*/
				if(count($importArtifactLinksFolder) > 0)	
				{	
					$var.='<div style="margin-top:10px;">'.$this->lang->line('txt_Folders').': '.implode(', ', $importArtifactLinksFolder).'</div>';
				}
				/*Dashrath- code end*/

				if(count($indivisualUrl) > 0)	
				{	
					$var.='<div style="margin-top:10px;">'.$this->lang->line('txt_Imported_URL').': '.implode(', ', $indivisualUrl).'</div>';
				}
			}
			else
			{
				$var .=$this->lang->line('txt_None');
			}
		
			echo $var;			
		}
	}
	
	function addURL($workSpaceId,$workSpaceType)
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/notification_db_manager');
		$this->load->model('dal/time_manager');
		$objTime = $this->time_manager;		
		
		
		$title=$this->input->post('title',true);
		$txtUrl=$this->input->post('txtUrl',true);
		$ownerId=$this->input->post('ownerId',true);
		
		echo $this->identity_db_manager->insertUrl($txtUrl,$title,$ownerId,$workSpaceId,$workSpaceType);
		
		//Manoj: insert originator id
		$urlId = $this->db->insert_id();
								
		$objectMetaData=array();
		$objectMetaData['object_id']='7';
		$objectMetaData['object_instance_id']=$urlId;
		$objectMetaData['user_id']=$_SESSION['userId'];
		$objectMetaData['created_date']=$objTime->getGMTTime();
								
		$this->notification_db_manager->set_object_originator_details($objectMetaData);
								
		//Manoj: insert originator id end
		
		
	}
	
	function applyURL($artifactId,$artifactType)
	{
	
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/notification_db_manager');
		$this->load->model('dal/time_manager');
		$objTime = $this->time_manager;		
		$this->load->model('dal/timeline_db_manager');
		
		$allImportedUrls=explode(",",$this->input->post('allImportedUrls',true));
		
		$applyedUrls=explode(",",$this->input->post('applyedUrls',true));
		
		foreach($allImportedUrls as $urlId)
		{
		 		$this->db->query("DELETE FROM `teeme_applied_url` WHERE urlId= $urlId AND artifactId=$artifactId and artifactType=$artifactType");
		}
		
		foreach($applyedUrls as $urlId)
		{
		
		 	$this->db->query("INSERT INTO  `teeme_applied_url`(urlId,artifactId,artifactType,userId)    VALUES($urlId,$artifactId,$artifactType,".$_SESSION['userId'].") ");

		 	/*Added by Dashrath- make apply url name array*/
		 	$urlTitle1=$this->identity_db_manager->getImportedUrlTitleById($urlId);
		 	$applyUrlsName[]=$urlTitle1;
		 	/*Dashrath- code end*/
		}
		
		//Manoj: Insert link apply notification start
								
		
								$nodeId = $artifactId;
								
								$workSpaceId = $this->uri->segment(5);
								
								$workSpaceType = $this->uri->segment(6);
								
								$tree_id=$this->identity_db_manager->getTreeIdByNodeId_identity($nodeId);
								
								//Add post tag change details start
								if($tree_id==0)
								{
										//3 for add tag in post change table
										$change_type=4;
										$postChangeStatus = $this->timeline_db_manager->add_post_change_details($change_type,$objTime->getGMTTime(),$nodeId,$_SESSION['userId'],$workSpaceId,$workSpaceType);
										$postOrderChange = $this->timeline_db_manager->change_post_order($nodeId,$objTime->getGMTTime());
								}
								//Add post tag change details end
				
								$notificationDetails=array();
													
								$notification_url='';
								
								$treeType = $this->identity_db_manager->getTreeTypeByTreeId($tree_id);
								
								$notificationDetails['created_date']=$objTime->getGMTTime();
								$notificationDetails['object_id']='7';
								$notificationDetails['action_id']='4';

								/*Added by Dashrath- Check object is tree or leaf*/
								if($artifactType==1)
								{
									$notificationDetails['parent_object_id']='1';
									$notificationDetails['parent_tree_id']=$nodeId;
								}
								else if($artifactType==2)
								{
									if($tree_id==0)
									{
										$notificationDetails['parent_object_id']='3';
									}
									else
									{
										$notificationDetails['parent_object_id']='2';
										$notificationDetails['parent_tree_id']=$tree_id;
									}
								}
								/*Dashrath- code end*/
								
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

									/*Added by Dashrath- Add data in events_data table*/
									if(count($applyUrlsName)>0)
									{
										if(count($applyUrlsName)==1)
										{
											$notificationData['data'] = $applyUrlsName[0];
										}
										else if(count($applyUrlsName)==2)
										{
											$notificationData['data'] = $applyUrlsName[0].','.$applyUrlsName[1];
										}
										else
										{
											$moreUrlCount = count($applyUrlsName)-2;
											$notificationData['data'] = $applyUrlsName[0].','.$applyUrlsName[1].' and '.$moreUrlCount.' more';
										}

									}
								
									$notification_data_id=$this->notification_db_manager->set_notification_data($notificationData);
									$notificationDetails['notification_data_id']=$notification_data_id;
									
									/*Dashrath- code end*/
								
									$notificationDetails['workSpaceId']= $workSpaceId;
									$notificationDetails['workSpaceType']= $workSpaceType;
									$notificationDetails['object_instance_id']=$nodeId;
									$notificationDetails['user_id']=$_SESSION['userId'];
									$notification_id = $this->notification_db_manager->set_notification($notificationDetails); 
				
									if($notification_id!='')
									{
										foreach($applyedUrls as $value)
										{	 			
											$tag = $value;
											
											$originatorUserId=$this->notification_db_manager->get_object_originator_id($notificationDetails['object_id'],$tag);
											if($originatorUserId!='')
											{
												$originatorIdArray[] = $originatorUserId;
											}
											
										}
										
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
															if ($tree_type_val=='') $tree_type = 'post';
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
		
	}
	
 	function getAppliedUrl()
	{
	
		$this->load->model('dal/identity_db_manager');
		
		return $this->identity_db_manager->getAppliedUrl();
	
	}
	
	function searchUrls($artifactId,$artifactType)
	{
		$this->load->model('dal/identity_db_manager');
		
		$txtSearch='';
		
		if($this->input->post('txtSearch',true)!='')
		{
		
			$txtSearch = $this->input->post('txtSearch',true);
		}	
		
		$allImportUrls=$this->identity_db_manager->getAllImportUrls($txtSearch);
		
		$appliedUrls=$this->identity_db_manager->getAppliedUrl($artifactId,$artifactType);
		
		$appliedUrlsIds=array();
		
		$i=0;
		 
		foreach($appliedUrls as $key)
		{
		 
			$appliedUrlsIds[]= $key['urlId'];
		}
		
		
		foreach($allImportUrls as $indivisualUrl)	
		{
												
			if (in_array($indivisualUrl['id'],$appliedUrlsIds))
			{
			$temp.='<input type="checkbox" name="chkImportUrls" value="'.$indivisualUrl['id'].'" checked="checked"  ><span class="clsCheckedTags">'.$indivisualUrl['title'].'</span><br />';
			}
		}
		foreach($allImportUrls as $indivisualUrl)	
		{
			if (!(in_array($indivisualUrl['id'],$appliedUrlsIds)))
			{
				$temp.= '<input type="checkbox" name="chkImportUrls" value="'.$indivisualUrl['id'].'"   >'.$indivisualUrl['title'].'<br />';
			}	
		}
		
		echo $temp;

	}	
}
?>