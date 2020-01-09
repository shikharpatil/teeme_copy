<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/**

* A PHP class to access User Database with convenient methods

* with various operation Add, update, delete & retrieve Discussion tree, node, leaf details

* @author   Ideavate Solutions (www.ideavate.com)

*/

// file that have the code for DBmanager class; 

//require('DBManager.php'); 

class task_db_manager extends CI_Model

{ 

	/**

	* $objdiscussion_db_manager This variable is used to make this class a singleton class.

	*/	

	private static $objdiscussion_db_manager = null;

	public $arrNodes = array();

    public $lViewrs;

	/**

	* This is the constructor of user DB Manager that call the contstructor of the Parent Class.

	*/

	public function __construct()

	{   

		//Parent class constructor.teeme_node

		parent::__construct();

	}



	/**

	* This function is used to retrieve the instance of discussion_db_manager. This method will ensure that there is only one instance of the discussion_db_manager in the single session. This is declared a static method because we would call this without being able to instantiate the class.

	*/

   

    static public function getInstance ()

	{

		if ($objdiscussion_db_manager == NULL)

		{

			$objdiscussion_db_manager = new chat_db_manager();

		}

		//Return the instance of discussion_db_manager class

		return $objdiscussion_db_manager;

	}

	



	/**

	* This function is used to insert the records to database.

	*/

	public function insertRecord($object, $status = 1)

    {		

		//Inserting task users
		//Manoj: Check user id in notes_users table
		
		/*$getNotesUser = $this->db->query('SELECT userId FROM teeme_notes_users WHERE notesId='.$object->getNotesId().' AND status = '.$this->db->escape_str($status));

		if($getNotesUser->num_rows() == 0)  

		{*/
		
		
		//Manoj: Check user id in notes_users table end

		if($object!= NULL && ($object instanceof Notes_users))

		{
			//Manoj: replace mysql_escape_str function
			$strResultSQL = "INSERT INTO teeme_notes_users(notesId, userId, status

						)

						VALUES

						(

						'".$object->getNotesId()."','".$object->getNotesUserId()."','".$this->db->escape_str($status)."' 

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
		//}

	}

	

	public function deleteTaskUsers ($taskId)

	{

		$query = $this->db->query('DELETE FROM teeme_notes_users WHERE notesId='.$taskId);

		if($query)

		{

			return true;			

		}

		else

		{

			return false;

		}

	}

	

	// to get treeId by leaf

	public function gettreeByLeaf($leafId){

	

		$treeData	= array();		

		$query = $this->db->query( "SELECT  *,  DATE_FORMAT( createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_tree  WHERE  type=2 and nodes=".$leafId);		

		if($query->num_rows() > 0)

		{

			 $row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] = $row->id;	

				$treeData['name']  = $row->name;	

				$treeData['userId'] = $row->userId;	

				$treeData['createdDate']  = $row->createdDate;				

				$treeData['nodes']  = $row->nodes;					

			}

		}					

		return $treeData;	

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

			$query = $this->db->query('SELECT 

			id FROM teeme_node WHERE treeIds='.$treeId);

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

					$link[0] = 'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('txt_Task').': '.$treeName;

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

	

	

	// to check unread leaf

	

	

	public function checkDiscussionLeafView($nodeId, $userId){

	

		$treeData= true;

		$query = $this->db->query( "SELECT * FROM teeme_discussion_view WHERE UserId=".$userId." and leafId=".$nodeId);		

 			if(!$query->num_rows())

			{

				$treeData= false;

			}		

			if($treeData){

				$succesor=$this->checkSuccessors($nodeId);

				$sArray=array();

				$sArray=explode(',',$succesor);

				$counter=0;

				while($counter < count($sArray)){

					if($sArray[$counter]){

						$treeData=$this->checkDiscussionLeafView($sArray[$counter], $userId);

						if(!$treeData){

							break;

						}

					}

					$counter++;

				}

			}

				

 		return $treeData;	

	

	}

	

	// to insert read leaf

	public function insertDiscussionLeafView($leafId, $userId){

		$this->load->model('dal/time_manager');			

		$curTime		= time_manager::getGMTTime();	

		$query = $this->db->query( "SELECT * FROM teeme_discussion_view WHERE UserId=".$userId." and leafId=".$leafId);		

 		if($query->num_rows() > 0)

		{

		

		}else{	

			$query = $this->db->query( "insert into teeme_discussion_view (UserId, leafId, view_time)values(".$userId.",".$leafId.",'".$curTime."')");		

			 





		}

		 

			

	}

	//to get parent tree by nodeId

	

	public function getPerentInfo($nodeId){

	

	$treeData	= array();

	
		/*Changed by Dashrath- add b.leafStatus column in query for delete feature*/
		$query = $this->db->query( "SELECT a.id as nodeId, a.treeIds, a.predecessor as predecessor, a.successors as successors, a.starttime as starttime,a.endtime as endtime, a.starttime as editStarttime, a.endtime as editEndtime, b.id as leafId, b.status as status, b.userId as userId, b.createdDate as DiscussionCreatedDate, b.editedDate as editedDate,b.latestContent, b.leafParentId, b.contents as contents, a.viewCalendar, b.leafStatus FROM teeme_node a, teeme_leaf b where b.nodeId=a.id and a.id= ".$nodeId." and b.latestContent=1 order by a.starttime, a.endtime");		

		if($query->num_rows() > 0)

		{

				foreach ($query->result() as $row)

				{

					$treeData['nodeId'] = $row->nodeId;	

					$treeData['predecessor'] = $row->predecessor;	

					$treeData['successors'] = $row->successors;	

					$treeData['leafId'] = $row->leafId;				

					$treeData['userId'] = $row->userId;	

					$treeData['starttime'] = $row->starttime;				

					$treeData['endtime'] = $row->endtime;	

					$treeData['latestContent']  = $row->latestContent;	

					$treeData['leafParentId']  = $row->leafParentId;	

					$treeData['DiscussionCreatedDate'] = $row->DiscussionCreatedDate;	

					$treeData['editedDate'] = $row->editedDate;	

					$treeData['contents'] = $row->contents;	

					$treeData['treeIds'] = $row->treeIds;

					$treeData['viewCalendar']  = $row->viewCalendar;	

					$treeData['editStarttime'] = $row->editStarttime;	

					$treeData['editEndtime'] = $row->editEndtime;

					/*Changed by Dashrath- add leafStatus column in array for delete feature*/
					$treeData['leafStatus'] = $row->leafStatus;

				}

		}					

		return $treeData;	

	



	}

	public function getPerentLeafInfo($id){

		$treeData	= array();

	

		$query = $this->db->query( "SELECT  id as leafId,  status as status, userId as userId, DATE_FORMAT(  createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,  latestContent,  leafParentId,  contents as contents FROM   teeme_leaf   where  id= ".$id);		

		if($query->num_rows() > 0)

		{

				foreach ($query->result() as $row)

				{

					

					$treeData['leafId'] = $row->leafId;				

					$treeData['userId'] = $row->userId;	

					 

					$treeData['latestContent']  = $row->latestContent;	

					$treeData['leafParentId']  = $row->leafParentId;	

					$treeData['DiscussionCreatedDate'] = $row->DiscussionCreatedDate;	

					$treeData['contents'] = $row->contents;	

					 

				}

		}					

		return $treeData;	

	

	}

	

	public function getByPerentLeaf($id){

		$treeData	= array();

	

		$query = $this->db->query( "SELECT  id as leafId,  status as status, userId as userId, DATE_FORMAT(  createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,  latestContent,  leafParentId,  contents as contents FROM   teeme_leaf   where  leafParentId= ".$id);		

		if($query->num_rows() > 0)

		{

				foreach ($query->result() as $row)

				{

					

					$treeData['leafId'] = $row->leafId;				

					$treeData['userId'] = $row->userId;	

					 

					$treeData['latestContent']  = $row->latestContent;	

					$treeData['leafParentId']  = $row->leafParentId;	

					$treeData['DiscussionCreatedDate'] = $row->DiscussionCreatedDate;	

					$treeData['contents'] = $row->contents;	

					 

				}

		}					

		return $treeData;	

	

	}

	public function checkPredecessor($nodeId){

		$query = $this->db->query( "SELECT * FROM teeme_node where id= ".$nodeId);		

		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{

				if(trim($row->predecessor)){

					return trim($row->predecessor);

				}else{

					return 0;

				}

			}

		}else{

			return 0;

		}

	}

	public function checkSuccessors($nodeId){

	

		$query = $this->db->query( "SELECT * FROM teeme_node where id= ".$nodeId);		

		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{

				if(trim($row->successors)){

					return trim($row->successors);

				}else{

					return 0;

				}

			}

		}else{

			return 0;

		}

	}

	// to get details of parent leaf for the discussion 



public function getChatTreeByLeaf($pId){

	

	$treeData	= array();

	

		$query = $this->db->query( "SELECT *, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_tree WHERE type=3 and nodes='".$pId."'");		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['treeid'] = $row->id;	

				$treeData['userId']  = $row->userId;	

				$treeData['createdDate'] = $row->createdDate;	

				$treeData['name']  = $row->name;				

				$treeData['workspaces']  = $row->workspaces;	

				

 			}

		}					

		return $treeData;	

	

}



	

	

// to get details of parent leaf for the discussion 



public function getDiscussionPerent($pId){

	

	$treeData	= array();

	

		$query = $this->db->query( "SELECT *, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_leaf WHERE id=".$pId);		

		if($query->num_rows() > 0)

		{

			 $row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] = $row->id;	

				$treeData['userId']  = $row->userId;	

				$treeData['createdDate'] = $row->createdDate;	

				$treeData['contents']  = $row->contents;				

				$treeData['nodeId']  = $row->nodeId;	

				

 			}

		}					

		return $treeData;	

	

}

   

		

	// this method is for getting all the nodes for discussion

	public function getAllRepalyDetails($treeId){

		$arrTree	= array();

		if($treeId != NULL)

		{

			 $query = $this->db->query('SELECT a.id as nodeId, a.tag as tag, b.id as leafId, b.status as status, b.userId as userId, b.createdDate, b.contents as contents FROM teeme_node a, teeme_leaf b where b.nodeId=a.id and a.treeIds= '.$treeId.' order by a.id');

			if($query->num_rows() > 0)

			{

			$treeId=0;

				foreach ($query->result() as $row)

				{

					$arrTree[$treeId]['nodeId'] = $row->nodeId;	

					$arrTree[$treeId]['tag'] = $row->tag;	

					$arrTree[$treeId]['leafId'] = $row->leafId;	

					$arrTree[$treeId]['status'] = $row->status;	

					$arrTree[$treeId]['userId'] = $row->userId;	

					$arrTree[$treeId]['createdDate'] = $row->createdDate;	

					$arrTree[$treeId]['contents'] = $row->contents;	

					$treeId++;

				}

			}		

		}

		return $arrTree;	

	}

	public function gettimmer($treeId){

	$this->load->model('dal/time_manager');			

	$curTime = time_manager::getGMTTime();

	

		 $query = $this->db->query("SELECT * from teeme_chat_info WHERE  starttime <  '".$curTime."' AND  endtime >'".$curTime."' and treeid =".$treeId);

			if($query->num_rows() > 0)

			{

				return true;

			}else{

				return false;

			}

	}

	

	//whole function edited by naga on 06/11/2008

	public function getNodesByTree($treeId){

	

		$treeData	= array();

		/* $memc = new Memcached;

		

		$i = $memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'task'.$treeId;	

		$memc->delete($memCacheId);	

		

		$memCacheValue = $memc->get($memCacheId); 

		

		$memCacheValue=0;

		if(!$memCacheValue)

		{							

			$tree = array();

	
			/*Changed by Dashrath- add b.leafStatus column in query for delete feature*/
			/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
			// $query = $this->db->query("SELECT a.id, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, a.starttime as editStarttime, a.endtime as editEndtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate, b.leafParentId , b.latestContent, a.viewCalendar, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and b.latestContent=1 and a.treeIds=".$treeId." order by a.nodeOrder");

			/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, a.starttime as editStarttime, a.endtime as editEndtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate, b.leafParentId , b.latestContent, a.viewCalendar, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and b.latestContent=1 and a.treeIds=".$treeId." and b.leafStatus != 'discarded' order by a.nodeOrder");
			/*Dashrath- code end*/

			foreach($query->result() as $chatData)

			{

				$tree[] = $chatData;

			}	

	

			 $memc->set($memCacheId, $tree);



		}		

		$value = $memc->get($memCacheId);	

	

		if ($value)

		{	

			$i=0;			

			foreach ($value as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['starttime'] = $row->starttime;	

				$treeData[$i]['endtime']  = $row->endtime;	

				$treeData[$i]['editStarttime'] = $row->editStarttime;	

				$treeData[$i]['editEndtime'] = $row->editEndtime;

				$treeData[$i]['endtime']  = $row->endtime;

				$treeData[$i]['leafId']  = $row->lid;	

				$treeData[$i]['latestContent']  = $row->latestContent;	

				$treeData[$i]['leafParentId']  = $row->leafParentId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;	

				$treeData[$i]['viewCalendar']  = $row->viewCalendar;

				/*Added by Dashrath- add leafStatus column in array for delete feature*/
				$treeData[$i]['leafStatus'] = $row->leafStatus;	

				$i++;

 			}

		}

		else

		{	

			$i=0;			

			foreach ($tree as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['starttime'] = $row->starttime;	

				$treeData[$i]['endtime']  = $row->endtime;	

				$treeData[$i]['editStarttime'] = $row->editStarttime;	

				$treeData[$i]['editEndtime'] = $row->editEndtime;

				$treeData[$i]['endtime']  = $row->endtime;

				$treeData[$i]['leafId']  = $row->lid;	

				$treeData[$i]['latestContent']  = $row->latestContent;	

				$treeData[$i]['leafParentId']  = $row->leafParentId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;	

				$treeData[$i]['viewCalendar']  = $row->viewCalendar;

				/*Added by Dashrath- add leafStatus column in array for delete feature*/
				$treeData[$i]['leafStatus'] = $row->leafStatus;	

				$i++;

 			}

		}

		/*Added by Dashrath- taskSortAccordingStarttime function call for sort task according starttime*/
		if(count($treeData)>0)
		{
			$treeData = $this->taskSortAccordingStarttime($treeData);
		}
		/*Dashrath- code end*/

		return $treeData;

	}

	public function getNodeDetailsByNodeId($nodeId){

	

		$treeData	= array();

		
		/*Changed by Dashrath- add b.leafStatus column in query for delete feature*/
		$q = "SELECT a.id, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, a.starttime as editStarttime, a.endtime as editEndtime, b.authors, b.userId, b.contents,  b.createdDate as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and b.latestContent=1 and a.id=".$nodeId." order by a.nodeOrder";



		$query = $this->db->query($q);

		

			foreach ($query->result() as $row)

			{

				$treeData['nodeId'] = $row->id;	

				$treeData['successors']  = $row->successors;	

				$treeData['predecessor'] = $row->predecessor;	

				$treeData['authors'] = $row->authors;	

				$treeData['userId']  = $row->userId;	

				$treeData['starttime'] = $row->starttime;	

				$treeData['endtime']  = $row->endtime;	

				$treeData['editStarttime'] = $row->editStarttime;	

				$treeData['editEndtime'] = $row->editEndtime;

				$treeData['endtime']  = $row->endtime;

				$treeData['leafId']  = $row->lid;	

				$treeData['latestContent']  = $row->latestContent;	

				$treeData['leafParentId']  = $row->leafParentId;	

				$treeData['contents'] = $row->contents;	

				$treeData['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData['viewCalendar']  = $row->viewCalendar;

				/*Added by Dashrath- add leafStatus column in array for delete feature*/
				$treeData['leafStatus']  = $row->leafStatus;



 			}

		return $treeData;

	}



	public function getNodesByPredecessor($predecessorId)

	{	

			$treeData	= array();

			

			$query = $this->db->query("SELECT a.id, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%m-%d-%Y %h:%i %p') as starttime,DATE_FORMAT(a.endtime, '%m-%d-%Y %h:%i %p') as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId  and a.predecessor=".$predecessorId." order by b.createdDate");

			foreach($query->result() as $chatData)

			{

				$tree[] = $chatData;

			}			

			

			$value = $tree;	

	

			if ($value)

			{	

				$i=0;			

				foreach ($value as $row)

				{

					$treeData[$i]['nodeId'] = $row->id;	

					$treeData[$i]['successors']  = $row->successors;	

					$treeData[$i]['predecessor'] = $row->predecessor;	

					$treeData[$i]['authors'] = $row->authors;	

					$treeData[$i]['userId']  = $row->userId;	

					$treeData[$i]['starttime'] = $row->starttime;	

					$treeData[$i]['endtime']  = $row->endtime;	

					$treeData[$i]['leafId']  = $row->lid;	

					$treeData[$i]['latestContent']  = $row->latestContent;	

					$treeData[$i]['leafParentId']  = $row->leafParentId;	

					$treeData[$i]['contents'] = $row->contents;	

					$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

					$treeData[$i]['viewCalendar']  = $row->viewCalendar;

					$treeData[$i]['treeIds']  = $row->treeIds;	

					$i++;

				}

			}		



	

		return $treeData;	

	

	}



	//whole function edited by naga on 06/11/2008

	public function getNodesByTreeDate($treeId, $date, $sortBy = 1, $workSpaceId=0, $workSpaceType=0){

	

		$treeData	= array();

		$orderBy 	= 'order by a.endtime';	

		if($sortBy == 2)

		{

			$orderBy = 'order by a.starttime';	

		}

		

		if($treeId > 0)

		{			

/*			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.starttime, '%Y-%m-%d')  AND a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=".$treeId." AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);*/		
			
			/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
			// $query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=".$treeId." AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);

			/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=".$treeId." AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 AND b.leafStatus != 'discarded' ".$orderBy);
			/*Dashrath- code end*/

		}

		else

		{

/*			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.starttime, '%Y-%m-%d')  AND a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);	*/		
			
			/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
			// $query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);
			
			/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 AND b.leafStatus != 'discarded' ".$orderBy);
			/*Dashrath- code end*/	

		}

	

		if ($query)

		{	

			$i=0;			

			foreach ($query->result() as $row)

			{

				$treeData[$i]['nodeId'] = $row->nodeId1;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['starttime'] = $row->starttime;	

				$treeData[$i]['endtime']  = $row->endtime;	

				$treeData[$i]['leafId']  = $row->lid;	

				$treeData[$i]['latestContent']  = $row->latestContent;	

				$treeData[$i]['leafParentId']  = $row->leafParentId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;

				$treeData[$i]['viewCalendar']  = $row->viewCalendar;	

				$treeData[$i]['treeIds']  = $row->treeIds;	

				$i++;

 			}

		}	

		return $treeData;

	}

	//whole function edited by naga on 06/11/2008

	public function getNodesByTreeEndDate($treeId, $date, $sortBy = 1, $workSpaceId=0, $workSpaceType=0){

		

		$treeData	= array();

		$orderBy = 'order by a.endtime';	

		if($sortBy == 2)

		{

			$orderBy = 'order by a.starttime';	

		}

		if($treeId > 0)

		{

/*			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.endtime, '%Y-%m-%d')  AND a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=".$treeId." AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.workSpaceId=".$workSpaceId." AND a.workSpaceType=".$workSpaceType." AND a.viewCalendar = 1 ".$orderBy);	*/	
			
			/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
			// $q = "SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId AND a.treeIds=".$treeId." AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy;

			/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
			$q = "SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId AND a.treeIds=".$treeId." AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 AND b.leafStatus != 'discarded' ".$orderBy;
			/*Dashrath- code end*/

			$query = $this->db->query($q);	

		}

		else

		{

/*			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.endtime, '%Y-%m-%d')  AND a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);*/		
			
			/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
			// $query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);

			/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,a.endtime as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 AND b.leafStatus != 'discarded' ".$orderBy);
			/*Dashrath- code end*/	

		}

	

		if ($query)

		{	

			$i=0;			

			foreach ($query->result() as $row)

			{

				$treeData[$i]['nodeId'] = $row->nodeId1;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['starttime'] = $row->starttime;	

				$treeData[$i]['endtime']  = $row->endtime;	

				$treeData[$i]['leafId']  = $row->lid;	

				$treeData[$i]['latestContent']  = $row->latestContent;	

				$treeData[$i]['leafParentId']  = $row->leafParentId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;

				$treeData[$i]['viewCalendar']  = $row->viewCalendar;	

				$treeData[$i]['treeIds']  = $row->treeIds;	

				$i++;

 			}

		}	

		return $treeData;

	}



	//whole function edited by naga on 06/11/2008

	public function getNodesByTreeSameDate($treeId, $date, $sortBy = 1, $workSpaceId=0, $workSpaceType=0){

	

		$treeData	= array();

		$orderBy = 'order by a.endtime';	

		if($sortBy == 2)

		{

			$orderBy = 'order by a.starttime';	

		}

		if($treeId > 0)

		{

/*			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1,DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime,DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.endtime, '%Y-%m-%d') AND a.successors = '0' AND '$date' = DATE_FORMAT(a.starttime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=".$treeId." AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);		*/
			
			/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
			// $query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1,a.endtime as endtime,DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND b.id=a.leafId and a.treeIds=".$treeId." AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);

			/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1,a.endtime as endtime,DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND b.id=a.leafId and a.treeIds=".$treeId." AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 AND b.leafStatus != 'discarded' ".$orderBy);	
			/*Dashrath- code end*/	

		}

		else

		{

			if ($workSpaceId==0)

			{

/*				$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime, DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1, DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.endtime, '%Y-%m-%d') AND a.successors = '0' AND '$date' = DATE_FORMAT(a.starttime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.userId='".$_SESSION['userId']."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);	*/		
				
				/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
				// $query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime, DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1, a.endtime as endtime, DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND b.id=a.leafId and a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.userId='".$_SESSION['userId']."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);

				/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
				$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime, DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1, a.endtime as endtime, DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND b.id=a.leafId and a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.userId='".$_SESSION['userId']."' AND c.type = 4 AND a.viewCalendar = 1 AND b.leafStatus != 'discarded' ".$orderBy);
				/*Dashrath- code end*/	

			}

			else

			{

/*				$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime, DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1, DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.endtime, '%Y-%m-%d') AND a.successors = '0' AND '$date' = DATE_FORMAT(a.starttime, '%Y-%m-%d') AND b.id=a.leafId AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);*/		

				$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime, DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1, a.endtime as endtime, DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE a.successors = '0' AND  b.id=a.leafId AND a.treeIds=c.id AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."' AND c.type = 4 AND a.viewCalendar = 1 AND b.leafStatus != 'discarded' ".$orderBy);

			}

		}

	

		if ($query)

		{	

			$i=0;			

			foreach ($query->result() as $row)

			{

				$treeData[$i]['nodeId'] = $row->nodeId1;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['starttime'] = $row->starttime;	

				$treeData[$i]['endtime']  = $row->endtime;	

				$treeData[$i]['starttime1'] = $row->starttime1;	

				$treeData[$i]['endtime1']  = $row->endtime1;	

				$treeData[$i]['leafId']  = $row->lid;	

				$treeData[$i]['latestContent']  = $row->latestContent;	

				$treeData[$i]['leafParentId']  = $row->leafParentId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;

				$treeData[$i]['viewCalendar']  = $row->viewCalendar;

				$treeData[$i]['treeIds']  = $row->treeIds;		

				$i++;

 			}

		}	

		return $treeData;

	}



	public function getNodesByTree1($treeId, $sort = 0){

	

		$treeData	= array();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'dis'.$treeId;	

		$memc->delete($memCacheId);			

		$value = $memc->get($memCacheId);

		

		if($sort == 1)

		{

			$sortBy = ' ORDER BY a.starttime ASC';

		}

		else if($sort == 2)

		{

			$sortBy = ' ORDER BY a.endtime ASC';

		}

		else if($sort == 3)

		{

			$sortBy = ' ORDER BY b.contents ASC';

		}

		else if($sort == 4)

		{

			$sortBy = ' ORDER BY b.contents DESC';

		}				

		else

		{

			$sortBy = ' ORDER BY b.createdDate';

		}	

			$tree = array();	

	

		$query = $this->db->query("SELECT a.id, a.treeIds, a.starttime as starttime, a.endtime as endtime, a.successors, a.predecessor,b.id as leafId, b.authors, b.userId, b.contents, b.createdDate as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE a.id=b.nodeId  and a.treeIds=".$treeId.$sortBy);

		foreach($query->result() as $disData)

		{

			$tree[] = $disData;

		}			

		$memc->set($memCacheId, $tree);

		$value = $memc->get($memCacheId);					

		if(count($value) > 0)

		{

			$i=0;

	

			foreach ($value as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['leafId']  = $row->leafId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['starttime'] = $row->starttime;	

				$treeData[$i]['endtime'] = $row->endtime;	

				$treeData[$i]['treeIds'] = $row->treeIds;	

				$i++;

 			}

		}			

		

		return $treeData;	

	

	}

	

	public function getNodesByTreeFromDB($treeId, $sort = 0){



		$treeData	= array();



		if($sort == 1)

		{

			$sortBy = ' ORDER BY a.starttime ASC';

		}

		else if($sort == 2)

		{

			$sortBy = ' ORDER BY a.starttime DESC';

		}

		else if($sort == 3)

		{

			$sortBy = ' ORDER BY b.contents ASC';

		}

		else if($sort == 4)

		{

			$sortBy = ' ORDER BY b.contents DESC';

		}				

		else

		{

			$sortBy = ' ORDER BY a.starttime DESC';

		}	

					

			$tree = array();	

			$q = "SELECT a.id, a.treeIds, a.starttime as starttime, a.endtime as endtime, a.successors, a.predecessor,b.id as leafId, b.authors, b.userId, b.contents, b.createdDate as DiscussionCreatedDate,b.editedDate FROM teeme_node a, teeme_leaf b WHERE a.id=b.nodeId  and a.treeIds=".$treeId.$sortBy;

			$query = $this->db->query($q);
			
			//echo $q;

			foreach($query->result() as $disData)

			{

				$tree[] = $disData;

			}			



			$value = $tree;				

		

		if(count($value) > 0)

		{

			$i=0;



			foreach ($value as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['leafId']  = $row->leafId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;	

				$treeData[$i]['starttime'] = $row->starttime;	

				$treeData[$i]['endtime'] = $row->endtime;	

				$treeData[$i]['treeIds'] = $row->treeIds;

				if($row->editedDate[0]==0)

					{ 

						$treeData[$i]['orderingDate'] = $row->DiscussionCreatedDate;	

					}	

					else

					{

						$treeData[$i]['orderingDate'] = $row->editedDate;	

					}	

				$i++;

 			}

		}			

		

		return $treeData;	

	

	}	

	

	//arun-add two more field fromDate,toDate in existing function 

	public function getNodesByTreeFromDB1($treeId, $sort = 0,$fromDate='',$toDate='',$completionStatus=0,$assigned=0,$by=0){



		$treeData	= array();



		if($sort == 1)

		{

			$sortBy = ' ORDER BY a.endtime DESC';

		}

		else if($sort == 3)

		{

			$sortBy = ' ORDER BY b.contents ASC';

		}

		else if($sort == 4)

		{

			$sortBy = ' ORDER BY b.contents DESC';

		}				

		else

		{

			$sortBy = ' ORDER BY a.starttime DESC';

		}	

					

			$tree = array();	

			

			$condition='';

			

			if($this->input->post('showAll')){

				//$condition .=" and a.starttime='0000-00-00 00:00:00' and a.endtime='0000-00-00 00:00:00'";

			}

			else{

/*				if($fromDate!='')

				{

					$condition=" and a.starttime >= '".$fromDate." 00:00:00' and a.starttime!='0000-00-00 00:00:00'";

				}

				

				if($toDate!='')

				{

				

					$condition .=" and a.starttime<= '".$toDate." 23:59:59' and a.endtime >= '".$toDate." 23:59:59' and a.endtime!='0000-00-00 00:00:00'";

				}*/
/*				if($fromDate!='' && $toDate=='')
				{
					$condition=" AND (a.endtime>= '".$fromDate." 00:00:00' OR (a.starttime!='0000-00-00 00:00:00' AND a.endtime='0000-00-00 00:00:00'))";
				}
				else if($toDate!='' && $fromDate=='')
				{
					$condition=" AND (a.starttime<= '".$toDate." 00:00:00' OR (a.starttime='0000-00-00 00:00:00' AND a.endtime!='0000-00-00 00:00:00'))";
				}
				else if ($fromDate!='' && $toDate!='')
				{
					$condition .=" AND (a.endtime>= '".$fromDate." 00:00:00' OR (a.starttime!='0000-00-00 00:00:00' AND a.endtime='0000-00-00 00:00:00')) AND (a.starttime<= '".$toDate." 00:00:00' OR (a.starttime='0000-00-00 00:00:00' AND a.endtime!='0000-00-00 00:00:00'))";
				}*/
			}

			

/*			if($completionStatus!='' && $completionStatus!=5){

				$condition .="and c.status IN(".$completionStatus.") ";

			}*/

			/*Changed by Dashrath- add b.leafStatus column in query*/
			$q = "SELECT distinct(a.id), a.treeIds, a.starttime as starttime, a.endtime as endtime, a.successors, a.predecessor,b.id as leafId, b.authors, b.userId, b.contents, b.createdDate as DiscussionCreatedDate,b.editedDate,b.leafStatus 

			FROM teeme_node a, teeme_leaf b,teeme_activity_completion_status  c WHERE

			a.id=b.nodeId AND a.id=c.activityId ".$condition."  AND a.treeIds=".$treeId.$sortBy;

	    	$query = $this->db->query($q);
			//echo $q; exit;

			

			foreach($query->result() as $disData)

			{ 

				$tree[] = $disData;

			}			

           

			$value = $tree;				

		 

		if(count($value) > 0)

		{



			foreach ($value as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['leafId']  = $row->leafId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;	

				$treeData[$i]['starttime'] = $row->starttime;	

				$treeData[$i]['endtime'] = $row->endtime;	

				$treeData[$i]['treeIds'] = $row->treeIds;

				$treeData[$i]['leafStatus'] = $row->leafStatus;	

				$i++;

 			}

		}			

		

		return $treeData;	

	

	}	

	

	

	public function getOnlineuserslist($wsId)

	{

		$treeData	= array();

		$query = $this->db->query( "SELECT *, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_tree WHERE id=".$treeId);		

		if($query->num_rows() > 0)

		{

			 $row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] = $row->id;	

				$treeData['name']  = $row->name;	

				$treeData['type'] = $row->type;	

				$treeData['userId']  = $row->userId;	

				$treeData['createdDate'] = $row->createdDate;	

				$treeData['editedDate']  = $row->editedDate;	

				$treeData['workspaces'] = $row->workspaces;	

				$treeData['nodes']  = $row->nodes;	

				$treeData['treeVersion'] = $row->treeVersion;	

 			}

		}					

		return $treeData;			

	}

	 /**

	* This method will be used for fetch the Discussion name from the database.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @return The Discussion name

	*/

	public function insertTaskTime($treeId, $detail,$starttime='NULL',$endtime='NULL'){

		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("insert into teeme_chat_info  (treeid,starttime,endtime,activity_detail) values (".$treeId.",'".$this->db->escape_str($starttime)."','".$this->db->escape_str($endtime)."','".$this->db->escape_str($detail)."')");

	}

	 /**

	* This method will be used to update the task title

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $taskTitle This is the variable used to hold the task title.

	* @update the task title

	*/	

	public function updateTaskTitle($title, $treeId){

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("update teeme_tree set name = '".$this->db->escape_str($title)."' WHERE id = ".$treeId);

		

	}	



	public function getDiscussionDetailsByTreeId($treeId)

	{
		$treeData	= array();



		$query = $this->db->query( "SELECT a.* FROM teeme_tree a WHERE a.id=".$treeId);		

		if($query->num_rows() > 0)

		{

			 $row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] = $row->id;

				if(substr_count($row->name, 'untitle') > 0)

				{

					$treeData['name']  = 'untitled';	

					$treeData['old_name']  = $row->old_name;	

				}

				else

				{

					$treeData['name']  = $row->name;	

					$treeData['old_name']  = $row->old_name;					

				}

				$treeData['type'] = $row->type;	

				$treeData['userId']  = $row->userId;	

				$treeData['createdDate'] = $row->createdDate;	

				$treeData['editedDate']  = $row->editedDate;	

				$treeData['workspaces'] = $row->workspaces;	

				$treeData['nodes']  = $row->nodes;	

				$treeData['treeVersion'] = $row->treeVersion;

				$treeData['starttime']  = '';	

				$treeData['endtime'] = '';	

				$treeData['task_detail'] = '';

				$treeData['autonumbering'] = $row->autonumbering;	

 			}

		}	
					

		return $treeData;			

	}

	public function getDiscussionDetailsByNodeId($nodeId)

	{

		$treeData	= array();

		$query = $this->db->query( "SELECT a.*,a.id as leafId, b.treeIds, DATE_FORMAT(a.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, DATE_FORMAT(b.starttime, '%m-%d-%Y %h:%i %p') as starttime, DATE_FORMAT(b.endtime, '%m-%d-%Y %h:%i %p') as endtime FROM teeme_leaf a,  teeme_node b WHERE b.leafId=a.id and b.id=".$nodeId);		

		if($query->num_rows() > 0)

		{

			 $row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] = $row->id;	

				$treeData['contents']  = $row->contents;					

				$treeData['starttime']  = $row->starttime;	

				$treeData['endtime'] = $row->endtime;	

				$treeData['treeId'] = $row->treeIds;	

				$treeData['leafId'] = $row->leafId;				

 			}

		}					

		return $treeData;			

	}

	

	public function insertNewLeaf($leafId,$content,$userId, $nodeId, $time, $startTime, $endTime, $viewCalendar){

		
		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("update teeme_leaf set userId = ".$_SESSION['userId'].",contents = '".$this->db->escape_str($content)."', createdDate = '".$time."' WHERE id = ".$leafId);



		$query = $this->db->query("update teeme_node set starttime = '".$startTime."',endtime = '".$endTime."',viewCalendar = ".$viewCalendar." WHERE id = ".$nodeId);

		

	}

	

	public function updateTaskLeaf($leafId,$content,$userId, $nodeId, $time, $startTime, $endTime, $viewCalendar){

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("update teeme_leaf set userId = ".$_SESSION['userId'].",contents = '".$this->db->escape_str($content)."', editedDate = '".$time."' WHERE id = ".$leafId);



		$query = $this->db->query("update teeme_node set starttime = '".$startTime."',endtime = '".$endTime."',viewCalendar = ".$viewCalendar." WHERE id = ".$nodeId);

		

	}	

	

public function insertTaskNode($treeId,$content,$userId,$createdDate,$starttime,$endtime,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1, $viewCalendar = 0, $nodeOrder=1){

	$query = $this->db->query("update teeme_node set nodeOrder=nodeOrder+1 where nodeOrder>=".$nodeOrder." AND treeIds = '".$treeId."' AND predecessor = '".$predecessor."'");

	$query = $this->db->query("insert into teeme_node (predecessor,successors,treeIds,starttime,endtime, viewCalendar, nodeOrder) values ('".$predecessor."','".$successors."',".$treeId.",'".$starttime."','".$endtime."','".$viewCalendar."','".$nodeOrder."')");

	$nodeId=$this->db->insert_id();	

		//Manoj: replace mysql_escape_str function

	  $query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,contents,nodeId, latestContent  ) values (".$type.",'".$this->db->escape_str($authors)."',".$status.",".$userId.",'".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.", 1)");

	$leafId=$this->db->insert_id();	

	

	$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		

 	return $nodeId;



}

//arun- add task_completion_activity query

public function insertTaskNode2($treeId,$content,$userId,$createdDate,$starttime,$endtime,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1, $viewCalendar = 0, $nodeOrder=1){

	$query = $this->db->query("update teeme_node set nodeOrder=nodeOrder+1 where nodeOrder>=".$nodeOrder." AND treeIds = '".$treeId."' AND predecessor = '".$predecessor."'");

	$query = $this->db->query("insert into teeme_node (predecessor,successors,treeIds,starttime,endtime, viewCalendar, nodeOrder) values ('".$predecessor."','".$successors."',".$treeId.",'".$starttime."','".$endtime."','".$viewCalendar."','".$nodeOrder."')");

	$nodeId=$this->db->insert_id();	

		
	//Manoj: replace mysql_escape_str function
	  $query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId, latestContent  ) values (".$type.",'".$this->db->escape_str($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.", 1)");

	$leafId=$this->db->insert_id();	

	

	$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

	

	$query = $this->db->query("INSERT INTO teeme_activity_completion_status(activityId,status,userId) VALUES('".$nodeId."','0','".$userId."')");

		

 	return $nodeId;



}



public function insertTaskNode1($treeId,$content,$userId,$createdDate,$starttime,$endtime,$taskStatus,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1, $viewCalendar = 0, $nodeOrder=1){

	

	$query = $this->db->query("update teeme_node set nodeOrder=nodeOrder+1 where nodeOrder>=".$nodeOrder." AND treeIds = '".$treeId."' AND predecessor = '".$predecessor."'");

	$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds,starttime,endtime, viewCalendar, nodeOrder) values ('".$predecessor."','".$successors."',".$treeId.",'".$starttime."','".$endtime."','".$viewCalendar."','".$nodeOrder."')");

	$nodeId=$this->db->insert_id();	

		

	$query = $this->db->query('INSERT INTO teeme_activity_completion_status(activityId, status, userId) VALUES('.$nodeId.','.$taskStatus.','.$userId.')');	

		
//Manoj: replace mysql_escape_str function
	  $query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId, latestContent  ) values (".$type.",'".$this->db->escape_str ($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str ($content)."',".$nodeId.", 1)");

	$leafId=$this->db->insert_id();	

	

	$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

	if($predecessor != 0)

	{	

		$query = $this->db->query("select * from teeme_node  where id=".$predecessor);

		foreach ($query->result() as $row)

		{

			$successors=trim($row->successors);

		}

		if($successors){

			$sArray=array();

			$sArray=explode(',',$successors);

			

			$sArray[count($sArray)]=$nodeId;

			

			$successors=implode(',',$sArray);

		}else{

			$successors=$nodeId;

		}

		$query = $this->db->query("update teeme_node set successors='".$successors."' where id=".$predecessor);

	}	

 	return $nodeId;



}

public function updateLeafContent($leafId, $contents,$editedDate)

{		
	//Manoj: replace mysql_escape_str function

	$query = $this->db->query("update teeme_leaf set contents = '".$this->db->escape_str($contents)."', userId='".$_SESSION['userId']."',editedDate='".$editedDate."' WHERE id = ".$leafId);

	if($query)

	{

		return true;

	}

	else

	{

		return false;

	}		

}

public function updateTreeName($treeId, $treeName)

{		

	$query = $this->db->query("update teeme_tree set name = '".$this->db->escape_str($treeName)."' WHERE id = ".$treeId);

	if($query)

	{

		return true;

	}

	else

	{

		return false;

	}		

}

	

public function insertDiscussionNode($treeId,$content,$userId,$createdDate,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1){

	$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds) values ('".$predecessor."','".$successors."',".$treeId.")");

	$nodeId=$this->db->insert_id();	

		//Manoj: replace mysql_escape_str function

	$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,contents,nodeId) values (".$type.",'".$this->db->escape_str ($authors)."',".$status.",".$userId.",'".$createdDate."','".$this->db->escape_str ($content)."',".$nodeId.")");

	$leafId=$this->db->insert_id();	

	

	$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		

	$this->insertDiscussionLeafView($leafId, $userId);

	return $nodeId;

}

// this method for inserting new reply

	public function insertTaskReplay($pnodeId,$content,$userId,$createdDate,$starttime,$endtime,$treeId,$tag='',$authors='',$status=1,$type=1, $viewCalendar = 0, $nodeOrder = 1)

	{

		$query = $this->db->query("update teeme_node set nodeOrder=nodeOrder+1 where nodeOrder>=".$nodeOrder." AND treeIds = '".$treeId."' AND predecessor = '".$pnodeId."'");

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds, starttime, endtime, viewCalendar, nodeOrder) values ('".$pnodeId."',0,".$treeId.", '".$starttime."','".$endtime."','".$viewCalendar."', '".$nodeOrder."')");

		$nodeId=$this->db->insert_id();

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("insert into teeme_leaf  (type, authors, status, userId, createdDate, contents, nodeId, leafParentId, latestContent) values (".$type.",'".$this->db->escape_str ($authors)."',".$status.",".$userId.",'".$createdDate."','".$this->db->escape_str ($content)."',".$nodeId.",'0',1)");

		$leafId=$this->db->insert_id();

		

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		

		

		$query = $this->db->query("select * from teeme_node  where id=".$pnodeId);

		foreach ($query->result() as $row)

		{

			$successors=trim($row->successors);

		}

		if($successors){

			$sArray=array();

			$sArray=explode(',',$successors);

			

			$sArray[count($sArray)]=$nodeId;

			

			$successors=implode(',',$sArray);

		}else{

			$successors=$nodeId;

		}

		$query = $this->db->query("update teeme_node set successors='".$successors."' where id=".$pnodeId);		

		$this->insertDiscussionLeafView($leafId, $userId);

		return $nodeId;			

	}

	

	// this method for inserting new reply

	//arun- add  entry teeme_activity_completion_status for showing task search result on 0% searchig

	public function insertTaskReplay1($pnodeId,$content,$userId,$createdDate,$starttime,$endtime,$subTaskComplitionStatus,$treeId,$tag='',$authors='',$status=1,$type=1, $viewCalendar = 0, $nodeOrder = 1)

	{

		$query = $this->db->query("update teeme_node set nodeOrder=nodeOrder+1 where nodeOrder>=".$nodeOrder." AND treeIds = '".$treeId."' AND predecessor = '".$pnodeId."'");

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds, starttime, endtime, viewCalendar, nodeOrder) values ('".$pnodeId."',0,".$treeId.", '".$starttime."','".$endtime."','".$viewCalendar."', '".$nodeOrder."')");

		$nodeId=$this->db->insert_id();

		

		$query = $this->db->query('INSERT INTO teeme_activity_completion_status(activityId, status, userId) VALUES('.$nodeId.','.$subTaskComplitionStatus.','.$userId.')');

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("insert into teeme_leaf  (type, authors, status, userId, createdDate,editedDate, contents, nodeId, leafParentId, latestContent) values (".$type.",'".$this->db->escape_str ($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str ($content)."',".$nodeId.",'0',1)");

		$leafId=$this->db->insert_id();

		

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		

		

		$query = $this->db->query("select * from teeme_node  where id=".$pnodeId);

		foreach ($query->result() as $row)

		{

			$successors=trim($row->successors);

		}

		if($successors){

			$sArray=array();

			$sArray=explode(',',$successors);

			

			$sArray[count($sArray)]=$nodeId;

			

			$successors=implode(',',$sArray);

		}else{

			$successors=$nodeId;

		}

		$query = $this->db->query("update teeme_node set successors='".$successors."' where id=".$pnodeId);		

		$this->insertDiscussionLeafView($leafId, $userId);

		

		$query = $this->db->query("INSERT INTO teeme_activity_completion_status(activityId,status,userId) VALUES('".$nodeId."','0','".$userId."')");

		return $nodeId;			

	}



	public function insertTaskTitle($title,$treeId,$viewCalendar = 0,$autonumbering=0)

		{

			//Manoj: replace mysql_escape_str function

			$query = $this->db->query("update teeme_tree set name='".$this->db->escape_str($title)."', viewCalendar = ".$viewCalendar.", autonumbering=".$autonumbering." where id=".$treeId);

				

		}

// this method for inserting new reply

	public function insertNewTask($title,$pnode,$workSpaceId,$workSpaceType,$userId,$createdDate,$leafType=2, $viewCalendar = 0)

	{		

		$query = $this->db->query("insert into teeme_tree  (name,type,workspaces,workSpaceType,userId,createdDate,editedDate,nodes,nodeType, viewCalendar) values ('".$this->db->escape_str($title)."',4,'".$workSpaceId."','".$workSpaceType."',".$userId.",'".$createdDate."','".$createdDate."','".$pnode."','".$leafType."','".$viewCalendar."')");

		$treeId=$this->db->insert_id();				

		return $treeId;			

	}

	// this method for get discussion tree for particular doc node

	public function getTreesByNode($nodeId){

		$treeData	= array();

		

		$query = $this->db->query("SELECT id,name,userId,workspaces,nodes, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as createdDate FROM teeme_tree WHERE type=2 and nodes='".$nodeId."'");

		$i=0;

		foreach ($query->result() as $row)

		{

			$treeData[$i]['treeId'] = $row->id;	

			$treeData[$i]['name'] = $row->name;

			$treeData[$i]['userId'] = $row->userId;	

			$treeData[$i]['createdDate'] = $row->createdDate;	

			$treeData[$i]['workspaces'] = $row->workspaces;	

			$treeData[$i]['nodes'] = $row->nodes;	

			$i++;

		}

		

		return $treeData;

	}



	// this method for get the child nodes of the parent node

	public function getChildNodes($nodeId, $treeId){

		$childNodes	= array();

		
		/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
		// $query = $this->db->query("SELECT id FROM teeme_node WHERE predecessor='".$nodeId."' and treeIds='".$treeId."' ORDER BY nodeOrder DESC");

		/*Added by Dashrath- change query and add condition in query leafStatus!=discarded*/
		$query = $this->db->query("SELECT a.id FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and a.predecessor='".$nodeId."' and a.treeIds='".$treeId."' and b.leafStatus != 'discarded' ORDER BY a.nodeOrder DESC");
		/*Dashrath- code end*/

		$i=0;

		foreach ($query->result() as $row)

		{

			$childNodes[] = $row->id;	

			

		}

		

		return $childNodes;

	}

 	/**

	* This method will be used to fetch the user detailse from the database.

 	* @param $userId This is the variable used to hold the user ID .

	* @return The user details

	*/

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



	/**

	* This method will be used for fetch the task user ids.

 	* @param $taskId This is the variable used to hold the task ID .

	* @return The task user details

	*/

	public function getTaskUsers($taskId, $type)

	{

		$userData = array();

		$query = $this->db->query('SELECT userId FROM teeme_notes_users WHERE notesId='.$taskId.' AND status = '.$type);

		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{										

				$userData[] = $row->userId;					

			}				

		}						

		return $userData;			

	}

	/**

	* This method will be used to update the task status.

 	* @param $taskId This is the variable used to hold the task ID .

	* @return The task user details

	*/

	public function updateTaskStatus($taskId, $status, $userId)

	{

		$userData = array();

		$query = $this->db->query('DELETE FROM teeme_activity_completion_status WHERE activityId='.$taskId);

		$query = $this->db->query('INSERT INTO teeme_activity_completion_status(activityId, status, userId) VALUES('.$taskId.','.$status.','.$userId.')');

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

	* This method will be used to get the task status.

 	* @param $taskId This is the variable used to hold the task ID .

	* @return The task user details

	*/

	public function getTaskStatus($taskId)

	{

		$status = 0;

		$query = $this->db->query('SELECT status FROM teeme_activity_completion_status WHERE activityId='.$taskId);

		

		if($query->num_rows() > 0)

		{

			$tmpData 	= $query->row();

			$status = $tmpData->status;		

		}

		return $status;

	}

	

	 /**

	 

	* This method will be used for fetch the tree Records from the database.

 	* @param $userId This is the variable used to hold the user ID .

	* @return The tree datas as an array

	*/

	public function getAllTask($workSpaceId,$workSpaceType,$userId, $type=4, $option = 1, $sortBy = 1, $sortOrder = 1)

	{

		$arrTree	= array();	

		if($workSpaceId != NULL)

		{

			// Get information of particular Discussion

			if($option == 1)

			{

				if($sortBy == 1)

				{

				    /*Changed by surbhi IV*/

					$orderBy = ' ORDER BY a.name';

					/*End of Changed by surbhi IV*/

				}

				else if($sortBy == 2)

				{

					$orderBy = ' ORDER BY d.tagName';

				}/*Added by surbhi IV*/

				else if($sortBy == 3)

				{

					$orderBy = ' ORDER BY a.editedDate';

				}/*End of added by surbhi IV*/

				else if($sortBy == 4)

				{

					$orderBy = ' ORDER BY b.starttime';

				}

				else if($sortBy == 5)

				{

					$orderBy = ' ORDER BY b.endtime';

				}/*Changed by surbhi IV*/

				else

				{

					$orderBy = ' ORDER BY a.editedDate';

				}/*End of Changed by surbhi IV*/		

				if($sortOrder == 1)

				{

					$orderBy .= ' DESC';

				}

				else

				{

					$orderBy .= ' ASC';

				} 		

		

				if($workSpaceId)
				{

					$query = $this->db->query("SELECT a.*,a.createdDate as treeCreatedDate, editedDate as treeEditedDate, date_format(b.starttime,'%m-%d-%Y %h:%i %p') as starttime,date_format(b.endtime,'%Y-%m-%d %H:%i:%s') as endtime, c.contents FROM teeme_tree a , teeme_node b, teeme_leaf c, teeme_users d where b.treeIds=a.id and c.id = b.leafId AND a.userId = d.userId AND (a.nodes='0' OR a.nodes='') and a.name like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);

				}

				else
				{

					$query = $this->db->query("SELECT a.*,a.createdDate as treeCreatedDate, editedDate as treeEditedDate, date_format(b.starttime,'%m-%d-%Y %h:%i %p') as starttime,date_format(b.endtime,'%Y-%m-%d %H:%i:%s') as endtime, c.contents FROM teeme_tree a , teeme_node b, teeme_leaf c, teeme_users d where b.treeIds=a.id and c.id = b.leafId AND a.userId = d.userId AND (a.nodes='0' OR a.nodes='') and a.name like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and (a.userId='".$userId."' OR a.isShared=1) and a.type=".$type.$orderBy);

				}



				if($query->num_rows() > 0)

				{

					foreach ($query->result() as $row)

					{	

						$treeId		= $row->id;							

						$arrTree[$treeId]['name'] 			= $row->contents;

						$arrTree[$treeId]['old_name'] 		= $row->old_name;

						$arrTree[$treeId]['type'] 			= $row->type;	

						$arrTree[$treeId]['userId'] 		= $row->userId;

						$arrTree[$treeId]['createdDate'] 	= $row->treeCreatedDate;

						$arrTree[$treeId]['editedDate'] 	= $row->treeEditedDate;

						$arrTree[$treeId]['starttime'] 		= $row->starttime;

						$arrTree[$treeId]['endtime'] 		= $row->endtime;

						$arrTree[$treeId]['nodes'] 			= $row->nodes;	

						$arrTree[$treeId]['viewCalendar'] 	= $row->viewCalendar;	

						$arrTree[$treeId]['isShared'] 		= $row->isShared;						

					}				

				}

			}

			else if($option == 2)

			{	

				if($sortBy == 1)

				{

					$orderBy = ' ORDER BY a.name';

				}

				else if($sortBy == 2)

				{

					$orderBy = ' ORDER BY b.tagName';

				}

				else if($sortBy == 3)

				{

					$orderBy = ' ORDER BY a.editedDate';

				}/*Changed by surbhi IV*/

				else

				{

					$orderBy = ' ORDER BY a.editedDate';

				}/*End of Changed by surbhi IV*/		

				if($sortOrder == 2)

				{

					$orderBy .= ' ASC';

				}

				else

				{

					$orderBy .= ' DESC';

				}

				

				



				if($workSpaceId>0)

				{								
					$qry = "SELECT a.*,a.createdDate as treeCreatedDate, editedDate as treeEditedDate FROM teeme_tree a, teeme_users b  where a.userId = b.userId AND (a.nodes='0' OR a.nodes='') and a.name not like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy;
					$query = $this->db->query($qry); 

				}

				else

				{

					$query = $this->db->query("SELECT a.*,a.createdDate as treeCreatedDate, editedDate as treeEditedDate FROM teeme_tree a, teeme_users b where a.userId = b.userId AND (a.nodes='0' OR a.nodes='') AND a.name not like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and (a.userId='".$userId."' OR a.isShared=1) and a.type=".$type.$orderBy);

				}

				if($query->num_rows() > 0)

				{

					foreach ($query->result() as $row)

					{	

						$treeId		= $row->id;								

						$arrTree[$treeId]['name'] 			= $row->name;	

						$arrTree[$treeId]['old_name'] 		= $row->old_name;

						$arrTree[$treeId]['type'] 			= $row->type;	

						$arrTree[$treeId]['userId'] 		= $row->userId;

						$arrTree[$treeId]['createdDate'] 	= $row->treeCreatedDate;

						$arrTree[$treeId]['editedDate'] 	= $row->treeEditedDate;

						$arrTree[$treeId]['nodes'] 			= $row->nodes;

						$arrTree[$treeId]['isShared'] 		= $row->isShared;						

						

					}				

				}

			}			

		}

		return $arrTree;				

	}



	



	/* This method will be used for update the chat memcache.

 	* @param $treeId This is the variable used to hold the chat tree ID .	

	*/

	public function updateChatMemCache( $treeId )

	{

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'chat'.$treeId;			

		$memCacheValue = $memc->get($memCacheId);								

		$tree = array();		

		$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId);

		foreach($query->result() as $chatData)

		{

			$tree[] = $chatData;

		}		

		if($memCacheValue)

		{		

			$memc->replace( $memCacheId, $tree );	

		}

		else

		{

			$memc->add( $memCacheId, $tree );

		}		

	}

	

	/**

	* This method is used to get the task contributors 	

	*/

	function getTaskContributors($nodeId)

	{		

		$userData 	= array();		

		$i = 0;

		$query 		= $this->db->query('SELECT b.tagName, b.nickName, a.userId FROM teeme_notes_users a, teeme_users b WHERE a.userId = b.userId AND a.notesId = '.$nodeId.' AND a.status = 2 ORDER BY b.tagName');

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $row)

			{						

				$userData[$i]['userId'] 		= $row->userId;	

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



	 /**

	* This method will be used for fetch the tree nodes from the database. 		

	* @param $date This is the variable used to hold the required date

	* @param $artifactTreeId This is the variable used to hold the artifact tree id

	* @return The tree datas as an array

	*/

	public function getNodesByDate($artifactTreeId, $searchDate1, $searchDate2, $sort = 0)

	{

		$arrNodes	= array();

		$whereDate  = '';

		if($sort == 1)

		{

			$sortBy = ' ORDER BY a.starttime ASC';

		}

		else if($sort == 2)

		{

			$sortBy = ' ORDER BY a.endtime ASC';

		}

		else

		{

			$sortBy = '';

		}

		if($searchDate1 != '' && $searchDate2 != '')

		{

			$whereDate .= ' AND (date_format(a.startTime, \'%Y-%m-%d\')=\''.$searchDate1.'\' OR date_format(a.endTime, \'%Y-%m-%d\')=\''.$searchDate2.'\')'.$sortBy;

		}

		else if($searchDate2 != '' && $searchDate1 == '')

		{

			$whereDate .= ' AND date_format(a.endTime, \'%Y-%m-%d\')=\''.$searchDate2.'\'';

		}		

		else if($searchDate1 != '' && $searchDate2 == '')

		{

			$whereDate .= ' AND date_format(a.startTime, \'%Y-%m-%d\')=\''.$searchDate1.'\'';

		}		

		

		$query = $this->db->query('SELECT 

							a.id FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\''.$whereDate);

		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{										

				$arrNodes[] 	= $row->id;						

			}				

		}

		

		return $arrNodes;				

	}



	/**

	* This method is used to get all the nodes by using successor ids	

	*/

	function getNodesBySuccessor($successorIds)

	{		

		$arrIds = explode(',',$successorIds);

		foreach($arrIds as $val)

		{

			$checksucc 	= $this->checkSuccessors($val);

			if($checksucc)

			{	

				$this->getNodesBySuccessor($checksucc);

			}

			else

			{

				$this->arrNodes[] = $val;

				

			}			

		}		

		return $this->arrNodes;		

	}



	/**

	* This method is used to get the sub list start and end time 	

	*/

	function getSubListTime($nodes)

	{		

		$arrTime 	= array();		

		$i = 0;

		$query 		= $this->db->query('SELECT startTime as listStartTime FROM teeme_node WHERE id IN('.$nodes.') AND startTime != \'0000-00-00 00:00:00\' ORDER BY startTime ASC LIMIT 0,1');

		if($query->num_rows() > 0)

		{			

			$tmpData 	= $query->row();

			$arrTime['listStartTime'] = $tmpData->listStartTime;

		}

		else

		{

			$arrTime['listStartTime'] = '';

		}	

		$query 		= $this->db->query('SELECT endTime as listEndTime FROM teeme_node WHERE id IN('.$nodes.') AND endTime != \'0000-00-00 00:00:00\' ORDER BY endTime DESC LIMIT 0,1');

		if($query->num_rows() > 0)

		{			

			$tmpData 	= $query->row();

			$arrTime['listEndTime'] = $tmpData->listEndTime;

		}

		else

		{

			$arrTime['listEndTime'] = '';

		}				

		return $arrTime;		

	}

	

	public function getCurrentTaskStatus($leafId)

	{

	

		$query 		= $this->db->query('SELECT date_format(startTime, \'%m-%d-%Y %h:%i %p\') as listStartTime,date_format(endtime, \'%m-%d-%Y %h:%i %p\') as endtime FROM teeme_node WHERE leafId ="'.$leafId.'"  LIMIT 0,1');

		if($query->num_rows() > 0)

		{			

			return $query->row();

			

		}

		else

		{

			return  '';

		}	

	}

	

	

	

	

	public function getCurrentEditTaskStatus($leafId)

	{

	

	 

		$query 		= $this->db->query('SELECT starttime as listStartTime, endtime FROM teeme_node WHERE id ="'.$leafId.'"  LIMIT 0,1');

		if($query->num_rows() > 0)

		{			

			return $query->row();

			

		}

		else

		{

			return  '';

		}	

	}

	

	public function getCurrentLeafContents ($leafId)

	{

		

		$query = $this->db->query('SELECT * FROM `teeme_leaf` WHERE id='.$leafId);								

		if($query->num_rows() > 0)

		{			

			return $query->row();

			

		}

		else

		{

			return  '';

		}	

	}

	

	public function getCurrentCalendarStatus($nodeId)

	{

		

		$query = $this->db->query('SELECT viewCalendar FROM `teeme_node` WHERE id='.$nodeId);								

		if($query->num_rows() > 0)

		{			

			$query =$query->row();

			return $query->viewCalendar;

			

		}

		else

		{

			return  '';

		}	

	}

	

	function insertTaskHistory($treeId,$workSpaceId,$workSpaceType,$nodeId,$content,$starTime,$endTime,$taskUsers,$completeStatus,$markCalendor=0,$date=0)

	{
		//Manoj: replace mysql_escape_str function
	 	 $query = $this->db->query("insert into teeme_task_history  (treeId,workSpaceId,workSpaceType,nodeId,contents,starttime,endtime,assignedTo,complitionStatus,userId,editTime) values ('".$treeId."','".$workSpaceId."','".$workSpaceType."','".$nodeId."','".$this->db->escape_str($content)."','".$starTime."','".$endTime."','".implode(',',$taskUsers)."','".$completeStatus."','".$_SESSION['userId']."','".$date."')");

	}

	

	

	public function getNodeDetailsByNodeIdForHistory($nodeId){

	

		$treeData	= array();



		$q = "SELECT a.id,a.leafId as leafId, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, b.contents ,a.viewCalendar FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId  and a.leafId=".$nodeId." order by a.nodeOrder";



		$query = $this->db->query($q);

		

			foreach ($query->result() as $row)

			{

				

				$treeData['starttime'] = $row->starttime;	

				$treeData['endtime']  = $row->endtime;	

				$treeData['leafId'] = $row->leafId;	

				$treeData['nodeId'] = $row->id;	

				$treeData['contents'] = $row->contents;	

				



 			}

		return $treeData;

	}

	

	

	public function getCurrentEditTaskStatusForHistory($leafId)

	{

	

		$query 		= $this->db->query('SELECT startTime as startTime ,endtime  as endtime FROM teeme_node WHERE leafId ="'.$leafId.'"  LIMIT 0,1');

		if($query->num_rows() > 0)

		{			

			return $query->row();

			

		}

		else

		{

			return  '';

		}	

	}

	

	/* This function is used to fetch the latest version of the tree using tree id */

	

	public function getTaskTreeLatestVersionByTreeId ($treeId,$nodeId)

	{

		

		$latest='';

		$query = $this->db->query("SELECT COUNT(id) as total FROM teeme_task_history WHERE treeId='".$treeId."' AND nodeId='".$nodeId."' ");	

		if($query->num_rows()>0)

		{							

			foreach($query->result() as $row)

			{

				$latest = $row->total;

			}	

		}		

		return $latest;

	

	}

	

	//arun - this function fetch history record of task

	function getTaskHistory($nodeId)

	{

	   $check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_task_history'");

	   if($check->num_rows()>0)

	   {

	   		$query 		= $this->db->query('SELECT *,date_format(editTime, \'%Y-%m-%d %H:%i:%s\') as editTime FROM teeme_task_history WHERE  nodeId="'.$nodeId.'"  ORDER BY editTime DESC  ');

			$arrTree=array();

			if($query->num_rows() > 0)

			{

			   $i=0;

				foreach ($query->result() as $row)

				{	

				

											

					$arrTree[$i]['contents'] 			= $row->contents;

					$arrTree[$i]['starttime'] 			= $row->starttime;

					$arrTree[$i]['endtime'] 			= $row->endtime;	

					$arrTree[$i]['assignedTo'] 			= $row->assignedTo;

					$arrTree[$i]['complitionStatus'] 	= $row->complitionStatus;

					$arrTree[$i]['userId'] 				= $row->userId;

					$arrTree[$i]['editTime'] 			= $row->editTime;

					

					$i++;	

									

				}				

			}

		

		  return $arrTree;

	   }

	   else

	   {

			echo $this->lang->line('history_table_not_exist');

			die;

	   }

	}

	

	

	//arun-get user tag name by user id

	function getUserTagNameByUserId($userId=0)

	{		

		$userData 	= array();		

		$i = 0;

		/*Commented by Dashrath- comment old query and new query with nickname */
		// $query 		= $this->db->query('SELECT b.tagName, b.userId FROM teeme_users b WHERE  b.userId = '.$userId);

		/*Change by Dashrath- add b.nickName in query*/
		$query 		= $this->db->query('SELECT b.tagName, b.userId, b.nickName FROM teeme_users b WHERE  b.userId = '.$userId);

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $row)

			{						

				$userData[$i]['userId'] 		= $row->userId;	

				/*Commented by Dashrath- add if else condition below*/
				//$userData[$i]['userTagName'] 	= $row->tagName;

				/*Added by Dashrath- add for if nickname exists usertagname is nickname*/
				if($row->nickName!='')
				{
					$userData[$i]['userTagName'] 	= $row->nickName;
				}
				else
				{
					$userData[$i]['userTagName'] 	= $row->tagName;	
				}
				/*Dashrath- code end*/	

				$i++;					

			}				

		}			

		return $userData;		

	}

	public function getTaskNodesDetailsByTree($treeId)
	{

		$treeData	= array();

	
		$tree = array();

	
		/*Changed by Dashrath- add b.leafStatus column in query*/
		$query = $this->db->query("SELECT a.id, a.successors, a.predecessor,a.leafId as lid,a.starttime as starttime,a.endtime as endtime, a.starttime as editStarttime, a.endtime as editEndtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate, b.leafParentId , b.latestContent, a.viewCalendar, a.nodeOrder, b.status, b.type, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and b.latestContent=1 and a.treeIds=".$treeId);

		foreach($query->result() as $chatData)
		{

			$tree[] = $chatData;

		}	

		$i=0;			

		foreach ($tree as $row)
		{

			$treeData[$i]['nodeId'] = $row->id;	

			$treeData[$i]['successors']  = $row->successors;	

			$treeData[$i]['predecessor'] = $row->predecessor;	

			$treeData[$i]['authors'] = $row->authors;	

			$treeData[$i]['userId']  = $row->userId;	

			$treeData[$i]['starttime'] = $row->starttime;	

			$treeData[$i]['endtime']  = $row->endtime;	

			$treeData[$i]['editStarttime'] = $row->editStarttime;	

			$treeData[$i]['editEndtime'] = $row->editEndtime;

			$treeData[$i]['endtime']  = $row->endtime;

			$treeData[$i]['leafId']  = $row->lid;	

			$treeData[$i]['latestContent']  = $row->latestContent;	

			$treeData[$i]['leafParentId']  = $row->leafParentId;	

			$treeData[$i]['contents'] = $row->contents;	

			$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

			$treeData[$i]['editedDate']  = $row->editedDate;	

			$treeData[$i]['viewCalendar']  = $row->viewCalendar;

			$treeData[$i]['nodeOrder']  = $row->nodeOrder;

			$treeData[$i]['status']  = $row->status;

			$treeData[$i]['type']  = $row->type;

			/*Added by Dashrath- add leafStatus column in array*/
			$treeData[$i]['leafStatus']  = $row->leafStatus;

			$i++;

 		}

		return $treeData;

	}

	/*Changed by Dashrath- Add leafStatus*/
	public function copyTaskNode($treeId,$content,$userId,$createdDate,$starttime,$endtime,$taskStatus,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1, $viewCalendar = 0, $nodeOrder=1, $leafStatus='publish')
	{

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds,starttime,endtime, viewCalendar, nodeOrder) values ('".$predecessor."','".$successors."',".$treeId.",'".$starttime."','".$endtime."','".$viewCalendar."','".$nodeOrder."')");

		$nodeId=$this->db->insert_id();	


		$query = $this->db->query('INSERT INTO teeme_activity_completion_status(activityId, status, userId) VALUES('.$nodeId.','.$taskStatus.','.$userId.')');	

		/*Changed by Dashrath- Add leafStatus*/
		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId, latestContent,leafStatus  ) values (".$type.",'".$this->db->escape_str ($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str ($content)."',".$nodeId.", 1,'".$this->db->escape_str ($leafStatus)."')");

		$leafId=$this->db->insert_id();	

		

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

	 	return $nodeId;

	}

	public function getNoteUsersByNodeId($nodeId)
	{
		$NoteData	= array();
		$noteDetails = array();

		$query = $this->db->query("SELECT * FROM teeme_notes_users WHERE notesId=".$nodeId);

		foreach($query->result() as $noteUserData)
		{

			$noteDetails[] = $noteUserData;

		}	

		$i=0;			

		foreach ($noteDetails as $row)
		{

			$NoteData[$i]['userId'] = $row->userId;	

			$NoteData[$i]['status']  = $row->status;	

			$i++;

 		}

		return $NoteData;
	}

	/*Added by Dashrath- taskSortAccordingStarttime function start*/
	public function taskSortAccordingStarttime($treeData)
	{
		$this->load->model('dal/time_manager');
		$this->load->model('dal/task_db_manager');
		$objTime = $this->time_manager;	
		$currentDateTime = $objTime->getGMTTime();

		//$treeDataNewArr = array();
		$treeDataNewArr1 = array();
		$treeDataNewArr2 = array();
		$treeDataNewArr3 = array();
		$treeDataNewArr4 = array();

		foreach ($treeData as $key => $value)
		{

			//starttime greatethan equal to current datetime
			// if($value['starttime'] >= $currentDateTime)
			// {
			// 	$treeDataNewArr1[] = $value;
			// 	$timestamps[$key]=strtotime($value['starttime']);
			// }
			// else if($value['starttime'] < $currentDateTime && $value['endtime'] >= $currentDateTime)
			// {
			// 	$treeDataNewArr2[] = $value;
			// }
			// else if($value['starttime'] == '0000-00-00 00:00:00')
			// {
			// 	$treeDataNewArr3[] = $value;
			// }
			// else
			// {
			// 	$treeDataNewArr4[] = $value;
			// }

			//$checksucc 	= $this->task_db_manager->checkSuccessors($value['nodeId']);
			$checksucc 	= $value['successors'];

			if($checksucc)
			{
				// $arrNodes = $this->task_db_manager->getNodesBySuccessor($checksucc);			
				// $allNodes = implode(',', $arrNodes);
				//$subListTime = $this->task_db_manager->getSubListTime($allNodes);

			
				$subListTime = $this->task_db_manager->getSubListTime($checksucc);

				if($subListTime['listStartTime'] != '')
				{
					$newStarttime = $subListTime['listStartTime'];
					
				}
				else
				{
					$newStarttime = '0000-00-00 00:00:00';
				}

				if($subListTime['listEndTime'] != '')
				{
					$newEndtime = $subListTime['listEndTime'];
				}
				else
				{
					$newEndtime = '0000-00-00 00:00:00';
				}
				
			}
			else
			{
				$newStarttime = $value['starttime'];
				$newEndtime = $value['endtime'];
			}	

			//starttime greatethan equal to current datetime
			// if($newStarttime >= $currentDateTime)
			// {
			// 	$treeDataNewArr1[] = $value;
			// 	$timestamps[$key]=strtotime($newStarttime);
			// }
			// else if($newStarttime < $currentDateTime && $newEndtime >= $currentDateTime)
			// {
			// 	$treeDataNewArr2[] = $value;
			// }
			// else if($newStarttime == '0000-00-00 00:00:00')
			// {
			// 	$treeDataNewArr3[] = $value;
			// }
			// else
			// {
			// 	$treeDataNewArr4[] = $value;
			// }


			// if($newStarttime != '' && $newStarttime != '0000-00-00 00:00:00')
			// {
			// 	$treeDataNewArr1[] = $value;
			// 	$timestamps1[$key]=strtotime($newStarttime);
			// }
			// else if(($newStarttime == '' || $newStarttime == '0000-00-00 00:00:00') && ($newEndtime !='' && $newEndtime != '0000-00-00 00:00:00'))
			// {
			// 	$treeDataNewArr2[] = $value;
			// 	$timestamps2[$key]=strtotime($newEndtime);
			// }
			// else if($newStarttime == '0000-00-00 00:00:00')
			// {
			// 	$treeDataNewArr3[] = $value;
			// }
			// else
			// {
			// 	$treeDataNewArr4[] = $value;
			// }

			if(($newStarttime != '' && $newStarttime != '0000-00-00 00:00:00') || ($newEndtime != '' && $newEndtime != '0000-00-00 00:00:00'))
			{
				if($newStarttime != '' && $newStarttime != '0000-00-00 00:00:00')
				{
					$startEndTime = strtotime($newStarttime);
				}
				else if($newEndtime != '' && $newEndtime != '0000-00-00 00:00:00')
				{
					$startEndTime = strtotime($newEndtime);
				}

				$treeDataNewArr1[] = $value;
				$timestamps1[$key]=$startEndTime;
			}
			else if($newStarttime == '0000-00-00 00:00:00')
			{
				$treeDataNewArr3[] = $value;
			}
			else
			{
				$treeDataNewArr4[] = $value;
			}
		}

		//array sort according starttime
		array_multisort($timestamps1, SORT_ASC, $treeDataNewArr1);

		//array sort according endtime
		//array_multisort($timestamps2, SORT_ASC, $treeDataNewArr2);

		// $treeDataNewArr = array_merge($treeDataNewArr1,$treeDataNewArr2,$treeDataNewArr3,$treeDataNewArr4);

		$treeDataNewArr = array_merge($treeDataNewArr1,$treeDataNewArr3,$treeDataNewArr4);

		return $treeDataNewArr;
	}
	/*taskSortAccordingStarttime function end*/


	/*Added by Dashrath- subTaskNodeIdArraySortAccordingDatetime function start*/
	public function subTaskNodeIdArraySortAccordingDatetime($nodeIdArr)
	{
		$this->load->model('dal/time_manager');
		$this->load->model('dal/task_db_manager');
		$objTime = $this->time_manager;	
		$currentDateTime = $objTime->getGMTTime();

		$nodeIdArr1 = array();
		$nodeIdArr2 = array();
		$nodeIdArr3 = array();
		$nodeIdArr4 = array();

		$subTaskDataArr = array();

		foreach ($nodeIdArr as $key => $value) {
			//get sub task details according node id
			$subTaskDataArr[] = $this->task_db_manager->getPerentInfo($value);
		}

		foreach ($subTaskDataArr as $key => $value)
		{
			$newStarttime = $value['starttime'];
			$newEndtime = $value['endtime'];

			// if($newStarttime != '' && $newStarttime != '0000-00-00 00:00:00')
			// {
			// 	$nodeIdArr1[] = $value;
			// 	$timestamps1[$key]=strtotime($newStarttime);
			// }
			// else if(($newStarttime == '' || $newStarttime == '0000-00-00 00:00:00') && ($newEndtime !='' && $newEndtime != '0000-00-00 00:00:00'))
			// {
			// 	$nodeIdArr2[] = $value;
			// 	$timestamps2[$key]=strtotime($newEndtime);
			// }
			// else if($newStarttime == '0000-00-00 00:00:00')
			// {
			// 	$nodeIdArr3[] = $value;
			// }
			// else
			// {
			// 	$nodeIdArr4[] = $value;
			// }

			if(($newStarttime != '' && $newStarttime != '0000-00-00 00:00:00') || ($newEndtime != '' && $newEndtime != '0000-00-00 00:00:00'))
			{
				if($newStarttime != '' && $newStarttime != '0000-00-00 00:00:00')
				{
					$startEndTime = strtotime($newStarttime);
				}
				else if($newEndtime != '' && $newEndtime != '0000-00-00 00:00:00')
				{
					$startEndTime = strtotime($newEndtime);
				}

				$nodeIdArr1[] = $value;
				$timestamps1[$key]=$startEndTime;
			}
			else if($newStarttime == '0000-00-00 00:00:00')
			{
				$nodeIdArr3[] = $value;
			}
			else
			{
				$nodeIdArr4[] = $value;
			}
		}

		//echo '<pre>';
		//print_r($treeDataNewArr1);die;

		//array sort according starttime
		array_multisort($timestamps1, SORT_ASC, $nodeIdArr1);

		//array sort according endtime
		//array_multisort($timestamps2, SORT_ASC, $nodeIdArr2);

		// $nodeIdNewArr = array_merge($nodeIdArr1,$nodeIdArr2,$nodeIdArr3,$nodeIdArr4);

		$nodeIdNewArr = array_merge($nodeIdArr1,$nodeIdArr3,$nodeIdArr4);

		$nodeIdNewArr1 = array();
		foreach ($nodeIdNewArr as $key => $value) {
			
			$nodeIdNewArr1[] = $value['nodeId'];
		}

		return $nodeIdNewArr1;
	}
	/*subTaskNodeIdArraySortAccordingDatetime function end*/

 }

?>