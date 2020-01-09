<?php 

/*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/*

* A PHP class to access User Database with convenient methods

* with various operation Add, update, delete & retrieve Discussion tree, node, leaf details

* @author   Ideavate Solutions (www.ideavate.com)

*/





class activity_db_manager extends CI_Model

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

		//Inserting activity users

		if($object!= NULL && ($object instanceof Notes_users))

		{

			$strResultSQL = "INSERT INTO teeme_notes_users(notesId, userId, status

							)

							VALUES

							(

							'".$object->getNotesId()."','".$object->getNotesUserId()."','".$status."' 

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

					$link[1] = 'Document: '.$treeName;

				}	

				if($treeType == 2)

				{

					$link[0] = 'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = 'Discussion: '.$treeName;

				}	

				if($treeType == 3)

				{

					$link[0] = 'view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = 'Chat: '.$treeName;

				}	

				if($treeType == 4)

				{

					$link[0] = 'view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = 'Activity: '.$treeName;

				}	

				if($treeType == 5)

				{

					$link[0] = 'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = 'Contact: '.$treeName;

				}	

				if($treeType == 6)

				{

					$link[0] = 'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = 'Notes: '.$treeName;

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

	

		$query = $this->db->query( "SELECT a.id as nodeId, a.treeIds, a.predecessor as predecessor, a.successors as successors, DATE_FORMAT(a.starttime, '%m-%d-%Y %h:%i %p') as starttime,DATE_FORMAT(a.endtime, '%m-%d-%Y %h:%i %p') as endtime, DATE_FORMAT(a.starttime, '%Y-%m-%d %H:%i') as editStarttime, DATE_FORMAT(a.endtime, '%Y-%m-%d %H:%i') as editEndtime, b.id as leafId, b.status as status, b.userId as userId, DATE_FORMAT( b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.latestContent, b.leafParentId, b.contents as contents, a.viewCalendar FROM teeme_node a, teeme_leaf b where b.nodeId=a.id and a.id= ".$nodeId." and b.latestContent=1 order by a.starttime, a.endtime");		

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

					$treeData['contents'] = $row->contents;	

					$treeData['treeIds'] = $row->treeIds;

					$treeData['viewCalendar']  = $row->viewCalendar;	

					$treeData['editStarttime'] = $row->editStarttime;	

					$treeData['editEndtime'] = $row->editEndtime;

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

		/*$memc = new Memcached;

		//$memc->flush();

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'activity'.$treeId;		

		$memc->delete($memCacheId);	

		$memCacheValue = $memc->get($memCacheId); 

		$memCacheValue=0;

		if(!$memCacheValue)

		{							

			$tree = array();

			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%m-%d-%Y %h:%i %p') as starttime,DATE_FORMAT(a.endtime, '%m-%d-%Y %h:%i %p') as endtime, DATE_FORMAT(a.starttime, '%Y-%m-%d %H:%i') as editStarttime, DATE_FORMAT(a.endtime, '%Y-%m-%d %H:%i') as editEndtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and b.latestContent=1 and a.treeIds=".$treeId." order by a.nodeOrder");

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

				$treeData[$i]['viewCalendar']  = $row->viewCalendar;

				$i++;

 			}

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

	public function getNodesByTreeDate($treeId, $date, $sortBy = 1){

	

		$treeData	= array();

		$orderBy 	= 'order by a.endtime';	

		if($sortBy == 2)

		{

			$orderBy = 'order by a.starttime';	

		}

		

		if($treeId > 0)

		{			

			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b WHERE '$date' = DATE_FORMAT(a.starttime, '%Y-%m-%d')  AND a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=".$treeId." AND a.viewCalendar = 1 ".$orderBy);		

		}

		else

		{

			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.starttime, '%Y-%m-%d')  AND a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=c.id AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);			

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

	public function getNodesByTreeEndDate($treeId, $date, $sortBy = 1){

		

		$treeData	= array();

		$orderBy = 'order by a.endtime';	

		if($sortBy == 2)

		{

			$orderBy = 'order by a.starttime';	

		}

		if($treeId > 0)

		{

	

			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b WHERE '$date' = DATE_FORMAT(a.endtime, '%Y-%m-%d')  AND a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=".$treeId." AND a.viewCalendar = 1 ".$orderBy);		

		}

		else

		{

			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.endtime, '%Y-%m-%d')  AND a.successors = '0' AND DATE_FORMAT(a.starttime, '%Y-%m-%d') != DATE_FORMAT(a.endtime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=c.id AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);			

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

	public function getNodesByTreeSameDate($treeId, $date, $sortBy = 1){

	

		$treeData	= array();

		$orderBy = 'order by a.endtime';	

		if($sortBy == 2)

		{

			$orderBy = 'order by a.starttime';	

		}

		if($treeId > 0)

		{

	

			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime,DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1,DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime,DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b WHERE '$date' = DATE_FORMAT(a.endtime, '%Y-%m-%d') AND a.successors = '0' AND '$date' = DATE_FORMAT(a.starttime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=".$treeId." AND a.viewCalendar = 1 ".$orderBy);		

		}

		else

		{

			$query = $this->db->query("SELECT a.id as nodeId1, a.treeIds, a.successors, a.predecessor,a.leafId as lid,DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime, DATE_FORMAT(a.starttime, '%h:%i %p') as starttime1, DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, DATE_FORMAT(a.endtime, '%h:%i %p') as endtime1, b.authors, b.userId, b.contents,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafParentId , b.latestContent, a.viewCalendar FROM teeme_node a, teeme_leaf b, teeme_tree c WHERE '$date' = DATE_FORMAT(a.endtime, '%Y-%m-%d') AND a.successors = '0' AND '$date' = DATE_FORMAT(a.starttime, '%Y-%m-%d') AND b.id=a.leafId and a.treeIds=c.id AND c.type = 4 AND a.viewCalendar = 1 ".$orderBy);			

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

		

		//$memc->flush();

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

			$sortBy = ' ORDER BY b.createdDate DESC';

		}	

	

			$tree = array();	

	

			$query = $this->db->query("SELECT a.id, a.treeIds, DATE_FORMAT(a.starttime, '%Y-%m-%d %h:%i %p') as starttime, DATE_FORMAT(a.endtime, '%Y-%m-%d %h:%i %p') as endtime, a.successors, a.predecessor,b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE a.id=b.nodeId  and a.treeIds=".$treeId.$sortBy);

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

	public function insertActivityTime($treeId, $detail,$starttime='NULL',$endtime='NULL'){

		$query = $this->db->query("insert into teeme_chat_info  (treeid,starttime,endtime,activity_detail) values (".$treeId.",'".$starttime."','".$endtime."','".$detail."')");

	}

	 /**

	* This method will be used to update the activity title

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $activityTitle This is the variable used to hold the activity title.

	* @update the activity title

	*/	

	public function updateActivityTitle($title, $treeId){

		

		$query = $this->db->query("update teeme_tree set name = '".$title."' WHERE id = ".$treeId);

		

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

				$treeData['activity_detail'] = '';	

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

		

		$query = $this->db->query("update teeme_leaf set userId = ".$_SESSION['userId'].",contents = '".addslashes($content)."', createdDate = '".$time."' WHERE id = ".$leafId);



		$query = $this->db->query("update teeme_node set starttime = '".$startTime."',endtime = '".$endTime."',viewCalendar = ".$viewCalendar." WHERE id = ".$nodeId);

		

	}

public function insertActivityNode($treeId,$content,$userId,$createdDate,$starttime,$endtime,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1, $viewCalendar = 0, $nodeOrder=1){

	$query = $this->db->query("update teeme_node set nodeOrder=nodeOrder+1 where nodeOrder>=".$nodeOrder." AND treeIds = '".$treeId."' AND predecessor = '".$predecessor."'");

	$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds,starttime,endtime, viewCalendar, nodeOrder) values ('".$predecessor."','".$successors."',".$treeId.",'".$starttime."','".$endtime."','".$viewCalendar."','".$nodeOrder."')");

	$nodeId=$this->db->insert_id();	

		

	  $query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,contents,nodeId, latestContent  ) values (".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".addslashes ($content)."',".$nodeId.", 1)");

	$leafId=$this->db->insert_id();	

	

	$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		

 	return $nodeId;



}

public function insertActivityNode1($treeId,$content,$userId,$createdDate,$starttime,$endtime,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1, $viewCalendar = 0, $nodeOrder=1){

	

	$query = $this->db->query("update teeme_node set nodeOrder=nodeOrder+1 where nodeOrder>=".$nodeOrder." AND treeIds = '".$treeId."' AND predecessor = '".$predecessor."'");

	$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds,starttime,endtime, viewCalendar, nodeOrder) values ('".$predecessor."','".$successors."',".$treeId.",'".$starttime."','".$endtime."','".$viewCalendar."','".$nodeOrder."')");

	$nodeId=$this->db->insert_id();	

		

	  $query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,contents,nodeId, latestContent  ) values (".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".addslashes ($content)."',".$nodeId.", 1)");

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

public function updateLeafContent($leafId, $content)

{		

	$query = $this->db->query("update teeme_leaf set contents = '".$content."' WHERE id = ".$leafId);

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

	$query = $this->db->query("update teeme_tree set name = '".$treeName."' WHERE id = ".$treeId);

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

		

	$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,contents,nodeId) values (".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".addslashes ($content)."',".$nodeId.")");

	$leafId=$this->db->insert_id();	

	

	$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		

	$this->insertDiscussionLeafView($leafId, $userId);

	return $nodeId;

}

// this method for inserting new reply

	public function insertActivityReplay($pnodeId,$content,$userId,$createdDate,$starttime,$endtime,$treeId,$tag='',$authors='',$status=1,$type=1, $viewCalendar = 0, $nodeOrder = 1)

	{

		$query = $this->db->query("update teeme_node set nodeOrder=nodeOrder+1 where nodeOrder>=".$nodeOrder." AND treeIds = '".$treeId."' AND predecessor = '".$pnodeId."'");

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds, starttime, endtime, viewCalendar, nodeOrder) values ('".$pnodeId."',0,".$treeId.", '".$starttime."','".$endtime."','".$viewCalendar."', '".$nodeOrder."')");

		$nodeId=$this->db->insert_id();

		

		$query = $this->db->query("insert into teeme_leaf  (type, authors, status, userId, createdDate, contents, nodeId, leafParentId, latestContent) values (".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".addslashes ($content)."',".$nodeId.",'0',1)");

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



	public function insertActivityTitle($title,$treeId,$viewCalendar = 0)

		{

			

			$query = $this->db->query("update teeme_tree set name='".$title."', viewCalendar = ".$viewCalendar." where id=".$treeId);

				

		}

// this method for inserting new reply

	public function insertNewActivity($title,$pnode,$workSpaceId,$workSpaceType,$userId,$createdDate,$leafType=2, $viewCalendar = 0)

	{		

		$query = $this->db->query("insert into teeme_tree  (name,type,workspaces,workSpaceType,userId,createdDate,nodes,nodeType, viewCalendar) values ('".$title."',4,'".$workSpaceId."','".$workSpaceType."',".$userId.",'".$createdDate."','".$pnode."','".$leafType."','".$viewCalendar."')");

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

	

		$query = $this->db->query("SELECT id FROM teeme_node WHERE predecessor='".$nodeId."' and treeIds='".$treeId."' ORDER BY nodeOrder");

		$i=0;

		foreach ($query->result() as $row)

		{

			$childNodes[] = $row->id;	

			

		}

	

		return $childNodes;

	}

 	/**

	* This method will be used for fetch the user detailse from the database.

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

				$userData['userTagName'] = $row->tagName;	

						

			}				

		}						

		return $userData;			

	}



	/**

	* This method will be used for fetch the activity user ids.

 	* @param $activityId This is the variable used to hold the activity ID .

	* @return The activity user details

	*/

	public function getActivityUsers($activityId, $type)

	{

		$userData = array();

		$query = $this->db->query('SELECT userId FROM teeme_notes_users WHERE notesId='.$activityId.' AND status = '.$type);

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

	* This method will be used to update the activity status.

 	* @param $activityId This is the variable used to hold the activity ID .

	* @return The activity user details

	*/

	public function updateActivityStatus($activityId, $status, $userId)

	{

		$userData = array();

		$query = $this->db->query('DELETE FROM teeme_activity_completion_status WHERE activityId='.$activityId);

		$query = $this->db->query('INSERT INTO teeme_activity_completion_status(activityId, status, userId) VALUES('.$activityId.','.$status.','.$userId.')');

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

	* This method will be used to get the activity status.

 	* @param $activityId This is the variable used to hold the activity ID .

	* @return The activity user details

	*/

	public function getActivityStatus($activityId)

	{

		$status = 0;

		$query = $this->db->query('SELECT status FROM teeme_activity_completion_status WHERE activityId='.$activityId);

		

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

	public function getAllActivity($workSpaceId,$workSpaceType,$userId, $type=4, $option = 1, $sortBy = 1, $sortOrder = 1)

	{

		$arrTree	= array();		

		if($workSpaceId != NULL)

		{

			// Get information of particular Discussion

			if($option == 1)

			{

				if($sortBy == 1)

				{

					$orderBy = ' ORDER BY a.name';

				}

				else if($sortBy == 2)

				{

					$orderBy = ' ORDER BY d.tagName';

				}

				else if($sortBy == 4)

				{

					$orderBy = ' ORDER BY b.starttime';

				}

				else if($sortBy == 5)

				{

					$orderBy = ' ORDER BY b.endtime';

				}

				else

				{

					$orderBy = ' ORDER BY a.name';

				}		

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

					$query = $this->db->query("SELECT a.*,date_format(a.createdDate,'%Y-%m-%d %H:%i:%s') as treeCreatedDate, date_format(editedDate,'%Y-%m-%d %H:%i:%s') as treeEditedDate, date_format(b.starttime,'%m-%d-%Y %h:%i %p') as starttime,date_format(b.endtime,'%Y-%m-%d %H:%i:%s') as endtime, c.contents FROM teeme_tree a , teeme_node b, teeme_leaf c, teeme_users d where b.treeIds=a.id and c.id = b.leafId AND a.userId = d.userId AND a.nodes='0' and a.name like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);

				}

				else

				{

					$query = $this->db->query("SELECT a.*,date_format(a.createdDate,'%Y-%m-%d %H:%i:%s') as treeCreatedDate, date_format(editedDate,'%Y-%m-%d %H:%i:%s') as treeEditedDate, date_format(b.starttime,'%m-%d-%Y %h:%i %p') as starttime,date_format(b.endtime,'%Y-%m-%d %H:%i:%s') as endtime, c.contents FROM teeme_tree a , teeme_node b, teeme_leaf c, teeme_users d where b.treeIds=a.id and c.id = b.leafId AND a.userId = d.userId AND a.nodes='0' and a.name like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.userId='".$userId."' and a.type=".$type.$orderBy);

				}

				if($query->num_rows() > 0)

				{

					foreach ($query->result() as $row)

					{	

						$treeId		= $row->id;							

						$arrTree[$treeId]['name'] 			= $row->contents;	

						$arrTree[$treeId]['type'] 			= $row->type;	

						$arrTree[$treeId]['userId'] 		= $row->userId;

						$arrTree[$treeId]['createdDate'] 	= $row->treeCreatedDate;

						$arrTree[$treeId]['editedDate'] 	= $row->treeEditedDate;

						$arrTree[$treeId]['starttime'] 		= $row->starttime;

						$arrTree[$treeId]['endtime'] 		= $row->endtime;

						$arrTree[$treeId]['nodes'] 			= $row->nodes;	

						$arrTree[$treeId]['viewCalendar'] 	= $row->viewCalendar;						

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

				}

				else

				{

					$orderBy = ' ORDER BY a.name';

				}		

				if($sortOrder == 2)

				{

					$orderBy .= ' DESC';

				}

				else

				{

					$orderBy .= ' ASC';

				}



				if($workSpaceId>0)

				{								

					$query = $this->db->query("SELECT a.*,date_format(a.createdDate,'%Y-%m-%d %H:%i:%s') as treeCreatedDate, date_format(editedDate,'%Y-%m-%d %H:%i:%s') as treeEditedDate FROM teeme_tree a, teeme_users b  where a.userId = b.userId AND a.nodes='0' and a.name not like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);

				}

				else

				{

					$query = $this->db->query("SELECT a.*,date_format(a.createdDate,'%Y-%m-%d %H:%i:%s') as treeCreatedDate, date_format(editedDate,'%Y-%m-%d %H:%i:%s') as treeEditedDate FROM teeme_tree a, teeme_users b where a.userId = b.userId AND a.nodes='0' and a.name not like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.userId='".$userId."' and a.type=".$type.$orderBy);

				}

				if($query->num_rows() > 0)

				{

					foreach ($query->result() as $row)

					{	

						$treeId		= $row->id;								

						$arrTree[$treeId]['name'] 			= $row->name;	

						$arrTree[$treeId]['type'] 			= $row->type;	

						$arrTree[$treeId]['userId'] 		= $row->userId;

						$arrTree[$treeId]['createdDate'] 	= $row->treeCreatedDate;

						$arrTree[$treeId]['editedDate'] 	= $row->treeEditedDate;

						$arrTree[$treeId]['nodes'] 			= $row->nodes;						

						

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

	* This method is used to get the activity contributors 	

	*/

	function getActivityContributors($nodeId)

	{		

		$userData 	= array();		

		$i = 0;

		$query 		= $this->db->query('SELECT b.tagName, a.userId FROM teeme_notes_users a, teeme_users b WHERE a.userId = b.userId AND a.notesId = '.$nodeId.' AND a.status = 2 ORDER BY b.tagName');

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $row)

			{						

				$userData[$i]['userId'] 		= $row->userId;	

				$userData[$i]['userTagName'] 	= $row->tagName;	

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

		$query 		= $this->db->query('SELECT date_format(startTime, \'%m-%d-%Y %h:%i %p\') as listStartTime FROM teeme_node WHERE id IN('.$nodes.') AND startTime != \'0000-00-00 00:00:00\' ORDER BY startTime ASC LIMIT 0,1');

		if($query->num_rows() > 0)

		{			

			$tmpData 	= $query->row();

			$arrTime['listStartTime'] = $tmpData->listStartTime;

		}

		else

		{

			$arrTime['listStartTime'] = '';

		}	

		$query 		= $this->db->query('SELECT date_format(endTime, \'%m-%d-%Y %h:%i %p\') as listEndTime FROM teeme_node WHERE id IN('.$nodes.') AND endTime != \'0000-00-00 00:00:00\' ORDER BY endTime DESC LIMIT 0,1');

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

	

 }

?>