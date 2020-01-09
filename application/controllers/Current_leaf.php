<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/  
class Current_leaf extends CI_Controller 
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
			$this->load->model('dal/document_db_manager');
			$objDocument = $this->document_db_manager;
			$leafId = $this->uri->segment(4);
			//Check Reserved Status
			$parentLeafId = $this->uri->segment(5);
			$saveBtnDisable = 0;
			$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($parentLeafId);
			if(count($draftReservedUsers)>0)
			{
				$saveBtnDisable = 1;
			}
			//Get Leaf Tree Id
			$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($leafId);
			//Code end
			$lastNode=$objDocument->hasSuccessor($leafId);
			if ( $lastNode== 0)
			{
				$contents		= $objDocument->getCurrentLeafContents($leafId); 
				echo "onlyContents~!@" .stripslashes($contents)."~!@".$saveBtnDisable."~!@".$leafTreeId;
			}
			else
			{				
				$arrNode		= array(); 	
				$arrNode		= $objDocument->getnodeDetailsByLeafId($lastNode); 
				echo $arrNode['nodeId'] ."~!@" .$arrNode['leafId'] ."~!@" .$arrNode['nodeOrder'] ."~!@" .$arrNode['treeId']."~!@".$arrNode['contents']."~!@".$saveBtnDisable."~!@".$leafTreeId;
			}
		}
	}
	
	function getLeafDetail()
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
			$objDocument = $this->document_db_manager;
			$leafId = $this->uri->segment(4);
	
			$contents		= $objDocument->getCurrentLeafContents($leafId); 
			echo "onlyContents~!@" .stripslashes($contents);
		}
	}
}
?>