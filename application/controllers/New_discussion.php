<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: new_Discussion.php
	* Description 		  	: A class file used to crate the new discussion.
	* External Files called	:  models/dal/idenityDBManage.php, models/dal/time_manager.php, models/dal/discussionManager.php,views/login.php,views/new_Discussion.php 
								
	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 15-09-2008				Vinaykant Sahu						Created the file.	
	**********************************************************************************************************/
/**
* A PHP class to create the new discussion.
* @author   Ideavate Solutions (www.ideavate.com)
*/
class new_discussion extends CI_Controller 
{
	
	function index($treeId)
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
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');				
			$objTime		= $this->time_manager;		
			$objIdentity->updateLogin();					
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');			
			$workSpaceId	= $this->input->post('workSpaceId');
			$workSpaceType	= $this->input->post('workSpaceType');
			if($this->input->post('reply') == 1){
				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				
				
				if($this->input->post($this->input->post('editorname1')) == '')
				{
					$_SESSION['errorMsg'] = $this->lang->line('msg_document_name_change_success');	
					redirect('/view_discussion/Discussion_reply/'.$this->input->post('nodeId').'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
				}
				$arrDiscussionDetails	= $this->discussion_db_manager->insertDiscussionReplay($this->input->post('nodeId'),$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$objTime->getGMTTime(),$treeId);	
				$editedDate = $this->time_manager->getGMTTime();
				$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);	
				#*********************memcache updation for discussion**********************
				$this->discussion_db_manager->updateDiscussionMemCache( $treeId );
				#********************end mmecache updation **********************************
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree
				
				$treeId=$this->input->post('treeId');
				redirect('/view_discussion/Discussion_reply/'.$this->input->post('nodeId').'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');		
			}else{
				$workSpaceId	= $this->uri->segment(4);
				$workSpaceType	= $this->uri->segment(6);
				redirect('/discussion/index/0/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
			}
						
		}
	}
	
	
	function start_Discussion($pnodeId=0){
		parent::__Construct();
			$this->load->model('dal/identity_db_manager');	
		if(!isset($_SESSION['userName']) || $_SESSION['userName'] =='')
		{		
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
									
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		else
		{	
			$this->load->model('container/discussion_container');
			$this->load->model('dal/discussion_db_manager');
			$this->load->model('dal/time_manager');
			$this->load->model('dal/tag_db_manager');	
			$this->load->model('dal/identity_db_manager');			
			$objTime		= $this->time_manager;			
			$linkType = $this->uri->segment(8);
			$title = $this->input->post('title');
			$nodeOrder = $this->input->post('nodeOrder');

			if($this->input->post('reply') == 1){

				$workSpaceId	= $this->input->post('workSpaceId');
				$workSpaceType	= $this->input->post('workSpaceType');
				$treeId	= $this->input->post('treeId');
				if($title)
				{
					$this->discussion_db_manager->insertDiscussionTitle($title,$treeId);
				}
				if ($nodeOrder)
				{
					$this->discussion_db_manager->updateNodeOrder($nodeOrder, $treeId, 1, 1);
				}
				else
				{
					$this->discussion_db_manager->updateNodeOrder(1, $treeId, 1, 2);
				}
				$arrDiscussionDetails	= $this->discussion_db_manager->insertDiscussionNode($treeId,$this->input->post($this->input->post('editorname1')),$_SESSION['userId'],$objTime->getGMTTime(),0,0,'','',1,1,$nodeOrder+1);	
				$linkType_vk		= $this->input->post('linkType_vk');
				if($linkType_vk)	{
					 $this->identity_db_manager->insertlink($treeId,$pnodeId,$linkType);
				}
			
				$editedDate = $this->time_manager->getGMTTime();
				$this->identity_db_manager->updateTreeModifiedDate($treeId, $editedDate);
				
				#*********************memcache updation for discussion**********************
				$this->discussion_db_manager->updateDiscussionMemCache( $treeId );
				#********************end mmecache updation **********************************
				
				$this->identity_db_manager->updateTreeUpdateCount($treeId); // Update Current Tree
				
				redirect('/view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType, 'location');
			}else{
				$workSpaceId	= $this->uri->segment(5);
				$workSpaceType	=  $this->uri->segment(7);
				$linkType_vk = 0;
				if($this->uri->segment(9) == 'link')
				{
					$linkType_vk = 1;
				}	
				$arrUser			= $this->discussion_db_manager->getUserDetailsByUserId($_SESSION['userId']);
				if($pnodeId){
					$arrparent=  $this->discussion_db_manager->getDiscussionTreeByLeaf($pnodeId);
					$arrDiscussionViewPage['treeId']=$this->discussion_db_manager->insertNewDiscussion('',$pnodeId,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime(), $linkType);
					$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
				}else{
					$arrDiscussionViewPage['treeId']=$this->discussion_db_manager->insertNewDiscussion('untile'.$objTime->getGMTTime(),$pnodeId,$workSpaceId,$workSpaceType,$_SESSION['userId'],$objTime->getGMTTime());
					$arrDiscussionViewPage['title'] = 'untile';
					$arrDiscussionViewPage['DiscussionUserName'] = $arrUser['userName'];
				}
				$arrDiscussionViewPage['DiscussionCreatedDate'] = 'Today';
				
				$arrDiscussionViewPage['DiscussionUserId'] = $_SESSION['userId'];
				$arrDiscussionViewPage['pnodeId'] = $pnodeId;
				$arrDiscussionViewPage['workSpaceId'] = $this->uri->segment(5);	
				$arrDiscussionViewPage['workSpaceType'] = $this->uri->segment(7);
				$arrDiscussionViewPage['linkType'] = $linkType;	
				$arrDiscussionViewPage['linkType_vk'] = $linkType_vk;	
				$this->load->view('discuss/new_discussion', $arrDiscussionViewPage);
			}
		}
	}
}
?>