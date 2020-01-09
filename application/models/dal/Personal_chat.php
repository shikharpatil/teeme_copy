<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: personal_chat.php 

	* Description 		  	: to handel personal_chat

 	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 19-12-2008				Vinaykant						personal_chat

	**********************************************************************************************************/

/*ALTER TABLE `teeme_chat_info` ADD `chat_member` VARCHAR( 200 ) NULL ;*/

/**

* A PHP class to access teeme work place, work space and users database with convenient methods

* with various operation Add, update, delete & retrieve teeme work place, work space and user details

* @author   Ideavate Solutions (www.ideavate.com)

*/

class personal_chat extends CI_Model

{	



	/**

	* This is the constructor of user DB Manager that call the contstructor of the Parent Class.

	*/

	public function __construct()

	{   

		//Parent class constructor.

		parent::__construct();

	}	

	/**

	* This function is used to retrieve the instance of personal_chat. This method will ensure that there is only one instance of the personal_chat in the single session. This is declared a static method because we would call this without being able to instantiate the class.

	*/

   

    static public function getInstance ()

	{

		if ($objpersonal_chat == NULL)

		{

			$objpersonal_chat = new personal_chat();

		}

		//Return the instance of personal_chat class

		return $objpersonal_chat;

	}

	// this method for inserting new personal_chat

	

	public function insertChatTime($starttime,$endtime,$treeId, $chat_member){

		$query = $this->db->query("insert into teeme_chat_info  (treeid, starttime, endtime, chat_member) values (".$treeId.",'".$starttime."','".$endtime."', '".$chat_member."')");

	}

	

	public function insertChat($starttime, $endtime, $chat_member, $title, $pnode, $workSpaceId, $workSpaceType, $userId){

		

		$query = $this->db->query("insert into teeme_tree  (name,type,workspaces,workSpaceType,userId,createdDate,nodes) values ('".$title."',7,'".$workSpaceId."','".$workSpaceType."',".$userId.",'".date("Y-m-d h:i:s")."','".$pnode."')");

		$treeId=$this->db->insert_id();

		$this->insertChatTime($starttime,$endtime,$treeId, $chat_member);

				

		return $treeId;	

	}

	public function personal_chatByMe($userId){

		$treeData	= array();

		$query = $this->db->query("SELECT a.id, a.nodes as pId, a.name as name,  DATE_FORMAT(a.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate,  DATE_FORMAT(b.starttime, '%Y-%m-%d %H:%i:%s') as starttime,  DATE_FORMAT(b.endtime, '%Y-%m-%d %H:%i:%s') as endtime, b.chat_member as chat_member FROM teeme_tree a,teeme_chat_info b  WHERE b.treeid=a.id and a.type=7 and a.userId='".$userId."'");

		$i=0;

		foreach ($query->result() as $row)

		{

			$treeData[$i]['treeId'] = $row->id;	

			$treeData[$i]['name'] = $row->name;

			$treeData[$i]['chat_member'] = $row->chat_member;	

			$treeData[$i]['createdDate'] = $row->createdDate;	

			$treeData[$i]['starttime'] = $row->starttime;

			$treeData[$i]['endtime'] = $row->endtime;	

			$treeData[$i]['pId'] = $row->pId;	

			$i++;

		}

		//print_r($treeData);

		return $treeData;

	}

	public function personal_chatBytreeId($treeId){

		$treeData	= array();

		$query = $this->db->query("SELECT a.id, a.nodes as pId, a.name as name, a.userId, DATE_FORMAT(a.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate,  DATE_FORMAT(b.starttime, '%Y-%m-%d %H:%i:%s') as starttime,  DATE_FORMAT(b.endtime, '%Y-%m-%d %H:%i:%s') as endtime, b.chat_member as chat_member FROM teeme_tree a,teeme_chat_info b  WHERE b.treeid=a.id and a.type=7 and a.id='".$treeId."'");

		

		foreach ($query->result() as $row)

		{

			$treeData['treeId'] 	= $row->id;	

			$treeData['name'] 		= $row->name;

			$treeData['chat_member'] = $row->chat_member;	

			$treeData['createdDate'] = $row->createdDate;	

			$treeData['starttime'] = $row->starttime;

			$treeData['endtime'] = $row->endtime;	

			$treeData['userId'] = $row->userId;	

			$treeData['pId'] = $row->pId;	

			

		}

		//print_r($treeData);

		return $treeData;

	}

	public function personal_chatForMe($userId){

		$treeData	= array();

		$query = $this->db->query("SELECT a.id, a.nodes as pId, a.name as name,  DATE_FORMAT(a.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate,  DATE_FORMAT(b.starttime, '%Y-%m-%d %H:%i:%s') as starttime,  DATE_FORMAT(b.endtime, '%Y-%m-%d %H:%i:%s') as endtime, a.userId as userId FROM teeme_tree a,teeme_chat_info b  WHERE a.type=7 and a.id=b.treeid and b.chat_member='".$userId."'");

		$i=0;

		foreach ($query->result() as $row)

		{

			$treeData[$i]['treeId'] = $row->id;	

			$treeData[$i]['name'] = $row->name;

			$treeData[$i]['userId'] = $row->userId;	

			$treeData[$i]['createdDate'] = $row->createdDate;	

			$treeData[$i]['starttime'] = $row->starttime;

			$treeData[$i]['endtime'] = $row->endtime;	

			$treeData[$i]['pId'] = $row->pId;	

			$i++;

		}

		//print_r($treeData);

		return $treeData;

	}

	public function getUserDetailsByUserId($userId)

	{

		$userData = array();

		//echo 'SELECT * FROM teeme_users WHERE userId='.$userId;

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

	public function insertChatNode($treeId,$content,$userId,$createdDate,$predecessor=0,$successors=0,$tag='',$authors='',$status=1,$type=1){

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds) values ('0','0',".$treeId.")");

		$nodeId=$this->db->insert_id();	

			

		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,contents,nodeId) values (".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".addslashes ($content)."',".$nodeId.")");

		$leafId=$this->db->insert_id();	

		

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

			

		return $nodeId;

	}

	public function insertChatReplay($pnodeId,$content,$userId,$createdDate,$treeId,$tag='',$authors='',$status=1,$type=1)

	{

		

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds) values ('".$pnodeId."',0,".$treeId.")");

		$nodeId=$this->db->insert_id();

		

		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,contents,nodeId) values (".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".addslashes ($content)."',".$nodeId.")");

		$leafId=$this->db->insert_id();

		

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		

		

		$query = $this->db->query("select * from teeme_node  where id=".$pnodeId);

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

		$query = $this->db->query("update teeme_node set successors='".$successors."' where id=".$pnodeId);		

		

		return $nodeId;			

	}

	public function getAllRepalyDetails($treeId){

		$arrTree	= array();

		if($treeId != NULL)

		{

			//echo 'SELECT a.id as nodeId, a.tag as tag, b.id as leafId, b.status as status, b.userId as userId, b.createdDate, b.contents as contents FROM teeme_node a, teeme_leaf b where b.id=a.leafId and a.treeIds= '.$treeId;

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

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'chat'.$treeId;	

		$memCacheValue = $memc->get($memCacheId);	

		$memCacheValue=0;

		//echo "SELECT a.id, a.successors, a.predecessor, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId;

		if(!$memCacheValue)

		{							

			$tree = array();		

			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId);

			foreach($query->result() as $chatData)

			{

				$tree[] = $chatData;

			}			

			$memc->set($memCacheId, $tree);			

		}		

		$value = $memc->get($memCacheId);	

		//print_r( $value );	

		if ($value)

		{	

			$i=0;			

			foreach ($value as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor '] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$i++;

 			}

		}	

	//	echo "SELECT a.id, a.successors,b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%m-%d-%Y %h:%i %p') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='')  and a.treeIds=".$treeId;

		/*$query = $this->db->query( "SELECT a.id, a.successors, a.predecessor, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%m-%d-%Y %h:%i %p') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId);		

		if($query->num_rows() > 0)

		{

			$i=0;

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData[$i]['nodeId'] = $row->id;	

				$treeData[$i]['successors']  = $row->successors;	

				$treeData[$i]['predecessor '] = $row->predecessor;	

				$treeData[$i]['authors'] = $row->authors;	

				$treeData[$i]['userId']  = $row->userId;	

				$treeData[$i]['contents'] = $row->contents;	

				$treeData[$i]['DiscussionCreatedDate']  = $row->DiscussionCreatedDate;	

				$i++;

 			}

		}*/					

		return $treeData;	

	

	}

	public function gettimmer($treeId){

	

		$this->load->model('dal/time_manager');

		$curTime = time_manager::getGMTTime();

		//echo "SELECT * from teeme_chat_info WHERE  starttime <  '".$curTime."' AND  endtime >'".$curTime."' and treeid =".$treeId;

		$query = $this->db->query("SELECT * from teeme_chat_info WHERE  starttime <  '".$curTime."' AND  endtime >'".$curTime."' and treeid =".$treeId);

		if($query->num_rows() > 0)

		{

			return true;

		}else{

			return false;

		}

	}

	

	public function getPerentInfo($nodeId){

	

	$treeData	= array();

	

		$query = $this->db->query( "SELECT a.id as nodeId, a.treeIds, a.predecessor as predecessor, a.successors as successors, b.id as leafId, b.status as status, b.userId as userId, DATE_FORMAT( b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.contents as contents FROM teeme_node a, teeme_leaf b where b.nodeId=a.id and a.id= ".$nodeId);		

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

}?>