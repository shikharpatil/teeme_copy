<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: process_document.php
	* Description 		  	: A class file used to store the document details to database.
	* External Files called	: models/dal/document_db_manager.php, models/dal/identity_db_manager.php, models/dal/time_manager.php, models/container/leaf.php,  models/container/node.php.  models/container/tree.php
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 09-08-2008				Nagalingam						Created the file.		
	**********************************************************************************************************/
/**
* A PHP class file used to store the document details to database
* @author   Ideavate Solutions (www.ideavate.com)
*/
class Process_document extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();			
	}	
	function index()
	{		
			
		ob_start();	
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
			$this->load->model('container/leaf');	
			$this->load->model('container/document');
			$this->load->model('container/tree');
			$this->load->model('container/node');		
			$this->load->model('dal/time_manager');		
			$this->load->model('dal/identity_db_manager');
			//Manoj: Added notes_user model
			$this->load->model('container/notes_users');
			
			$objDBDocument 	= $this->document_db_manager;
			$objLeaf		= $this->leaf;
			$objNode		= $this->node;	
			$objDocument	= $this->document;
			$objTree		= $this->tree;
			$objTime		= $this->time_manager;
			$xdoc 			= new DomDocument;
			$xdoc1 			= new DomDocument;			
			$xdoc3 			= new DomDocument;	
					
			$arrTitle 		= array();
			$arrSubTitle 	= array();
			$arrLeaf		= array(); 	
			$titleName  	= $objDocument->getTitleTag();
			$subTitleName 	= $objDocument->getSubTitleTag();	
			$leafName 		= $objDocument->getLeafTag();
			$nextPage		= $this->input->post('nextPage');
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			$nodeId			= $this->input->post('nodeId');	
			$nodeType		= $this->input->post('nodeType');	
			$linkType_vk	= $this->input->post('linkType_vk');	

			$strHtml_vinay = trim($this->input->post('editorContents'));
			$documentName = trim($this->input->post('documentTitle'));
			
				if($documentName != '')
				{		
					if (!($this->identity_db_manager->ifTreeExists($documentName,1,$workSpaceId)))
					{						
						$objTree->setTreeName( $documentName );
						$objTree->setTreetype( 1 );
						$objTree->setUserId( $_SESSION['userId'] );
						$objTree->setCreatedDate( $objTime->getGMTTime() );
						$objTree->setEditedDate( $objTime->getGMTTime() );
						$objTree->setWorkspaces( $this->input->post('workSpaceId') );
						$objTree->setWorkSpaceType( $this->input->post('workSpaceType') );
						$objTree->setNodes( $nodeId );
						if($objDBDocument->insertRecord($objTree,'tree', $nodeType))
						{
							$treeId = $this->db->insert_id();
							
							/****** Parv - Create Talk Tree for Tree ******/
							
							$this->load->model('dal/discussion_db_manager');
				
							$objDiscussion = $this->discussion_db_manager;										
				
							$discussionTitle = $this->identity_db_manager->formatContent($documentName,200,1);
							$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType,
							$_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
				
							$discussionTreeId = $this->db->insert_id();
							
							$objDiscussion->insertLeafTree ($treeId,$discussionTreeId,1);
							
							/****** Parv - Create Talk Tree for Tree ******/
	
							if($strHtml_vinay)
							{
	
								$i = 1;			
	
									$objLeaf->setLeafContents($strHtml_vinay);
									if(substr($keyVal, 0, strlen($titleName)) == $titleName)
									{
										$objLeaf->setLeafType(1);
									}
									else if(substr($keyVal, 0, strlen($subTitleName)) == $subTitleName)
									{
										$objLeaf->setLeafType(2);
									}
									else if(substr($keyVal, 0, strlen($leafName)) == $leafName)
									{
										$objLeaf->setLeafType(3);
									}
									else
									{
										$objLeaf->setLeafType(1);
									}			
									$objLeaf->setLeafAuthors(1); 
									$objLeaf->setLeafStatus(0); 
									$objLeaf->setLeafUserId($_SESSION['userId']); 
									$objLeaf->setLeafCreatedDate( $objTime->getGMTTime() ); 
	
									if($objDBDocument->insertRecord($objLeaf, 'leaf')) 
									{
										$leafId = $this->db->insert_id();
										$objNode->setNodePredecessor('0');
										$objNode->setNodeSuccessor('0');
										$objNode->setLeafId($leafId); 
										$objNode->setNodeTag($keyVal); 
										$objNode->setNodeTreeIds($treeId); 
										$objNode->setNodeOrder($i);
										if($objDBDocument->insertRecord($objNode, 'node')) 
										{
											$nodeId = $this->db->insert_id();
											$objDBDocument->updateLeafNodeId($leafId, $nodeId);
	
											/****** Parv - Create Talk Tree for leaf ******/
	
											
											$discussionTitle = $this->identity_db_manager->formatContent($strHtml_vinay,200,1);
											$objDiscussion->insertNewDiscussion ($discussionTitle,0,$workSpaceId,$workSpaceType, $_SESSION['userId'],$objTime->getGMTTime(),2,1,$treeId);
								
											$discussionTreeId = $this->db->insert_id();
											
											$objDiscussion->insertLeafTree ($leafId,$discussionTreeId);
											
											/****** Parv - Create Talk Tree for leaf ******/
										}				
	
									}
									$i++;			
							}
							//Manoj: Code for adding contributor on creating new document tree
							
							if($this->input->post('workSpaceId') == 0)
							{		
									$objNotesUsers = $this->notes_users;
									$objNotesUsers->setNotesId( $treeId );
									$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
									$this->document_db_manager->insertContributorsRecord( $objNotesUsers ,3);
							}
							else
							{			
		
									$objNotesUsers = $this->notes_users;
									$objNotesUsers->setNotesId( $treeId );
									$objNotesUsers->setNotesUserId( $_SESSION['userId'] );					
									$this->document_db_manager->insertContributorsRecord( $objNotesUsers ,3);
							}	
							//Manoj: Code for adding contributor on creating new document tree end
								
							if($linkType_vk)	{
								 $this->identity_db_manager->insertlink($treeId,$nodeId,$nodeType);
							}		
						}			
								
						$_SESSION['currentMsg'] = $this->lang->line('msg_document_add_success');
						if($nextPage == 'exit')				
						{	
							redirect('view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist', 'location');							
						}
						else
						{
							redirect('view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=new', 'location');					
						}
					}	
					else
					{
						$_SESSION['documentTitle'] = $this->input->post('documentTitle');				
						$_SESSION['errorMsg'] = $this->lang->line('doc_tree_name_exist');
						redirect('document_new/index/'.$workSpaceId.'/type/'.$workSpaceType.'/status/fail', 'location');	
					}
				}
				else
				{
					$_SESSION['documentTitle'] = $this->input->post('documentTitle');				
					$_SESSION['errorMsg'] = $this->lang->line('msg_document_add_fail');
					redirect('document_new/index/'.$workSpaceId.'/type/'.$workSpaceType.'/status/fail', 'location');					
				}
		}
	}
}
?>