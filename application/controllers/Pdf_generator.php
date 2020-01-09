<?php

class Pdf_generator extends CI_Controller 
{
	function __Construct()
	{
		parent::__Construct();	
		$this->load->library('Pdf');
		$this->load->helper("url");		
	}	
	function index()
	{
			$this->load->model('dal/identity_db_manager');	
			$this->load->model('container/document');
			$this->load->model('dal/document_db_manager');
			$this->load->model('dal/notes_db_manager');		
			$this->load->model('dal/contact_list');		
			$this->load->model('dal/chat_db_manager');	
			$this->load->model('dal/task_db_manager');
			$this->load->model('dal/time_manager');
			
			$treeId = $this->uri->segment(3);
			$workSpaceId = $this->uri->segment(4);
			$workSpaceType = $this->uri->segment(6);
			$userId = $_SESSION['userId'];
			$treeName = $this->uri->segment(7);
			
			
			//Document Tree
			
			if($treeName=='docs')
			{
				$treeData['treeName'] = $treeName;
				$treeData['seedName'] = $this->document_db_manager->getDocumentDetailsByTreeId($treeId);
				$treeData['arrUser']  = $this->document_db_manager->getUserDetailsByUserId($treeData['seedName']['userId']);
				$treeData['treeData'] = $this->document_db_manager->getDocumentFromDB($treeId);	
			}	
			
			//Notes Tree
			
			if($treeName=='notes')
			{
				$treeData['treeName'] = $treeName;
				$treeData['seedName'] = $this->notes_db_manager->getNotes($treeId);
				$treeData['arrUser']  = $this->identity_db_manager->getUserDetailsByUserId($treeData['seedName']['userId']);
				$treeData['treeData'] = $this->notes_db_manager->gettNotesByTree($treeId);
			}
			
			//Contact Tree
			
			if($treeName=='contact')
			{
				$treeData['treeName'] = $treeName;
				$treeData['seedName'] = $this->contact_list->getlatestContactDetails($treeId);
				$treeData['arrUser']  = $this->identity_db_manager->getUserDetailsByUserId($treeData['seedName']['userId']);
				$treeData['treeData'] = $this->contact_list->getlatestContactNote($treeId, $start=0, $userId, $workSpaceId, $workSpaceType);
			}
			
			//Discuss Tree
			
			if($treeName=='chat')
			{
				$treeData['treeName'] = $treeName;
				$treeData['seedName'] = $this->chat_db_manager->getDiscussionDetailsByTreeId($treeId);
				$treeData['arrUser']  = $this->identity_db_manager->getUserDetailsByUserId($treeData['seedName']['userId']);
				$treeData['treeData'] = $this->chat_db_manager->getNodesByTreeFromDB($treeId);
			}
			
			//Task Tree
			
			if($treeName=='task')
			{
				$treeData['treeName'] = $treeName;
				$treeData['seedName'] = $this->notes_db_manager->getNotes($treeId);
				$treeData['arrUser']  = $this->identity_db_manager->getUserDetailsByUserId($treeData['seedName']['userId']);
				$treeData['treeData'] = $this->task_db_manager->getNodesByTree($treeId);
				$treeData['treeId']   = $treeId;
			}
			
			
				
			
			$this->load->view('common/pdf_report',$treeData);
	}
}