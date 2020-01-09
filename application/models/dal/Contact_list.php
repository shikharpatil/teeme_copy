<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/



/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: contact_list.php 

	* Description 		  	: to handle contact list

 	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 02-12-2008				Vinaykant						contact_list

	**********************************************************************************************************/

/**

* A PHP class to access teeme work place, work space and users database with convenient methods

* with various operation Add, update, delete & retrieve teeme work place, work space and user details

* @author   Ideavate Solutions (www.ideavate.com)

*/

class contact_list extends CI_Model

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

	// this method for inserting new contactlist

	public function insertNewContact($name,$workSpaceId,$workSpaceType,$userId,$createdDate, $contactinfo)

	{

		 

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("insert into teeme_tree (name,type,workspaces,workSpaceType,userId,createdDate,editedDate) values ('".$this->db->escape_str($name)."',5,'".$workSpaceId."','".$workSpaceType."',".$userId.",'".$createdDate."','".$createdDate."')");

		

		$treeId=$this->db->insert_id();

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("insert into teeme_contact_info (treeId,firstname,lastname,middlename ,title ,designation ,company,website,email ,fax ,mobile ,landline ,address ,address2,city ,state ,country ,zipcode, comments, sharedStatus, workplaceId, other ) values ('".$treeId."','".$this->db->escape_str($contactinfo['firstname'])."','".$this->db->escape_str($contactinfo['lastname'])."','".$this->db->escape_str($contactinfo['middlename'])."','".$this->db->escape_str($contactinfo['title'])."','".$this->db->escape_str($contactinfo['designation'])."','".$this->db->escape_str($contactinfo['company'])."','".$this->db->escape_str($contactinfo['website'])."','".$contactinfo['email']."','".$contactinfo['fax']."','".$contactinfo['mobile']."','".$contactinfo['landline']."','".$this->db->escape_str($contactinfo['address'])."','".$this->db->escape_str($contactinfo['address2'])."','".$contactinfo['city']."','".$contactinfo['state']."','".$contactinfo['country']."','".$contactinfo['zipcode']."','".$this->db->escape_str($contactinfo['comments'])."','".$this->db->escape_str($contactinfo['sharedStatus'])."','".$_SESSION['workPlaceId']."','".$this->db->escape_str($contactinfo['other'])."')");

				

		return $treeId;			

	}

	

	// to update Contact

	public function updateContact($treeId, $contactinfo)

	{

		$predecessor=0;
		//Manoj: replace mysql_escape_str function
 		$query = $this->db->query("UPDATE teeme_contact_info SET treeId ='".$treeId."', firstname ='".$this->db->escape_str($contactinfo['firstname'])."', lastname ='".$this->db->escape_str($contactinfo['lastname'])."', middlename= '".$this->db->escape_str($contactinfo['middlename'])."', title= '".$this->db->escape_str($contactinfo['title'])."', designation ='".$this->db->escape_str($contactinfo['designation'])."', company='".$this->db->escape_str($contactinfo['company'])."', website='".$this->db->escape_str($contactinfo['website'])."',email= '".$contactinfo['email']."', fax= '".$contactinfo['fax']."',mobile= '".$contactinfo['mobile']."',landline= '".$contactinfo['landline']."',address= '".$this->db->escape_str($contactinfo['address'])."',address2= '".$this->db->escape_str($contactinfo['address2'])."',city= '".$contactinfo['city']."',state= '".$contactinfo['state']."',country= '".$contactinfo['country']."',zipcode='".$contactinfo['zipcode']."',comments='".$contactinfo['comments']."',sharedStatus='".$contactinfo['sharedStatus']."',other='".$contactinfo['other']."' WHERE treeId = ".$treeId);

		

	}

	

	
	/*Changed by Dashrath- Add leafStatus*/
	public function insertNote($treeId,$note,$userId,$nodeOrder,$workspaceId =0,$workspaceType=0,$createdDate,$copy=0,$leafStatus='publish')

	{

		if($copy == 0)
		{
			if($workspaceId > 0)

			{	

				$query = $this->db->query("update teeme_node SET nodeOrder = nodeOrder+1 WHERE treeIds = '".$treeId."' AND workSpaceId = ".$workspaceId." AND workSpaceType = ".$workspaceType." AND nodeOrder >= ".$nodeOrder);		

			}

			else

			{		

				$query = $this->db->query("update teeme_node SET nodeOrder = nodeOrder+1 WHERE treeIds = '".$treeId."' AND userId = ".$userId." AND nodeOrder >= ".$nodeOrder);		

			}	
		}

		

		if ($createdDate!='')

		{
			//Manoj: replace mysql_escape_str function
			/*Changed by Dashrath- Add leafStatus*/
			$query 	= $this->db->query("insert into teeme_leaf (contents,createdDate,editedDate, userId, leafStatus) values ('".$this->db->escape_str($note)."','".$createdDate."','".$createdDate."','".$userId."', '".$this->db->escape_str($leafStatus)."')");		

			$leafId	= $this->db->insert_id();

		}

		else

		{
			//Manoj: replace mysql_escape_str function
			$query 	= $this->db->query("insert into teeme_leaf (contents,createdDate, userId, leafStatus) values ('".$this->db->escape_str($note)."','".date("Y-m-d h:i:s")."','".$userId."', '".$this->db->escape_str($leafStatus)."')");		

			$leafId	= $this->db->insert_id();

		}

				

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
			//Manoj: replace mysql_escape_str function
		 $query = $this->db->query("insert into teeme_leaf (`contents`,`createdDate`, `userId`, workSpaceId, workSpaceType) values ('".$this->db->escape_str($note)."','".$date."','".$userId."','".$workspaceId."','".$workspaceType."' )");

		

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

	

	/* <!-- Changed By Surbhi IV-->*/

	public function getContectList($workspaces,$workSpaceType,$userId,$sortBy = 1, $sortOrder = 1){

	/* <!-- End of Changed By Surbhi IV-->*/	

		$treeData	= array();

		/*Added by Surbhi IV*/

		if($sortBy == 1)

		{
		
			$orderBy = ' ORDER BY b.firstname';

			

		}

		else if($sortBy == 2)

		{
			$orderBy = ' ORDER BY a.name';

			

		}

		else if($sortBy == 3)

		{

			$orderBy = ' ORDER BY u.tagName';
			

		}

		else if($sortBy == 4)

		{
			$orderBy = ' ORDER BY a.editedDate';
			

		}

		else

		{
			$orderBy = ' ORDER BY b.company';
			

		}

		if($sortOrder == 1)

		{

			$orderBy .= ' DESC';

		}

		else

		{

			$orderBy .= ' ASC';

		} 		

		/*End of Added by Surbhi IV*/

		

		if ($workspaces)

		{

		    /*Changed by Surbhi IV*/


			$query = $this->db->query( "SELECT a.*, b.firstname, b.lastname, b.middlename, b.sharedStatus, b.company, u.tagName FROM teeme_tree a, teeme_users u, teeme_contact_info b WHERE a.userId=u.userId AND a.id = b.treeId AND b.workplaceId = '".$_SESSION['workPlaceId']."' AND a.type=5".$orderBy);

			 /*End of Changed by Surbhi IV*/

		}

		else

		{

			/*Changed by Surbhi IV*/

			$query = $this->db->query( "SELECT a.*, b.firstname, b.lastname, b.middlename, b.sharedStatus, b.company FROM teeme_tree a, teeme_contact_info b, teeme_users u WHERE a.userId=u.userId AND a.id = b.treeId AND a.workspaces=0 AND b.workplaceId = '".$_SESSION['workPlaceId']."' AND a.type=5".$orderBy);

            /*End of Changed by Surbhi IV*/

		}

		

		$i=0;	

		if($query->num_rows() > 0)
		{

			$row=$query->result();

			if($workspaces)

			{							
				$this->load->model('dal/identity_db_manager');
				$userGroup= $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId']);
					if ($workSpaceType==2)
					{
						$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workspaces);
					}
					else
					{
						$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workspaces);
					}			
				foreach ($query->result() as $row)

				{				

					if( (($row->sharedStatus == 1 && $userGroup>0) && $workSpaceDetails['workSpaceName']!='Try Teeme') || ($workspaces == $row->workspaces && $workSpaceType == $row->workSpaceType))

					{							

						$treeData[$i]=array();

						$treeData[$i]['id'] 		= $row->id;	
						
						$treeData[$i]['firstname']  		= $row->firstname;	
						
						$treeData[$i]['lastname']  		= $row->lastname;	
						
						$treeData[$i]['middlename']  		= $row->middlename;	

						$treeData[$i]['name']  		= $row->name;	

						$treeData[$i]['type'] 		= $row->type;	

						$treeData[$i]['userId']  	= $row->userId;	

						$treeData[$i]['createdDate']= $row->createdDate;	

						$treeData[$i]['editedDate'] = $row->editedDate;	

						$treeData[$i]['workspaces'] = $row->workspaces;	

						$treeData[$i]['company']  	= $row->company;	

						$treeData[$i]['nodes']  	= $row->nodes;	

						$treeData[$i]['treeVersion']= $row->treeVersion;

						$treeData[$i]['isShared'] 		= $row->isShared;

						$i++;

					}

				}

			}

			else

			{ 
				//print_r ($query->result()); exit;
				foreach ($query->result() as $row)

				{				
					if($row->isShared==1 || ($row->sharedStatus == 1 && $userGroup>0) || ($workspaces == $row->workspaces && $row->sharedStatus == 2 && $row->userId == $_SESSION['userId']))

					{

						$treeData[$i]=array();

						$treeData[$i]['id'] 		= $row->id;	
						
						$treeData[$i]['firstname']  		= $row->firstname;	
						
						$treeData[$i]['lastname']  		= $row->lastname;	

						$treeData[$i]['name']  		= $row->name;	

						$treeData[$i]['type'] 		= $row->type;	

						$treeData[$i]['userId']  	= $row->userId;	

						$treeData[$i]['createdDate']= $row->createdDate;	

						$treeData[$i]['editedDate'] = $row->editedDate;	

						$treeData[$i]['workspaces'] = $row->workspaces;	

						$treeData[$i]['nodes']  	= $row->nodes;	

						$treeData[$i]['company']  	= $row->company;	

						$treeData[$i]['treeVersion']= $row->treeVersion;

						$treeData[$i]['isShared'] 		= $row->isShared;

						$i++;

					}

				}

			}		

		} 

		return $treeData;	 

	}

	

	public function getlatestContactDetails($treeId){

		$treeData	= array();

		

		$query = $this->db->query( "SELECT a.*, b.name,b.isShared,b.userId,b.createdDate FROM teeme_contact_info a, teeme_tree b  WHERE (a.succesor ='' or a.succesor =0 or a.succesor is Null ) and b.id=a.treeId and a.treeId=".$treeId);		

		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['id'] 		= $row->id;

				$treeData['userId'] 	= $row->userId;	

				$treeData['treeId']  = $row->treeId;

				$treeData['name']  = $row->name;	

				$treeData['firstname']  = $row->firstname;	

				$treeData['lastname'] 		= $row->lastname;	

				$treeData['middlename']  	= $row->middlename;	

				$treeData['title'] = $row->title;	

				$treeData['designation']  = $row->designation;	

				$treeData['company'] = $row->company;

				$treeData['website'] = $row->website;

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

				$treeData['isShared'] 		= $row->isShared;

				$treeData['createdDate'] 		= $row->createdDate;

				

				 

 			}

		} 

		return $treeData;

	}

	

	//this method is for getting contact details using node ID

	public function getContactDetailsByNode($node, $treeId=0){

		$treeData	= array();

		//Added by Dashrath : code start
		if($treeId > 0)
		{
			$query = $this->db->query( "SELECT * FROM teeme_contact_info  WHERE treeId=".$treeId);
		}
		else
		{
			$query = $this->db->query( "SELECT * FROM teeme_contact_info  WHERE id=".$node);
		}
		//Dashrath : code end		

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

				$treeData['website']  = $row->website;	 

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

		

		if($workspaceId > 0)

		{	
			/*Changed by Dashrath- add b.leafStatus and a.leafId column in query for delete feature*/
			$query = $this->db->query( "SELECT a.id as nodeId, a.predecessor,a.successors, b.contents, b.userId,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate, b.leafStatus, a.leafId  FROM teeme_node a, teeme_leaf b  WHERE  b.id=a.leafId and a.treeIds=".$treeId." order by b.createdDate DESC");		

		}

		else

		{
			/*Changed by Dashrath- add b.leafStatus and a.leafId column in query for delete feature*/
			$query = $this->db->query( "SELECT a.id as nodeId, a.predecessor,a.successors, b.contents, b.userId,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate ,DATE_FORMAT(b.editedDate, '%Y-%m-%d %H:%i:%s') as editedDate, b.leafStatus, a.leafId  FROM teeme_node a, teeme_leaf b  WHERE  b.id=a.leafId and a.treeIds=".$treeId." order by b.createdDate DESC");		

		}		

		if($query->num_rows() > 0)

		{

			$row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData[$start]['nodeId'] 		= $row->nodeId;	

				$treeData[$start]['predecessor']  	= $row->predecessor;	

				$treeData[$start]['successors']  	= $row->successors;	

				$treeData[$start]['contents'] 		= $row->contents;	

				$treeData[$start]['userId']  		= $row->userId;	

				$treeData[$start]['createdDate'] 	= $row->createdDate;	

				$treeData[$start]['editedDate'] 	= $row->editedDate;

				if($row->editedDate==0)

					{ 

						$treeData[$start]['orderingDate'] = $row->createdDate;	

					}	

					else

					{

						$treeData[$start]['orderingDate'] = $row->editedDate;	

					}	

				/*Changed by Dashrath- add leafStatus and leafId column in array for delete feature*/
				$treeData[$start]['leafStatus'] 	= $row->leafStatus;	

				$treeData[$start]['leafId'] 	= $row->leafId;

				$start++;

 			}

		} 

		return $treeData;

	}

	

	

	//this method is for getting contact leaves with details

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

	

	// this method is for checking unique contact name

	public function checkUniqueContact($name)

	{

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query( "SELECT * FROM teeme_tree WHERE name='".$this->db->escape_str($name)."' and type=5");		

		if($query->num_rows() > 0)

		{

			return false;

		}else{

			return true;

		}

		 		

	}

	

	//this method is for getting user details using userId

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

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("update teeme_leaf set contents ='".$this->db->escape_str($note)."',userId='".$userId."',editedDate='".$date."' where nodeId=".$nodeId);



		if ($query)

			return 1;

		else

			return 0;			

	}

	

	

	function randomUserContactTagName($firstname,$lastname)

	{

		$tagName=$firstname."_".$lastname."_".rand(100,999);

		if($this->checkUniqueContact($tagName))

			return $tagName;

		else

		  randomUserContactTagName($firstname,$lastname);	 

	}

	

	//this is the method for generating unique contact name

	function generateaUniqueContactTagName($firstname,$lastname)

	{

		if($this->checkUniqueContact($lastname."_".$firstname))

		{

			return $lastname."_".$firstname;

		}

		elseif($this->checkUniqueContact($firstname."_".$lastname))

		{

			return $firstname."_".$lastname;

		}

		elseif($this->checkUniqueContact($lastname."".$firstname))

		{

			return $lastname."".$firstname;

		}

		elseif($this->checkUniqueContact($firstname."".$lastname))

		{

			return $firstname."".$lastname;

		}

		elseif($this->checkUniqueContact("_".$lastname."".$firstname))

		{

			return "_".$lastname."".$firstname;

		}

		else

		   return $this->randomUserContactTagName($firstname,$lastname);

		 	

	}

	//Added by Dashrath : code start
	public function getContactNoteBuyTreeId($treeId, $workspaceId, $workspaceType, $userId){


		$arrNodeIds = $this->getNodeIdsByTreeId($treeId, $workspaceId, $workspaceType, $userId);

		$i = 0;
		foreach ($arrNodeIds as $nodeId)
		{
			/*Changed by Dashrath- add b.leafStatus column in query*/
			$query = $this->db->query( "SELECT a.id as nodeId, a.predecessor,a.successors, b.contents, b.userId,  DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as createdDate, a.nodeOrder, b.leafStatus FROM teeme_node a, teeme_leaf b  WHERE b.id=a.leafId and a.id=".$nodeId."  ORDER BY a.id DESC");

			if($query->num_rows() > 0)
			{
				
				$row=$query->result();

				foreach ($query->result() as $row)
				{

					$treeData[$i]['nodeId'] 		= $row->nodeId;	

					$treeData[$i]['predecessor']  = $row->predecessor;	

					$treeData[$i]['successors']  = $row->successors;	

					$treeData[$i]['contents'] 		= $row->contents;	

					$treeData[$i]['userId']  	= $row->userId;	

					$treeData[$i]['createdDate'] = $row->createdDate;

					$treeData[$i]['nodeOrder'] = $row->nodeOrder;

					/*Added by Dashrath- add leafStatus column in array*/
					$treeData[$i]['leafStatus']  = $row->leafStatus;	

	 			}

			}
			$i++; 

		}

		return $treeData;
	}	
	//Dashrath : code end



}?>

