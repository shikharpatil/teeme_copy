<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/**

* A PHP class to access User Database with convenient methods

* with various operation Add, update, delete & retrieve Discussion tree, node, leaf details

* @author   Ideavate Solutions (www.ideavate.com)

*/

// file that have the code for DBmanager class; 

//require('DBManager.php'); 

class discussion_db_manager extends CI_Model

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

			$objdiscussion_db_manager = new discussion_db_manager();

		}

		//Return the instance of discussion_db_manager class

		return $objdiscussion_db_manager;

	}

	

	// to get treeId by leaf

	public function gettreeByLeaf($leafId){

	

		$treeData	= array();

		

			$query = $this->db->query( "SELECT  *,  DATE_FORMAT( createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_tree WHERE  type=2 and nodes=".$leafId." AND embedded=0");		

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

	

	

	/* This function is used to fetch the latest version of the tree using tree id */

	

	public function getTreeLatestVersionByTreeId ($treeId)

	{

		$query = $this->db->query("SELECT latestVersion FROM teeme_tree WHERE id='".$treeId."'");	

									

		foreach($query->result() as $row)

		{

			$latest = $row->latestVersion;

		}		

		return $latest;

	

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

			$query = $this->db->query('SELECT type,name,workspaces,workSpaceType FROM teeme_tree WHERE id='.$treeId.' AND embedded=0');		

		

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

	

	public function getPerentInfo($nodeId){

	

	$treeData	= array();

	

		$query = $this->db->query("SELECT a.id as nodeId, a.treeIds, a.predecessor as predecessor, a.successors as successors, b.id as leafId, b.status as status, b.userId as userId, DATE_FORMAT( b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.contents as contents FROM teeme_node a, teeme_leaf b where b.nodeId=a.id and a.id= ".$nodeId);		

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

					$treeData['contents'] = $row->contents;	

					$treeData['treeIds'] = $row->treeIds;	

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



public function getDiscussionTreeByLeaf($pId){

	

	$treeData	= array();

	

		$query = $this->db->query( "SELECT *, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_tree WHERE type=2 and nodes='".$pId."' AND embedded=0");		

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

	

		$query = $this->db->query( "SELECT *, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_leaf WHERE nodeId=".$pId);		

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



public function getDiscussionPerent1($pId){

	

	$treeData	= array();

	

		$query = $this->db->query( "SELECT *, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_tree WHERE id=".$pId);		

		if($query->num_rows() > 0)

		{

			 $row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] = $row->id;	

				$treeData['userId']  = $row->userId;	

				$treeData['createdDate'] = $row->createdDate;	

				$treeData['name']  = $row->name;				

	

				

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

	

	

	public function getNodesByTree($treeId){

		

		$treeData	= array();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'dis'.$treeId;			

		$value = $memc->get($memCacheId);	

		

		if(!$value)

		{						

			$tree = array();		

			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.createdDate ASC");

			

			foreach($query->result() as $disData)

			{

				$tree[] = $disData;

			}			

			$memc->set($memCacheId, $tree);

			$value = $memc->get($memCacheId);					

		}			

		if(count($value) > 0)

		{

			$i=0;

			

			foreach ($value as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;

				$treeData[$i]['nodeOrder'] = $row->nodeOrder;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['leafId']  = $row->leafId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$i++;

 			}

		}



		

		return $treeData;	

	

	}

	

	

	public function getTalkNodesByTree($treeId){

		

		$treeData	= array();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'dis'.$treeId;			

		$value = $memc->get($memCacheId);	

		

		if(!$value)

		{						

			$tree = array();

			

					

				$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.createdDate ASC");

			

			

				

			

			

			foreach($query->result() as $disData)

			{

				$tree[] = $disData;

			}			

			$memc->set($memCacheId, $tree);

			$value = $memc->get($memCacheId);					

		}			

		if(count($value) > 0)

		{

			$i=0;

		

			foreach ($value as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;

				$treeData[$i]['nodeOrder'] = $row->nodeOrder;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['leafId']  = $row->leafId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$i++;

 			}

		}

			

		return $treeData;	

	

	}

	

	

	public function getTalkNodesByTreeRealTalk($treeId,$time=''){

		

		$treeData	= array();

		$tree= array();

			

			if($time=='')

			{ 		

			

				$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.createdDate ASC");

			}

			else

			{

			 

				$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and b.createdDate >= '".$time."' ORDER BY b.createdDate ASC") ;

				

			}	

			

			foreach($query->result() as $disData)

			{

				$tree[] = $disData;

			}			

						

			

		if(count($tree) > 0)

		{

			$i=0;

		

			foreach ($tree as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;

				$treeData[$i]['nodeOrder'] = $row->nodeOrder;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['leafId']  = $row->leafId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$i++;

 			}

		}

		

		

		return $treeData;	

	

	}

	

	/*<!--Added by Surbhi IV -->	*/

	public function getLastTalkByTreeId($treeId)

	{

		   $query = $this->db->query("SELECT * FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.createdDate DESC LIMIT 1");

		   if($query->num_rows()>0)

		   {

				foreach($query->result() as $disData)

				{

					$talk[] = $disData;

				}

				return $talk;

		   }		

		   return 0;	

	 }

	 /*<!--End of Added by Surbhi IV -->	*/

	

	public function getCountTalkNodesByTreeRealTalk($treeId){

				

				 $query = $this->db->query("SELECT COUNT(*) as total FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.createdDate ASC");

			   if($query->num_rows()>0)

			   {

			   		$query =$query->row();

					return $query->total;

			   }		

		      return 0;	

	}

	public function getNodesByTreeFromDB($treeId){

		

		$treeData	= array();

					

			$tree = array();		

			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY a.nodeOrder");

		

			

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

				$treeData[$i]['nodeOrder'] = $row->nodeOrder;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['leafId']  = $row->leafId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$i++;

 			}

		}

	

		return $treeData;	

	

	}



	public function getNodesByTree1($treeId){



		$treeData	= array();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'dis'.$treeId;	

		$memc->delete($memCacheId);			

		$value = $memc->get($memCacheId);

		

	

		if(!$value)

		{						

			$tree = array();	

		

			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE a.id=b.nodeId  and a.treeIds=".$treeId." ORDER BY a.nodeOrder");

			foreach($query->result() as $disData)

			{

				$tree[] = $disData;

			}			

			$memc->set($memCacheId, $tree);

			$value = $memc->get($memCacheId);					

		}			

		if(count($value) > 0)

		{

			$i=0;

	

			foreach ($value as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor'] = $row->predecessor;

				$treeData[$i]['nodeOrder'] = $row->nodeOrder;		

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['leafId']  = $row->leafId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$i++;

 			}

		}			

		

		return $treeData;	

	

	}

	 /**

	* This method will be used for fetch the Discussion name from the database.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @return The Discussion name

	*/

	public function getDiscussionDetailsByTreeId($treeId)

	{		

		$treeData	= array();

		$query = $this->db->query("SELECT *, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_tree WHERE id=".$treeId);



		if($query->num_rows() > 0)

		{

			 $row=$query->result();

			 

			foreach ($query->result() as $row)

			{

				$treeData['id'] 		= $row->id;	

				$treeData['parentTreeId'] = $row->parentTreeId;	

				$treeData['name']  		= $row->name;	

				$treeData['old_name']  	= $row->old_name;

				$treeData['type'] 		= $row->type;	

				$treeData['userId']  	= $row->userId;	

				$treeData['createdDate'] = $row->createdDate;	

				$treeData['editedDate']  = $row->editedDate;	

				$treeData['workspaces'] = $row->workspaces;	

				$treeData['nodes']  	= $row->nodes;	

				$treeData['treeVersion'] = $row->treeVersion;	

 			}

		}					

		return $treeData;			

	}



// this method for inserting new reply

	public function insertDiscussionReplay($pnodeId,$content,$userId,$createdDate,$treeId,$tag='',$authors='',$status=1,$type=1)

	{

		

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds) values ('".$pnodeId."',0,".$treeId.")");

		$nodeId=$this->db->insert_id();

		
		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,contents,nodeId) values (".$type.",'".$this->db->escape_str(addslashes($authors))."',".$status.",".$userId.",'".$createdDate."','".$this->db->escape_str(addslashes($content))."',".$nodeId.")");

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

		

		$query = $this->db->query("update teeme_leaf_tree set updates=updates+1 where tree_id=".$treeId);

		

		$this->insertDiscussionLeafView($leafId, $userId);

		return $nodeId;			

	}

	

	/**

	* This method will be used for fetch the leaf details from the database.

 	* @param $leafId This is the variable used to hold the leaf ID .

	* @return The leaf details

	*/

	public function updateNodeOrder($nodeOrder, $treeId, $increment, $option = 1)

	{		

		if($option == 1)

		{

			$bResult  = $this->db->query('UPDATE teeme_node SET nodeOrder=nodeOrder+'.$increment.' WHERE treeIds='.$treeId.' AND nodeOrder>'.$nodeOrder);

		}

		else

		{

			$bResult  = $this->db->query('UPDATE teeme_node SET nodeOrder=nodeOrder+'.$increment.' WHERE treeIds='.$treeId.' AND nodeOrder>='.$nodeOrder);

		}		

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}

	

	public function insertDiscussionTitle($title,$treeId)

		{

			//Manoj: replace mysql_escape_str function

			$query = $this->db->query("update teeme_tree set name='".$this->db->escape_str(addslashes($title))."' where id=".$treeId);

				

		}

		

	public function insertDiscussionNode($treeId,$content,$userId,$createdDate,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1,$nodeOrder=0){

		

		if ($nodeOrder==0)

		{

			$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds) values ('".$predecessor."','".$successors."',".$treeId.")");

		}

		else

		{

			$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,nodeOrder) values ('".$predecessor."','".$successors."',".$treeId.",".$nodeOrder.")");

		}

		

		$nodeId=$this->db->insert_id();

	

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,contents,nodeId) values 

		(".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.")");

		$leafId=$this->db->insert_id();	

		

	

	

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		

		$query = $this->db->query("update teeme_leaf_tree set updates=updates+1 where tree_id=".$treeId);

		

		$this->insertDiscussionLeafView($leafId, $userId);

	

		return $nodeId;

	}

	// this method for inserting new reply

	public function insertNewDiscussion($title,$pnode,$workSpaceId,$workSpaceType,$userId,$createdDate,$linkType=2,$embedded=0,$parentTreeId=0)

	{

		if ($parentTreeId==0)

		{
			//Manoj: replace mysql_escape_str function
			$query = $this->db->query("insert into teeme_tree (name,type,workspaces,workSpaceType,userId,createdDate,editedDate,nodes, nodeType,embedded) 

			values ('".$this->db->escape_str(strip_tags($title))."',2,'".$workSpaceId."','".$workSpaceType."',".$userId.",'".$createdDate."','".$createdDate."','".$pnode."','".$linkType."','".$embedded."')");

		}

		else

		{

			if (strlen($title)>1024)

			{

				$title = substr(strip_tags($title,'<b><p><a><em><span><img>'),0,2048); 

				$title = substr($title,0,1024) .".....";

			}
			//Manoj: replace mysql_escape_str function
			$query = $this->db->query("insert into teeme_tree (parentTreeId, name,type,workspaces,workSpaceType,userId,createdDate,editedDate,nodes, nodeType,embedded) 

			values ('".$parentTreeId."','".$this->db->escape_str(addslashes($title))."',2,'".$workSpaceId."','".$workSpaceType."',".$userId.",'".$createdDate."','".$createdDate."','".$pnode."','".$linkType."','".$embedded."')");		

		}

		$treeId=$this->db->insert_id();

				

		return $treeId;			

	}

	// Linking leaf and tree ids

	public function insertLeafTree ($leafId,$treeId,$type=2)

	{

		if ($type==2)

		{

			$query = $this->db->query("insert into teeme_leaf_tree (leaf_id,tree_id) values ('".$leafId."','".$treeId."')");

		}

		else

		{

			$query = $this->db->query("insert into teeme_leaf_tree (leaf_id,tree_id,type) values ('".$leafId."','".$treeId."','".$type."')");

		}

		

		return $this->db->insert_id();

	}

	// Get Leaf Tree id by Leaf Id

	public function getLeafTreeIdByLeafId ($leafId)

	{

		$leafTreeId	= '';						

		$query = $this->db->query("SELECT tree_id FROM teeme_leaf_tree WHERE leaf_id = '".$leafId."'");

		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{	

				$leafTreeId = $row->tree_id;					

			}				

		}		

		return $leafTreeId;	

	}

	

	public function getLeafIdByLeafTreeId ($treeId)

	{

		$leafId	= '';						

		$query = $this->db->query("SELECT leaf_id FROM teeme_leaf_tree WHERE tree_id = '".$treeId."'");

		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{	

				$leafId = $row->leaf_id;					

			}				

		}	

		return $leafId;	

	}





	public function updateTalkTreeNameByLeafTreeId ($leafId,$treeId,$isSeedTalk=0,$treeType=0)

	{

		$contents = '';

		if ($isSeedTalk)

		{

			$query = $this->db->query("SELECT name FROM teeme_tree WHERE id='".$leafId."'");

				if($query->num_rows() > 0)

				{

					foreach ($query->result() as $row)

					{	

						$contents = $row->name;					

					}					

				}

		}

		else

		{

			if ($treeType==1) // if document

			{

				$query = $this->db->query("SELECT contents FROM teeme_leaf WHERE id='".$leafId."'");

			}

			else

			{
				
				$query = $this->db->query("SELECT contents FROM teeme_leaf WHERE nodeId='".$leafId."'");

			}

				if($query->num_rows() > 0)

				{

					foreach ($query->result() as $row)

					{	

						$contents = $row->contents;					

					}					

				}

		}

		

		if (strlen($contents)>255)

		{
			
			$contents = substr(strip_tags(stripslashes($contents)),0,50).".....";

		}

		//echo "<li>content2= " .$contents; exit;
		
		if ($contents!='')
		{
			//Manoj: replace mysql_escape_str function
			$qry = "UPDATE teeme_tree SET name='".$this->db->escape_str(addslashes($contents))."' WHERE id='".$treeId."'";
			$query = $this->db->query($qry);
			//echo "<li>qry= " .$qry; exit;
		}
	}	

	public function isTalkActive ($leafTreeId)

	{

				

		$query = $this->db->query("SELECT count(*) AS total FROM teeme_leaf_tree WHERE tree_id = '".$leafTreeId."' AND updates > 0");



		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{	

				if ($row->total > 0)

					return 1;				

			}		

		}		

		return 0;	

	}	

	// this method for get discussion tree for particular doc node

	public function getTreesByNode($nodeId){

		$treeData	= array();

	

		$query = $this->db->query("SELECT id,name,userId,workspaces,nodes, DATE_FORMAT(createdDate, '%Y-%m-%d %H:%i:%s') as createdDate FROM teeme_tree WHERE type=2 and nodes='".$nodeId."' AND embedded=0");

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
	
		if($userId!='')
		{	

		$query = $this->db->query('SELECT firstName, lastName, userName, tagName, nickName FROM teeme_users WHERE userId='.$userId);

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
		}
		return $userData;
					

	}

	 /**

	 

	* This method will be used for fetch the tree Records from the database.

 	* @param $userId This is the variable used to hold the user ID .

	* @return The tree datas as an array

	*/

	public function getTreesByworkSpaceId($workSpaceId,$workSpaceType,$userId, $type=2, $sortBy=3, $sortOrder=1)

	{

		$arrTree	= array();	

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

			$orderBy .= ' DESC';

		}

		else

		{

			$orderBy .= ' ASC';

		}

		if($workSpaceId != NULL)

		{

			// Get information of particular Discussion

			if($workSpaceId){

			$query = $this->db->query("SELECT a.*,date_format(a.createdDate,'%Y-%m-%d %H:%i:%s') as treeCreatedDate, date_format(a.editedDate,'%Y-%m-%d %H:%i:%s') as treeEditedDate FROM teeme_tree a, teeme_users b where a.userId = b.userId AND a.embedded=0 AND a.nodes='0' and a.name not like('untile%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);

			}else{

			$query = $this->db->query("SELECT a.*,date_format(a.createdDate,'%Y-%m-%d %H:%i:%s') as treeCreatedDate, date_format(a.editedDate,'%Y-%m-%d %H:%i:%s') as treeEditedDate FROM teeme_tree a, teeme_users b where a.userId = b.userId AND a.embedded=0 AND a.nodes='0' and a.name not like('untile%') and a.name <>' ' and a.workspaces='".$workSpaceId."'  and (a.userId='".$userId."' OR a.isShared=1) and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);

			}

			if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$treeId		= $row->id;							

					$arrTree[$treeId]['name'] = $row->name;	

					$arrTree[$treeId]['old_name'] = $row->old_name;

					$arrTree[$treeId]['type'] = $row->type;	

					$arrTree[$treeId]['userId'] = $row->userId;

					$arrTree[$treeId]['createdDate'] = $row->treeCreatedDate;

					$arrTree[$treeId]['editedDate'] = $row->treeEditedDate;

					$arrTree[$treeId]['workSpaces'] = $row->workSpaces;

					$arrTree[$treeId]['nodes'] = $row->nodes;

					$arrTree[$treeId]['isShared'] = $row->isShared;	

				}				

			}

		}

 			$query = $this->db->query("delete FROM teeme_tree where nodes='0' and (name like('untile%') or name =' ') and type=".$type);

			return $arrTree;				

	}



	/* This method will be used for update the discussion memcache.

 	* @param $treeId This is the variable used to hold the discussion tree ID .	

	*/

	public function updateDiscussionMemCache( $treeId )

	{

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'dis'.$treeId;			

		$tree = array();		

		$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId ." ORDER BY b.createdDate ASC");

		foreach($query->result() as $disData)

		{

			$tree[] = $disData;

		}				

		if($memc->get($memCacheId))

		{	

			$memc->replace($memCacheId, $tree);	

		}

		else

		{	

			$memc->add($memCacheId, $tree);	

		}					

	}

	

	public function updateTalkMemCache( $treeId )

	{

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'dis'.$treeId;			

		$tree = array();		

		$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId ." ORDER BY b.createdDate ASC");

		foreach($query->result() as $disData)

		{

			$tree[] = $disData;

		}				

		if($memc->get($memCacheId))

		{	

			$memc->replace($memCacheId, $tree);	

		}

		else

		{	

			$memc->add($memCacheId, $tree);	

		}					

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

	public function getSuccessors ($nodeId)

	{

	

		$query = $this->db->query('SELECT successors FROM teeme_node WHERE id='.$nodeId);

		

	

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{		

				$succArray=explode(',',$row->successors);	

				$counter=0;

				while($counter < count($succArray))

				{

					if ($succArray[$counter] == 0)

					{

						return $_SESSION['succ'];

					}

					else

					{

				

						if ($_SESSION['succ']=='')

							$_SESSION['succ'] = $succArray[$counter];

						else

							$_SESSION['succ'] .= ',' .$succArray[$counter];



						$treeIds = $this->getSuccessors($succArray[$counter]);				

					}

					

					$counter++;

				}						

				

			}				

		}

					

		return $_SESSION['succ'];		

	}

	//Added by Dashrath : code start
	function getDiscussTreeNodesByTreeId($treeId)
	{
		$arrNodes = array();

		/*Changed by Dashrath- add chatSession column in query*/
		$query = 'SELECT a.id as nodeId,a.tag, a.treeIds,b.id as leafId, b.type, b.authors,b.userId, b.contents,b.lockedStatus,b.createdDate, b.leafStatus, a.nodeOrder, b.userLocked, a.predecessor, a.successors, a.chatSession FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = '.$treeId.' ORDER BY nodeOrder';	
		
		$query = $this->db->query($query);									
		
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
				
				$arrNodes[$i]['leafStatus'] 	= $nodeData->leafStatus;
				
				$arrNodes[$i]['nodeOrder'] 	= $nodeData->nodeOrder;
				
				$arrNodes[$i]['userLocked'] 	= $nodeData->userLocked;

				$arrNodes[$i]['predecessor'] 	= $nodeData->predecessor;

				$arrNodes[$i]['successors'] 	= $nodeData->successors;

				//Added by Dashrath
				$arrNodes[$i]['chatSession'] 	= $nodeData->chatSession;

				$i++;	
			}
		}	

		return $arrNodes;		

	}
	// Dashrath : code end

	//Added by Dashrath : code start
	function setNodeIdInSessionForPredecessor($successors, $nodeId)
	{
		$sArray=array();
		$sArray=explode(',',$successors);

		foreach ($sArray as $key => $value) 
		{
			$setNodeId = 'successors_'.$value;
	        $_SESSION[$setNodeId] = $nodeId;
		}
	}
	// Dashrath : code end

	//Added by Dashrath : code start
	function updateSuccessorDeatil($nodeIdForSession, $nodeId)
	{
		$pNodeIdKey = 'successors_'.$nodeIdForSession;
		$pNodeId = $_SESSION[$pNodeIdKey];

		$query = $this->db->query("select * from teeme_node  where id=".$pNodeId);

		foreach ($query->result() as $row)
		{
			$successors=trim($row->successors);
		}

		if($successors)
		{
			$sArray=array();

			$sArray=explode(',',$successors);

			$sArray[count($sArray)]=$nodeId;

			$successors=implode(',',$sArray);

		}
		else
		{
			$successors=$nodeId;
		}

		$query = $this->db->query("update teeme_node set successors='".$successors."' where id=".$pNodeId);
	}
	// Dashrath : code end
	
	/*Added by Dashrath : Update chatSession value in node table*/
	function updateNodeDetails($nodeId, $chatSession)
	{
		$query = $this->db->query("update teeme_node set chatSession=".$chatSession." where id=".$nodeId);

		return true;
	}
	/*Dashrath- code end*/
 }

?>