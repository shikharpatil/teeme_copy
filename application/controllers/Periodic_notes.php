<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
	/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: periodic_notes.php
	* Description 		  	: A class file used to create the Notes by specific periods.
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
* @author   Ideavate Solutions (www.ideavate.com)
*/ 
class Periodic_notes extends CI_Controller 
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
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/notes_db_manager');
		$this->load->model('dal/time_manager');
		$this->load->model('dal/tag_db_manager');								
		$objIdentity	= $this->identity_db_manager;	
		$objIdentity->updateLogin();		
		$userId	= $_SESSION['userId'];		
		$workSpaceId 	= $this->uri->segment(3);	
		$workSpaceType 	= $this->uri->segment(5);	
		$arrPeriodicNotes = $this->notes_db_manager->getPeriodicNotes();
		foreach($arrPeriodicNotes as $notesData)
		{
			$periodicOption = $notesData['periodicOption'];
			$fromDate 	= $notesData['fromDate']; 
			$toDate	= $notesData['toDate'];
			$arrEndDate = explode('-',$toDate);
			if($arrEndDate[0] > 0)
			{		
				$endDate 	= date('Y-m-d',mktime(0,0,0,$arrEndDate[1],$arrEndDate[2],$arrEndDate[0]));
				if($endDate > date('Y-m-d'))
				{ 
					$endDate	= date('Y-m-d');
				}
			}
			else
			{
				$endDate	= date('Y-m-d');
			}
			
			$periodicNotesId = $notesData['notesId'];
			
			$notesDetails = $this->notes_db_manager->getNotes($periodicNotesId);
			
			if($periodicOption == 1 || $periodicOption == 3)	
			{
				$arrCreatedNotes = $this->notes_db_manager->getCreatedNotesByNotesId($periodicNotesId);					
				if(count($arrCreatedNotes) > 0)
				{	
					$date = $arrCreatedNotes[count($arrCreatedNotes)-1];					
					$arrInitDate = explode('-',$date);		
					$initDate 	= date('Y-m-d',mktime(0,0,0,$arrInitDate[1],$arrInitDate[2]+1,$arrInitDate[0])); 					
					$i = 2;									
					while($initDate <= $endDate)
					{						
						$treeId = $this->notes_db_manager->insertNewNotes($notesDetails['name'],$workSpaceId,$workSpaceType,$notesDetails['userId'],$initDate,$nodes=0);							
						$this->notes_db_manager->insertPeriodicNotes($treeId, $periodicNotesId, $initDate);
						$initDate = date('Y-m-d',mktime(0,0,0,$arrInitDate[1],$arrInitDate[2]+$i,$arrInitDate[0]));	
						$i++;
					}
				}				
			}
			if($periodicOption == 2)	
			{
				$arrCreatedNotes = $this->notes_db_manager->getCreatedNotesByNotesId($periodicNotesId);					
				if(count($arrCreatedNotes) > 0)
				{	
					$date = $arrCreatedNotes[count($arrCreatedNotes)-1];					
					$arrInitDate = explode('-',$date);		
					$initDate 	= date('Y-m-d',mktime(0,0,0,$arrInitDate[1],$arrInitDate[2]+7,$arrInitDate[0])); 					
					$i = 14;									
					while($initDate <= $endDate)
					{						
						$treeId = $this->notes_db_manager->insertNewNotes($notesDetails['name'],$workSpaceId,$workSpaceType,$notesDetails['userId'],$initDate,$nodes=0);							
						$this->notes_db_manager->insertPeriodicNotes($treeId, $periodicNotesId, $initDate);
						$initDate = date('Y-m-d',mktime(0,0,0,$arrInitDate[1],$arrInitDate[2]+$i,$arrInitDate[0]));	
						$i = $i+7;
					}
				}				
			}
			if($periodicOption == 4)	
			{
				$arrCreatedNotes = $this->notes_db_manager->getCreatedNotesByNotesId($periodicNotesId);					
				if(count($arrCreatedNotes) > 0)
				{	
					$date = $arrCreatedNotes[count($arrCreatedNotes)-1];					
					$arrInitDate = explode('-',$date);		
					$initDate 	= date('Y-m-d',mktime(0,0,0,$arrInitDate[1]+1,$arrInitDate[2],$arrInitDate[0])); 					
					$i = 2;									
					while($initDate <= $endDate)
					{						
						$treeId = $this->notes_db_manager->insertNewNotes($notesDetails['name'],$workSpaceId,$workSpaceType,$notesDetails['userId'],$initDate,$nodes=0);							
						$this->notes_db_manager->insertPeriodicNotes($treeId, $periodicNotesId, $initDate);
						$initDate = date('Y-m-d',mktime(0,0,0,$arrInitDate[1]+$i,$arrInitDate[2],$arrInitDate[0]));	
						$i++;
					}
				}				
			}
		}	
		redirect('/notes/index/0/'.$workSpaceId.'/type/'.$workSpaceType, 'location');	
	}
}
?>