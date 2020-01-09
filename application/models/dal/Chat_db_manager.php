<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/**

* A PHP class to access User Database with convenient methods

* with various operation Add, update, delete & retrieve Discussion tree, node, leaf details

* @author   Ideavate Solutions (www.ideavate.com)

*/



class Chat_db_manager extends CI_Model

{ 

	/**

	* $objdiscussion_db_manager This variable is used to make this class a singleton class.

	*/

	

	private static $objdiscussion_db_manager = null;

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

		$curTime = time_manager::getGMTTime();

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


		$query = $this->db->query( "SELECT a.id as nodeId, a.treeIds, a.predecessor as predecessor, a.successors as successors, b.id as leafId, b.status as status, b.userId as userId, DATE_FORMAT( b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,DATE_FORMAT( b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate ,b.contents as contents FROM teeme_node a, teeme_leaf b where b.nodeId=a.id and a.id= ".$nodeId);		

	
		/*Changed by Dashrath- add b.leafStatus column in query for delete feature*/
		$query = $this->db->query( "SELECT a.id as nodeId, a.treeIds, a.predecessor as predecessor, a.successors as successors, b.id as leafId, b.status as status, b.userId as userId, DATE_FORMAT( b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,DATE_FORMAT( b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate ,b.contents as contents,b.leafStatus FROM teeme_node a, teeme_leaf b where b.nodeId=a.id and a.id= ".$nodeId);		


		if($query->num_rows() > 0)

		{

				foreach ($query->result() as $row)

				{

					$treeData['nodeId'] = $row->nodeId;	

					$treeData['predecessor'] = $row->predecessor;	

					$treeData['successors'] = $row->successors;	

					$treeData['leafId'] = $row->leafId;				

					$treeData['userId'] = $row->userId;	

					$treeData['DiscussionCreatedDate'] = $row->DiscussionCreatedDate;	

					$treeData['editedDate'] = $row->editedDate;	

					$treeData['contents'] = $row->contents;	

					$treeData['treeIds'] = $row->treeIds;

					/*Changed by Dashrath- add leafStatus column in array for delete feature*/
					$treeData['leafStatus'] = $row->leafStatus;	

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

	

	public function getNodesByTree($treeId)

	{

	

		$treeData	= array();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'discuss'.$treeId;	

		$memc->delete($memCacheId);

		$memCacheValue = $memc->get($memCacheId);	

		if(!$memCacheValue)

		{	

			$tree = array();		
			/*Changed by Dashrath- add b.leafStatus and a.leafId column in query for delete feature*/
			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.chatSession, b.authors, b.userId, b.contents, b.leafStatus, a.leafId, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.createdDate ASC");

			foreach($query->result() as $chatData)

			{

				$tree[] = $chatData;

			}	

			

			

			$memc->set($memCacheId,$tree,MEMCACHE_COMPRESSED);	

			

					

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

				$treeData[$i]['chatSession'] = $row->chatSession;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;

				/*Added by Dashrath- add leafStatus and leafId column in array for delete feature*/
				$treeData[$i]['leafStatus']  = $row->leafStatus;

				$treeData[$i]['leafId']  = $row->leafId;	

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

				$treeData[$i]['chatSession'] = $row->chatSession;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;

				/*Added by Dashrath- add leafStatus and leafId column in array for delete feature*/
				$treeData[$i]['leafStatus']  = $row->leafStatus;

				$treeData[$i]['leafId']  = $row->leafId;	

				$i++;

 			}

		

		

		}	

		

		return $treeData;		

	}





	public function getNodesByTreeFromDB($treeId)

	{

		$treeData	= array();

						

			$tree = array();	

				
			/*Changed by Dashrath- add b.leafStatus and a.leafId column in query for delete feature*/
			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.chatSession, b.authors, b.userId, b.contents, b.leafStatus, a.leafId, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.createdDate ASC");

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

				$treeData[$i]['chatSession'] = $row->chatSession;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;

				/*Added by Dashrath- add leafStatus and leafId column in array for delete feature*/
				$treeData[$i]['leafStatus']  = $row->leafStatus;

				$treeData[$i]['leafId']  = $row->leafId;	

				$i++;

 			}

		}		

		return $treeData;		

	}

	//arun add new parameter $time

	//$time used for fetch result for  real time chat

	public function getNodesByTreeRealTime($treeId,$time='')

	{ 

		$treeData = array();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'chat'.$treeId;	

		$memc->delete($memCacheId);

		$memCacheValue = $memc->get($memCacheId);	

		if(!$memCacheValue)

		{							

			$tree = array();

			if($time=='')

			{	
				/*Changed by Dashrath- Add b.leafStatus column in query*/
				$query="SELECT a.id, a.successors, a.predecessor, a.chatSession, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and a.treeIds=".$treeId." ORDER BY b.createdDate ASC"; 

			}

			else

			{
				/*Changed by Dashrath- Add b.leafStatus column in query*/
				$query="SELECT a.id, a.successors, a.predecessor, a.chatSession, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and a.treeIds=".$treeId." and b.createdDate > '".$time."' ORDER BY b.createdDate ASC"; 

			

			}

			

			$query=$this->db->query($query);

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

				$treeData[$i]['chatSession'] = $row->chatSession;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				//Added by Dashrath- used in real time view check delete status
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

				$treeData[$i]['chatSession'] = $row->chatSession;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$i++;

 			}

		}	

		

		return $treeData;		

	}

	

	

	public function getNodesByTreechatTimeview($treeId,$time='')

	{ 

		$treeData = array();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'chat'.$treeId;	

		$memc->delete($memCacheId);

		$memCacheValue = $memc->get($memCacheId);	

		if(!$memCacheValue)

		{							

			$tree = array();

			if($time=='')

			{	

				$query=$this->db->query("SELECT a.id, a.successors, a.predecessor, a.chatSession, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and a.treeIds=".$treeId." ORDER BY b.createdDate DESC"); 

			}

			else

			{

				$query=$this->db->query("SELECT a.id, a.successors, a.predecessor, a.chatSession, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and a.treeIds=".$treeId." and b.createdDate > '".$time."' ORDER BY b.createdDate DESC"); 

			

			}

			

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

				$treeData[$i]['chatSession'] = $row->chatSession;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$i++;

 			}

		}	

		

		return $treeData;		

	}

	

	//whole function edited by naga on 06/11/2008

	public function getTopicByNodeId($treeId,$nodeId)

	{

	

	  

		$topic	= '';	

		$query = $this->db->query("SELECT a.contents FROM teeme_leaf a, teeme_node b WHERE b.leafId = a.id AND b.id = ".$nodeId." and b.treeIds=".$treeId);

		foreach($query->result() as $chatData)

		{

			$topic = $chatData->contents;

		}

		return $topic;		

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

	public function insertChatTime($starttime,$endtime,$treeId){

		$query = $this->db->query("insert into teeme_chat_info  (treeid,starttime,endtime) values (".$treeId.",'".$starttime."','".$endtime."')");

	}

	

	public function getDiscussionDetailsByTreeId($treeId)

	{

		$treeData	= array();

		$query = $this->db->query("SELECT *, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_tree WHERE id=".$treeId);		

		if($query->num_rows() > 0)

		{

			 $row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] = $row->id;	

				$treeData['name']  = $row->name;

				$treeData['old_name']  = $row->old_name;		

				$treeData['type'] = $row->type;	

				$treeData['userId']  = $row->userId;	

				$treeData['createdDate'] = $row->createdDate;	

				$treeData['editedDate']  = $row->editedDate;	

				$treeData['workspaces'] = $row->workspaces;	

				$treeData['nodes']  = $row->nodes;

				$treeData['status']  = $row->status;

				

 			}

		}					

		return $treeData;			

	}



	// this method for inserting new reply

	public function insertDiscussionReplay($pnodeId,$content,$userId,$createdDate,$treeId,$tag='',$authors='',$status=1,$type=1)

	{
	
		//Manoj: transaction begin here
		$this->db->trans_begin();

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds) values ('".$pnodeId."',0,".$treeId.")");

		$nodeId=$this->db->insert_id();

	

		//arun-change in query for add new feild in leaf table edited date.
		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate 	,contents,nodeId) values (".$type.",'".$this->db->escape_str($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.")");

		

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
		
		//Manoj: Checking transaction status here
		
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return $nodeId;
		}		

		//return $nodeId;

	}



	public function insertChatTitle($title,$treeId)

	{

		
		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("update teeme_tree set name='".$this->db->escape_str($title)."' where id=".$treeId);

			

	}

	public function insertDiscussionNode($treeId,$content,$userId,$createdDate,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1,$chatSession=0){

		

		if ($chatSession != 0)

			$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds,chatSession) values ('".$predecessor."','".$successors."',".$treeId.",".$chatSession.")");

		else

			$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds) values ('".$predecessor."','".$successors."',".$treeId.")");

			

		$nodeId=$this->db->insert_id();	

		

	

		//arun-changes query for adding new feiled edited date in teeme_leaf table

		

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId) values (".$type.",'".$this->db->escape_str($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.")");

		$leafId=$this->db->insert_id();	

	   

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		

		$this->insertDiscussionLeafView($leafId, $userId);

		return $nodeId;

	}

	public function updateChatStatus($treeId,$status)

	{	

		$query = $this->db->query("update teeme_tree set status='".$status."' where id=".$treeId);	

	}

	

	// this method for inserting new reply

	public function insertNewChat($title,$pnode,$workSpaceId,$workSpaceType,$userId,$createdDate, $linkType = 2,$embedded=0)

	{

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("insert into teeme_tree  (name,type,workspaces,workSpaceType,userId,createdDate,nodes,nodeType,embedded) values ('".$this->db->escape_str($title)."',3,'".$workSpaceId."','".$workSpaceType."',".$userId.",'".$createdDate."','".$pnode."','".$linkType."','".$embedded."')");

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

	* This method will be used for fetch the tree Records from the database.

 	* @param $userId This is the variable used to hold the user ID .

	* @return The tree datas as an array

	*/

	public function getTreesByworkSpaceId($workSpaceId,$workSpaceType, $userId, $type=3, $sortBy = 3, $sortOrder = 1)

	{

		$arrTree	= array();	

		if($sortBy == 1)

		{

			$orderBy = ' ORDER BY a.name';

		}

		else if($sortBy == 2)

		{

			$orderBy = ' ORDER BY c.tagName';

		}

/*		else if($sortBy == 4)

		{

			$orderBy = ' ORDER BY b.starttime';

		}

		else if($sortBy == 5)

		{

			$orderBy = ' ORDER BY b.endtime';

		}*/

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

			// Get information of particular Discussion

			if($workSpaceId){

				$query = $this->db->query("SELECT a.*,date_format(a.createdDate,'%Y-%m-%d %H:%i:%s') as treeCreatedDate FROM teeme_tree a, teeme_users c where a.userId = c.userId AND a.name not like('untile%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);

								

			}else{

				$query = $this->db->query("SELECT a.*,date_format(a.createdDate,'%Y-%m-%d %H:%i:%s') as treeCreatedDate FROM teeme_tree a, teeme_users c where a.userId = c.userId and a.name not like('untile%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and (a.userId='".$userId."' OR a.isShared=1) and a.type=".$type.$orderBy);

			}



			if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$treeId		= $row->id;							

					$arrTree[$treeId]['name'] 			= $row->name;

					$arrTree[$treeId]['status'] 		= $row->status;		

					$arrTree[$treeId]['old_name'] 		= $row->old_name;

					$arrTree[$treeId]['type'] 			= $row->type;	

					$arrTree[$treeId]['userId'] 		= $row->userId;

					$arrTree[$treeId]['createdDate'] 	= $row->treeCreatedDate;

					$arrTree[$treeId]['editedDate'] 	= $row->editedDate;

					$arrTree[$treeId]['workSpaces'] 	= $row->workspaces;

					$arrTree[$treeId]['workSpaceType'] 	= $row->workSpaceType;

					$arrTree[$treeId]['nodes'] 			= $row->nodes;

					$arrTree[$treeId]['isShared'] 		= $row->isShared;					

				}				

			}



 			$query = $this->db->query("delete FROM teeme_tree where nodes='0' and (name like('untile%') or name =' ') and type=".$type);

		return $arrTree;				

	}



	/* This method will be used for update the chat memcache.

 	 * @param $treeId This is the variable used to hold the chat tree ID.	

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

	

	

	function getLeafAuthorsByLeafIds($treeId)

	{

		$query = $this->db->query("SELECT distinct(b.userId) as authors,u.tagName FROM teeme_node a, teeme_leaf b,teeme_users u WHERE b.id=a.leafId and a.treeIds=".$treeId." and u.userId=b.userId ORDER BY a.nodeOrder");

		return $query->result_array();	

	}
	
	//Manoj: code for getting discussion topic by edited time
	
	public function getNodesByTreeRealTime2($treeId)

	{

	

		$treeData	= array();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'discuss'.$treeId;	

		$memc->delete($memCacheId);

		$memCacheValue = $memc->get($memCacheId);	

		if(!$memCacheValue)

		{	

			$tree = array();		

			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.chatSession, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.createdDate ASC");

			foreach($query->result() as $chatData)

			{

				$tree[] = $chatData;

			}	

			

			

			$memc->set($memCacheId,$tree,MEMCACHE_COMPRESSED);	

			

					

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

				$treeData[$i]['chatSession'] = $row->chatSession;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;	

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

				$treeData[$i]['chatSession'] = $row->chatSession;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;	

				$i++;

 			}

		

		

		}	

		

		return $treeData;		

	}
	//Manoj: code end
	
	//Manoj: Insert real time discuss comment
	
	public function insertDiscussCommentRealTime($pnodeId,$content,$userId,$createdDate,$treeId,$tag='',$authors='',$status=1,$type=1)

	{
	
		//Manoj: transaction begin here
		$this->db->trans_begin();

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds) values ('".$pnodeId."',0,".$treeId.")");

		$nodeId=$this->db->insert_id();

	

		//arun-change in query for add new feild in leaf table edited date.
		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate 	,contents,nodeId) values (".$type.",'".$this->db->escape_str($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.")");

		

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
				
		//Manoj: code to update edited date of discussion topic after comment 
		
		//$query = $this->db->query("update teeme_leaf set editedDate='".$createdDate."' where nodeId=".$pnodeId);
		
		//Manoj: code end		

		$this->insertDiscussionLeafView($leafId, $userId);
		
		//Manoj: Checking transaction status here
		
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return $nodeId;
		}		

		//return $nodeId;

	}
	
	//whole function edited by naga on 06/11/2008
	
	public function getTopicDetailsByNodeId($treeId,$nodeId)

	{

		$topic	= '';	

		$query = $this->db->query("SELECT a.id FROM teeme_leaf a, teeme_node b WHERE b.leafId = a.id AND b.id = ".$nodeId." and b.treeIds=".$treeId);

		foreach($query->result() as $chatData)

		{

			$topic = $chatData->id;

		}
		//Get topic details here
			$treeData	= array();
			
			$tree = array();		

			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.chatSession, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.id=".$nodeId." ORDER BY b.createdDate ASC");

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

				$treeData[$i]['chatSession'] = $row->chatSession;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$treeData[$i]['editedDate']  = $row->editedDate;	

				$i++;

 			}
		return $treeData;
		//return $topic;		

	}
	
	//Manoj: code end

 }

?>