<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: profile_manager.php 

	* Description 		  	: to handle contact list

 	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 02-12-2008				Vinaykant						profile_manager

	**********************************************************************************************************/



/**

* A PHP class to access teeme work place, work space and users database with convenient methods

* with various operation Add, update, delete & retrieve teeme work place, work space and user details

* @author   Ideavate Solutions (www.ideavate.com)

*/

class Profile_manager extends CI_Model

{	



	public $loopCount=0;

	public $loopTree =array();

	/**

	* This is the constructor of user DB Manager that call the contstructor of the Parent Class.

	*/

	public function __construct()

	{   

		//Parent class constructor.

		parent::__construct();

	}	

	/**

	* This function is used to retrieve the instance of profile_manager. This method will ensure that there is only one instance of the discussion_db_manager in the single session. This is declared a static method because we would call this without being able to instantiate the class.

	*/

   

    static public function getInstance ()

	{

		if ($objProfileManager == NULL)

		{

			$objProfileManager = new profile_manager();

		}

		//Return the instance of discussion_db_manager class

		return $objProfileManager;

	}

	// this method for inserting new contactlist

	public function insertNewContact($name,$workSpaceId,$workSpaceType,$userId,$createdDate, $contactinfo)

	{

		 

		

		$query = $this->db->query("insert into teeme_tree (name,type,workspaces,workSpaceType,userId,createdDate) values ('".$name."',5,'".$workSpaceId."','".$workSpaceType."',".$userId.",'".$createdDate."')");

		

		$treeId=$this->db->insert_id();

		

		$query = $this->db->query("insert into teeme_contact_info (treeId,firstname,lastname,middlename ,title ,designation ,company,email ,fax ,mobile ,landline ,address ,address2,city ,state ,country ,zipcode, comments, sharedStatus, workplaceId, other ) values ('".$treeId."','".$contactinfo['firstname']."','".$contactinfo['lastname']."','".$contactinfo['middlename']."','".$contactinfo['title']."','".$contactinfo['designation']."','".$contactinfo['company']."','".$contactinfo['email']."','".$contactinfo['fax']."','".$contactinfo['mobile']."','".$contactinfo['landline']."','".$contactinfo['address']."','".$contactinfo['address2']."','".$contactinfo['city']."','".$contactinfo['state']."','".$contactinfo['country']."','".$contactinfo['zipcode']."','".$contactinfo['comments']."','".$contactinfo['sharedStatus']."','".$_SESSION['workPlaceId']."','".$contactinfo['other']."')");

				

		return $treeId;			

	}

	

	// to update Contact

	public function updateContact($treeId, $contactinfo)

	{

		$predecessor=0;

 		$query = $this->db->query("UPDATE teeme_contact_info SET treeId ='".$treeId."', firstname ='".$contactinfo['firstname']."', lastname ='".$contactinfo['lastname']."', middlename= '".$contactinfo['middlename']."', title= '".$contactinfo['title']."', designation ='".$contactinfo['designation']."', company='".$contactinfo['company']."', email= '".$contactinfo['email']."', fax= '".$contactinfo['fax']."',mobile= '".$contactinfo['mobile']."',landline= '".$contactinfo['landline']."',address= '".$contactinfo['address']."',address2= '".$contactinfo['address2']."',city= '".$contactinfo['city']."',state= '".$contactinfo['state']."',country= '".$contactinfo['country']."',zipcode='".$contactinfo['zipcode']."',comments='".$contactinfo['comments']."',sharedStatus='".$contactinfo['sharedStatus']."',other='".$contactinfo['other']."' WHERE treeId = ".$treeId);

		

	}

	

	

	public function insertNote($treeId,$note,$userId,$nodeOrder,$workspaceId =0,$workspaceType=0)

	{

		if($workspaceId > 0)

		{	

			$query = $this->db->query("update teeme_node SET nodeOrder = nodeOrder+1 WHERE treeIds = '".$treeId."' AND workSpaceId = ".$workspaceId." AND workSpaceType = ".$workspaceType." AND nodeOrder >= ".$nodeOrder);		

		}

		else

		{		

			$query = $this->db->query("update teeme_node SET nodeOrder = nodeOrder+1 WHERE treeIds = '".$treeId."' AND userId = ".$userId." AND nodeOrder >= ".$nodeOrder);		

		}	

		$query 	= $this->db->query("insert into teeme_leaf (contents,createdDate, userId) values ('".$note."','".date("Y-m-d h:i:s")."','".$userId."')");		

		$leafId	= $this->db->insert_id();		

		$query 	= $this->db->query("insert into teeme_node (predecessor,successors,treeIds,leafId, nodeOrder,workSpaceId, workSpaceType, userId) values ('0','0','".$treeId."','".$leafId."','".$nodeOrder."','".$workspaceId."','".$workspaceType."','".$userId."')");

		$nodeId	= $this->db->insert_id();	

		

		$query = $this->db->query("update teeme_leaf set nodeId ='".$nodeId."' where id=".$leafId);	

		return $nodeId;			

	}



	public function insertNewNote($treeId,$note,$userId,$workspaceId =0, $workspaceType=0, $date = 0)

	{	

		

		if($date == 0)

		{

			$date = date("Y-m-d h:i:s");

		}

		 $query = $this->db->query("insert into teeme_leaf (`contents`,`createdDate`, `userId`, workSpaceId, workSpaceType) values ('".$note."','".$date."','".$userId."','".$workspaceId."','".$workspaceType."' )");

		

		 $leafId=$this->db->insert_id();

		 

		 $query = $this->db->query("insert into teeme_node (treeIds,`leafId`, predecessor, successors ) values ('".$treeId."','".$leafId."','".$predecessor."','".$successors."')");

		

		 $nodeId=$this->db->insert_id();

			$query = $this->db->query("update teeme_leaf set nodeId ='".$nodeId."' where id=".$leafId);

		if($predecessor){

			$query = $this->db->query("update teeme_node set successors ='".$nodeId."' where id=".$predecessor);

		}

		else if($predecessor == 0){

			$query = $this->db->query("update teeme_node set predecessor ='".$nodeId."' where id=".$successors);

		}

		 return $nodeId;

	}

	

	

	public function getContectList($workspaces,$workSpaceType,$userId){

		$treeData	= array();

		if($workspaces){

		//echo "SELECT * FROM teeme_tree WHERE workspaces='".$workspaces."' and  workSpaceType='".$workSpaceType."' and type=5";

		//$query = $this->db->query( "SELECT * FROM teeme_tree WHERE workspaces='".$workspaces."' and  workSpaceType='".$workSpaceType."' and type=5");	

		$query = $this->db->query( "SELECT a.*, b.sharedStatus, b.company FROM teeme_tree a, teeme_contact_info b WHERE a.id = b.treeId AND b.workplaceId = '".$_SESSION['workPlaceId']."' AND a.type=5 ORDER BY a.createdDate DESC");

		}else{

		//$query = $this->db->query( "SELECT * FROM teeme_tree WHERE workspaces='".$workspaces."' and userId='".$userId."' and  workSpaceType='".$workSpaceType."' and type=5");

		$query = $this->db->query( "SELECT a.*, b.sharedStatus, b.company FROM teeme_tree a, teeme_contact_info b WHERE a.id = b.treeId AND b.workplaceId = '".$_SESSION['workPlaceId']."' AND a.type=5 ORDER BY a.createdDate DESC");

		}

		$i=0;	

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			if($workspaces)

			{							

				foreach ($query->result() as $row)

				{				

					if($row->sharedStatus == 1 || ($row->sharedStatus == 2 && $workspaces == $row->workspaces && $workSpaceType == $row->workSpaceType))

					{

														

						$treeData[$i]=array();

						$treeData[$i]['id'] 		= $row->id;	

						$treeData[$i]['name']  		= $row->name;	

						$treeData[$i]['type'] 		= $row->type;	

						$treeData[$i]['userId']  	= $row->userId;	

						$treeData[$i]['createdDate']= $row->createdDate;	

						$treeData[$i]['editedDate'] = $row->editedDate;	

						$treeData[$i]['workspaces'] = $row->workspaces;	

						$treeData[$i]['company']  	= $row->company;	

						$treeData[$i]['nodes']  	= $row->nodes;	

						$treeData[$i]['treeVersion']= $row->treeVersion;	

						$i++;

					}

				}

			}

			else

			{

				foreach ($query->result() as $row)

				{				

					if($row->sharedStatus == 1 || ($row->sharedStatus == 2 && $row->userId == $_SESSION['userId']))

					{

						$treeData[$i]=array();

						$treeData[$i]['id'] 		= $row->id;	

						$treeData[$i]['name']  		= $row->name;	

						$treeData[$i]['type'] 		= $row->type;	

						$treeData[$i]['userId']  	= $row->userId;	

						$treeData[$i]['createdDate']= $row->createdDate;	

						$treeData[$i]['editedDate'] = $row->editedDate;	

						$treeData[$i]['workspaces'] = $row->workspaces;	

						$treeData[$i]['nodes']  	= $row->nodes;	

						$treeData[$i]['company']  	= $row->company;	

						$treeData[$i]['treeVersion']= $row->treeVersion;	

						$i++;

					}

				}

			}		

		} 

		return $treeData;	 

	}

	

	public function getlatestContactDetails($treeId){

		$treeData	= array();

		

		$query = $this->db->query( "SELECT a.*, b.name FROM teeme_contact_info a, teeme_tree b  WHERE (a.succesor ='' or a.succesor =0 or a.succesor is Null ) and b.id=a.treeId and a.treeId=".$treeId);		

		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] 		= $row->id;	

				$treeData['treeId']  = $row->treeId;

				$treeData['name']  = $row->name;	

				$treeData['firstname']  = $row->firstname;	

				$treeData['lastname'] 		= $row->lastname;	

				$treeData['middlename']  	= $row->middlename;	

				$treeData['title'] = $row->title;	

				$treeData['designation']  = $row->designation;	

				$treeData['company'] = $row->company;	

				$treeData['email']  	= $row->email;	

				$treeData['fax'] = $row->fax;	

				$treeData['mobile']  = $row->mobile;	

				$treeData['landline'] 		= $row->landline;	

				$treeData['address']  	= $row->address;

				$treeData['address2']  	= $row->address2;		

				$treeData['city'] = $row->city;	

				$treeData['state']  = $row->state;	

				$treeData['country'] = $row->country;	

				$treeData['zipcode']  	= $row->zipcode;	

				$treeData['predecessor'] = $row->predecessor;	

				$treeData['succesor']  = $row->succesor;	

				$treeData['comments']  = $row->comments;

				$treeData['sharedStatus']  = $row->sharedStatus;

				$treeData['other']  = $row->other;

				 

 			}

		} 

		return $treeData;

	}

	

	

	public function getContactDetailsByNode($node){

		$treeData	= array();

		

		$query = $this->db->query( "SELECT * FROM teeme_contact_info  WHERE id=".$node);		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] 		= $row->id;	

				$treeData['treeId']  = $row->treeId;	

				$treeData['firstname']  = $row->firstname;	

				$treeData['lastname'] 		= $row->lastname;	

				$treeData['middlename']  	= $row->middlename;	

				$treeData['title'] = $row->title;	

				$treeData['designation']  = $row->designation;	

				$treeData['company'] = $row->company;	

				$treeData['email']  	= $row->email;	

				$treeData['fax'] = $row->fax;	

				$treeData['mobile']  = $row->mobile;	

				$treeData['landline'] 		= $row->landline;	

				$treeData['address']  	= $row->address;	

				$treeData['address2']  	= $row->address2;

				$treeData['city'] = $row->city;	

				$treeData['state']  = $row->state;	

				$treeData['country'] = $row->country;	

				$treeData['zipcode']  	= $row->zipcode;	

				$treeData['predecessor'] = $row->predecessor;	

				$treeData['succesor']  = $row->succesor;

				$treeData['comments']  = $row->comments;	

				$treeData['sharedStatus']  = $row->sharedStatus;

				$treeData['other']  = $row->other;	 

 			}

		} 

		return $treeData;

	}

	public function totalContactNote($treeId){

		$treeData	= array();

		$query = $this->db->query( "SELECT a.id as nodeId, a.predecessor,a.successors, b.contents, b.userId,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate FROM teeme_node a, teeme_leaf b  WHERE  b.id=a.leafId and a.treeIds=".$treeId);		

		return $query->num_rows();

	}

	public function getlatestContactNote($treeId, $start=0, $userId = 0, $workspaceId = 0, $workspaceType = 0){

		$treeData	= array();

		//echo "SELECT a.id as nodeId, a.predecessor,a.successors, b.contents, b.userId,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate FROM teeme_node a, teeme_leaf b  WHERE (a.successors ='' or a.successors is Null or a.successors =0 ) and b.id=a.leafId and a.treeIds=".$treeId;

		if($workspaceId > 0)

		{	

			$query = $this->db->query( "SELECT a.id as nodeId, a.predecessor,a.successors, b.contents, b.userId,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate FROM teeme_node a, teeme_leaf b  WHERE  b.id=a.leafId and a.treeIds=".$treeId." and a.workSpaceId=".$workspaceId." and a.workSpaceType=".$workspaceType." order by a.nodeOrder ASC");		

		}

		else

		{

			$query = $this->db->query( "SELECT a.id as nodeId, a.predecessor,a.successors, b.contents, b.userId,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate FROM teeme_node a, teeme_leaf b  WHERE  b.id=a.leafId and a.treeIds=".$treeId." and a.userId=".$userId." order by a.nodeOrder ASC");		

		}		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData[$start]['nodeId'] 		= $row->nodeId;	

				$treeData[$start]['predecessor']  = $row->predecessor;	

				$treeData[$start]['successors']  = $row->successors;	

				$treeData[$start]['contents'] 		= $row->contents;	

				$treeData[$start]['userId']  	= $row->userId;	

				$treeData[$start]['createdDate'] = $row->createdDate;	

				 $start++;

 			}

		} 

		return $treeData;

	}

	

	public function getContactNoteBuyId($nodeId){

		$treeData	= array();

		

		$query = $this->db->query( "SELECT a.id as nodeId, a.predecessor,a.successors, b.contents, b.userId,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate FROM teeme_node a, teeme_leaf b  WHERE b.id=a.leafId and a.id=".$nodeId);		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['nodeId'] 		= $row->nodeId;	

				$treeData['predecessor']  = $row->predecessor;	

				$treeData['successors']  = $row->successors;	

				$treeData['contents'] 		= $row->contents;	

				$treeData['userId']  	= $row->userId;	

				$treeData['createdDate'] = $row->createdDate;	

 			}

		} 

		return $treeData;

	}

	

	// this method for checking unique contact name

	public function checkUniqueContact($name)

	{

		

		$query = $this->db->query( "SELECT * FROM teeme_tree WHERE name='".$name."' and type=5");		

		if($query->num_rows() > 0)

		{

			return false;

		}else{

			return true;

		}

		 		

	}

/*	public function getUserDetailsByUserId($userId)

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

	}*/

	

	 /**

	* This method will be used for fetch the node ids from the database.

 	* @param $treeId This is the variable used to hold the tree ID.

	* @return The node ids as an array

	*/

	public function getNodeIdsByTreeId($treeId, $workspaceId, $workspaceType, $userId)

	{

		$arrIdDetails = array();

		if($treeId != NULL)

		{

			// Get information of particular document

			if($workspaceId == 0)

			{

				$query = $this->db->query('SELECT 

				id  FROM teeme_node WHERE treeIds='.$treeId.' AND workSpaceId = '.$workspaceId.' AND workspaceType = '.$workspaceType);

				if($query->num_rows() > 0)

				{				

					foreach ($query->result() as $nodeData)

					{	

						$arrIdDetails[] = $nodeData->id;						

					}

				}

			}

			else

			{

				$query = $this->db->query('SELECT 

				id  FROM teeme_node WHERE treeIds='.$treeId.' AND userId = '.$userId);

				if($query->num_rows() > 0)

				{				

					foreach ($query->result() as $nodeData)

					{	

						$arrIdDetails[] = $nodeData->id;						

					}

				}

			}

		}

		return $arrIdDetails;

	}

	

	# this method is used to insert the new node and leaf of notes artifact

	public function editNotesContents($treeId,$nodeId,$note,$userId,$date = 0)

	{

		if($date == 0)

		{

			$date = date("Y-m-d h:i:s");

		}



		$query = $this->db->query("update teeme_leaf set contents ='".$note."',userId='".$userId."' where nodeId=".$nodeId);



		if ($query)

			return 1;

		else

			return 0;			

	}	

	

	public function getAllUsersByWorkPlaceId($workPlaceId,$search='')

	{

		$userData = array();

		$i = 0;
		if ($search==''){
			$query = $this->db->query('SELECT * FROM teeme_users WHERE workPlaceId='.$workPlaceId.' ORDER BY tagName ASC');
		}
		else {
			$query = $this->db->query('SELECT * FROM teeme_users WHERE workPlaceId='.$workPlaceId.' AND tagName LIKE (\''.$search.'%\') ORDER BY tagName ASC');
		}
		

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{

				$userData[$i]['userId'] 		= $row->userId;	

				$userData[$i]['workPlaceId'] 	= $row->workPlaceId;

				$userData[$i]['userName']	 	= $row->userName;	

				$userData[$i]['password'] 		= $row->password;

				$userData[$i]['userCommunityId'] = $row->userCommunityId;

				$userData[$i]['userTitle'] 		= $row->userTitle;									

				$userData[$i]['firstName'] 		= $row->firstName;

				$userData[$i]['lastName'] 		= $row->lastName;		

				$userData[$i]['address1'] 		= $row->address1;

				$userData[$i]['address2'] 		= $row->address2;	

				$userData[$i]['city'] 			= $row->city;		

				$userData[$i]['state'] 			= $row->state;			

				$userData[$i]['country'] 		= $row->country;	

				$userData[$i]['zip'] 			= $row->zip;		

				$userData[$i]['phone'] 			= $row->phone;	

				$userData[$i]['mobile'] 		= $row->mobile;		

				$userData[$i]['email'] 			= $row->email;

				$userData[$i]['status'] 		= $row->status;			

				$userData[$i]['emailSent'] 		= $row->emailSent;	

				$userData[$i]['registeredDate']	= $row->registeredDate;	

				$userData[$i]['lastLoginTime']	= $row->lastLoginTime;

				$userData[$i]['activation'] 	= $row->activation;

				$userData[$i]['photo'] 			= $row->photo;	

				$userData[$i]['statusUpdate'] 	= $row->statusUpdate;	

				$userData[$i]['other'] 			= $row->other;	
				
				$userData[$i]['role'] 			= $row->role;
				
				$userData[$i]['skills'] 		= $row->skills;
				
				$userData[$i]['department'] 	= $row->department;
				
				$userData[$i]['userGroup'] 		= $row->userGroup;
				
				$userData[$i]['isPlaceManager'] = $row->isPlaceManager;
				
				if($row->nickName!='')
				{
					$userData[$i]['tagName'] 		= $row->nickName;	
					$userData[$i]['userTagName']	= $row->nickName;		
				}
				else
				{
					$userData[$i]['tagName'] 		= $row->tagName;	
					$userData[$i]['userTagName']	= $row->tagName;	
				}	

				$i++;

														

			}				

		}					

		return $userData;			

	}

	

	public function getUserDetailsByUserId($userId)

	{

		$userData = array();

		//$limit = $this->config->item('msg_limit');

		//$i = 0;

		$query = $this->db->query('SELECT * FROM teeme_users  WHERE userId='.$userId);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{

				$userData['userId'] 		= $row->userId;	

				$userData['workPlaceId'] 	= $row->workPlaceId;

				$userData['userName']	 	= $row->userName;	

				$userData['password'] 		= $row->password;

				$userData['userCommunityId'] = $row->userCommunityId;

				$userData['userTitle'] 		= $row->userTitle;									

				$userData['firstName'] 		= $row->firstName;

				$userData['lastName'] 		= $row->lastName;		

				$userData['address1'] 		= $row->address1;

				$userData['address2'] 		= $row->address2;	

				$userData['city'] 			= $row->city;		

				$userData['state'] 			= $row->state;			

				$userData['country'] 		= $row->country;	

				$userData['zip'] 			= $row->zip;		

				$userData['phone'] 			= $row->phone;	

				$userData['mobile'] 		= $row->mobile;		

				$userData['email'] 			= $row->email;

				$userData['status'] 		= $row->status;			

				$userData['emailSent'] 		= $row->emailSent;	

				$userData['registeredDate']	= $row->registeredDate;	

				$userData['lastLoginTime']	= $row->lastLoginTime;

				$userData['activation'] 	= $row->activation;

				$userData['photo'] 			= $row->photo;	

				$userData['statusUpdate'] 	= $row->statusUpdate;

				$userData['other'] 			= $row->other;

				$userData['role'] 			= $row->role;
				
				$userData['skills'] 			= $row->skills;

				$userData['department'] 	= $row->department;
				
				$userData['userGroup'] 	= $row->userGroup;
				
				$userData['isPlaceManager'] 	= $row->isPlaceManager;
				
				$userData['defaultSpace'] 	= $row->defaultSpace;
				
				if($row->nickName!='')
				{
					$userData['tagName'] 		= $row->nickName;
					$userData['userTagName']	= $row->nickName;
				}
				else
				{
					$userData['tagName'] 		= $row->tagName;
					$userData['userTagName']	= $row->tagName;	
				}
				$userData['editUserTagName']	= $row->tagName;
				$userData['editNickName']	    = $row->nickName;

				//$i++;									

			}				

		}					

		return $userData;			

	}

	

	public function insertWallComment($ownerId,$userId,$comment,$limitation='public',$urgent=0)

	{	

		$query = "INSERT INTO teeme_wall (owner_id, commenter_id, comment, comment_time, limitation, urgent) VALUES ('".$ownerId."','".$userId."','".addslashes($comment)."',NOW(),'".$limitation."','".$urgent."')";

		$result = $this->db->query($query);

		

		if($result)

		{

			return true;

		}		

		else

		{

			return false;

		}		

	}

	

	//arun- insert comment 

	public function insertComment($ownerId,$userId,$comment,$limitation,$urgent=0,$recipients,$parentCommentId=0,$date='00000-00-00',$workSpaceId_search_user,$workSpaceType_search_user)

	{	

		//print_r ($recipients); exit;

	

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'  ");

	   if($check->num_rows()>0)

	   {

		 $query = "INSERT INTO teeme_wall_comments (commenterId,commentWorkSpaceId ,commentWorkSpaceType,comment, commentTime, limitation, parentCommentId,latestUpdateTime) VALUES ('".$userId."',".$workSpaceId_search_user.",".$workSpaceType_search_user.",'".addslashes($comment)."','".$date."','".$limitation."','".$parentCommentId."','".$date."')";

		

		$result = $this->db->query($query);

		

		$commentId=$this->db->insert_id();

		//echo "commentid= " .$commentId;

		$result = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId,urgent) VALUES ('".$commentId."','".$ownerId."','".$urgent."')");

		

		//$result = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId) VALUES ('".$commentId."','".$_SESSION['userId']."')");

		

		if(!empty($recipients))

		{

			

			if($workSpaceId_search_user==0){

				$recipients=explode(',',$recipients);	

				foreach($recipients as $recipientsUserId)

				{ 

					if($recipientsUserId && $_SESSION['userId']!=$recipientsUserId)

					{

					   $result = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId,urgent) VALUES ('".$commentId."','".$recipientsUserId ."','".$urgent."')");

					}		

				}

			}

			else{

				foreach($recipients as $recipientsUserId)

				{ 

					if($recipientsUserId['userId'] && $_SESSION['userId']!=$recipientsUserId['userId'])

					{

					   $result = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId,urgent) VALUES ('".$commentId."','".$recipientsUserId['userId']."','".$urgent."')");

					}		

				}

			}

		}



		

		if($result)

		{

			return true;

		}		

		else

		{

			return false;

		}

		

		}

		else

		{

		

			echo $this->lang->line('some_tables_not_exist');

			die;

		}

	}

	

	//delete

	public function getWallCommentsByOwnerId($ownerId){

		$treeData	= array();

		$i = 0;

		$query = $this->db->query( "SELECT * FROM teeme_wall  WHERE owner_id='".$ownerId."' AND status=1 ORDER BY comment_time DESC");		

		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData[$i]['id'] 			= $row->id;	

				$treeData[$i]['owner_id']  		= $row->owner_id;

				$treeData[$i]['commenter_id']  	= $row->commenter_id;	

				$treeData[$i]['comment']  		= $row->comment;	

				$treeData[$i]['comment_time'] 	= $row->comment_time;

				$treeData[$i]['limitation'] 	= $row->limitation;

				$treeData[$i]['status'] 		= $row->status;	

				$treeData[$i]['urgent'] 		= $row->urgent;	

				$i++;

 			}

		} 

		return $treeData;

	}

	

	//arun- get all messages

	public function getWallCommentsByCommenterId($ownerId){

		$treeData	= array();

		$i = 0;

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'  ");

	   if($check->num_rows()>0)

	   {

	  

		$query = $this->db->query( "SELECT * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE recipientId ='".$ownerId."' AND c.status=1  AND c.parentCommentId=0 AND r.recipientStatus =1 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime   DESC");	

		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData[$i]['id'] 						= $row->id;	

				$treeData[$i]['commentWorkSpaceId']  		= $row->commentWorkSpaceId;

				$treeData[$i]['commentWorkSpaceType']  		= $row->commentWorkSpaceType;

				$treeData[$i]['commenterId']  				= $row->commenterId;

				$treeData[$i]['recipientId']  				= $row->recipientId;	

				$treeData[$i]['comment']  					= $row->comment;	

				$treeData[$i]['commentTime'] 				= $row->commentTime;

				$treeData[$i]['limitation'] 				= $row->limitation;

				$treeData[$i]['status'] 					= $row->status;	

				$treeData[$i]['urgent'] 					= $row->urgent;	

				$i++;

 			}

		} 

		return $treeData;

		

		}

		else

		{

				//echo "Some tables not exist, Please install the tables.";

				//die;

		

		}

		

	}

	

	//arun- get all messages by space id and spaceType

	public function getMessagesBySpaceIdAndType($ownerId,$count=false,$spaceType=0,$spaceId=0,$offset=0,$limit=''){

		$treeData	= array();

		$i = 0;

		

		//added by monika

		if($limit==''){

			$limit = 10;

		}

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'  ");

	   if($check->num_rows()>0)

	   {

	   		$where="";

			

			if($ownerId==$_SESSION['userId'])

			{

				$where=" ( r.recipientId= '".$ownerId."' ) ";

				//$where=" (( r.recipientId= '".$_SESSION['userId']."'  AND c.commenterId= '".$ownerId."'  ) OR  ( r.recipientId= '".$ownerId."'  AND c.commenterId= '".$_SESSION['userId']."'  ) )";

			}

			else

			{

				$where=" (( r.recipientId= '".$_SESSION['userId']."'  AND c.commenterId= '".$ownerId."'  ) OR  ( r.recipientId= '".$ownerId."'  AND c.commenterId= '".$_SESSION['userId']."'  ) )";

			}

	   

			//($arrVal['recipientId']==$_SESSION['userId']) || ($arrVal['commenterId']==$_SESSION['userId'] && $arrVal['recipientId']== $this->uri->segment(3) )

	  		if($spaceId==0)

			{

			    if($count)

				{

					//$query=$this->db->query("SELECT COUNT(*) AS total_count FROM ( SELECT COUNT(*)  FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE recipientId ='".$ownerId."' AND c.status=1  AND c.parentCommentId=0 AND r.recipientStatus =1 GROUP BY commentId,recipientId   ) AS T ");			

					if($_SESSION['allSpace'])

					{ 

					   	$query = $this->db->query("SELECT COUNT(*) AS total_count FROM ( SELECT COUNT(*) FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where." AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime      ) AS T ");

					}

					else

					{

						$query = $this->db->query("SELECT COUNT(*) AS total_count FROM ( SELECT COUNT(*) FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where." AND c.commentWorkSpaceId =0 AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime      ) AS T ");		

					}

					if($query->num_rows() > 0)

					{

						$query=$query->row();

						

 						return $query->total_count;

					}		

				}

				else

				{

					if($_SESSION['allSpace'])

					{ 

					   	$query="SELECT * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where." AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime   DESC   LIMIT $offset,$limit"; 

					}

					else

					{

					 	$query="SELECT * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where." AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND c.commentWorkSpaceId =0 AND r.recipientStatus =1 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime DESC   LIMIT $offset,$limit"; 

					}

				}

			}

			else

			{

				if($count)

				{

					if($_SESSION['allSpace'])

					{ 

					    $query=$this->db->query("SELECT COUNT(*) AS total_count FROM (SELECT COUNT(*) FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where."  AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1  GROUP BY commentId,recipientId) AS T  ");  

					}

					else

					{

					    $query=$this->db->query("SELECT COUNT(*) AS total_count FROM (SELECT COUNT(*) FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where."  AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 AND c.commentWorkSpaceId ='".$spaceId."' AND c.commentWorkSpaceType='".$spaceType."'	 GROUP BY commentId,recipientId) AS T  ");

					}

					

					

					if($query->num_rows() > 0)

					{

						$query=$query->row();

						return $query->total_count;

					}		

				}

				else

				{

				

			      if($_SESSION['allSpace'])

					{ 

					    $query="SELECT  * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where."   AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1  GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime   DESC LIMIT $offset,$limit"; 

					}

					else

					{

				  		$query="SELECT  * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where."   AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 AND c.commentWorkSpaceId ='".$spaceId."' AND c.commentWorkSpaceType='".$spaceType."'	 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime   DESC  LIMIT $offset,$limit";

					}

				}

			

			}

	   

		$query = $this->db->query($query);		

		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData[$i]['id'] 						= $row->id;	

				$treeData[$i]['commentWorkSpaceId']  		= $row->commentWorkSpaceId;

				$treeData[$i]['commentWorkSpaceType']  		= $row->commentWorkSpaceType;

				$treeData[$i]['commenterId']  				= $row->commenterId;

				$treeData[$i]['recipientId']  				= $row->recipientId;	

				$treeData[$i]['comment']  					= $row->comment;	

				$treeData[$i]['commentTime'] 				= $row->commentTime;

				$treeData[$i]['limitation'] 				= $row->limitation;

				$treeData[$i]['status'] 					= $row->status;	

				$treeData[$i]['urgent'] 					= $row->urgent;	

				$treeData[$i]['notification'] 				= $row->notification;	

				$i++;

 			}

		} 

		return $treeData;

		

		}

		else

		{

				//echo "Some tables not exist, Please install the tables.";

				//die;

		

		}

		

	}

	

	//arun-function for get reply 

	function getReplyByCommentId($parentCommentId,$time=0,$order='desc',$count=false)

	{

		$j=0;

		$treeData1=array();

		

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'   ");

	   if($check->num_rows()>0)

	   {

		

		if($time)

		{

		

				$query = $this->db->query( "SELECT * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE c.parentCommentId ='".	$parentCommentId."' AND c.commentTime >= '".$time." -1000 ' AND c.status=1 AND r.recipientStatus = 1  ORDER BY 	c.commentTime ".$order);

			

		}

		else

		{ 

			if($count)

			{

				$query = $this->db->query( "SELECT count(*) as total_count FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE c.parentCommentId ='".	$parentCommentId."' AND c.status=1  AND r.recipientStatus = 1 ORDER BY 	c.commentTime ".$order);

				

				if($query->num_rows()>0)

				{

					$query=$query->row();

					return $query->total_count;

				}

			

				return 0;	

			}

			else

			{ 

				$query = $this->db->query( "SELECT * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE c.parentCommentId ='".	$parentCommentId."' AND c.status=1  AND r.recipientStatus = 1 ORDER BY 	c.commentTime ".$order);

			}	

		

		}

		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row1)

			{

				$treeData1[$j]['id'] 			= $row1->id;	

				$treeData1[$j]['commenterId']  		= $row1->commenterId;

				$treeData1[$j]['recipientId ']  	= $row1->recipientId;	

				$treeData1[$j]['comment']  		= $row1->comment;	

				$treeData1[$j]['commentTime'] 	= $row1->commentTime;

				$treeData1[$j]['limitation'] 	= $row1->limitation;

				$treeData1[$j]['status'] 		= $row1->status;	

				$treeData1[$j]['urgent'] 		= $row1->urgent;	

				$j++;

 			}

		} 

		return $treeData1;

		

		}

		else

		{

			echo $this->lang->line('dataBase_error');

			die;

		} 

	

	}

	
	function getLastCommentByMessageId ($message_id=0)
	{
		$treeData1=array();
		//$j=0;
	
		$query = $this->db->query( "SELECT * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id WHERE c.parentCommentId ='".$message_id."' AND c.status=1 AND r.recipientStatus = 1 ORDER BY c.commentTime DESC LIMIT 1");
		
		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row1)

			{
				$treeData1[] = $row1;

/*				$treeData1[$j]['id'] 			= $row1->id;	

				$treeData1[$j]['commenterId']  		= $row1->commenterId;

				$treeData1[$j]['recipientId ']  	= $row1->recipientId;	

				$treeData1[$j]['comment']  		= $row1->comment;	

				$treeData1[$j]['commentTime'] 	= $row1->commentTime;

				$treeData1[$j]['limitation'] 	= $row1->limitation;

				$treeData1[$j]['status'] 		= $row1->status;	

				$treeData1[$j]['urgent'] 		= $row1->urgent;	

				$j++;*/

 			}

		} 
		else
		{
			return 0;
		}

		return $treeData1;		
	}
	

	//arun-function for get reply 

	function getReplyByCommentIdForConverDiscuss($messageId,$order='DESC')

	{

		$j=0;

		$treeData1=array();

		

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_comments'   ");

	   if($check->num_rows()>0)

	   {

		

			$query = $this->db->query( "SELECT * FROM teeme_wall_comments as c WHERE c.parentCommentId ='".$messageId."' ORDER BY 	c.commentTime ".$order);

		

			if($query->num_rows() > 0)

			{

			

				foreach ($query->result() as $row1)

				{

					$treeData1[$j]['id'] 			= $row1->id;	

					$treeData1[$j]['commenterId']  		= $row1->commenterId;

					$treeData1[$j]['recipientId ']  	= $row1->recipientId;	

					$treeData1[$j]['comment']  		= $row1->comment;	

					$treeData1[$j]['commentTime'] 	= $row1->commentTime;

					$treeData1[$j]['limitation'] 	= $row1->limitation;

					$treeData1[$j]['status'] 		= $row1->status;	

					$treeData1[$j]['urgent'] 		= $row1->urgent;	

					$j++;

				}

			} 

			return $treeData1;

		

			}

			else

			{

				echo $this->lang->line('some_tables_not_exist');

				die;

			} 

	

	}

	

	//Arun- delete comment 

	public function deleteComment ($comment_id,$userId)

	{

		

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_comments'  ");

	   	if($check->num_rows()>0)

	   	{ 

			

			$query="UPDATE `teeme_wall_recipients` SET recipientStatus=0 WHERE commentId='".$comment_id."'  AND recipientId='".$userId."' ";

			$result = $this->db->query($query);

			

			if($result)

			{

				return true;

			}		

			else

			{

				return false;

			}

		}

		else

		{

			echo $this->lang->line('comment_table_not_exist');

			die;

		} 

	}

	

	//Arun- delete comment 

	public function deleteComment1($comment_id,$userId,$date='0000-00-00',$msgId=0)

	{

		

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_comments'  ");

	   	if($check->num_rows()>0)

	   	{ 

		

			$this->db->query("UPDATE `teeme_wall_comments` SET latestUpdateTime='".$date."' WHERE id 	='".$msgId."'  ");

			

			$query="UPDATE `teeme_wall_recipients` SET recipientStatus=0 WHERE commentId='".$comment_id."'  ";

			

			$result = $this->db->query($query);

			

			

			

			if($result)

			{

				return true;

			}		

			else

			{

				return false;

			}

		}

		else

		{

			echo $this->lang->line('comment_table_not_exist');

			die;

		} 

	}

	

	

	//Arun- delete Message comment 

	public function deleteMessageComment ($comment_id,$userId)

	{

		

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_comments'  ");

	   	if($check->num_rows()>0)

	   	{ 

			

			$query="UPDATE `teeme_wall_recipients` SET recipientStatus=0 WHERE commentId='".$comment_id."' and recipientId ='".$userId."' ";

			$result = $this->db->query($query);

			

			if($result)

			{

				return true;

			}		

			else

			{

				return false;

			}

		}

		else

		{

			echo $this->lang->line('comment_table_not_exist');

			die;

		} 

	}

	

	//Arun- delete Entire message atter convering message into Discuss

	public function deleteMessage ($comment_id,$link)

	{

		

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_comments'  ");

	   	if($check->num_rows()>0)

	   	{ 

		

			//$query="delete  from `teeme_wall_recipients`  WHERE commentId='".$comment_id."'   ";

			//$result = $this->db->query($query);

			

			$query="UPDATE `teeme_wall_comments` SET status='2',`comment`=CONCAT(`comment`,'This messsage has been moved to discuss tree! - <a href=\'".$link."\'>Click Here to view</a><br>')  WHERE id='".$comment_id."'   ";

			$result = $this->db->query($query);

			

			if($result)

			{

				return true;

			}		

			else

			{

				return false;

			}

		}

		else

		{

			echo $this->lang->line('comment_table_not_exist');

			die;

		} 

	}

	

	//not in  use

	public function getWallAlertsByMemberId ($memberId)

	{

		$query = $this->db->query( "SELECT count(*) as counted FROM teeme_wall WHERE owner_id='".$memberId."' and urgent=1");		

		$row=$query->result();

			foreach ($query->result() as $row)

			{

				$wallAlerts = $row->counted;	

 			}

		return $wallAlerts;

	}

	

	//arun-

	public function getWallAlertsByMemberId2 ($memberId)

	{

		

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'");

	   	if($check->num_rows()>0)

	   	{ 

		

			$query = $this->db->query("SELECT count(*) as counted from  teeme_wall_recipients as r LEFT JOIN teeme_wall_comments  as c ON r.commentId=c.id  where r.urgent=1  AND r.recipientId='".$memberId."' AND r.recipientId!=c.commenterId ");

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$wallAlerts = $row->counted;	

 			}

			return $wallAlerts;

		}

		else

		{

			//echo "Recipients table does not exist, Please install the table.";

			//die;

		

		} 

	}

	

	//arun-

	public function getMessageNotificationByMemberId2 ($memberId)

	{

		

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'");

	   	if($check->num_rows()>0)

	   	{ 

		

			$query = $this->db->query("SELECT count(*) as counted from  teeme_wall_recipients as r LEFT JOIN teeme_wall_comments  as c ON r.commentId=c.id  where r.notification=1 AND r.urgent=0  AND r.recipientId='".$memberId."' AND r.recipientId!=c.commenterId ");

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$count = $row->counted;	

 			}

			return $count;

		}

		else

		{

			//echo "Recipients table does not exist, Please install the table.";

			//die;

		

		} 

	}

	

	//not in use

	public function updateWallAlert ($memberId,$value)

	{

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'");

	   if($check->num_rows()>0)

	   {

			$query = "UPDATE teeme_wall SET urgent='".$value."' WHERE owner_id='".$memberId."'";

			$result = $this->db->query($query);

			

			if($result)

			{

				return true;

			}		

			else

			{

				return false;

			}

		}

		else

		{

			echo $this->lang->line('recipients_table_not_exist');

			//die;

		

		}	

	}

	

	//arun

	public function updateWallAlert2($memberId,$value)

	{ 

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'");

	   if($check->num_rows()>0)

	   {

		   //echo "UPDATE teeme_wall_comments  SET urgent='".$value."' WHERE commenterId='".$memberId."'"; die;

			$query = "UPDATE  teeme_wall_recipients  SET urgent='".$value."' WHERE recipientId='".$memberId."'";

			$result = $this->db->query($query);

			

			if($result)

			{

				return true;

			}		

			else

			{

				return false;

			}

		}

		else

		{

			echo $this->lang->line('recipients_table_not_exist');

			die;

		}		

	}

	

	//arun

	public function updateMessageNotification($memberId,$value)

	{ 

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'");

	   if($check->num_rows()>0)

	   {

		   //echo "UPDATE teeme_wall_comments  SET urgent='".$value."' WHERE commenterId='".$memberId."'"; die;

			$query = "UPDATE  teeme_wall_recipients  SET notification='".$value."' WHERE recipientId='".$memberId."'";

			$result = $this->db->query($query);

			

			if($result)

			{

				return true;

			}		

			else

			{

				return false;

			}

		}

		else

		{

			echo $this->lang->line('recipients_table_not_exist');

			die;

		}		

	}

	

	//Arun- function add reply of comment 

	public function insertMessageReply($msgId,$comment,$userId,$commenterId,$urgent=0,$date='0000-00-00')

	{ 

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_comments'");

	   if($check->num_rows()>0)

	   {

	   

			$query = "INSERT INTO teeme_wall_comments (commenterId, comment, commentTime, limitation, parentCommentId) VALUES ('".$userId."','".addslashes($comment)."','".$date."','".$limitation."','".$msgId."')";

			

			$result = $this->db->query($query);

			
			//Manoj: replace mysql function
			//$commentId=mysql_insert_id();
			$commentId=$this->db->insert_id();
			

			

			$result = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId,urgent) VALUES ('".$commentId."','".$commenterId."','".$urgent."')");

			

			$result = $this->db->query("UPDATE `teeme_wall_comments` SET latestUpdateTime='".$date."' WHERE id='".$msgId."' ");

		}

		else

		{

			echo $this->lang->line('comment_table_not_exist');

			die;

		

		}	

		

	}

	

	//arun - function for get message details by message id

	function getMessageDetailByMessageId($msgId)

	{

		

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'");

		

	   	if($check->num_rows()>0)

	   	{ 

		  //echo "SELECT * FROM `teeme_wall_comments` WHERE `id`=$msgId ";

			$query = $this->db->query("SELECT * FROM `teeme_wall_comments` WHERE `id`=$msgId ");

			

			return $query->row();

			

			

		}

		else

		{

			//echo "Recipients table does not exist, Please install the table.";

			//die;

		

		} 

	

	}

	

	//Arun- function updates message 

	public function updateMessage($msgId,$message,$userId,$date='0000-00-00')

	{ 

		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_comments'");

	   if($check->num_rows()>0)

	   {

			

			$result = $this->db->query("UPDATE `teeme_wall_comments` SET comment='".$message."',latestUpdateTime='".$date."' WHERE id='".$msgId."' ");

		}

		else

		{

			echo $this->lang->line('comment_table_not_exist');

			die;

		

		}	

		

	}

	

	function getMessageRecipents($cmmntId,$cmmntrId=0){

		

		$qry = $this->db->query("select recipientId from teeme_wall_recipients WHERE commentId = $cmmntId AND  	recipientId!=$cmmntrId");

		if($qry->num_rows()){

			return $qry->result_array();

		}

		else{

			return 0;

		}

	}

	

	function getCommentCount($wsId){
	
		$q = "SELECT COUNT(id) as count FROM `teeme_wall_comments` WHERE parentCommentId IN(SELECT id from  teeme_wall_comments where commentWorkSpaceId='".$wsId."') AND parentCommentId!=0 AND (SELECT count(id) FROM teeme_wall_recipients WHERE commentId=teeme_wall_comments.parentCommentId AND  recipientId=".$_SESSION['userId'].") >0";

		$qry = $this->db->query($q);
		
		//echo $q; exit;

		if($qry->num_rows()){

			$arr=$qry->result_array();

			return $arr[0]['count'];

		}

		else{

			return 0;

		}

	}
	
	//Timeline First five post start
	
	public function getPostsBySpaceIdAndTypeTimeline($ownerId,$count=false,$spaceType=0,$spaceId=0,$offset=0,$limit=''){

		$treeData	= array();

		$i = 0;

		

		//added by monika

		if($limit==''){

			$limit = 10;

		}

	   $check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'  ");

	   if($check->num_rows()>0)

	   {

	   		$where="";

			

			if($ownerId==$_SESSION['userId'])

			{

				$where=" ( r.recipientId= '".$ownerId."' ) ";

				//$where=" (( r.recipientId= '".$_SESSION['userId']."'  AND c.commenterId= '".$ownerId."'  ) OR  ( r.recipientId= '".$ownerId."'  AND c.commenterId= '".$_SESSION['userId']."'  ) )";

			}

			else

			{

				$where=" (( r.recipientId= '".$_SESSION['userId']."'  AND c.commenterId= '".$ownerId."'  ) OR  ( r.recipientId= '".$ownerId."'  AND c.commenterId= '".$_SESSION['userId']."'  ) )";

			}

	   

			//($arrVal['recipientId']==$_SESSION['userId']) || ($arrVal['commenterId']==$_SESSION['userId'] && $arrVal['recipientId']== $this->uri->segment(3) )

	  		if($spaceId==0)

			{

			    if($count)

				{

					//$query=$this->db->query("SELECT COUNT(*) AS total_count FROM ( SELECT COUNT(*)  FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE recipientId ='".$ownerId."' AND c.status=1  AND c.parentCommentId=0 AND r.recipientStatus =1 GROUP BY commentId,recipientId   ) AS T ");			

					if($_SESSION['allSpace'])

					{ 

					   	$query = $this->db->query("SELECT COUNT(*) AS total_count FROM ( SELECT COUNT(*) FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where." AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime      ) AS T ");

					}

					else

					{

						$query = $this->db->query("SELECT COUNT(*) AS total_count FROM ( SELECT COUNT(*) FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where." AND c.commentWorkSpaceId =0 AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime      ) AS T ");		

					}

					if($query->num_rows() > 0)

					{

						$query=$query->row();

						

 						return $query->total_count;

					}		

				}

				else

				{

					if($_SESSION['allSpace'])

					{ 

					   	$query="SELECT * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where." AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime   DESC   LIMIT $offset,$limit"; 

					}

					else

					{

					 	$query="SELECT * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where." AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND c.commentWorkSpaceId =0 AND r.recipientStatus =1 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime DESC   LIMIT $offset,$limit"; 

					}

				}

			}

			else

			{

				if($count)

				{

					if($_SESSION['allSpace'])

					{ 

					    $query=$this->db->query("SELECT COUNT(*) AS total_count FROM (SELECT COUNT(*) FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where."  AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1  GROUP BY commentId,recipientId) AS T  ");  

					}

					else

					{

					    $query=$this->db->query("SELECT COUNT(*) AS total_count FROM (SELECT COUNT(*) FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where."  AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 AND c.commentWorkSpaceId ='".$spaceId."' AND c.commentWorkSpaceType='".$spaceType."'	 GROUP BY commentId,recipientId) AS T  ");

					}

					

					

					if($query->num_rows() > 0)

					{

						$query=$query->row();

						return $query->total_count;

					}		

				}

				else

				{

				

			      if($_SESSION['allSpace'])

					{ 

					    $query="SELECT  * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where."   AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1  GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime   DESC LIMIT $offset,$limit"; 

					}

					else

					{

				  		$query="SELECT  * FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE ".$where."   AND (c.status=1 || c.status=2)  AND c.parentCommentId=0 AND r.recipientStatus =1 AND c.commentWorkSpaceId ='".$spaceId."' AND c.commentWorkSpaceType='".$spaceType."'	 GROUP BY commentId,recipientId  ORDER BY   c.latestUpdateTime   DESC  LIMIT $offset,$limit";

					}

				}

			

			}

	   

		$query = $this->db->query($query);		

		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData[$i]['id'] 						= $row->id;	

				$treeData[$i]['commentWorkSpaceId']  		= $row->commentWorkSpaceId;

				$treeData[$i]['commentWorkSpaceType']  		= $row->commentWorkSpaceType;

				$treeData[$i]['commenterId']  				= $row->commenterId;

				$treeData[$i]['recipientId']  				= $row->recipientId;	

				$treeData[$i]['comment']  					= $row->comment;	

				$treeData[$i]['commentTime'] 				= $row->commentTime;

				$treeData[$i]['limitation'] 				= $row->limitation;

				$treeData[$i]['status'] 					= $row->status;	

				$treeData[$i]['urgent'] 					= $row->urgent;	

				$treeData[$i]['notification'] 				= $row->notification;	

				$i++;

 			}

		} 

		return $treeData;

		

		}

		else

		{

				//echo "Some tables not exist, Please install the tables.";

				//die;

		

		}

		

	}
	
	//Timeline first five post end

}?>