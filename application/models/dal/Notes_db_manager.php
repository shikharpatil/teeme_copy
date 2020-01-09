<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
/***********************************************************************************************************
	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *
	************************************************************************************************************
	* Filename				: notes_db_manager.php 
	* Description 		  	: to handel Notes Db 
 	* Global Variables	  	: 
	* 
	* Modification Log
	* 	Date                	 Author                       		Description
	* ---------------------------------------------------------------------------------------------------------
	* 02-12-2008				Vinaykant						Notes Db Manager
	**********************************************************************************************************/

/**
* A PHP class to access teeme work place, work space and users database with convenient methods
* with various operation Add, update, delete & retrieve teeme work place, work space and user details
* @author   Ideavate Solutions (www.ideavate.com)
*/
class notes_db_manager extends CI_Model
{	

	/**
	* This is the constructor of user DB Manager that call the contstructor of the Parent Class.
	*/
	public $loopCount=0;
	public $loopTree =array();
	public function __construct()
	{   
		//Parent class constructor.
		parent::__construct();
	}	
	/**
	* This function is used to retrieve the instance of contact_list. This method will ensure that there is only one instance of the discussion_db_manager in the single session. This is declared a static method because we would call this without being able to instantiate the class.
	*/
   
    static public function getInstance ()
	{
		if ($objcontact_list == NULL)
		{
			$objcontact_list = new contact_list();
		}
		//Return the instance of discussion_db_manager class
		return $objcontact_list;
	}
	/**
	* This function is used to insert the records to database.
	*/
	public function insertRecord($object)
    {
		
		 if($object!=NULL && ($object instanceof Notes_periodic))
		 {		
			//Get data from the object and set it to according to their Database field name.
			//Inserting document tree details
			$strResultSQL = "INSERT INTO teeme_notes_info
							 (
							notesId, periodicOption, fromDate, toDate )
							VALUES
							(
							'".$object->getNotesId()."','".$object->getNotesPeriodicOption()."','".$object->getNotesStartDate()."','".$object->getNotesEndDate()."')";
							
		}
		//Inserting notes users
		if($object!= NULL && ($object instanceof Notes_users))
		{
			$strResultSQL = "INSERT INTO teeme_notes_users(notesId, userId
						)
						VALUES
						(
						'".$object->getNotesId()."','".$object->getNotesUserId()."'
						)";
		}
		$bResult = $this->db->query($strResultSQL);
		if($bResult)
		{
			return true;
		}		
		else
		{
			return false;
		}
	}
	
	
	// This function is used to delete the list of notes users
	
	public function deleteNotesUsers ($notesId)
	{
	
		$strResultSQL = "DELETE FROM teeme_notes_users WHERE notesId='".$notesId."'";
		$bResult = $this->db->query($strResultSQL);
	
		if($bResult)
		{
			return true;
		}		
		else
		{
			return false;
		}	
	}
	
	
	public function deleteNotesUserByUserId ($notesId=0,$userId=0)
	{
	
		$strResultSQL = "DELETE FROM teeme_notes_users WHERE notesId='".$notesId."' AND userId='".$userId."'";
		$bResult = $this->db->query($strResultSQL);
	
		if($bResult)
		{
			return true;
		}		
		else
		{
			return false;
		}	
	}
	
	// this method for inserting new contactlist
	public function insertNewNotes($name,$workSpaceId,$workSpaceType,$userId,$createdDate, $nodes=0, $linkType = 2, $autonumbering=0)
	{
		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("insert into teeme_tree (name,type,workspaces,workSpaceType,userId,createdDate,editedDate, nodes, nodeType, autonumbering) values ('".$this->db->escape_str($name)."',6,'".$workSpaceId."','".$workSpaceType."',".$userId.",'".$createdDate."','".$createdDate."' ,'".$nodes."', '".$linkType."', '".$autonumbering."')");
		
		$treeId=$this->db->insert_id();
		
		return $treeId;			
	}
	
	
	
	# this method is used to insert the node and leaf of notes artifact
	public function insertNote($treeId,$note,$userId, $successors=0,$predecessor=0, $date = 0)
	{
		if($date == 0)
		{
			$date = date("Y-m-d h:i:s");
		}
		//Manoj: replace mysql_escape_str function
		 $query = $this->db->query("insert into teeme_leaf (`contents`,`createdDate`, `userId`) values ('".$this->db->escape_str($note)."','".$date."','".$userId."' )");
		
		 $leafId=$this->db->insert_id();
		 
		 $query = $this->db->query("insert into teeme_node (treeIds,`leafId`, predecessor, successors ) values ('".$treeId."','".$leafId."','".$predecessor."','".$successors."')");
		
		 $nodeId=$this->db->insert_id();
			$query = $this->db->query("update teeme_leaf set nodeId ='".$nodeId."' where id=".$leafId);
		if($predecessor){
			$query = $this->db->query("update teeme_node set successors ='".$nodeId."' where id=".$predecessor);
		}
		
		 return $nodeId;			
	}

		/**
	* This method will be used for fetch the node ids from the database.
 	* @param $treeId This is the variable used to hold the tree ID.
	* @return The node ids as an array
	*/
	public function getNodeIdsByTreeId($treeId)
	{
	
		$arrIdDetails = array();
		if($treeId != NULL)
		{
			// Get information of particular document
			$q = 'SELECT id FROM teeme_node WHERE treeIds='.$treeId;
			$query = $this->db->query($q);
			// echo $q;
			if($query->num_rows() > 0)
			{				
				foreach ($query->result() as $nodeData)
				{	
					$arrIdDetails[] = $nodeData->id;						
				}
			}
		}
		return $arrIdDetails;
	}
	
	
			 /**
	* This method will be used for fetch the leaf or node tags from the database.
 	* @param $leafIds This is the variable used to hold the leaf ids or node IDs.
	* @return The leaf ids as an array
	*/
	function getLeafLinksByLeafIds($leafIds, $artifactType, $searchDate1 = '', $searchDate2 = '')	
	{		
		$arrLinkDetails = array();			
		$userId 	= $_SESSION['userId'];		
		$i = 0;	
	
		$query = $this->db->query('SELECT c.id,c.name FROM teeme_links a, teeme_leaf b, teeme_tree c WHERE a.artifactId=b.nodeId AND a.treeId=c.id AND a.artifactId IN('.$leafIds.')');	
		
		if($query->num_rows() > 0)
		{			
			foreach ($query->result() as $linkData)
			{	
				$arrLinkDetails['response'][$i]['treeId'] = $linkData->id;
				$arrLinkDetails['response'][$i]['treeName'] = $linkData->name;
				$i++;
			}
		}					
		return $arrLinkDetails;											
	}
	//to get parent tree by nodeId
	
	/**
	* This method will be used to get the page link by using tag id.
 	* @return The page link
	*/
	public function getLinkByLinkedTreeId($treeId)
	{
		$link = array();	
			$query = $this->db->query('SELECT type,name,workspaces,workSpaceType FROM teeme_tree WHERE id='.$treeId);		
			
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{	
					$treeType 		= $treeData->type;
					$workSpaceId 	= $treeData->workspaces;
					$workSpaceType 	= $treeData->workSpaceType;
					$treeName		= $treeData->name;
				}
				if($treeType == 1)
				{
					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist';
					$link[1] = $this->lang->line('txt_Document').': '.$treeName;
				}	
				if($treeType == 2)
				{
					$link[0] = 'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('disucssion').': '.$treeName;
				}	
				if($treeType == 3)
				{
					$link[0] = 'view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('chat').': '.$treeName;
				}	
				if($treeType == 4)
				{
					$link[0] = 'view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('activity').': '.$treeName;
				}	
				if($treeType == 5)
				{
					$link[0] = 'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('txt_Contact').': '.$treeName;
				}	
				if($treeType == 6)
				{
					$link[0] = 'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;
				}	
				return $link;
			}
		
	}	



	# this method is used to insert the new node and leaf of notes artifact
	public function insertNewNote($treeId,$note,$userId, $successors=0,$predecessor=0, $date = 0)
	{
		
		if($date == 0)
		{
			$date = date("Y-m-d h:i:s");
		}
		 
		 //arun-chages in query new feild edited date added in teeme_leaf table
		 //Manoj: replace mysql_escape_str function
		 $query = $this->db->query("insert into teeme_leaf (`contents`,`createdDate`,`editedDate`, `userId`) values ('".$this->db->escape_str($note)."','".$date."','".$date."','".$userId."' )");
		
		 $leafId=$this->db->insert_id();
		 $result = "";
		
		 if($predecessor){
			 $query = $this->db->query("SELECT id FROM teeme_node WHERE predecessor='".$predecessor."' LIMIT 1"); 
		 }
		 else{
			 $query = $this->db->query("SELECT id FROM teeme_node WHERE predecessor='".$predecessor."' AND treeIds = '".$treeId."'"); 
		 }
		 
		 if($query->num_rows()){
			$result = $query->row_array();
		 }
	
		 $query = $this->db->query("insert into teeme_node (treeIds,`leafId`, predecessor, successors ) values ('".$treeId."','".$leafId."','".$predecessor."','".$successors."')");
		
		 $nodeId=$this->db->insert_id();
		 $query = $this->db->query("update teeme_leaf set nodeId ='".$nodeId."' where id=".$leafId);
		 if($result!=''){
		 	$this->db->query("update teeme_node set predecessor ='".$nodeId."' where id=".$result['id']);
			$this->db->query("update teeme_node set successors ='".$result['id']."' where id=".$nodeId);
		 }
		 
		 $query = $this->db->query("update teeme_leaf set nodeId ='".$nodeId."' where id=".$leafId);
		 if($predecessor){
		 	$query = $this->db->query("update teeme_node set successors ='".$nodeId."' where id=".$predecessor);
		 }
		 
		 return $nodeId;			
		
		
	}
	
	# this method is used to insert the new node and leaf of notes artifact
	public function editNotesContents($treeId,$nodeId,$note,$userId,$date = 0)
	{ 
		if($date == 0)
		{
			$date = date("Y-m-d h:i:s");
		}
	
		//arun-add new feild editedDate in teeme_leaf table
		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("update teeme_leaf set contents ='".$this->db->escape_str($note)."',userId='".$userId."',editedDate='".$date."' where nodeId=".$nodeId);

		if ($query)
			return 1;
		else
			return 0;			
	}
	
		
	public function getNotesList($workspaces, $workSpaceType, $userId, $nodes=0, $sortBy = 3, $sortOrder=1){
		$treeData	= array();
		if($sortBy == 1)
		{
			$orderBy = ' ORDER BY a.name';
		}
		else if($sortBy == 2)
		{
			$orderBy = ' ORDER BY b.tagName';
		}
		else
		{
			$orderBy = ' ORDER BY a.editedDate';
		}		
		if($sortOrder == 2)
		{
			$orderBy .= ' ASC';
		}
		else
		{
			$orderBy .= ' DESC';
		}
		if($workspaces){
	
			$query = $this->db->query( "SELECT a.* FROM teeme_tree a, teeme_users b WHERE a.userId = b.userId AND a.workspaces='".$workspaces."' and  a.workSpaceType='".$workSpaceType."' and a.type=6 and a.nodes=".$nodes." ".$orderBy);	
		}else{
			$query = $this->db->query( "SELECT a.* FROM teeme_tree a, teeme_users b WHERE a.userId = b.userId AND a.workspaces='".$workspaces."' and  a.workSpaceType='".$workSpaceType."' and a.type=6  and (a.userId='".$userId."' OR a.isShared=1) and a.nodes=".$nodes." ".$orderBy);	
		}
		$i=0;	
		if($query->num_rows() > 0)
		{
			$row=$query->result();
			foreach ($query->result() as $row)
			{
				$treeData[$i]=array();
				$treeData[$i]['id'] 		= $row->id;	
				$treeData[$i]['name']  		= $row->name;	
				$treeData[$i]['type'] 		= $row->type;	
				$treeData[$i]['userId']  	= $row->userId;	
				$treeData[$i]['createdDate'] = $row->createdDate;	
				$treeData[$i]['editedDate']  = $row->editedDate;	
				$treeData[$i]['workspaces'] = $row->workspaces;	
				$treeData[$i]['nodes']  	= $row->nodes;	
				$treeData[$i]['treeVersion'] = $row->treeVersion;	
				$treeData[$i]['isShared'] 		= $row->isShared;	
				$i++;
 			}
		} 
		return $treeData;
		 
	}
	
	public function getNotes($treeId){
		$treeData	= array();
	
		$query = $this->db->query( "SELECT * FROM teeme_tree WHERE id=".$treeId);	
		 	
		if($query->num_rows() > 0)
		{
			$row=$query->result();
			foreach ($query->result() as $row)
			{
				
				$treeData['id'] 		= $row->id;	
				$treeData['name']  		= $row->name;
				$treeData['old_name']  	= $row->old_name;		
				$treeData['type'] 		= $row->type;	
				$treeData['userId']  	= $row->userId;	
				$treeData['createdDate'] = $row->createdDate;	
				$treeData['editedDate']  = $row->editedDate;	
				$treeData['workspaces'] = $row->workspaces;	
				$treeData['nodes']  	= $row->nodes;	
				$treeData['treeVersion'] = $row->treeVersion;	
				$treeData['autonumbering'] = $row->autonumbering;
				 
 			}
		} 
		return $treeData;
	}

	public function gettNotesByTree($treeId, $ids =""){
		$treeData	= array();
		$i=0;
		$str = "";
		
		
		$query = $this->db->query( "SELECT b.id as leafid,a.id as nodeId, b.contents, b.userId, a.predecessor, a.successors, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId $str and a.treeIds=".$treeId." and (a.predecessor=0 or a.predecessor='') order by b.createdDate asc LIMIT 0,1");		
		if($query->num_rows() > 0)
		{
			$row=$query->result();
			foreach ($query->result() as $row)
			{
				$this->loopCount=0;
				$this->loopTree=array();
				$this->loopTree[$this->loopCount]['leafid'] 		= $row->leafid;	
				$this->loopTree[$this->loopCount]['nodeId']= $row->nodeId;	
				$this->loopTree[$this->loopCount]['contents']= $row->contents;	
				$this->loopTree[$this->loopCount]['userId']= $row->userId;	
				$this->loopTree[$this->loopCount]['successors']= $row->successors;	
				$this->loopTree[$this->loopCount]['predecessor']= $row->predecessor;	
				$this->loopTree[$this->loopCount]['createdDate'] = $row->createdDate;	
				$this->loopTree[$this->loopCount]['editedDate'] = $row->editedDate;
				if($row->editedDate==0)
				{ 
					$this->loopTree[$this->loopCount]['orderingDate'] = $row->createdDate;	
				}	
				else
				{
					$this->loopTree[$this->loopCount]['orderingDate'] = $row->editedDate;	
				}	
					
				if($row->successors){
					$this->loopCount++;
					$this->allNotesdetails($row->successors);
				}
 			}	 
		}
		return $this->loopTree;
	}
	
	
	
	public function allNotesdetails($nodeId){
		
		$this->loopTree[$this->loopCount]=array();
		$query = $this->db->query( "SELECT b.id as leafid, a.id as nodeId, b.contents, b.userId, a.predecessor, a.successors, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and a.id=".$nodeId." LIMIT 0,1");		
		if($query->num_rows() > 0)
		{
			 foreach ($query->result() as $row)
			{
				$this->loopTree[$this->loopCount]['leafid'] 		= $row->leafid;	
				$this->loopTree[$this->loopCount]['nodeId'] 		= $row->nodeId;	
				$this->loopTree[$this->loopCount]['contents'] 		= $row->contents;	
				$this->loopTree[$this->loopCount]['userId']  	= $row->userId;	
				$this->loopTree[$this->loopCount]['successors']  	= $row->successors;	
				$this->loopTree[$this->loopCount]['predecessor']  	= $row->predecessor;
				$this->loopTree[$this->loopCount]['createdDate'] = $row->createdDate;
				$this->loopTree[$this->loopCount]['editedDate'] = $row->editedDate;	
				if($row->editedDate==0)
				{ 
					$this->loopTree[$this->loopCount]['orderingDate'] = $row->createdDate;	
				}	
				else
				{
					$this->loopTree[$this->loopCount]['orderingDate'] = $row->editedDate;	
				}
				if($row->successors){
					$this->loopCount++;
					$this->allNotesdetails($row->successors);
				}
			}
		}
	 
	}
	
	// to get details of parent leaf for the Note 

		public function getNotesPerent($pId){
			
			$treeData	= array();
			
				$query = $this->db->query( "SELECT *, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as CreatedDate FROM teeme_leaf WHERE id=".$pId);		
				if($query->num_rows() > 0)
				{
					$row=$query->result();
					foreach ($query->result() as $row)
					{
						$treeData['id'] = $row->id;	
						$treeData['userId']  = $row->userId;	
						$treeData['createdDate'] = $row->CreatedDate;	
						$treeData['contents']  = $row->contents;				
						$treeData['nodeId']  = $row->nodeId;	
					}
				}					
				return $treeData;	
			
		}
		
	public function getUserDetailsByUserId($userId)
	{
		$userData = array();
		$query = $this->db->query('SELECT * FROM teeme_users WHERE userId='.$userId);
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{										
				$userData['firstName'] = $row->firstName;	
				$userData['lastName'] = $row->lastName;	
				$userData['userName'] = $row->userName;	
				if($row->nickName!='')
				{
					$userData['userTagName'] = $row->nickName;
				}
				else
				{
					$userData['userTagName'] = $row->tagName;
				}
						
			}				
		}						
		return $userData;			
	}
	
	public function insertPeriodicNotes( $notesId, $periodicNotesId, $date )
	{
		$query = $this->db->query('INSERT INTO teeme_periodic_notes( notesId, periodicNotesId, createdDate) VALUES ('.$notesId.','.$periodicNotesId.',\''.$date.'\')');
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}			
	}
	/**
	* This method is used to get the periodic notes. 	
	*/
	public function getPeriodicNotes()
	{
		$notesData 	= array();
		$userId		= $_SESSION['userId'];
		$date 		= date('Y-m-d');
		$query 		= $this->db->query('SELECT a.* FROM teeme_notes_info a, teeme_notes_users b WHERE a.notesId = b.notesId AND b.userId ='.$userId);
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach ($query->result() as $row)
			{										
				$notesData[$i]['notesId'] 			= $row->notesId;	
				$notesData[$i]['periodicOption'] 	= $row->periodicOption;	
				$notesData[$i]['fromDate'] 			= $row->fromDate;	
				$notesData[$i]['toDate'] 			= $row->toDate;	
				$i++;					
			}				
		}						
		return $notesData;			
	}
	
	/**
	* This method is used to get the periodic created notes. 	
	*/
	function getCreatedNotesByNotesId($periodicNotesId)
	{
		$notesData 	= array();
		$userId		= $_SESSION['userId'];
		$date 		= date('Y-m-d');
		$query 		= $this->db->query('SELECT * FROM teeme_periodic_notes WHERE periodicNotesId = '.$periodicNotesId.' ORDER BY createdDate ASC');
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach ($query->result() as $row)
			{						
				$notesData[] 		= $row->createdDate;	
				$i++;					
			}				
		}						
		return $notesData;		
	}

	/**
	* This method is used to get the first node information of notes. 	
	*/
	function getFirstLeafContent($treeId)
	{
		$notesData 	= '';
		$userId		= $_SESSION['userId'];
		$date 		= date('Y-m-d');
		$query 		= $this->db->query('SELECT b.contents FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and a.treeIds='.$treeId.' order by b.createdDate ASC LIMIT 0,1');
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach ($query->result() as $row)
			{						
				$notesData 		= $row->contents;	
				$i++;					
			}				
		}						
		return $notesData;		
	}

	/**
	* This method is used to get the notes contributors 	
	*/
	function getNotesContributors($notesId)
	{		
		$userData 	= array();		
		$i = 0;
		if ($notesId>0)
		{
			$query 		= $this->db->query('SELECT b.tagName, b.nickName, a.userId, b.userGroup FROM teeme_notes_users a, teeme_users b WHERE a.userId = b.userId AND a.notesId = '.$notesId.' ORDER BY b.tagName');
			if($query->num_rows() > 0)
			{			
				foreach ($query->result() as $row)
				{						
					$userData[$i]['userId'] 		= $row->userId;	
					$userData[$i]['userGroup'] 	= $row->userGroup;		
					if($row->nickName!='')
					{
						$userData[$i]['userTagName'] 	= $row->nickName;	
					}
					else
					{
						$userData[$i]['userTagName'] 	= $row->tagName;	
					}
					$i++;					
				}				
			}			
			return $userData;	
		}	
		return 0;
	}
	
	/**
	* This method is used to get the periodic notes parent id 	
	*/
	function getNotesParentId($notesId)
	{		
		$noteId 	= $notesId;		
		$i = 0;
		$query 		= $this->db->query('SELECT periodicNotesId FROM teeme_periodic_notes WHERE notesId = '.$notesId);
		if($query->num_rows() > 0)
		{			
			$tmpData 	= $query->row();
			$notesId = $tmpData->periodicNotesId;
		}			
		return $notesId;					
	}
	
	function getTopNodesByTreeId( $treeId, $treeVersion )

	{

	

		$arrNodes = array();

		$query = $this->db->query('SELECT a.id as nodeId,a.tag, a.treeIds,b.id as leafId, b.type, b.authors,b.userId, b.contents,b.lockedStatus,b.createdDate FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = '.$treeId.' ORDER BY nodeOrder');										

		if($query->num_rows() > 0)

		{		

			$i = 0;							

			foreach ($query->result() as $nodeData)

			{

				$arrNodes[$i]['nodeId'] 	= $nodeData->nodeId;

				$arrNodes[$i]['leafId'] 	= $nodeData->leafId;

				$arrNodes[$i]['tag'] 		= $nodeData->tag;

				$arrNodes[$i]['treeIds'] 	= $nodeData->treeIds;

				$arrNodes[$i]['type'] 		= $nodeData->type;

				$arrNodes[$i]['authors'] 	= $nodeData->authors;

				$arrNodes[$i]['userId'] 	= $nodeData->userId;

				$arrNodes[$i]['contents'] 	= $nodeData->contents;

				$arrNodes[$i]['lockedStatus'] 	= $nodeData->lockedStatus;

				$arrNodes[$i]['createdDate'] 	= $nodeData->createdDate;

				$i++;	

			}

		}	

		return $arrNodes;		

	}
	

}