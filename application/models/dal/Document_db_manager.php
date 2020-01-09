<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: document_db_manager.php

	* Description 		  	: A class file used to handle teeme document functionalities with database

	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 04-08-2008				Nagalingam						Created the file.	

	* 28-08-2014				Parv						    Created the file.			

	**********************************************************************************************************/



/**

* A PHP class to access User Database with convenient methods

* with various operation Add, update, delete & retrieve document tree, node, leaf details

* @author   Ideavate Solutions (www.ideavate.com)

*/

// file that have the code for DBmanager class; 

//require('DBManager.php'); 

class document_db_manager extends CI_Model

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

	* This is the implmentation of the abstract method from the parent DBManager class .

	* @param $object This is the object that will get inserted into the database.

	* @return This function returns SQL query for addding new user into database.

	*/



	public function insertRecord($object, $option='tree', $nodeType = 0)

    {

		if($option == 'tree')

		{

			//Get data from the object and set it to according to their Database field name.

			//Inserting document tree details
			//Manoj: replace mysql_escape_str function
			// $strResultSQL = "INSERT INTO teeme_tree

			// 				 (

			// 				parentTreeId, name, type, userId, createdDate, editedDate, workspaces, workSpaceType, nodes, version, latestVersion, nodeType )

			// 				VALUES

			// 				(
							
			// 				'".$object->getParentTreeId()."','".$this->db->escape_str(addslashes($object->getTreeName()))."','".$object->getTreeType()."','".$object->getUserId()."','".$object->getCreatedDate()."','".$object->getEditedDate()."','".$object->getWorkspaces()."','".$object->getWorkSpaceType()."','".$object->getNodes()."','".$object->getTreeMainVersion()."','".$object->getTreeLatestVersion()."','".$nodeType."')";

			/*Changed by Dashraht- comment old query in above and add two paramter in new query (autonumbering, position)*/
			$strResultSQL = "INSERT INTO teeme_tree

							 (

							parentTreeId, name, type, userId, createdDate, editedDate, workspaces, workSpaceType, nodes, version, latestVersion, nodeType, autonumbering, position)

							VALUES

							(
							
							'".$object->getParentTreeId()."','".$this->db->escape_str(addslashes($object->getTreeName()))."','".$object->getTreeType()."','".$object->getUserId()."','".$object->getCreatedDate()."','".$object->getEditedDate()."','".$object->getWorkspaces()."','".$object->getWorkSpaceType()."','".$object->getNodes()."','".$object->getTreeMainVersion()."','".$object->getTreeLatestVersion()."','".$nodeType."','".$object->getAutonumbering()."','".$object->getDocumentPosition()."')";

		}

		//Inserting document node details 

		if($option == 'node')

		{

			

			$strResultSQL = "INSERT INTO teeme_node(predecessor, successors, leafId, tag, treeIds, nodeOrder, version

						)

						VALUES

						(

						'".$object->getNodePredecessor()."','".$object->getNodeSuccessor()."',".$object->getLeafId().",'".$object->getNodeTag()."','".$object->getNodeTreeIds()."','".$object->getNodeOrder()."','".$object->getVersion()."'

						)";

		}

		//Inserting document leaf details 

		if($option == 'leaf')

		{
			//Manoj: replace mysql_escape_str function
			$strResultSQL = "INSERT INTO teeme_leaf(type, authors, status, userId, createdDate,editedDate, contents, version, leafParentId, leafStatus)

						VALUES

						(

						'".$object->getLeafType()."','".$object->getLeafAuthors()."',".$object->getLeafStatus().",".$object->getLeafUserId().",'".$object->getLeafCreatedDate()."','".$object->getLeafCreatedDate()."','".$this->db->escape_str($object->getLeafContents())."','".$object->getLeafVersion()."','".$object->getLeafParentId()."','".$object->getLeafPostStatus()."'

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

			$query = $this->db->query('SELECT id FROM teeme_node WHERE treeIds='.$treeId);

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

	 /**

	* This is the implmentation of the abstract method from the parent DBManager class .

	* @param $object This is the object that will get updated into the database.

	* @return This function returns SQL query for updating teeme document details into database.

	*/



	public function updateRecord($object)

    {

		//This variable hold the query for insert menu information into Database.

		$strResultSQL = '';

		if($object != NULL)

		{		

			if($object instanceof tree)

			{

				//Get data from the object and set it to according to their Database field name.

				//Updating document tree details
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'UPDATE 

									teeme_tree 

								SET

									name = \''.$this->db->escape_str($object->getTreeName()).'\', 

									type = \''.$object->getTreeType().'\',	

									userId = \''.$object->getUserId().'\',

									createdDate = \''.$object->getCreatedDate().'\',

									workspaces = \''.$object->getWorkspaces().'\',

									workSpaceType = '.$object->getWorkSpaceType().',

									nodes = \''.$object->getNodes().'\'

								WHERE

									id = '.$object->getTreeId();

								

								

			}

			//Updating document node details 

			if($object instanceof node)

			{

				$strResultSQL = 'UPDATE 

									teeme_node 

								SET

									predecessor = \''.$object->getNodePredecessor().'\', 

									successors = \''.$object->getNodeSuccessor().'\',	

									leafId = \''.$object->getLeafId().'\',

									tag = \''.$object->getNodeTag().'\',

									treeIds = \''.$object->getNodeTreeIds().'\'									

								WHERE

									id = '.$object->getNodeId();				

			}

			//Updating document leaf details 

			if($object instanceof leaf)

			{
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'UPDATE 

									teeme_leaf 

								SET

									type = \''.$object->getLeafType().'\', 

									authors = \''.$object->getLeafAuthors().'\',	

									status = \''.$object->getLeafStatus().'\',

									userId = \''.$object->getLeafUserId().'\',

									createdDate = \''.$object->getLeafCreatedDate().'\',

									contents = \''.$this->db->escape_str($object->getLeafContents()).'\'									

								WHERE

									id = '.$object->getLeafId();							

			}								

		}

		else

		{

			$objMessage = new MessageManager();

			$bError=true;

			$objMessage->logMessage("Can not insert record",$objMessage->CC_FATAL_ALERT);

		}

		if(!$bError)

		{

			return $strResultSQL;

		}

	}

	 /**

	* This method will be used for fetch the tree Records from the database.

 	* @param $userId This is the variable used to hold the user ID .

	* @return The tree datas as an array

	*/

	public function getTreesByWorkSpaceId($workSpaceId, $workSpaceType, $type=1, $sortBy = 3, $sortOrder = 1)

	{

		$arrTree	= array();	

		

		

		if($workSpaceId != NULL)

		{

			// Get information of particular document

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

			if($workSpaceId == 0)

			{

				$where = 'a.userId = b.userId AND a.workspaces='.$workSpaceId.' AND (a.userId = '.$_SESSION['userId'].' OR a.isShared=1) AND a.type='.$type;				

			}

			else

			{

				$where = 'a.userId = b.userId AND a.workSpaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.' AND a.type='.$type;	

			}

			$q = 'SELECT a.*,date_format(a.createdDate,\'%Y-%m-%d %H:%i:%s\') as treeCreatedDate, date_format(a.editedDate,\'%Y-%m-%d %H:%i:%s\')  as treeEditedDate FROM teeme_tree a, teeme_users b WHERE '.$where.' AND latestVersion = 1'.$orderBy;

			$query = $this->db->query($q);

			

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

					$arrTree[$treeId]['workSpaces'] = $row->workspaces;

					$arrTree[$treeId]['nodes'] = $row->nodes;

					$arrTree[$treeId]['isShared'] = $row->isShared;	

							

				}				

			}

		}

		return $arrTree;				

	}



	 /**

	* This method will be used for fetch the tree Records from the database.

 	* @param $workSpaceId This is the variable used to hold the workspace ID .

	* @param $workSpaceType This is the variable used to hold theworkspace type .

	* @param $type This is the variable used to hold the artifact type.

	* @param $date This is the variable used to hold the required date

	* @return The tree datas as an array

	*/

	public function getTreesByDate($workSpaceId, $workSpaceType, $type, $date)

	{

		$arrTree	= array();	

		if($workSpaceId != NULL)

		{

			// Get information of particular document

			if($workSpaceId == 0)

			{

				$where = 'workspaces='.$workSpaceId.' AND userId = '.$_SESSION['userId'].' AND type='.$type.' AND date_format(createdDate, \'%Y-%m-%d\')=\''.$date.'\'';				

			}

			else

			{

				$where = 'workSpaces = \''.$workSpaceId.'\' AND workSpaceType= '.$workSpaceType.' AND type='.$type.' AND date_format(createdDate, \'%Y-%m-%d\')=\''.$date.'\'';	

			}

			$query = $this->db->query('SELECT 

								*,date_format(createdDate, \'%Y-%m-%d %H:%i:%s\') as treeCreatedDate FROM teeme_tree WHERE '.$where.' ORDER BY createdDate DESC');

			if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$treeId		= $row->id;		

										

					$arrTree[$treeId]['name'] = $row->name;	

					$arrTree[$treeId]['type'] = $row->type;	

					$arrTree[$treeId]['userId'] = $row->userId;

					$arrTree[$treeId]['createdDate'] = $row->treeCreatedDate;

					$arrTree[$treeId]['editedDate'] = $row->editedDate;

					$arrTree[$treeId]['workSpaces'] = $row->workspaces;

					$arrTree[$treeId]['nodes'] = $row->nodes;	

							

				}				

			}

		}

		return $arrTree;				

	}



	 /**

	* This method will be used for fetch the tree nodes from the database.

 	* @param $workSpaceId This is the variable used to hold the workspace ID .

	* @param $workSpaceType This is the variable used to hold theworkspace type .

	* @param $artifactType This is the variable used to hold the artifact type.

	* @param $date This is the variable used to hold the required date

	* @param $artifactTreeId This is the variable used to hold the artifact tree id

	* @return The tree datas as an array

	*/

	public function getTreeNodesByDate($workSpaceId, $workSpaceType,$artifactType,$date,$artifactTreeId)

	{

		$arrNodes	= array();	

		if($workSpaceId != NULL)

		{

			// Get information of particular document

			$query = $this->db->query('SELECT 

								b.*, date_format(b.createdDate, \'%Y-%m-%d %H:%i:%s\') as leafCreatedDate FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\' AND date_format(b.createdDate, \'%Y-%m-%d\')=\''.$date.'\' ORDER BY b.createdDate DESC');

			if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$leafId								= $row->id;										

					$arrNodes[$leafId]['leafParentId'] 	= $row->leafParentId;	

					$arrNodes[$leafId]['type'] 			= $row->type;	

					$arrNodes[$leafId]['status'] 		= $row->status;

					$arrNodes[$leafId]['userId'] 		= $row->userId;

					$arrNodes[$leafId]['createdDate'] 	= $row->leafCreatedDate;					

					$arrNodes[$leafId]['contents'] 		= $row->contents;

					$arrNodes[$leafId]['latestContent'] = $row->latestContent;	

					$arrNodes[$leafId]['version'] 		= $row->version;	

					$arrNodes[$leafId]['nodeId'] 		= $row->nodeId;			

				}				

			}

		}

		return $arrNodes;				

	}



	

 /**

	* This method will be used for fetch the tree details from the database.

 	* @param $workSpaceId This is the variable used to hold the workspace ID .


	* @param $workSpaceType This is the variable used to hold the workspace type .

	* @param $type This is the variable used to hold the tree type.

	* @param $start This is the variable used to hold the tree start record.

	* @param $totalRecords This is the variable used to hold the required record details.

	* @return The tree ids as an array

	*/

	public function getTreeDetailsByWorkSpaceId($workSpaceId, $workSpaceType, $type=1, $start = 0, $totalRecords = 0)

	{

		$treeDetails	= array();	

		$limit	= '';

		if($totalRecords > 0)

		{

			$limit = ' LIMIT '.$start.','.$totalRecords;

		}

		if($workSpaceId != NULL)

		{

			// Get information of particular document

			if($workSpaceId == 0)

			{

				$where = 'workspaces='.$workSpaceId.' AND userId = '.$_SESSION['userId'].' AND type='.$type;				

			}

			else

			{

				$where = 'workspaces = \''.$workSpaceId.'\' AND workSpaceType= '.$workSpaceType.' AND type='.$type;	

			}	

			if($type == 3)

			{		

				$curTime = date('Y-m-d H:i:s');

				// Get information of particular document

				if($workSpaceId > 0)

				{

					$query = $this->db->query('SELECT 

									a.id, a.name FROM teeme_tree a,teeme_chat_info b WHERE a.id = b.treeId AND a.embedded=0 AND a.workSpaces = \''.$workSpaceId.'\' AND a.workSpaceType= \''.$workSpaceType.'\' AND a.type=3 AND b.starttime<\''.$curTime.'\' AND b.endtime>\''.$curTime.'\' ORDER BY a.createdDate DESC');

				}

				else

				{

					$query = $this->db->query('SELECT 

									a.id, a.name FROM teeme_tree a,teeme_chat_info b WHERE a.id = b.treeId AND a.embedded=0 AND a.userId = '.$_SESSION['userId'].' AND a.workSpaces = \'0\' AND a.type=3 AND b.starttime<\''.$curTime.'\' AND b.endtime>\''.$curTime.'\' ORDER BY a.createdDate DESC');

				}

			}

			else

			{

				$query = $this->db->query('SELECT id, name FROM teeme_tree WHERE '.$where.' AND latestVersion=1 AND embedded=0 AND name not like(\'untile%\') AND name <>\' \' ORDER BY editedDate DESC'.$limit);				

			}	

			if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$treeDetails[$row->id] 		= $row->name;					

				}				

			}

		}

		//echo "<li>q= " .$q; exit;

		return $treeDetails;				

	}



	/**

	* This method will be used for fetch the tree details from the database.

 	* @param $workSpaceId This is the variable used to hold the workspace ID .

	* @param $workSpaceType This is the variable used to hold the workspace type .

	* @param $type This is the variable used to hold the tree type.

	* @param $start This is the variable used to hold the tree start record.

	* @param $totalRecords This is the variable used to hold the required record details.

	* @return The tree ids as an array

	*/

	public function getTreeDetailsByWorkSpacesId($workspaces, $subWorkspaces, $type=1, $start = 0, $totalRecords = 0)

	{

		$treeDetails	= array();	

		$limit	= '';

		if($totalRecords > 0)

		{

			$limit = ' LIMIT '.$start.','.$totalRecords;

		}

		if($workspaces != NULL)

		{

			// Get information of particular document			

			$where = '((workspaces IN('.$workspaces.') AND workSpaceType= 1) OR (userId = '.$_SESSION['userId'].' AND workSpaces = \'0\')) AND type='.$type;				

			if($type == 3)

			{		

				$curTime = date('Y-m-d H:i:s');

				// Get information of particular document				

				$query = $this->db->query('SELECT 

								a.id, a.name, a.workspaces, a.workSpaceType FROM teeme_tree a,teeme_chat_info b WHERE a.id = b.treeId AND a.embedded=0 AND ((a.workspaces IN('.$workspaces.') AND a.workSpaceType= 1) OR (a.userId = '.$_SESSION['userId'].' AND a.workSpaces = \'0\')) AND a.type=3 AND b.starttime<\''.$curTime.'\' AND b.endtime>\''.$curTime.'\' ORDER BY a.createdDate DESC');				

				

			}

			else

			{

				$query = $this->db->query('SELECT id, name, workspaces, workSpaceType FROM teeme_tree WHERE '.$where.' AND embedded=0 AND name <>\' \' ORDER BY createdDate DESC'.$limit);				

			}	

			

			if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$treeDetails[$row->id]['name'] 				= $row->name;		

					$treeDetails[$row->id]['workspaceId'] 		= $row->workspaces;		

					$treeDetails[$row->id]['workspaceType'] 	= $row->workSpaceType;			

				}				

			}

		}

		return $treeDetails;				

	}



	/**

	* This method will be used for fetch the tree details from the database.

 	* @param $treeId This is the variable used to hold the tree ID.	

	* @return the first leaf details of the tree

	*/

	public function getFirstLeafInfoByTreeId($treeId)

	{

		$leafDetails	= '';						

		$query = $this->db->query('SELECT b.contents FROM teeme_node a, teeme_leaf b WHERE a.leafId = b.id AND a.treeIds =\''.$treeId.'\'');

		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{	

				$leafDetails 		= $row->contents;					

			}				

		}		

		return $leafDetails;				

	}

	

	 /**

	* This method will be used for fetch the tree ids from the database.

 	* @param $workSpaceId This is the variable used to hold the workspace ID .

	* @param $workSpaceType This is the variable used to hold the workspace type .

	* @return The tree ids as an array

	*/

	public function getTreeIdsByWorkSpaceId($workSpaceId, $workSpaceType, $type=1)

	{

		$treeIds	= array();	

		if($workSpaceId != NULL)

		{

			// Get information of particular document

			if($workSpaceId == 0)

			{

				$where = 'workspaces='.$workSpaceId.' AND userId = '.$_SESSION['userId'].' AND type='.$type;				

			}

			else

			{

				$where = 'workSpaces = \''.$workSpaceId.'\' AND workSpaceType= '.$workSpaceType.' AND type='.$type;	

			}

			$query = $this->db->query('SELECT id FROM teeme_tree WHERE '.$where.' ORDER BY createdDate DESC');

			if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$treeIds[] = $row->id;			

				}				

			}

		}

		return $treeIds;				

	}



	 /**

	* This method will be used for fetch the leaf contents from the database.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @return The leaf contents as an array

	*/

	public function getLeafContentsByTreeId($treeId)

	{

		$arrLeafDetails = array();

		if($treeId != NULL)

		{

			// Get information of particular document

			$query = $this->db->query('SELECT a.*, b.* 

										FROM teeme_leaf a, teeme_node b 

										WHERE a.id=b.leafId AND b.treeIds='.$treeId);

			if($query->num_rows() > 0)

			{

				foreach ($query->result() as $leafData)

				{	

					$arrLeafDetails[$leafData['leafId']]['contents'] = $leafData->contents;

					$arrLeafDetails[$leafData['leafId']]['version'] = $leafData->version;	

				}

			}

		}

		return $arrLeafDetails;

	}







	/**

	* This method will be used for count the no of leafs on particular tree id.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @return the total leaf count

	*/

	public function getLastLeafDetailsByTreeId($treeId)

	{	

		$leafDetails = array();

		$query = $this->db->query('SELECT 

			a.id as leafId, b.nodeOrder, b.id as nodeId FROM teeme_leaf a, teeme_node b, teeme_users c WHERE a.userId=c.userId AND a.id=b.leafId AND b.treeIds='.$treeId.' AND a.latestContent=0 AND b.successors=0');								

		$totalLeafs = $query->num_rows();

		$leafDetails['totalLeafs'] = $totalLeafs;

	

		$query = $this->db->query('SELECT 

			a.id as leafId, b.nodeOrder, b.id as nodeId FROM teeme_leaf a, teeme_node b, teeme_users c WHERE a.userId=c.userId AND a.id=b.leafId AND b.treeIds='.$treeId.' AND a.latestContent=0 AND b.successors=\'0\' ORDER BY b.nodeOrder DESC LIMIT 0,1');								

		$totalLeafs = $query->num_rows();

		foreach($query->result() as $leafData)

		{

			$leafDetails['nodeId'] = $leafData->nodeId;	

			$leafDetails['leafId'] = $leafData->leafId;	

			$leafDetails['leafOrder'] = $leafData->nodeOrder;	

		}

		return $leafDetails;

	}



	 /**

	* This method will be used for fetch the leaf and node ids from the database.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @return The leaf and node ids as an array

	*/

	public function getNodeLeafIdsByTreeId($treeId)

	{

		$arrIdDetails = array();

		if($treeId != NULL)

		{

			// Get information of particular document

			$query = $this->db->query('SELECT 

			a.id as teemLeafId, b.id as teemeNodeId FROM teeme_leaf a, teeme_node b WHERE a.id=b.leafId AND b.treeIds='.$treeId);

			if($query->num_rows() > 0)

			{

				$i = 0;	

				foreach ($query->result() as $leafData)

				{			

					$arrIdDetails[$i]['nodeId'] = $leafData->teemeNodeId;

					$arrIdDetails[$i]['leafId'] = $leafData->teemLeafId;

					$i++;			

				}

			}

		}

		return $arrIdDetails;

	}

	// Get Leaf Tree id by Leaf Id

	public function getLeafTreeIdByLeafId ($leafId,$type=2)

	{

		$leafTreeId	= '';	

				

		$query = $this->db->query("SELECT tree_id FROM teeme_leaf_tree WHERE leaf_id = '".$leafId."' AND type='".$type."'");



		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{	

				$leafTreeId = $row->tree_id;					

			}				

		}		

		return $leafTreeId;	

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

	/**

	* This method will be used for fetch the previous leaf contents from the database.

 	* @param $leafId This is the variable used to hold the leaf ID.

	* @param $childLeafId This is the variable used to hold the child leaf ID.

	* @param $divId This is the variable used to hold the div id to refresh the contents.	

	* @return The leaf's previous leaf contents

	*/

	public function getLeafPreviousContentsByLeafId($arrParams)

	{

		error_reporting(0);

		$leafId 		= $arrParams['leafParentId'];

		$childLeafId 	= $arrParams['leafId'];

		$curLeafId 		= $arrParams['curLeafId'];

		$leafOrder 		= $arrParams['leafOrder'];

		$treeId 		= $arrParams['treeId'];

		$workSpaceId 	= $arrParams['workSpaceId'];

		$workSpaceType 	= $arrParams['workSpaceType'];	

		$bgColor		= $arrParams['bgcolor'];

		$nodeId		 	= $arrParams['nodeId'];

		

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();	

		$memCacheId 	= 'wp'.$_SESSION['workPlaceId'].'doc'.$treeId;	

		$value 			= $memc->get($memCacheId);

		$strContents	= '';



		if(!$value)

		{				
			/*Changed by Dashrath - replace this query by call getDocumentFromDB function */
			// $tree 	= array();		

			// $query 	= $this->db->query('SELECT a.*, a.version as leafVersion, b.*,b.id as nodeId1, a.id as leafId1, c.firstName, c.lastName, c.userName, c.tagName FROM teeme_leaf a, teeme_node b, teeme_users c WHERE a.userId=c.userId AND a.id=b.leafId AND b.treeIds='.$treeId.' ORDER BY b.nodeOrder');

			

			// foreach($query->result() as $docData)

			// {

			// 	$tree[] = $docData;

			// }

			$tree = $this->getDocumentFromDB($treeId);	

			$memc->set($memCacheId, $tree);

			$value = $tree;			

			

	

		}	

			

		if ($value)

		{	

		

			$strContents	= '';			

			$i = 1;	

			$artifactLink = '';	

			//to get published leaf for unreserved users
			$value = array_reverse($value);

			//Sort an array by edited date descending
			foreach ($value as $key => $lfData) {
				$timestamps[$key]=strtotime($lfData->editedDate) ;
			}
			array_multisort($timestamps, SORT_DESC, $value);
			//Code end
			//return $value;	
			
			$contributors = $this->getDocsContributors($treeId);

			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
			
			$treeOriginatorId	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);
	
			foreach ($value as $leafData)
			{		
		
				$leafParentData = $this->getLeafParentIdByNodeOrder($leafData->treeIds, $leafData->nodeOrder);
				$leafReserveStatus = $this->getLeafReserveStatus($leafData->treeIds,$leafParentData['parentLeafId']);
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->getDocsReservedUsers($leafParentData['parentLeafId']);
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}	
				
				/*
				if($leafData->nodeId1 == $leafId)
				*/

				if(($leafData->nodeId1 == $leafId && ($leafData->leafStatus == 'publish')) || ($leafData->leafStatus == 'draft' && in_array($_SESSION['userId'], $resUserIds) && $leafData->leafId1 < $curLeafId && $leafOrder == $leafData->nodeOrder) || ($leafData->leafStatus == 'publish' && $leafData->leafId1 < $curLeafId && $leafOrder == $leafData->nodeOrder) || ($leafData->nodeId1 == $leafId && ($leafData->leafStatus == 'deleted')))

				{	
				
					if($leafData->treeIds!='' && $leafData->nodeOrder!='')
					{
						$prevLeafData = $this->getDraftStatusByNodeOrder($leafData->treeIds,$leafData->nodeOrder);
						$previousPublishLeafId = $prevLeafData['prevPublishLeafId'];
					}

					$xdoc 			= new DomDocument;

					$tmpText		= str_replace('<o:p>','',$leafData->contents);

					$tmpText		= str_replace('</o:p>','',$tmpText);		

					$strData		= '<div id="tmp'.$i.'">'.htmlspecialchars_decode($tmpText).'</div>';					

					$xml 			= $xdoc->loadHTML($strData);						

					$nodeVal  		= substr($xdoc->getElementsByTagName('div')->item(0)->nodeValue, 0, 700);	

											

					$timeTags 	= $this->tag_db_manager->getTags(1, $_SESSION['userId'], $leafData->leafId, 2);

					$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $leafData->nodeId1, 2);

					$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $leafData->nodeId1, 2);

					$createTags	= $this->tag_db_manager->getTags(4, $_SESSION['userId'], $leafData->nodeId1, 2);

					$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $leafData->nodeId1, 2);

					$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $leafData->nodeId1, 2);

								

					$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 1, 2);

					$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 2, 2);

					$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 3, 2);

					$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 4, 2);

					$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 5, 2);

					$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 6, 2);

					//previous external and url applied link count
					$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($leafData->nodeId1, 2);

					/*Added by Dashrath- used for display linked folder count*/
					$docTrees10 	=$this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($leafData->nodeId1, 2);
					/*Dashrath- code end*/	
					
					$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($leafData->nodeId1, 2);		

					$latestVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($leafData->treeIds);

					$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($leafData->leafId);

					$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId);

				

				



		

				if (!empty($leafTreeId))	

				{



				}				



				$headerContent='';

				if($leafData->leafVersion <10)

				{

					//$leafVersion = '00'.$leafData->leafVersion;	
					$leafVersion = $leafData->leafVersion;

				}

				else if($leafData->leafVersion >=10 && $leafData->leafVersion <100)

				{

					//$leafVersion = '0'.$leafData->leafVersion;
					$leafVersion = $leafData->leafVersion;	

				}

				else

				{

					$leafVersion = $leafData->leafVersion;	

				}
				
				//Code for draft reservation icon
				/*if($leafData->leafStatus == 'draft'){ 
					$headerContent.= '<span class="draft_txt">'.$this->lang->line("txt_draft").'</span>';
				} */
				//Draft text view end
				
				//if($latest==1 && $leafOwnerData['userId'] == $_SESSION['userId'] && $leafData->leafStatus == 'draft')
				//if($leafParentData['parentLeafUserId']== $_SESSION['userId'])
				/*if(in_array($_SESSION['userId'],$contributorsUserId))
				{*/
					$reserveImg = '';
					$resTitle = '';
					//if($leafReserveStatus==1)
					if(count($reservedUsers)==0)
					{
						$reserveImg = '<img src="'.base_url().'images/emptyReserve.png" border="0">';
						$resTitle = 'Unreserved';
					}
					else
					{
						$reserveImg = '<img src="'.base_url().'images/reserve.png" border="0">';
						$resTitle = 'Reserved';
					}
					//if(($_SESSION['userId']==$treeOriginatorId && $leafReserveStatus==1) || ($leafReserveStatus!='1'))
					if(($_SESSION['userId']==$treeOriginatorId && count($reservedUsers)==0) || (count($reservedUsers)!=0))
					{
						$display = 'display:block;';
					}
					else
					{
						$display = 'display:none;';
					}
						
					//changed start by dashrath- commented old code and add new code for new ui 
					// $headerContent.= '<span class="reserve"><a id="liReserve'.$leafParentData['parentLeafId'].'" href="javaScript:void(0)" onClick="showPopWin(\''.base_url().'comman/getDocReservedCountributors/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$leafParentData['parentNodeId'].'/'.$leafData->nodeId1.'\', 600, 350, null, \'\');" title="'.$resTitle.'" border="0" style="'.$display.'">'.$reserveImg.'</a></span>';
					$reserveHeaderContent = '<span class="documentSeedLeafSpanRight"><a id="liReserve'.$leafParentData['parentLeafId'].'" href="javaScript:void(0)" onClick="showPopWin(\''.base_url().'comman/getDocReservedCountributors/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$leafParentData['parentNodeId'].'/'.$leafData->nodeId1.'\', 600, 350, null, \'\');" title="'.$resTitle.'" border="0" style="'.$display.'">'.$reserveImg.'</a></span>';
					//changed end by dashrath
					
				/*}*/
				//Code for draft reservation icon end

				if($leafData->predecessor > 0)

				{												
					/*Added by Dashrath- add previousVersionNewUi and versionIconNewUi class and add &nbsp and float left for new ui */

					if($leafData->leafStatus=='draft')
					{
						$headerContent.='<a href="javascript:void(0)" class="previousVersionNewUi" style="text-decoration:none;" onClick="showLeafPrevious('.$leafData->nodeId1.','.$leafData->predecessor.','.$leafData->leafVersion.',\''.$leafData->leafId.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$bgColor.'\',\''.$nodeId.'\')"><img src="'.base_url().'images/left.gif" border="0" class="versionIconNewUi"> </a> </a> <span class="clsLabel" style="font-style: normal; float:left;"></span>';
					}
					else
					{
						$headerContent.='<a href="javascript:void(0)" class="previousVersionNewUi" style="text-decoration:none;" onClick="showLeafPrevious('.$leafData->nodeId1.','.$leafData->predecessor.','.$leafData->leafVersion.',\''.$leafData->leafId.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$bgColor.'\',\''.$nodeId.'\')"><img src="'.base_url().'images/left.gif" border="0" class="versionIconNewUi"> </a> </a> <span class="clsLabel" style="font-style: normal; float:left;">&nbsp;&nbsp;Version '.$leafVersion.'</span>';
					}

				}

				else

				{												

					//$headerContent.=$leafVersion;
					/*Changed by Dashrath- add float:left and padding-left:20pxfor new ui */
					if($leafData->leafStatus=='draft')
					{

						$headerContent.='<span class="clsLabel" style="font-style: normal; float:left; padding-left: 20px;"></span>';
					}
					else
					{
						$headerContent.='<span class="clsLabel" style="font-style: normal; float:left; padding-left: 20px;">Version '.$leafVersion.'</span>';
					}

				}

				

				if($leafData->successors != 0 )

				{
				
					$draftResUserIds == array();
					//Get next publish status for showing next icon
					$nextPubLeafStatus = $this->getNextLeafPublishStatus($leafData->treeIds, $leafData->nodeOrder, $leafData->leafId1);	
					
					$childLeafId = $leafData->successors;		

					/*Changed by Dashrath- add versionIconNewUi class and &nbsp for new ui */		
					/*Commented by Dashrath- Add new code below for show draft leaf for contributor when no reserved list*/						
					// if($nextPubLeafStatus == 'publish' || $nextPubLeafStatus == 'deleted' || ($nextPubLeafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds))))
					// $headerContent.=' &nbsp;&nbsp;<a href="javascript:void(0)" style="text-decoration:none" onClick="showLeafNext('.$leafData->leafId1.','.$childLeafId.','.$leafData->version.',\''.$leafData->leafId1.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$bgColor.'\',\''.$nodeId.'\')"><img src="'.base_url().'images/right.gif" border="0" class="versionIconNewUi"></a>';

					if($nextPubLeafStatus == 'publish' || $nextPubLeafStatus == 'deleted' || ($nextPubLeafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds))) || ($nextPubLeafStatus == 'draft' && (in_array($_SESSION['userId'], $contributorsUserId))))
					$headerContent.=' &nbsp;&nbsp;<a href="javascript:void(0)" style="text-decoration:none" onClick="showLeafNext('.$leafData->leafId1.','.$childLeafId.','.$leafData->version.',\''.$leafData->leafId1.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$bgColor.'\',\''.$nodeId.'\')"><img src="'.base_url().'images/right.gif" border="0" class="versionIconNewUi"></a>';												

				}

				else

				{

					$_SESSION['set_doc_latest_version']=1; 

				}



				if (($this->document_db_manager->hasSuccessor ($leafData->leafId1) == 0) && ($latestVersion==1) )

					$latest = 1;

				else

					$latest = 0;

	
				if($previousPublishLeafId!='' && $previousPublishLeafId==$leafData->leafId1 && $latestVersion==1)
				{
					$latest = 1;
				}
					

				$strContents.= ''.$headerContent.'';

					

				 $strContents.= '|||'; 

				if ($leafData->leafStatus=='deleted')
				{
					$strContents.='<span class="clearedLeafContent">'.$this->lang->line('txt_content_deleted').'</span>'.'|||'.$this->lang->line('txt_content_deleted');	
				}
				else
				{	
					$strContents.=stripslashes($leafData->contents).'|||'.stripslashes($leafData->contents);	
				}
				//$strContents.=stripslashes($leafData->contents).'|||'.stripslashes($leafData->contents);	
				$strContents.= '|||'.$nodeVal.'|||'.$latest.'|||';

				

				if($leafData->leafStatus == 'draft'){
					/*Changed by Dashrath- add draftLi class for new ui */ 
					$strContents.= '<li class="draftLi" id="draftTxt'.$leafData->nodeId1.'"><span class="draft_txt">'.$this->lang->line("txt_draft").'</span></li>';
				}

				

				if(1)

				{

										

					$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);

					if($total==0)

					{

						$total='';

						$tag_container=$this->lang->line('txt_Tags_None');

					}

					else

					{

						 if(count($viewTags)>0)

						 {

							$tag_container='Simple Tag : ';

							foreach($viewTags as $simpleTag)

							$tag_container.=$simpleTag['tagName'].", ";

							$tag_container=substr($tag_container, 0, -2).

"";							 

						}					

						if(count($actTags) > 0)

						{

							   $tag_container.='Action Tag : ';

								$tagAvlStatus = 1;	

								foreach($actTags as $tagData)

								{	$dispResponseTags='';

									$dispResponseTags = $tagData['comments']."[";							

									$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);

									if(!$response)

									{  

										

										if ($tagData['tag']==1)

											$dispResponseTags .= $this->lang->line('txt_ToDo');									

										if ($tagData['tag']==2)

											$dispResponseTags .= $this->lang->line('txt_Select');	

										if ($tagData['tag']==3)

											$dispResponseTags .= $this->lang->line('txt_Vote');

										if ($tagData['tag']==4)

											$dispResponseTags .= $this->lang->line('txt_Authorize');															

									}

									$dispResponseTags .= "], ";	

														

									

									

									$tag_container.=$dispResponseTags;

								}

								

								$tag_container=substr($tag_container, 0, -2).

""; 

							}

															

						if(count($contactTags) > 0)

						{

									$tag_container.='Contact Tag : ';

									$tagAvlStatus = 1;	

									foreach($contactTags as $tagData)

									{

										

										$tag_container .= strip_tags($tagData['contactName'],'').", ";	

										

									}

									

									$tag_container=substr($tag_container, 0, -2); 

								}	

					}

				

				$tagclass='';	
				/*Changed by Dashrath- add else condition and add class in if condition for new ui */
				if(($latest==1) || ($latest==0 && $total!='' ))

				{

				  $tagclass='class="tag"';

				  $liClass = 'class="tagLinkTalkSeedLeafIcon"';

				}
				else{
					$liClass = 'class="tagLinkTalkSeedLeafIconPreviousLi"';
				}

					
				/*Changed by Dashrath- add tagLinkTalkSeedLeafIcon class for new ui */ 
				$strContents.='<li '.$liClass.'><a id="liTag'.$leafData->nodeId1.'" '.$tagclass.'   onClick="showPopWin(\''.base_url().'add_tag/index/'.$workSpaceId.'/'. $workSpaceType.'/'. $leafData->nodeId1.'/2/'.$latest.'\', 710, 480, null, \'\');" href="javascript:void(0);" title="'. strip_tags($tag_container,'').'"  ><strong>'.$total.'</strong></a></li>';	

			

			 

			
				/*Changed by Dashrath- add $docTrees10 for total*/
				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9)+sizeof($docTrees10);

				

				$appliedLinks=' ';

				

				if($total==0)

				{

						$total='';

						$appliedLinks=$this->lang->line('txt_Links_None') ;

				}

				else

				{

						 

						   

						   if(count($docTrees1)>0)

						   {

							   $appliedLinks .= $this->lang->line('txt_Document').': ';

							   foreach($docTrees1 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

							}	

							

							

							 if(count($docTrees3)>0)

						   {

								$appliedLinks.=$this->lang->line('txt_Chat').': ';	

								foreach($docTrees3 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

							}	

							

							if(count($docTrees4)>0)

							{

							

								$appliedLinks.=$this->lang->line('txt_Task').': ';	

								foreach($docTrees4 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

							}	

							

							if(count($docTrees6)>0)

							{

								$appliedLinks.=$this->lang->line('txt_Notes').': ';	

								foreach($docTrees6 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

								}

							}

							

							if(count($docTrees5)>0)

							{

							

								$appliedLinks .=$this->lang->line('txt_Contacts').': ';	

								foreach($docTrees5 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

							

							}

							

							if(count($docTrees7)>0)

							{

							
								/*Commented by Dashrath- extra foreach loop commented because link title repeted*/
								// $appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	

								// foreach($docTrees7 as $key=>$linkData)

							 //   {

									 

								$appliedLinks .=$this->lang->line('txt_Files').': ';	

								foreach($docTrees7 as $key=>$linkData)

							   {

							         

									 if($linkData['docName']=='')

									 {

									    $appliedLinks.=$this->lang->line('txt_Files')."_v".$linkData['version'].", ";

									 }

									 else

									 {
									 	/*Changed by Dashrath- Comment old code and add new below after changes */
									 	// $appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
									 	$appliedLinks.=$linkData['docName'].", ";

									 }

									

								}

							

								// }

							}

							/*Added by Dashrath- used for display linked folder name*/
							if(count($docTrees10)>0)
							{
								$appliedLinks .=$this->lang->line('txt_Folders').': ';	

								foreach($docTrees10 as $key=>$linkData)
							    {							      
									if($linkData['folderName']!='')
									{
									  
									 	$appliedLinks.=$linkData['folderName'].", ";
									}
								}
							}
							/*Dashrath- code end*/		
							
							if(count($docTrees9	)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	
								
								foreach($docTrees9 as $key=>$linkData)
							    {
									 $appliedLinks.=$linkData['title'].", ";
									
								}
								
							}

							

							$appliedLinks=substr($appliedLinks, 0, -2); 

						

					}

				

				$linkclass='class="disblock"';	

				/*Changed by Dashrath- add else condition and add class in if condition for new ui */
				if(($latest==1) || ($latest==0 && $total!='' ))

				{

				  $linkclass='class="link disblock"';

				  $liClass = 'class="tagLinkTalkSeedLeafIcon"';

			    }
			    else{
			    	$liClass = 'class="tagLinkTalkSeedLeafIconPreviousLi"';
			    }	

					
			    /*Changed by Dashrath- add liClass variable for new ui */ 
				$strContents.='<li '.$liClass.'><a id="liLink'.$leafData->nodeId1.' "  '.$linkclass.'  onClick="showPopWin(\''.base_url().'show_artifact_links/index/'.$leafData->nodeId1.'/2/'.$workSpaceId.'/'.$workSpaceType.'/2/1/'.$latest.'\', 750, 430, null, \'\');" alt="'. $this->lang->line("txt_Links").'" title="'.strip_tags($appliedLinks).'" border="0" ><strong>'.$total.'</strong></a></li>';	

				 	

					

				$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($leafData->leafId1);  

				$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId); 

				

				

				$total='';

				/*<!--Added by Surbhi IV -->	*/

				$latestTalk='Talk';

				/*<!--End of Added by Surbhi IV -->	*/

				$ci =&get_instance();

				$ci->load->model('dal/discussion_db_manager');

				$ci->load->model("dal/time_manager");

 

				if (!empty($leafTreeId) && ($isTalkActive==1))

				{	

				$total=$ci->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);
				
					if($total==0)
					{
						$total='';
					}

				}

				/*<!-Added by Surbhi IV -->	*/

				$talk=$ci->discussion_db_manager->getLastTalkByTreeId($leafTreeId);

				if(strip_tags($talk[0]->contents))

				{

					$userDetails = $ci->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);

					$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails['userTagName']."\t\t".$ci->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));

				}

				else

				{

					$latestTalk='Talk';

				}

				/*<!--End of Added by Surbhi IV -->	*/	  

		

				$talkClass='';	

				/*Changed by Dashrath- add else condition for new ui */
				if(($latest==1) || ($latest==0 && $total!=0 ))

				{
				  /*Changed by Dashrath- add tagLinkTalkSeedLeafIcon class for new ui */
				  $talkClass='class="talk tagLinkTalkSeedLeafIcon"';

			    }
			    else
			    {
			    	$talkClass='class="tagLinkTalkSeedLeafIconPreviousLi"';
			    }

				/*<!--Cahnged title by Surbhi IV -->	*/
				
				/*window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'/0/'.$latest.'\' ,\'\',\'width=850,height=500,scrollbars=yes\')*/
				
							$leafdataContent=strip_tags($leafData->contents);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($leafData->contents, ENT_QUOTES);	
				if($_COOKIE['ismobile'])
				{
				
					$strContents.= ' <li '.$talkClass.' ><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'/0/'.$latest.'\' ,\'\',\'width=850,height=500,scrollbars=yes\')" title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
				
				}
				else
				{
					if($latest == 1)
					{
						$talkTreeIds = $treeId;
					}
					
					$strContents.= ' <li '.$talkClass.' ><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="talkOpen(\''.$leafTreeId.'\', \''.$workSpaceId.'\',\''.$workSpaceType.'\',\''.$talkTreeIds.'\',\''.$talkTitle.'\',\'0\',\'\',\''.$leafData->nodeId1.'\',\'2\', \'1\')" title="'.$latestTalk.'" border="0" >'.$total.'</a></li><input type="hidden" value="'.$leafhtmlContent.'" name="talk_content" id="talk_content'.$leafTreeId.'"/>';	
				}

				/*<!--End of Cahnged title by Surbhi IV -->	*/
			
			}

				else

				{

				  $strContents.= '';

				}


				$strContents	.= '|||&nbsp;';

				$tagLink 		= '<a href="javascript:void(0)" onClick="showTagView(\''.$leafData->nodeOrder.'\')">'.$this->lang->line('txt_Tags').'</a>';

				echo $strContents.= '|||'.$tagLink;

				?>|||

				<?php

				#********************************************* Tags ********************************************************88

				

				$dispTags	= '';

				?>

				<div style="width:<?php echo $this->config->item('page_width')-50;?>px; float:left;">

									

		<?php	

		$tagAvlStatus = 0;				

		if(count($timeTags) > 0)

		{

			$tagAvlStatus = 1;

			$dispTags = '';			

			foreach($timeTags as $tagData)

			{

				if (empty($dispTags))

					$dispTags = $tagData['tagName'];	

				else											

					$dispTags .= ', ' .$tagData['tagName'];						 

			}

		}

		if(count($viewTags) > 0)

		{

			$tagAvlStatus = 1;	

			$dispTags .= $this->lang->line('txt_Simple_Tags') .": ";

			$count = 0 ;

			foreach($viewTags as $tagData)

			{													

				if ($count==0)

					$dispTags .= $tagData['tagName'];			

				else											

					$dispTags .= ', ' .$tagData['tagName'];		

					

				$count++;			 

			}

			$dispTags .= "<br><br>";

		}	

		if(count($createTags) > 0)

		{

			$tagAvlStatus = 1;	

			foreach($createTags as $tagData)

			{

				$taskId = 0;

				if($tagData['tag'] == 17)

				{

					$date   = date('Y-m-d');

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);

				}

				else if($tagData['tag'] == 18)

				{			

					$date	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N')),date('Y')));

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);

				}

				else if($tagData['tag'] == 19)

				{

					$date	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);

				}

				else if($tagData['tag'] == 20)

				{

					$date   = date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);

				}

				else if($tagData['tag'] == 0)

				{

					$taskCreateDate   = $this->tag_db_manager->getTaskCreateTagByTagId($tagData['tagId']);

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$taskCreateDate);

				}

				if($taskId == 0)

				{

					$url = base_url().'Notes/New_Notes/0/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData['tagId'].'/'.$tagData['comments'].'/'.$tagData['ownerId'].'/'.$tagData['tag'];

				}

				elseif($taskId > 0)

				{

					$url = base_url().'Notes/Details/'.$taskId.'/'.$workSpaceId.'/type/'.$workSpaceType;

				}

				if($tagData['tag'] == 0)

				{

					$arrTaskDate = explode('-', $taskCreateDate);	

					$taskDate = date('Y-m-d', mktime(0,0,0,$arrTaskDate[1],$arrTaskDate[2],$arrTaskDate[0]));

					$curDate  = date('Y-m-d');

					if($taskDate <= $curDate)

					{								

						$dispTags .= '<a href="'.$url.'" class="black-link">'.$tagData['comments'].'</a>, ';

					}										

				}

				else

				{

					$dispTags .= '<a href="'.$url.'" class="black-link">'.$tagData['comments'].'</a>, ';			

				}									

			}

		}



		if(count($userTags) > 0)

		{

			$tagAvlStatus = 1;	

			foreach($userTags as $tagData)

			{

				$dispTags .= $tagData['userTagName'].', ';						

			}

		}

		if(count($actTags) > 0)

		{

					$tagAvlStatus = 1;	

					$dispTags .= $this->lang->line('txt_Response_Tags') .": ";

					$count = 0;

					foreach($actTags as $tagData)

					{

						if ($count==0)

							$dispTags .= $tagData['comments'].' [';	

						else

							$dispTags .= ', ' .$tagData['comments'].' [';							

						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);

						if(!$response)

						{

				

							if ($tagData['tag']==1)

								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',2,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==2)

								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',2,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_Select').'</a>,  ';	

							if ($tagData['tag']==3)

								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',2,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_Vote').'</a>,  ';

							if ($tagData['tag']==4)

								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',2,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_Authorize').'</a>,  ';					

						}

						$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',3,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_View_Responses').'</a>';	

						

						$dispTags .= ']';

					

						$count++;

					}

					$dispTags .= "<br><br>";

		}

		if(count($contactTags) > 0)

		{

			$tagAvlStatus = 1;	

			$dispTags .= $this->lang->line('txt_Contact_Tags') .": ";

			foreach($contactTags as $tagData)

			{

				$dispTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';

			}

			

		}

		

		echo substr($dispTags, 0, strlen( $dispTags )-2);		

		

		?>

		

				<?php					

				if($tagAvlStatus == 0)

				{

				?>			

					<div><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></div>

				<?php

				}

				?>

					

				</div>

				

				<?php

				$i++;

				?>|||<?php echo $leafData->leafId1;?>|||                	

				<input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagView(<?php echo $leafData->nodeOrder;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $leafData->nodeId1;?>,2)" />

				<?php



							?>

				||| <?php 

			

				$leafTime='';

				if($leafData->editedDate[0]==0)

				{

					$leafTime=$leafData->createdDate;

				}	

				else

				{

					$leafTime=$leafData->editedDate;

				}

			/* Changed by Dashrath- remove &nbsp&nbsp and commented $leafData->tagName for new ui */
			//echo $leafData->tagName;
			?>
				<?php 

				$ci=&get_instance();



        		$ci->load->model('time_manager');		

        		/* Changed by Dashrath- remove &nbsp&nbsp and add tagName and reserveHeaderContent for new ui */
        		/*Commented by Dashrath- comment if condition for show R icon for all user and all status*/
      //   		if($_SESSION['userId'] != $treeOriginatorId && $leafData->leafStatus == 'publish')
  				// {
      // 				$reserveHeaderContent = '';
      // 			}

				echo $ci->time_manager->getUserTimeFromGMTTime($leafTime, $ci->config->item('date_format')).'<br/>|||'.$viewTags[0]['tagName'].'|||'.$reserveHeaderContent.'|||'.$leafData->tagName.'|||';

				}		

				

						

				

			

			}

	

		}

		

		//return $strContents;				

	}



	/**

	* This method will be used for fetch the next leaf contents from the database.

 	* @param $leafId This is the variable used to hold the leaf ID.

	* @param $parentLeafId This is the variable used to hold the parent leaf ID.

	* @param $divId This is the variable used to hold the div id to refresh the contents.	

	* @return The next leaf's next leaf contents

	*/

	public function getLeafNextContentsByLeafId($leafId, $parentLeafId, $curLeafId, $leafOrder, $treeId, $workSpaceId, $workSpaceType,$bgColor,$nodeId)

	{	

		memcache_debug(true);	

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no')) or die("test failed");*/	
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc'.$treeId;	

		

		$value = $memc->get($memCacheId);

		$strContents='';

		//echo "value= "; print_r($value); exit;

		if(!$value)

		{					
			/*Changed by Dashrath - replace this query by getDocumentFromDB function */
			// $tree 	= array();		

			// $query 	= $this->db->query('SELECT a.*, a.version as leafVersion, b.*,b.id as nodeId1, a.id as leafId1, c.firstName, c.lastName, c.userName, c.tagName FROM teeme_leaf a, teeme_node b, teeme_users c WHERE a.userId=c.userId AND a.id=b.leafId AND b.treeIds='.$treeId.' ORDER BY b.nodeOrder');

			// foreach($query->result() as $docData)

			// {

			// 	$tree[] = $docData;

			// }

			$tree = $this->getDocumentFromDB($treeId);

			$memc->set($memCacheId,$tree,MEMCACHE_COMPRESSED);

			

			$value = $tree;

		}			

		// Get the information of previous version node

		if ($value)
		{	

		
			//Sort an array by edited date ascending
			foreach ($value as $key => $lfData) {
				$timestamps[$key]=strtotime($lfData->editedDate) ;
			}
			array_multisort($timestamps, SORT_ASC, $value);
			//Code end		

			$strContents	= '';			

			$i = 1;	

			$artifactLink = '';		

			$contributors = $this->getDocsContributors($treeId);

			$contributorsUserId			= array();	
			foreach($contributors  as $userData)
			{
				$contributorsUserId[] 	= $userData['userId'];	
			}
			
			$treeOriginatorId	= $this->identity_db_manager->getTreeOriginatorByTreeId($treeId);

			foreach ($value as $leafData)
			{	
				//print_r($leafData);
				$leafParentData = $this->getLeafParentIdByNodeOrder($leafData->treeIds, $leafData->nodeOrder);
				$leafReserveStatus = $this->getLeafReserveStatus($leafData->treeIds,$leafParentData['parentLeafId']);	
			
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->getDocsReservedUsers($leafParentData['parentLeafId']);
				if(count($reservedUsers)>0)
				{
					$saveBtnDisable = 1;
				}
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}	
				
				/*if(($leafData->nodeId1 == $leafId && $leafData->leafStatus == 'publish') || ($leafData->leafStatus == 'draft' && in_array($_SESSION['userId'], $resUserIds) && $leafData->leafId1 < $curLeafId) || ($leafData->leafStatus == 'publish' && $leafData->leafId1 < $curLeafId))*/	

				/*Commented by Dashrath- Add new code below for show draft leaf for contributor when no reserved list*/
				// if(($leafData->nodeId1 == $leafId && ($leafData->leafStatus == 'publish' || $leafData->leafStatus == 'deleted')) || ($leafData->leafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds)) && $leafData->leafId1 > $curLeafId && $leafOrder == $leafData->nodeOrder) || ($leafData->leafStatus == 'publish' && $leafData->leafId1 > $curLeafId && $leafOrder == $leafData->nodeOrder))

				if(($leafData->nodeId1 == $leafId && ($leafData->leafStatus == 'publish' || $leafData->leafStatus == 'deleted')) || ($leafData->leafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds)) && $leafData->leafId1 > $curLeafId && $leafOrder == $leafData->nodeOrder) || ($leafData->leafStatus == 'draft' && (in_array($_SESSION['userId'], $contributorsUserId)) && $leafData->leafId1 > $curLeafId && $leafOrder == $leafData->nodeOrder) || ($leafData->leafStatus == 'publish' && $leafData->leafId1 > $curLeafId && $leafOrder == $leafData->nodeOrder))
				{	
					//echo "here"; exit;
					if($leafData->treeIds!='' && $leafData->nodeOrder!='')
					{
						$prevLeafData = $this->getDraftStatusByNodeOrder($leafData->treeIds,$leafData->nodeOrder);
						$previousPublishLeafId = $prevLeafData['prevPublishLeafId'];
					}
					 
					$xdoc 			= new DomDocument;

					$tmpText		= str_replace('<o:p>','',$leafData->contents);

					$tmpText		= str_replace('</o:p>','',$tmpText);		

					$strData		= '<div id="tmp'.$i.'">'.htmlspecialchars_decode($tmpText).'</div>';					

					$xml 			= $xdoc->loadHTML($strData);						

					$nodeVal  		= substr($xdoc->getElementsByTagName('div')->item(0)->nodeValue, 0, 700);

											

					$timeTags 	= $this->tag_db_manager->getTags(1, $_SESSION['userId'], $leafData->leafId, 2);

								$viewTags 	= $this->tag_db_manager->getTags(2, $_SESSION['userId'], $leafData->nodeId1, 2);

								$actTags 	= $this->tag_db_manager->getTags(3, $_SESSION['userId'], $leafData->nodeId1, 2);

								$createTags	= $this->tag_db_manager->getTags(4, $_SESSION['userId'], $leafData->nodeId1, 2);

								$contactTags= $this->tag_db_manager->getTags(5, $_SESSION['userId'], $leafData->nodeId1, 2);

								$userTags	= $this->tag_db_manager->getTags(6, $_SESSION['userId'], $leafData->nodeId1, 2);

								

								$docTrees1 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 1, 2);

								$docTrees2 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 2, 2);

								$docTrees3 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 3, 2);

								$docTrees4 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 4, 2);

								$docTrees5 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 5, 2);

								$docTrees6 	=$this->identity_db_manager->getLinkedTreesByArtifactNodeId($leafData->nodeId1, 6, 2);

								$docTrees7 	=$this->identity_db_manager->getLinkedExternalDocsByArtifactNodeId($leafData->nodeId1, 2);
								
								/*Added by Dashrath- used for display linked folder count*/
								$docTrees10 	=$this->identity_db_manager->getLinkedExternalFoldersByArtifactNodeId($leafData->nodeId1, 2);
								/*Dashrath- code end*/

								//previous external and url applied link count
								
								$docTrees9 	=$this->identity_db_manager->getImportedUrlsByartifactAndArtifactType($leafData->nodeId1, 2);	



				$headerContent='';

				

				if($leafData->leafVersion <10)

				{

					//$leafVersion = '00'.$leafData->leafVersion;
					$leafVersion = $leafData->leafVersion;	

				}

				else if($leafData->leafVersion >=10 && $leafData->leafVersion <100)

				{

					//$leafVersion = '0'.$leafData->leafVersion;
					$leafVersion = $leafData->leafVersion;	

				}

				else

				{

					$leafVersion = $leafData->leafVersion;	

				}
				//Code for draft reservation icon
				/*if($leafData->leafStatus == 'draft'){ 
					$headerContent.= '<span class="draft_txt">'.$this->lang->line("txt_draft").'</span>';
				} */
				//Draft text view end
				
				//if($latest==1 && $leafOwnerData['userId'] == $_SESSION['userId'] && $leafData->leafStatus == 'draft')
				//if($leafParentData['parentLeafUserId']== $_SESSION['userId'])
				/*if(in_array($_SESSION['userId'],$contributorsUserId))
				{*/
					$reserveImg = '';
					$resTitle = '';
					//if($leafReserveStatus==1)
					if(count($reservedUsers)==0)
					{
						$reserveImg = '<img src="'.base_url().'images/emptyReserve.png" border="0">';
						$resTitle = 'Unreserved';
					}
					else
					{
						$reserveImg = '<img src="'.base_url().'images/reserve.png" border="0">';
						$resTitle = 'Reserved';
					}
					//if(($_SESSION['userId']==$treeOriginatorId && $leafReserveStatus==1) || ($leafReserveStatus!='1'))
					if(($_SESSION['userId']==$treeOriginatorId && count($reservedUsers)==0) || (count($reservedUsers)!=0))
					{
						$display = 'display:block;';
					}
					else
					{
						$display = 'display:none;';
					}
					
					/*changed start by dashrath- commented old code and add new code for new ui*/
					// $headerContent.= '<span class="reserve"><a id="liReserve'.$leafParentData['parentLeafId'].'" href="javaScript:void(0)" onClick="showPopWin(\''.base_url().'comman/getDocReservedCountributors/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$leafParentData['parentNodeId'].'/'.$leafData->nodeId1.'\', 600, 350, null, \'\');" title="'.$resTitle.'" border="0" style="'.$display.'">'.$reserveImg.'</a></span>';
					$reserveHeaderContent = '<span class="documentSeedLeafSpanRight"><a id="liReserve'.$leafParentData['parentLeafId'].'" href="javaScript:void(0)" onClick="showPopWin(\''.base_url().'comman/getDocReservedCountributors/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$leafParentData['parentNodeId'].'/'.$leafData->nodeId1.'\', 600, 350, null, \'\');" title="'.$resTitle.'" border="0" style="'.$display.'">'.$reserveImg.'</a></span>';

					
				/*}*/
				//Code for draft reservation icon end

				if($leafData->predecessor > 0)

				{												
					/*Added by Dashrath- add previousVersionNewUi and versionIconNewUi class and add &nbsp and float left for new ui */

					if($leafData->leafStatus=='draft')
					{
						$headerContent.='<a href="javascript:void(0)" class="previousVersionNewUi" style="text-decoration:none;" onClick="showLeafPrevious('.$leafData->nodeId1.','.$leafData->predecessor.','.$leafData->leafVersion.',\''.$leafData->leafId.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$bgColor.'\',\''.$nodeId.'\')"><img src="'.base_url().'images/left.gif" border="0" class="versionIconNewUi"> </a> </a> <span class="clsLabel" style="font-style: normal;float:left;"></span>';
					}
					else
					{
						$headerContent.='<a href="javascript:void(0)" class="previousVersionNewUi" style="text-decoration:none;" onClick="showLeafPrevious('.$leafData->nodeId1.','.$leafData->predecessor.','.$leafData->leafVersion.',\''.$leafData->leafId.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$bgColor.'\',\''.$nodeId.'\')"><img src="'.base_url().'images/left.gif" border="0" class="versionIconNewUi"> </a> </a> <span class="clsLabel" style="font-style: normal;float:left;">&nbsp;&nbsp;Version '.$leafVersion.'</span>';
					}

					

					$checkLast=1;					

				}

				else

				{												

					//$headerContent.=$leafVersion;
					/*Changed by Dashrath- add float:left and padding-left:20pxfor new ui */

					if($leafData->leafStatus=='draft')
					{
						$headerContent.='<span class="clsLabel" style="font-style: normal; float:left; padding-left: 20px;"></span>';
					}
					else
					{
						$headerContent.='<span class="clsLabel" style="font-style: normal; float:left; padding-left: 20px;">Version '.$leafVersion.'</span>';
					}

				}
				
				if($leafData->successors != 0 )

				{
					$draftResUserIds == array();
					//Get next publish status for showing next icon
					$nextPubLeafStatus = $this->getNextLeafPublishStatus($leafData->treeIds, $leafData->nodeOrder, $leafData->leafId1);	
					
					$childLeafId = $leafData->successors;		

					/*Changed by Dashrath- add versionIconNewUi class and &nbsp for new ui */		
					/*Changed by Dashrath- add draft orignator condition in if condition*/								
					if($nextPubLeafStatus == 'publish' || $nextPubLeafStatus == 'deleted' || ($nextPubLeafStatus == 'draft' && (in_array($_SESSION['userId'], $resUserIds))) || $_SESSION['userId'] == $leafData->userId)
					$headerContent.=' &nbsp;&nbsp;<a href="javascript:void(0)" style="text-decoration:none" onClick="showLeafNext('.$leafData->leafId1.','.$childLeafId.','.$leafData->version.',\''.$leafData->leafId1.'\','.$leafData->nodeOrder.','.$treeId.','.$workSpaceId.','.$workSpaceType.',\''.$bgColor.'\',\''.$nodeId.'\')"><img src="'.base_url().'images/right.gif" border="0" class="versionIconNewUi"></a>';	

					$_SESSION['set_doc_latest_version']=0;											

				}

				else

				{

				   //This variable set for view tag and link view in edit(add tags or links ) mode also

					$_SESSION['set_doc_latest_version']=1;

				}

				

				$headerContent.='';

				$latestVersion = $this->document_db_manager->getTreeLatestVersionByTreeId($leafData->treeIds);
				
				$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($leafData->leafId);

				$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId);

				

				$this->document_db_manager->hasSuccessor($leafData->leafId1);

				$latestVersion;

				if (($this->document_db_manager->hasSuccessor ($leafData->leafId1) == 0) && ($latestVersion==1) )

					$latest = 1;

				else

					$latest = 0;

				
				if($previousPublishLeafId!='' && $previousPublishLeafId==$leafData->leafId1 && $latestVersion==1)
				{
					$latest = 1;
				}


				if (($this->document_db_manager->hasSuccessor ($leafData->leafId1)) == 0) { 

					$tagLink 	= '<a href="javascript:void(0)" onClick="showTagView(\''.$leafData->nodeOrder.'\')">'.$this->lang->line('txt_Tags').'</a>';

					$links 	= '<a href="javascript:void(0)" onClick="showArtifactLinks(\''.$leafData->nodeOrder.'\','.$leafData->nodeId1.',2,'.$workSpaceId.','.$workSpaceType.',2,'.$latest.')">'.$this->lang->line('txt_Links').'</a>';

				}

				

			

				$strContents.= ''.$headerContent.'';

				

					

				$strContents.= '|||';
				
				if ($leafData->leafStatus=='deleted')
				{
					$strContents.='<span class="clearedLeafContent">'.$this->lang->line('txt_content_deleted').'</span>'.'|||'.$this->lang->line('txt_content_deleted');	
				}
				else
				{	
					$strContents.=stripslashes($leafData->contents).'|||'.stripslashes($leafData->contents);	
				}

				
				$strContents.= '|||'.$nodeVal.'|||'.$latest.'|||';

						
				if($leafData->leafStatus == 'draft'){ 
					/*Changed by Dashrath- add draftLi class for new ui */
					// $strContents.= '<li class="draftLi" id="draftTxt'.$leafData->nodeId1.'"><span class="draft_txt">'.$this->lang->line("txt_draft").'</span></li>';

					$draftContent = $this->lang->line("txt_draft");
				}		
										

				if(1==1)

				{

										

					$total=  count($viewTags)+count($actTags)+count($contactTags)+count($userTags);

					if($total==0)

					{

						$total='';

						$tag_container=$this->lang->line('txt_Tags_None');

					}

					else

					{

						     if(count($viewTags)>0)

							 {

								$tag_container=$this->lang->line('txt_Simple_Tag').' : ';

								foreach($viewTags as $simpleTag)

								$tag_container.=$simpleTag['tagName'].", ";

								$tag_container=substr($tag_container, 0, -2).

"";							 

							}

							

												

							if(count($actTags) > 0)

								{

								   $tag_container.=$this->lang->line('txt_Response_Tag').' : ';

									$tagAvlStatus = 1;	

									foreach($actTags as $tagData)

									{	$dispResponseTags='';

										$dispResponseTags = $tagData['comments']."[";							

										$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);

										if(!$response)

										{  

											

											if ($tagData['tag']==1)

												$dispResponseTags .= $this->lang->line('txt_ToDo');									

											if ($tagData['tag']==2)

												$dispResponseTags .= $this->lang->line('txt_Select');	

											if ($tagData['tag']==3)

												$dispResponseTags .= $this->lang->line('txt_Vote');

											if ($tagData['tag']==4)

												$dispResponseTags .= $this->lang->line('txt_Authorize');															

										}

										$dispResponseTags .= "], ";	

															

										

										

										$tag_container.=$dispResponseTags;

									}

									

									$tag_container=substr($tag_container, 0, -2).

""; 

								}

								

								

								if(count($contactTags) > 0)

									{

										$tag_container.=$this->lang->line('txt_Contact_Tag').' : ';

										$tagAvlStatus = 1;	

										foreach($contactTags as $tagData)

										{

											

											$tag_container .= strip_tags($tagData['contactName'],'').", ";	

											

										}

										

										$tag_container=substr($tag_container, 0, -2); 

									}	

									

								

							

					}

						



				$tagclass='';	

				/*Changed by Dashrath- add else condition and add class in if condition for new ui */
				if(($latest==1) || ($latest==0 && $total!='' ))

				{

				  $tagclass='class="tag"';

				  $liClass = 'class="tagLinkTalkSeedLeafIcon"';

			    }
			    else{
					$liClass = 'class="tagLinkTalkSeedLeafIconPreviousLi"';
				}

				/*Changed by Surbhi IV*/
				/*Changed by Dashrath- add $liClass variable for new ui */
				$strContents.='<li '.$liClass.'><a id="liTag'.$leafData->nodeId1.'" '.$tagclass.' onClick="showPopWin(\''.base_url().'add_tag/index/'.$workSpaceId.'/'. $workSpaceType.'/'. $leafData->nodeId1.'/2/'.$latest.'\', 710, 480, null, \'\');" href="javascript:void(0);" title="'. strip_tags($tag_container,'').'"  ><strong>'.$total.'</strong></a></li>';	

			   /*End of Changed by Surbhi IV*/

			    /*Changed by Dashrath- add $docTrees10 for total*/
				$total=sizeof($docTrees1)+sizeof($docTrees2)+sizeof($docTrees3)+sizeof($docTrees4)+sizeof($docTrees5)+sizeof($docTrees6)+sizeof($docTrees7)+sizeof($docTrees9)+sizeof($docTrees10);

				

				$appliedLinks=' ';

				

				if($total==0)

					{

						$total='';

						$appliedLinks=$this->lang->line('txt_Links_None') ;

					}

					else

					{


						   if(count($docTrees1)>0)

						   {

							   $appliedLinks .= $this->lang->line('txt_Document').': ';

							   foreach($docTrees1 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

							}	

							

							

							 if(count($docTrees3)>0)

						   {

								$appliedLinks.=$this->lang->line('txt_Chat').': ';	

								foreach($docTrees3 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

							}	

							

							if(count($docTrees4)>0)

							{

							

								$appliedLinks.=$this->lang->line('txt_Task').': ';	

								foreach($docTrees4 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

									

								}

							}	

							

							if(count($docTrees6)>0)

							{

								$appliedLinks.=$this->lang->line('txt_Notes').': ';	

								foreach($docTrees6 as $key=>$linkData)

							   {

									 $appliedLinks.=$linkData['name'].", ";

								}

							}

							

							if(count($docTrees5)>0)

							{

								$appliedLinks .=$this->lang->line('txt_Contacts').': ';	

								foreach($docTrees5 as $key=>$linkData)

							    {

									 $appliedLinks.=$linkData['name'].", ";

								}

							

							}

							

							if(count($docTrees7)>0)

							{

							
								/*Commented by Dashrath- extra foreach loop commented because link title repeted*/
								// $appliedLinks .=$this->lang->line('txt_Imported_Files').': ';	

								// foreach($docTrees7 as $key=>$linkData)

							 //   {

									 

								$appliedLinks .=$this->lang->line('txt_Files').': ';	

								foreach($docTrees7 as $key=>$linkData)

							   {

							         

									 if($linkData['docName']=='')

									 {

									    $appliedLinks.=$this->lang->line('txt_Files')."_v".$linkData['version'].", ";

									 }

									 else

									 {

									 	/*Changed by Dashrath- Comment old code and add new below after changes */
									 	// $appliedLinks.=$linkData['docName']."_v".$linkData['version'].", ";
									 	$appliedLinks.=$linkData['docName'].", ";

									 }

									

								}

							

								// }

							}
							

							/*Added by Dashrath- used for display linked folder name*/
							if(count($docTrees10)>0)
							{
								$appliedLinks .=$this->lang->line('txt_Folders').': ';	

								foreach($docTrees10 as $key=>$linkData)
							    {							      
									if($linkData['folderName']!='')
									{
									  
									 	$appliedLinks.=$linkData['folderName'].", ";
									}
								}
							}
							/*Dashrath- code end*/	

							if(count($docTrees9	)>0)
							{
							
								$appliedLinks .=$this->lang->line('txt_Imported_URL').': ';	
								
								foreach($docTrees9 as $key=>$linkData)
							    {
									 $appliedLinks.=$linkData['title'].", ";
									
								}
								$appliedLinks=substr($appliedLinks, 0, -2)."
"; 
							
							}	

							

							$appliedLinks=substr($appliedLinks, 0, -2); 

						

					}

					

				

				$linkclass='class="disblock"';	

				/*Changed by Dashrath- add else condition and add class in if condition for new ui */
				if(($latest==1) || ($latest==0 && $total!='' ))

				{

				  $linkclass='class="link disblock"';

				  $liClass = 'class="tagLinkTalkSeedLeafIcon"';

			    }
			    else{
					$liClass = 'class="tagLinkTalkSeedLeafIconPreviousLi"';
				}

					

				/*Changed by Surbhi IV*/	
				/*Changed by Dashrath- add $liClass variable for new ui */
				$strContents.='<li '.$liClass.'><a id="liLink'.$leafData->nodeId1.'"  '.$linkclass.' onClick="showPopWin(\''.base_url().'show_artifact_links/index/'.$leafData->nodeId1.'/2/'.$workSpaceId.'/'.$workSpaceType.'/2/1/'.$latest.'\', 750, 430, null, \'\');" alt="'. $this->lang->line("txt_Links").'" title="'.strip_tags($appliedLinks).'" border="0" ><strong>'.$total.'</strong></a></li>';	

				/*End of Changed by Surbhi IV*/	

					

				$leafTreeId	= $this->document_db_manager->getLeafTreeIdByLeafId($leafData->leafId1);

				$isTalkActive = $this->document_db_manager->isTalkActive($leafTreeId);

				

				  

				$total='';

				$latestTalk='Talk';	

				$ci =&get_instance();

				$ci->load->model('dal/discussion_db_manager');

				

 				$ci->load->model("dal/time_manager");

				if (!empty($leafTreeId) && ($isTalkActive==1))

				{	

				$total=$ci->discussion_db_manager->getCountTalkNodesByTreeRealTalk($leafTreeId);
				
				if($total==0)
				{
					$total='';
				}

				$talk=$ci->discussion_db_manager->getLastTalkByTreeId($leafTreeId);

				if(strip_tags($talk[0]->contents))

				{

					$userDetails = $ci->discussion_db_manager->getUserDetailsByUserId($talk[0]->userId);

					$latestTalk=substr(strip_tags($talk[0]->contents),0,300)."\n".$userDetails['userTagName']."\t\t".$ci->time_manager->getUserTimeFromGMTTime($talk[0]->createdDate,$this->config->item('date_format'));

				}

				else

				{

					$latestTalk='Talk';

				}	  

				}

				$talkClass='';	

				/*Changed by Dashrath- add else condition and add class in if condition for new ui */
				if(($latest==1) || ($latest==0 && $total!='' ))

				{
				  /*Changed by Dashrath- add tagLinkTalkSeedLeafIcon class for new ui */
				  $talkClass='class="talk tagLinkTalkSeedLeafIcon"';

			    }
			    else{
			    	$talkClass='class="tagLinkTalkSeedLeafIconPreviousLi"';
			    }

				/*window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'/0/'.$latest.'\' ,\'\',\'width=850,height=500,scrollbars=yes\')*/
				
							$leafdataContent=strip_tags($leafData->contents);
							if (strlen($leafdataContent) > 10) 
							{
   								$talkTitle = substr($leafdataContent, 0, 10) . "..."; 
							}
							else
							{
								$talkTitle = $leafdataContent;
							}
							$leafhtmlContent=htmlentities($leafData->contents, ENT_QUOTES);	
				if($_COOKIE['ismobile'])
				{
					$strContents.= ' <li  '.$talkClass.'><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="window.open(\''.base_url() .'view_talk_tree/node/' .$leafTreeId .'/'. $workSpaceId.'/type/'.$workSpaceType.'/ptid/'.$treeId.'/0/'.$latest.'\' ,\'\',\'width=850,height=500,scrollbars=yes\')" title="'.$latestTalk.'" border="0" >'.$total.'</a></li>';
				}
				else
				{
					if($latest == 1)
					{
						$talkTreeIds = $treeId;
					}
					
					$strContents.= ' <li  '.$talkClass.'><a id="liTalk'.$leafTreeId.'" href="javaScript:void(0)"  onClick="talkOpen(\''.$leafTreeId.'\', \''.$workSpaceId.'\',\''.$workSpaceType.'\',\''.$talkTreeIds.'\',\''.$talkTitle.'\',\'0\',\'\',\''.$leafData->nodeId1.'\',\'2\', \'1\')" title="'.$latestTalk.'" border="0" >'.$total.'</a></li><input type="hidden" value="'.$leafhtmlContent.'" name="talk_content" id="talk_content'.$leafTreeId.'"/>';
				}
				// Added by Parv - Need delete for the latest version of the leaf
				if ($latest==1 && $leafData->leafStatus!='deleted' && $leafData->userId==$_SESSION['userId'])
				{
					/*Commented by Dashrath- for new ui*/
					// $deleteclass='class="delete"';

					// $strContents.='<li><a '.$deleteclass.' onClick="deleteLeaf('.$leafData->leafId.','.$workSpaceId.','. $workSpaceType.','. $treeId.')" href="javascript:void(0);" title="'.$this->lang->line('txt_delete').'"  ></a></li>';

					$deleteLeafContent = '<a href="javascript:void(0)" onClick="deleteLeaf('.$leafData->leafId.','.$workSpaceId.','.$workSpaceType.','.$treeId.')" title="'.$this->lang->line('txt_delete').'" border="0" ><img src="'.base_url().'images/trash.gif" alt="'.$this->lang->line('txt_del').'" title="'. $this->lang->line('txt_delete').'" border="0">
							</a>';
				}

				/*Added by Dashrath- Need move for the latest version of the leaf */
				if($latest==1 && $leafData->userId==$_SESSION['userId'] && count($value)>1)
				{
					$moveLeafContent = '<a href="javascript:void(0)" onClick="newLeafMove('.$leafData->leafId.','.$leafTreeId.')" title="'.$this->lang->line('txt_move').'" border="0" ><img src="'.base_url().'images/move_icon_new.png" alt="'.$this->lang->line('txt_move').'" title="'. $this->lang->line('txt_move').'" border="0">
							</a>';
				}

				/*Added by Dashrath- Need copy for the latest version of the leaf */
				if($latest==1)
				{
					$copyLeafContent = '<a href="javascript:void(0)" onClick="newLeafCopy('.$leafData->leafId.')" title="'.$this->lang->line('txt_copy').'" border="0" ><img src="'.base_url().'images/copy_icon_new.png" alt="'.$this->lang->line('txt_copy').'" title="'. $this->lang->line('txt_copy').'" border="0">
							</a>';
				}
				  


					
	
				//Draft view start
				if($leafData->nodeId1!='')
				{
					$leafOwnerData = $this->identity_db_manager->getLeafIdByNodeId($leafData->nodeId1);
				}
				
			}

				else

				{

				  $strContents.= '';

				}

										

										

			$strContents.= '|||';

			

			

			//if($latest==1)
			if (($this->document_db_manager->hasSuccessor ($leafData->leafId1) == 0) && ($latestVersion==1) )
			{

			    /*Updated by Surbhi IV for checking version */	
				$editClass = 'class="disnone2"';


				// if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $resUserIds) || ($leafData->leafStatus != 'draft' && count($resUserIds)==0))) 

				/*Commented by Dashrath- add new code below with some changes in if statement*/
				// if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $resUserIds) || ($leafData->leafStatus != 'draft' && count($resUserIds)==0) || ($leafData->leafStatus == 'draft' && in_array($_SESSION['userId'],$contributorsUserId)))) 

				if (in_array($_SESSION['userId'],$contributorsUserId) && (in_array($_SESSION['userId'], $resUserIds) || ($leafData->leafStatus != 'draft' && count($resUserIds)==0) || ($leafData->leafStatus == 'draft' && in_array($_SESSION['userId'],$contributorsUserId) && count($resUserIds)==0 )))  
				{
					$editClass = 'disblock3';
				}
				else 
				{ 
					$editClass = 'disnone2';
				}
				 
				$latestLeafClass = 'latestLeafShow';
			  	  

				/*Commented by Dashrath- commented old code and add new code below for new ui*/
			    // $strContents.='<span>&nbsp;&nbsp;<a  style="margin-right:25px;" href="javascript:void(0)" class="'.$editClass.' '.$latestLeafClass.'" onClick="editLeaf('.$leafData->leafId1.','.$leafData->nodeOrder.','. $treeId .','.$leafData->nodeId1.','.$leafData->version.',\''.$leafData->leafStatus.'\',\''.$leafParentData['parentLeafId'].'\')" title="'.$this->lang->line('txt_Edit_this_idea').'" ><img src="'.base_url().'images/editnew.png" alt="'.$this->lang->line("txt_Edit").'" title="'.$this->lang->line("txt_Edit").'" border="0"></a></span>';

			    $strContents.='<span class="commonSeedLeafSpanLeft"><a href="javascript:void(0)" class="'.$editClass.' '.$latestLeafClass.'" onClick="editLeaf('.$leafData->leafId1.','.$leafData->nodeOrder.','. $treeId .','.$leafData->nodeId1.','.$leafData->version.',\''.$leafData->leafStatus.'\',\''.$leafParentData['parentLeafId'].'\')" title="'.$this->lang->line('txt_Edit_this_idea').'" ><img src="'.base_url().'images/editnew.png" alt="'.$this->lang->line("txt_Edit").'" title="'.$this->lang->line("txt_Edit").'" border="0"></a></span>';

					

			    /*End of Updated by Surbhi IV for checking version */

			

			}

			else

			{

				$strContents.= '';

			}

				

			echo $strContents.= '|||'.$tagLink;	

			?>|||

				<?php

				#********************************************* Tags ********************************************************88

				

				$dispTags	= '';	

				?>

				<div style="width:785px; float:left;">	

									

		<?php	

		$tagAvlStatus = 0;				

		if(count($timeTags) > 0)

		{

			$tagAvlStatus = 1;

			$dispTags = '';			

			foreach($timeTags as $tagData)

			{

				if (empty($dispTags))

					$dispTags = $tagData['tagName'];	

				else											

					$dispTags .= ', ' .$tagData['tagName'];						 

			}

		}

		if(count($viewTags) > 0)

		{

			$tagAvlStatus = 1;	

			$dispTags .= $this->lang->line('txt_Simple_Tags') .": ";

			$count = 0 ;

			foreach($viewTags as $tagData)

			{													

				if ($count==0)

					$dispTags .= $tagData['tagName'];			

				else											

					$dispTags .= ', ' .$tagData['tagName'];		

					

				$count++;			 

			}

			$dispTags .= "<br><br>";

		}	

		if(count($createTags) > 0)

		{

			$tagAvlStatus = 1;	

			foreach($createTags as $tagData)

			{

				$taskId = 0;

				if($tagData['tag'] == 17)

				{

					$date   = date('Y-m-d');

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);

				}

				else if($tagData['tag'] == 18)

				{			

					$date	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')+(7-date('N')),date('Y')));

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);

				}

				else if($tagData['tag'] == 19)

				{

					$date	= date('Y-m-d',mktime(0,0,0,date('m'),date('d')-(date('N')-1),date('Y')));

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);

				}

				else if($tagData['tag'] == 20)

				{

					$date   = date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')));

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$date);

				}

				else if($tagData['tag'] == 0)

				{

					$taskCreateDate   = $this->tag_db_manager->getTaskCreateTagByTagId($tagData['tagId']);

					$taskId = $this->tag_db_manager->getTaskId($tagData['tagId'],$taskCreateDate);

				}

				if($taskId == 0)

				{

					$url = base_url().'Notes/New_Notes/0/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagData['tagId'].'/'.$tagData['comments'].'/'.$tagData['ownerId'].'/'.$tagData['tag'];

				}

				elseif($taskId > 0)

				{

					$url = base_url().'Notes/Details/'.$taskId.'/'.$workSpaceId.'/type/'.$workSpaceType;

				}

				if($tagData['tag'] == 0)

				{

					$arrTaskDate = explode('-', $taskCreateDate);	

					$taskDate = date('Y-m-d', mktime(0,0,0,$arrTaskDate[1],$arrTaskDate[2],$arrTaskDate[0]));

					$curDate  = date('Y-m-d');

					if($taskDate <= $curDate)

					{								

						$dispTags .= '<a href="'.$url.'" class="black-link">'.$tagData['comments'].'</a>, ';

					}										

				}

				else

				{

					$dispTags .= '<a href="'.$url.'" class="black-link">'.$tagData['comments'].'</a>, ';			

				}									

			}

		}



		if(count($userTags) > 0)

		{

			$tagAvlStatus = 1;	

			foreach($userTags as $tagData)

			{

				$dispTags .= $tagData['userTagName'].', ';						

			}

		}

		if(count($actTags) > 0)

		{

	

					$tagAvlStatus = 1;	

					$dispTags .= $this->lang->line('txt_Response_Tags') .": ";

					$count = 0;

					foreach($actTags as $tagData)

					{

						if ($count==0)

							$dispTags .= $tagData['comments'].' [';	

						else

							$dispTags .= ', ' .$tagData['comments'].' [';							

						$response = $this->tag_db_manager->checkTagResponse($tagData['tagId'], $_SESSION['userId']);

						if(!$response)

						{

			

							if ($tagData['tag']==1)

								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',2,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_ToDo').'</a>,  ';									

							if ($tagData['tag']==2)

								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',2,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_Select').'</a>,  ';	

							if ($tagData['tag']==3)

								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',2,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_Vote').'</a>,  ';

							if ($tagData['tag']==4)

								$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',2,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_Authorize').'</a>,  ';					

							

						}

						$dispTags .= '<a href="javascript:void(0)" onClick="showNewTagLeaf('.$leafData->nodeOrder.','.$workSpaceId.','.$workSpaceType.','.$leafData->leafId1.',3,'.$tagData['tagId'].',3,'.$leafData->nodeOrder.')">'.$this->lang->line('txt_View_Responses').'</a>';	

						

						$dispTags .= ']';

					

						$count++;

					}

					$dispTags .= "<br><br>";

		}

		if(count($contactTags) > 0)

		{

			$tagAvlStatus = 1;	

			$dispTags .= $this->lang->line('txt_Contact_Tags') .": ";

			foreach($contactTags as $tagData)

			{

				$dispTags .= '<a target="_blank" href="'.base_url().'contact/contactDetails/'.$tagData['tag'].'/'.$workSpaceId.'/type/'.$workSpaceType.'" class="black-link">'.$tagData['contactName'].'</a>, ';									

			}

			

		}

		echo substr($dispTags, 0, strlen( $dispTags )-2);		

		?>

				<?php					

				if($tagAvlStatus == 0)

				{

				?>			

					<div><?php echo $this->lang->line('txt_Tags_Applied');?> - <?php echo $this->lang->line('msg_tags_not_available');?></div>	

				<?php

				}

				?>		

				

				</div>

				

				<?php

					$i++;

					?>|||<?php echo $leafData->leafId1;?>

                    <?php if (($this->document_db_manager->hasSuccessor ($leafData->leafId1)) == 0) { ?>

					|||<input type="button" class="button01" value="<?php echo $this->lang->line('txt_Apply_tag');?>" onClick="showNewTag(<?php echo $leafData->leafId1; ?>,<?php echo $workSpaceId; ?>,<?php echo $workSpaceType; ?>,<?php echo $leafData->nodeId1; ?>,2,0,1,<?php echo $leafData->nodeOrder; ?>)" />					<?php

					}

					else

					{

						echo '|||';

					}

					if (!($this->document_db_manager->hasSuccessor ($leafData->leafId1)) == 0)

					{

					?>

                		<input type="button" class="button01" value="<?php echo $this->lang->line('txt_Done');?>" onClick="hideTagView(<?php echo $leafData->nodeOrder;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $leafData->nodeId1;?>,2)" />

					<?php

					}

					

					$leafTime='';

					if($leafData->editedDate[0]==0)

					{

						$leafTime=$leafData->createdDate;

					}	

					else

					{

						$leafTime=$leafData->editedDate;

					}

					

					?>||| <?php 

					/* Changed by Dashrath- remove &nbsp&nbsp and commented $leafData->tagName for new ui */
					//echo $leafData->tagName;
					?> 

					<?php 

					$ci=&get_instance();



					$ci->load->model('time_manager');

					$tagNameDeleteMoveCopy = $leafData->tagName.'^^^^'.$deleteLeafContent.'^^^^'.$moveLeafContent.'^^^^'.$copyLeafContent.'^^^^'.$draftContent;

					/* Changed by Dashrath- remove &nbsp&nbsp and add tagName and reserveHeaderContent for new ui */

					/*Commented by Dashrath- comment if condition for show R icon for all user and all status*/
					// if($_SESSION['userId'] != $treeOriginatorId && $leafData->leafStatus=='publish')
     //  				{
     //      				$reserveHeaderContent = '';
     //      			}

					echo $ci->time_manager->getUserTimeFromGMTTime($leafTime, $ci->config->item('date_format')).'<br/>|||'.$viewTags[0]['tagName'].'|||'.$reserveHeaderContent.'|||'.$tagNameDeleteMoveCopy.'|||';
					
				}		

				

							

					

			}

		}		

		//return $strContents;				

	}





	 /**

	* This method will be used for fetch the leafs contents from the database.

 	* @param $leafId This is the variable used to hold the leaf ID .

	* @return The leaf contents

	*/

	public function getLeafContentsByLeafId($leafId, $option="")

	{

		$strContents	= '';	

		if($leafId != NULL)

		{

			// Get information of particular document

			$query = $this->db->query('SELECT contents FROM teeme_leaf WHERE id='.$leafId);

			if($query->num_rows() > 0)

			{							

				foreach ($query->result() as $leafData)

				{						

					if($option == 'short')

					{

						$strData		= '<div id="'.$leafData->tag.'">'.htmlspecialchars_decode($leafData->contents).'</div>';

						$xdoc 			= new DomDocument;						

						$xml 			= $xdoc->loadHTML($strData);						

						$strContents  .= $xdoc->getElementsByTagName('div')->item(0)->nodeValue;

					}

					else

					{

						$strContents.= $leafData->contents;

					}

				}				

			}

		}

		

		return $strContents;				

	}

	

	 /**

	* This method will be used for fetch the document name from the database.

	* @param $treeId This is the variable used to hold the tree ID .

	* @return The document name

	*/

	public function getDocumentDetailsByTreeId($treeId)

	{

		$treeData = array();
		//echo "here= ".$treeId; exit;

		$q = 'SELECT *, DATE_FORMAT(createdDate, \'%Y-%m-%d %H:%i:%s\') as documentCreatedDate FROM teeme_tree WHERE id='.$treeId;

	

		$query = $this->db->query($q);	

										

		foreach($query->result() as $rsData)

		{	

			$treeData['treeId'] 		= $rsData->id;

			$treeData['parentTreeId'] 	= $rsData->parentTreeId;

			$treeData['name'] 			= $rsData->name;

			$treeData['old_name']		= $rsData->old_name;

			$treeData['type'] 			= $rsData->type;

			$treeData['userId'] 		= $rsData->userId;

			$treeData['documentCreatedDate'] = $rsData->documentCreatedDate;

			$treeData['workspaces'] 	= $rsData->workspaces;

			$treeData['workSpaceType'] 	= $rsData->workSpaceType;

			$treeData['nodes'] 			= $rsData->nodes;			

			$treeData['version'] 		= $rsData->version;

			$treeData['latestVersion'] 	= $rsData->latestVersion;

			//Added by dashrath
			$treeData['position'] 	= $rsData->position;	

			//Added by dashrath
			$treeData['autonumbering'] 	= $rsData->autonumbering;
			

		}			

		return $treeData;			

	}

	

	

	/*********** Begin Parv ************/

	

	public function hasSuccessor1($node){

		$query = $this->db->query('SELECT successors FROM teeme_node WHERE id='.$node);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{			

			

				if ($row->successors == 0)

				{

					return $node;

				}else{

					$return=$this->hasSuccessor1($row->successors);

				}

			}

		}



		return $return;

	}

	public function hasSuccessor ($leafId)

	{

	

		$query = $this->db->query('SELECT successors FROM teeme_node WHERE leafId='.$leafId);

		

	

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{			

			

				if ($row->successors == 0)

				{

					return 0;

				}

				else

				{ 

					$return=$this->hasSuccessor1($row->successors);

		

				}							

				

			}				

		}

					

		return $return;		

	}

	

	



	public function getSuccessors ($nodeId)

	{

	

		$query = $this->db->query('SELECT successors FROM teeme_node WHERE id='.$nodeId);

		

	

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{			

				

				if ($row->successors == 0)

				{



					return $_SESSION['succ'];

				}

				else

				{

				

					if ($_SESSION['succ']=='')

						$_SESSION['succ'] = $row->successors;

					else

						$_SESSION['succ'] .= ',' .$row->successors;



					$treeIds = $this->getSuccessors($row->successors);

				}						

				

			}				

		}

					

		return $_SESSION['succ'];		

	}



	public function hasParent($treeId){

		

		global $treeIds2;



		$query = $this->db->query('SELECT parentTreeId FROM teeme_tree WHERE id='.$treeId);

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{			

			

				if ($row->parentTreeId == 0)

				{

					return $treeIds2;

				}else{

				

					if ($treeIds2=='')

						$treeIds2 = $row->parentTreeId;

					else

						$treeIds2 .= ',' .$row->parentTreeId;



						$treeIds = $this->hasParent($row->parentTreeId);

				}

			}



		}



		return $treeIds2;

	}

	public function hasChild($treeId){

		

		global $treeIds2;



		$query = $this->db->query('SELECT id FROM teeme_tree WHERE parentTreeId='.$treeId .' AND embedded=0');

		if($query->num_rows() > 0)

		{

			foreach($query->result() as $row)

			{			

			

				if ($row->id == 0)

				{

					return $treeIds2;

				}else{

				

		

						$treeIds2 = $row->id;

		

		

						$treeIds = $this->hasChild($row->id);

				}

			}



		}



		return $treeIds2;

	}	



	

	

	public function getCurrentLeafContents ($leafId)

	{

		$contents = '';		

		$query = $this->db->query('SELECT leafStatus, contents FROM teeme_leaf WHERE id='.$leafId);								

		foreach($query->result() as $row)

		{
				if ($row->leafStatus =='deleted')
				{
					$contents = '';
				}
				else
				{
					$contents = $row->contents;
				}
			

		}	

		return $contents; 	

	}

	

	public function getnodeDetailsByLeafId( $lastNode )

	{

		$node = array();		



		$query = $this->db->query('SELECT a.id as nodeId,a.leafId,a.nodeOrder as leafOrder,a.treeIds, b.leafStatus, b.contents as contents 

		FROM teeme_node	a, teeme_leaf b WHERE b.id=a.leafId and a.id='.$lastNode);

		foreach($query->result() as $row)

		{

			

			$node['nodeId'] = $row->nodeId;

			$node['leafId'] = $row->leafId;

			$node['nodeOrder'] = $row->nodeOrder;

			$node['treeId'] = $row->treeIds;

				if ($row->leafStatus =='deleted')
				{
					$node['contents'] = '';
				}
				else
				{
					$node['contents'] = $row->contents;
				}
			
		}	

		

		return $node;	

	}

	

	/*********** End Parv ************/



 /**

	* This method will be used for fetch the user detailse from the database.

 	* @param $userId This is the variable used to hold the user ID .

	* @return The user details

	*/

	public function getUserDetailsByUserId($userId)

	{

		$userData = array();

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
					$userData['userTagName']	= $row->nickName;	
				}
				else
				{
					$userData['userTagName']	= $row->tagName;	
				}	

			}				

		}						

		return $userData;			

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



	 /**

	* This method will be used for fetch the leaf details from the database.

 	* @param $leafId This is the variable used to hold the leaf ID .

	* @return The leaf details

	*/

	public function getLeafDetailsByLeafId($leafId)

	{

		$leafDetails = array();

		$query = $this->db->query('SELECT 

							*, DATE_FORMAT(createdDate, \'%Y-%m-%d %H:%i:%s\') as leafCreatedDate FROM teeme_leaf WHERE id='.$leafId);

		if($query->num_rows() > 0)

		{							

			foreach ($query->result() as $leafData)

			{	

				$leafDetails['leafId'] = $leafData->id;	

				$leafDetails['leafParentId'] = $leafData->leafParentId;	

				$leafDetails['type'] = $leafData->type;	

				$leafDetails['authors'] = $leafData->authors;	

				$leafDetails['status'] = $leafData->status;	

				$leafDetails['userId'] = $leafData->userId;	

				$leafDetails['leafCreatedDate'] = $leafData->leafCreatedDate;	

				$leafDetails['contents'] = $leafData->contents;	

				$leafDetails['latestContent'] = $leafData->latestContent;	

				$leafDetails['version'] = $leafData->version;	

				$leafDetails['lockedStatus'] = $leafData->lockedStatus;	

				$leafDetails['userLocked'] = $leafData->userLocked;					

			}

		}										

		return $leafDetails;			

	}



	 /**

	* This method will be used for fetch the leaf details from the database.

 	* @param $leafId This is the variable used to hold the leaf ID .

	* @return The leaf details

	*/

	public function updateNodeLeafId($currentleafId, $lastLeafId)

	{

		$leafDetails = array();

		$bResult  = $this->db->query('UPDATE teeme_node SET leafId='.$currentleafId.' WHERE leafId='.$lastLeafId);

		$bResult1 = $this->db->query('UPDATE teeme_leaf SET latestContent=1 WHERE id='.$lastLeafId);		

		if($bResult && $bResult1)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

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



	 /**

	* This method will be used for update the node successor details.

 	* @param $nodeId This is the variable used to hold the node ID .

	* @param $successorIds This is the variable used to hold the node successor Ids.

	* @update the node successor details

	*/

	public function updateNodeSuccessors($nodeId, $successorIds)

	{	

		$bResult  = $this->db->query('UPDATE teeme_node SET successors=\''.$successorIds.'\' WHERE id='.$nodeId);			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}



	 /**

	* This method will be used for locking the leaf. 	

	*/

	public function lockLeaf($obj)

	{		

		$bResult  = $this->db->query('UPDATE teeme_leaf SET lockedStatus=\''.$obj->getLeafLockedStatus().'\',userLocked=\''.$obj->getLeafUserLocked().'\' WHERE id='.$obj->getLeafId());		

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}



	 /**

	* This method will be used for locking the leaf. 	

	*/
	/*Changed by Dashrath- Add $config for load db*/
	public function unlockLeafByUserId($obj, $config=0)

	{											

		/*Changed by Dashrath- Add if else condition for load db*/
		if ($config!=0)
        {
            $placedb = $this->load->database($config,TRUE);

            $bResult = $placedb->query('UPDATE teeme_leaf SET lockedStatus=\''.$obj->getLeafLockedStatus().'\',userLocked=\''.$obj->getLeafUserLocked().'\' WHERE userLocked='.$obj->getLeafUserId());
        }
		else
		{
			$bResult = $this->db->query('UPDATE teeme_leaf SET lockedStatus=\''.$obj->getLeafLockedStatus().'\',userLocked=\''.$obj->getLeafUserLocked().'\' WHERE userLocked='.$obj->getLeafUserId());	
		}
		/*Dashrath- changes end*/
		
			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}



	 /**

	* This method will be used to get the status of leaf lock. 	

	*/

	public function checkLeafLockStatus($leafId)

	{

	

		$lockStatus = 0;		

		$query = $this->db->query('SELECT lockedStatus FROM teeme_leaf WHERE id='.$leafId);								

		foreach($query->result() as $row)

		{

			$lockStatus = $row->lockedStatus;

		}	

		return $lockStatus; 		

	}



	 /**

	* This method will be used for update the leaf node id.

 	* @param $nodeId This is the variable used to hold the node ID .

	* @param $leafId This is the variable used to hold the node leaf Id.

	* @update the leaf node id 

	*/

	public function updateLeafNodeId($leafId, $nodeId)

	{	

		$bResult  = $this->db->query('UPDATE teeme_leaf SET nodeId='.$nodeId.' WHERE id='.$leafId);			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}

	public function updateOldNodeSuccessor($nodeId, $successor)

	{	

		$bResult  = $this->db->query('UPDATE teeme_node SET successors='.$successor.' WHERE id='.$nodeId);			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}	

	public function updateOldNodeNewNodeId($oldNodeId, $newNodeId)

	{	

		$bResult  = $this->db->query('UPDATE teeme_node SET newTreeVersionNodeId='.$newNodeId.' WHERE id='.$oldNodeId);			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}	

	

	public function updateLeafLockedStatus($leafId,$lockedStatus=0)

	{	

		$bResult  = $this->db->query('UPDATE teeme_leaf SET lockedStatus ='.$lockedStatus.' WHERE id='.$leafId);			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}

	

	public function updateNewVersionLeaf($oldLeafId,$newLeafId='',$status=0,$newContents='',$oldContents='',$newNodeId='')

	{

	

		if ($status==1)

			$bResult  = $this->db->query('UPDATE teeme_leaf SET newVersionLeafId ='.$newLeafId.' WHERE id='.$oldLeafId);

		else

		{

				$query = $this->db->query('SELECT newVersionLeafId FROM teeme_leaf WHERE id='.$oldLeafId);								

				foreach($query->result() as $row)

				{

					$newVersionLeafId = $row->newVersionLeafId;

				}

			if ($newVersionLeafId != 0)

			{

			

				$bResult  = $this->db->query('UPDATE teeme_leaf SET newVersionLeafId=0 WHERE id='.$oldLeafId);	

				$cResult  = $this->db->query('UPDATE teeme_leaf SET lockedStatus=0 WHERE id='.$newVersionLeafId);

				

				if ($newContents != '')	

					$dResult  = $this->db->query("UPDATE teeme_leaf SET contents='".$newContents."' WHERE id=".$newVersionLeafId);

				if ($newContents != '')	

					$eResult  = $this->db->query("UPDATE teeme_leaf SET contents='".$oldContents."' WHERE id=".$newLeafId);

					

			}

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

	

	public function updateNewVersionNode($oldNodeId,$newNodeId='',$status=0)

	{	

		if ($status==1)

			$bResult  = $this->db->query('UPDATE teeme_leaf SET newVersionLeafId ='.$newLeafId.' WHERE id='.$oldLeafId);

		else

		{

				$query = $this->db->query('SELECT newVersionLeafId FROM teeme_leaf WHERE id='.$oldLeafId);								

				foreach($query->result() as $row)

				{

					$newVersionLeafId = $row->newVersionLeafId;

				}

			if ($newVersionLeafId != 0)

			{

			

				$bResult  = $this->db->query('UPDATE teeme_leaf SET newVersionLeafId=0 WHERE id='.$oldLeafId);	

				$cResult  = $this->db->query('UPDATE teeme_leaf SET lockedStatus=0 WHERE id='.$newVersionLeafId);

				

				if ($newContents != '')	

					$dResult  = $this->db->query("UPDATE teeme_leaf SET contents='".$newContents."' WHERE id=".$newVersionLeafId);

				if ($newContents != '')	

					$eResult  = $this->db->query("UPDATE teeme_leaf SET contents='".$oldContents."' WHERE id=".$newLeafId);

			}

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

	public function insertLockedLeafDetails($oldLeafId,$newLeafId)

	{	

		$bResult  = $this->db->query('INSERT INTO teeme_temp_leaf (oldLeafId,newLeafId) VALUES ('.$oldLeafId.','.$newLeafId.')');			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}



	 /**

	* This method will be used to get the node id by using leaf id. 	

	*/

	public function getNodeIdByLeafId($leafId)

	{

		$query = $this->db->query('SELECT id FROM teeme_node WHERE leafId='.$leafId);								

		foreach($query->result() as $row)

		{

			$nodeId = $row->id;

		}	

		return $nodeId; 		

	}



	public function getNewTreeCorrespondentNodeIdByNodeOrder($treeId,$nodeOrder)

	{

		$query = $this->db->query('SELECT id FROM teeme_node WHERE treeIds='.$treeId .' AND nodeOrder='.$nodeOrder);								

		foreach($query->result() as $row)

		{

			$nodeId = $row->id;

		}	

		return $nodeId; 		

	}

	/* This method will be used for update the document memcache.

 	* @param $treeId This is the variable used to hold the document tree ID .	

	*/

	public function updateDocumentMemCache( $treeId )

	{

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc'.$treeId;			

		$tree = array();		

		$query = $this->db->query('SELECT 

					a.leafParentId, a.type, a.status, a.userId, a.createdDate, a.contents, a.latestContent, a.version, a.lockedStatus, a.userLocked, a.nodeId, b.version as nodeVersion, b.predecessor, b.successors, b.leafId, b.tag, b.treeIds, b.nodeOrder, b.starttime, b.endtime, b.id as nodeId1, a.id as leafId1, c.firstName, c.userName, c.lastName

					 FROM teeme_leaf a, teeme_node b, teeme_users c WHERE a.userId=c.userId AND a.id=b.id AND b.treeIds='.$treeId.' ORDER BY b.nodeOrder');

		foreach($query->result() as $docData)

		{

			$tree[] = $docData;

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

	

	 /**

	* This method will be used for update the tree edited Date.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $editedDate This is the variable used to hold the tree modified date.

	* @update the tree edited date

	*/

	public function updateTreeModifiedDate( $treeId, $editedDate )

	{	

		$bResult  = $this->db->query('UPDATE teeme_tree SET editedDate=\''.$editedDate.'\' WHERE id='.$treeId);			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}



	 /**

	* This method will be used for update the tree latest version status.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $versionStatus This is the variable used to hold the latest version of the tree.

	* @update the tree latest version status

	*/

	public function changeTreeLatestVersionStatus( $treeId, $versionStatus )

	{	

		$bResult  = $this->db->query('UPDATE teeme_tree SET latestVersion='.$versionStatus.' WHERE id='.$treeId);			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}





	public function checkTreeLatestVersion( $treeId )

	{	

	

		$query = $this->db->query('SELECT latestVersion FROM teeme_tree WHERE id='.$treeId);	

									

		foreach($query->result() as $row)

		{

			$latestVersion = $row->latestVersion;

		}	



		return $latestVersion;

		

	}

	 /**

	* This method will be used for update the document name to database.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $documentName This is the variable used to hold the document name

	* @update the document name

	*/

	public function updateDocumentName( $treeId, $documentName)

	{	
		//Manoj: replace mysql_escape_str function
		$bResult  = $this->db->query('UPDATE teeme_tree SET old_name=name,name=\''.$this->db->escape_str(addslashes($documentName)).'\' WHERE id='.$treeId);			

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}

	

	public function getOldContentOfTreeByTreeId( $treeId)

	{	

		$query  = $this->db->query('select old_name from teeme_tree  WHERE id='.$treeId);			

		foreach($query->result() as $row)

		{

			$old_name = $row->old_name;

		}	



		return $old_name;			

	}

	

	

		 /**

	* This method will be used for update the 'tree updates count' to database.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $documentName This is the variable used to hold the document name

	* @update the document name

	*/

	public function updateTreeUpdateCount( $treeId)

	{	

		$bResult  = $this->db->query('UPDATE teeme_tree SET updateCount = (updateCount+1) WHERE id='.$treeId);	

		$_SESSION['treeUpdateCount'.$treeId] = $_SESSION['treeUpdateCount'.$treeId]+1;		

		if($bResult)

		{									

			return true;

		}	

		else

		{

			return false;

		}				

	}

	

			 /**

	* This method will be used to set the tree update count

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $documentName This is the variable used to hold the document name

	* @update the document name

	*/

	public function setTreeUpdateCount($treeId)

	{	

		$query = $this->db->query('select updateCount from teeme_tree WHERE id='.$treeId);	

									

		foreach($query->result() as $row)

		{

			$updateCount = $row->updateCount;

		}	

		$_SESSION['treeUpdateCount'.$treeId] = $updateCount;	

		return $updateCount;

	}



		 /**

	* This method will be used to get the tree update count

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $documentName This is the variable used to hold the document name

	* @update the document name

	*/

	public function getTreeUpdateCount($treeId)

	{	

	 	

		$query = $this->db->query('select updateCount from teeme_tree WHERE id='.$treeId);	

									

		foreach($query->result() as $row)

		{

			$updateCount = $row->updateCount;

		}		

		return $updateCount;

	}



	 /**

	* This method will be used for update the node tree version.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $treeVersion This is the variable used to hold the tree version.

	* @update the tree version

	*/

	public function getDocumentFromDB( $treeId )

	{

		$tree = array();		


		/*Changed by Dashrath- remove , a.leafStatus, a.userId because this column is repeted*/
		$query = $this->db->query('SELECT 

			a.leafParentId, a.type, a.status, a.userId,a.leafStatus, c.tagName, c.nickName, a.createdDate,a.editedDate, a.contents, a.latestContent, a.version as leafVersion, a.lockedStatus, a.userLocked, b.predecessor, b.successors, b.leafId, b.tag, b.treeIds, b.nodeOrder, b.starttime, b.endtime, b.version, b.id as nodeId1, a.id as leafId1, c.firstName, c.userName, c.lastName 

			FROM 

			teeme_leaf a, teeme_node b, teeme_users c 

			WHERE 

			a.userId=c.userId AND a.id=b.leafId AND b.treeIds='.$treeId.' ORDER BY b.nodeOrder');

		foreach($query->result() as $docData)

		{

			

			$tree[] = $docData;

		}	

		

		return $tree;	

	}

	

	

	/**

	* This method will be used for update the node tree version.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $treeVersion This is the variable used to hold the tree version.

	* @update the tree version

	*/

	public function getDocumentFromDbTimeView( $treeId )

	{

		$tree = array();		

		$i=0;

		$query = $this->db->query('SELECT 

			a.leafParentId, a.type, a.status, a.userId, c.tagName, c.nickName, a.createdDate,a.editedDate, a.contents, a.latestContent, a.version as leafVersion, a.lockedStatus, a.userLocked, b.predecessor, b.successors, b.leafId, b.tag, b.treeIds, b.nodeOrder, b.starttime, b.endtime, b.version, b.id as nodeId1, a.id as leafId1, c.firstName, c.userName, c.lastName 

			FROM 

			teeme_leaf a, teeme_node b, teeme_users c 

			WHERE 

			a.userId=c.userId AND a.id=b.leafId AND b.treeIds='.$treeId.' ORDER BY b.nodeOrder');

		foreach($query->result() as $docData)

		{

			

			$tree[$i]['leafParentId'] = $docData->leafParentId;

			$tree[$i]['type'] = $docData->type;

			$tree[$i]['status'] = $docData->status;

			$tree[$i]['userId'] = $docData->userId;

			$tree[$i]['createdDate'] = $docData->createdDate;

			$tree[$i]['editedDate'] = $docData->editedDate;

			$tree[$i]['contents'] = $docData->contents;

			$tree[$i]['latestContent'] = $docData->latestContent;

			$tree[$i]['leafVersion'] = $docData->leafVersion;

			$tree[$i]['lockedStatus'] = $docData->lockedStatus;

			$tree[$i]['userLocked'] = $docData->userLocked;

			$tree[$i]['predecessor'] = $docData->predecessor;

			$tree[$i]['successors'] = $docData->successors;

			$tree[$i]['leafId'] = $docData->leafId;

			$tree[$i]['tag'] = $docData->tag;

			$tree[$i]['treeIds'] = $docData->treeIds;

			$tree[$i]['nodeOrder'] = $docData->nodeOrder;

			$tree[$i]['starttime'] = $docData->starttime;

			$tree[$i]['endtime'] = $docData->endtime;

			$tree[$i]['version'] = $docData->version;

			$tree[$i]['nodeId1'] = $docData->nodeId1;

			$tree[$i]['leafId1'] = $docData->leafId1;

			$tree[$i]['firstName'] = $docData->firstName;

			$tree[$i]['userName'] = $docData->userName;

			$tree[$i]['lastName'] = $docData->lastName;
			
			if($docData->nickName!='')
			{
				$tree[$i]['tagName'] = $docData->nickName;	
			}
			else
			{
				$tree[$i]['tagName'] = $docData->tagName;
			}

			if($docData->editedDate==0)

					{ 

						$tree[$i]['orderingDate'] = $docData->createdDate;	

					}	

					else

					{

						$tree[$i]['orderingDate'] = $docData->editedDate;	

					}

					$i++;	

		}	

		

		return $tree;	

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



	

	 /**

	* This method will be used to check the node version status.

 	* @param $successors This is the variable used to hold the cuccessor nodes of current node.

	* @param $treeVersion This is the variable used to hold the tree version.

	* @check the node version status

	*/

	function checkNodeVersionStatus($successors, $treeVersion)

	{

		$arrSucc = explode(',',$successors);

		$nodeId		= $arrSucc[0];	


		$query = $this->db->query('SELECT version FROM teeme_node WHERE id='.$nodeId);								

		foreach($query->result() as $row)

		{

			$version = $row->version;

		}		

		if($version <= $treeVersion) 

		{		

			return false;

		}

		else

		{

			return true;

		}

	}



	 /**

	* This method will be used to give the child tree id.

 	* @param $treeId This is the variable used to hold the current tree id.	

	* @return the next version tree id

	*/

	function getChildTreeIdByTreeId( $treeId )

	{

		$id = 0;

		$query = $this->db->query('SELECT id FROM teeme_tree WHERE parentTreeId='.$treeId .' AND embedded=0');								

		foreach($query->result() as $row)

		{

			$id = $row->id;

		}		

		return $id;

	}



	 /**

	* This method will be used to check the discussions of document node.

 	* @param $leafId This is the variable used to hold the current document leaf id.	

	* @return the number of discussions of current leaf

	*/

	function getTotalDiscussionRows( $leafId )

	{

		$totalDisRows = 0;

		$query = $this->db->query('SELECT name FROM teeme_tree WHERE nodes='.$leafId.' AND type=2');	

		if($query)

		{								

			$totalDisRows = $query->num_rows();

		}

		return $totalDisRows;

	}



	/**

	* This method will be used to get the top level nodes of document tree.

 	* @param $treeId This is the variable used to hold the tree Id.

	* @param $treeVersion This is the variable used to hold the current document tree version.

	* @return the top level nodes of document tree

	*/

	function getTopNodesByTreeId( $treeId, $treeVersion )

	{

	

		$arrNodes = array();

		//$query = $this->db->query('SELECT a.id as nodeId,a.tag, a.treeIds,b.id as leafId, b.type, b.authors,b.userId, b.contents,b.lockedStatus,b.createdDate FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.successors = 0 AND a.treeIds = '.$treeId.' ORDER BY nodeOrder');	
		
		$query = 'SELECT a.id as nodeId,a.tag, a.treeIds,b.id as leafId, b.type, b.authors,b.userId, b.contents,b.lockedStatus,b.createdDate,a.nodeOrder FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.successors = 0 AND a.treeIds = '.$treeId.' ORDER BY nodeOrder';	
		
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
				
				$arrNodes[$i]['nodeOrder'] 	= $nodeData->nodeOrder;

				$i++;	

			}

		}	

		return $arrNodes;		

	}

	

	public function getPerentInfo($nodeId){

		$treeData	= array();

	

		$query = $this->db->query("SELECT a.id as nodeId, a.treeIds, a.predecessor as predecessor, a.successors as successors, b.id as leafId, b.status as status, b.userId as userId, DATE_FORMAT( b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate, b.contents as contents, a.nodeOrder as nodeOrder FROM teeme_node a, teeme_leaf b where b.nodeId=a.id and a.id= ".$nodeId);		

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
				
				$treeData['nodeOrder'] = $row->nodeOrder;

			}

		}

		return $treeData;

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

			$query = $this->db->query("SELECT a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as DiscussionCreatedDate FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY a.nodeOrder");

			

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

	/*Added by Surbhi IV for checking version */

	function checkVersion($treeId)

	{

	 	$query = $this->db->query('select * from teeme_tree WHERE parentTreeId='.$treeId.' And latestVersion=1');

		foreach($query->result() as $row)

		{

			$row = $row;

		}		

		return $row;

	}

	/*End of Added by Surbhi IV for checking version */

	

	/*This function is used to get list of leaf authors for user tags in tag view*/

	function getLeafAuthorsByLeafIds($treeId)

	{

		$query = $this->db->query("(SELECT distinct(b.userId) as authors,u.tagName FROM teeme_node a, teeme_leaf b,teeme_users u WHERE b.id=a.leafId and a.treeIds=".$treeId." and u.userId=b.userId ORDER BY a.nodeOrder) UNION 

		 (SELECT a.userId as authors,b.tagName from teeme_tree a,teeme_users b where a.userId=b.userId and a.id=$treeId)"); 

		

		return $query->result_array();

	}

	//Manoj: to get details of parent leaf for the Note 

		public function getDocsPerent($pId){
			
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
		
		//Manoj: to get details of tree 
		
		public function getDocs($treeId){
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
	
	/* This method is used to get the notes contributors */
	function getDocsContributors($notesId)
	{		
		$userData 	= array();		
		$i = 0;
		if ($notesId>0)
		{
			$query 		= $this->db->query('SELECT b.tagName, b.nickName, a.userId, b.userGroup FROM teeme_notes_users a, teeme_users b WHERE a.userId = b.userId AND a.notesId = '.$notesId.' AND a.status = 3 ORDER BY b.tagName');
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
	
	/* This function is used to insert the contributor records to database. */
	public function insertContributorsRecord($object,$status = 1)
    {
		//Inserting notes users
		if($object!= NULL && ($object instanceof Notes_users))
		{
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
	}
	/*Draft reserved users code start*/
	public function clearReservedUsers($leafId)
	{
	
		$strResultSQL = "DELETE FROM teeme_leaf_reservation WHERE leafId='".$leafId."'";
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
	
	function getDocsReservedUsers($leafId)
	{		
		$userData 	= array();		
		$i = 0;
		if ($leafId>0 && $leafId!='')
		{
			$query 		= $this->db->query('SELECT b.tagName, b.nickName, a.userId, b.userGroup FROM teeme_leaf_reservation a, teeme_users b WHERE a.userId = b.userId AND a.leafId = '.$leafId.' AND a.status = 1 ORDER BY b.tagName');
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
	
	public function insertReservedUserRecord($object)
    {
		//Inserting notes users
		
		$this->db->trans_begin();
		
		if($object!= NULL && ($object instanceof Notes_users))
		{
			$strResultSQL = "INSERT INTO teeme_leaf_reservation(leafId, treeId, userId
						)
						VALUES
						(
						'".$object->getNotesId()."','".$object->getNotesTreeId()."','".$object->getNotesUserId()."'
						)";
		}
		$bResult = $this->db->query($strResultSQL);
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}	
	}
	
	public function getDraftStatusByNodeOrder($treeId,$nodeOrder)

	{
		if($treeId != '' && $nodeOrder != '')
		{

		/*Changed by Dashrath- Add a.userId column in query*/
		$query = 'SELECT a.leafStatus, a.userId, b.leafId FROM teeme_leaf a, teeme_node b WHERE b.treeIds='.$treeId .' AND b.nodeOrder='.$nodeOrder.' AND b.leafId = a.id ORDER BY a.editedDate DESC LIMIT 0,1';	
		
		//return $query;
		
		$query = $this->db->query($query);							
		
		foreach($query->result() as $row)

		{

			$leafStatus = $row->leafStatus;
			$draftLeafId = $row->leafId;

			/*Added by Dashrath- Add userId column*/
			$draftLeafUserId = $row->userId;

		}	

		//return $leafStatus; 	
		
		if($leafStatus == 'draft')
		{
			$query = 'SELECT a.id as leafId, b.id as nodeId FROM teeme_leaf a, teeme_node b WHERE b.treeIds='.$treeId .' AND b.nodeOrder='.$nodeOrder.' AND b.leafId = a.id AND a.leafStatus="publish" ORDER BY a.editedDate DESC LIMIT 0,1';
			
			$query = $this->db->query($query);							
		
			foreach($query->result() as $row)
	
			{
				
				$draftLeafIds['prevPublishLeafId'] = $row->leafId;
				$draftLeafIds['draftLeafId']	   = $draftLeafId;

				/*Added by Dashrath- Add draftLeafUserId column in array*/
				$draftLeafIds['draftLeafUserId']	   = $draftLeafUserId;
	
			}	
			return $draftLeafIds; 		
		}	
		}

	}
	
	//Get leaf status (publish or draft)
	public function getLeafStatusByLeafId($leafId)
	{
		if($leafId != '')
		{
			$query = 'SELECT leafStatus FROM teeme_leaf WHERE id = "'.$leafId.'"';	
			
			$query = $this->db->query($query);							
			
			foreach($query->result() as $row)
			{
				$leafStatus = $row->leafStatus;
			}
			
			return $leafStatus;
			
		}	
		
	}
	
	public function getNextLeafPublishStatus($treeId,$nodeOrder,$leafId)
	{
		if($treeId != '' && $nodeOrder != '' && $leafId != '')
		{
			$query = 'SELECT a.leafStatus, b.leafId FROM teeme_leaf a, teeme_node b WHERE b.treeIds='.$treeId .' AND b.nodeOrder='.$nodeOrder.' AND b.leafId = a.id AND (a.leafStatus="publish" OR a.leafStatus="deleted") AND a.id > '.$leafId.' LIMIT 0,1';	
		
			//return $query;
			
			$query = $this->db->query($query);							
			
			foreach($query->result() as $row)
			{
				$leafNextPublicStatus = $row->leafStatus;
			}	
			if($leafNextPublicStatus == 'publish' || $leafNextPublicStatus == 'deleted')
			{
				return $leafNextPublicStatus;
			}
			else
			{
				return 'draft';
			}
		}	
	}
	
	public function getPrevDraftDataByUserId($treeId,$nodeOrder,$latestDraftLeafId,$userId,$prevPublishLeafId)

	{
		if($treeId != '' && $nodeOrder != '' && $latestDraftLeafId != '' && $userId != '' && $prevPublishLeafId!='')
		{

		$query = 'SELECT a.leafStatus, b.leafId FROM teeme_leaf a, teeme_node b, teeme_leaf_reservation c WHERE b.treeIds='.$treeId .' AND b.nodeOrder='.$nodeOrder.' AND b.leafId = a.id AND c.leafId = a.id AND c.userId = '.$userId.' AND a.id > '.$prevPublishLeafId.' AND c.status = 1 ORDER BY a.editedDate DESC LIMIT 0,1';	
		
		//return $query;
		
		$query = $this->db->query($query);							
		
		foreach($query->result() as $row)

		{

			$leafStatus = $row->leafStatus;
			$draftLeafId = $row->leafId;

		}	
		
		return $draftLeafId;

		}

	}
	
	//Get last publish leaf id
	public function getPreviousPublishLeafId($treeId,$nodeOrder)

	{
		if($treeId != '' && $nodeOrder != '')
		{
			$query = 'SELECT a.id as leafId, b.id as nodeId FROM teeme_leaf a, teeme_node b WHERE b.treeIds='.$treeId .' AND b.nodeOrder='.$nodeOrder.' AND b.leafId = a.id AND a.leafStatus="publish" ORDER BY a.editedDate DESC LIMIT 0,1';
			
			$query = $this->db->query($query);							
		
			foreach($query->result() as $row)
			{
				$prevPublishLeafId = $row->leafId;
			}	
			return $prevPublishLeafId; 		
		}
	}
	
	public function getNxtDraftDataByUserId($treeId,$nodeOrder,$userId,$latestLeafId)

	{
		if($treeId != '' && $nodeOrder != '' && $latestLeafId != '' && $userId != '')
		{

		$query = 'SELECT a.leafStatus, b.leafId FROM teeme_leaf a, teeme_node b, teeme_leaf_reservation c WHERE b.treeIds='.$treeId .' AND b.nodeOrder='.$nodeOrder.' AND b.leafId = a.id AND c.leafId = a.id AND c.userId = '.$userId.' AND a.id > '.$latestLeafId.' AND a.leafStatus="draft" AND c.status = 1 ORDER BY a.editedDate ASC LIMIT 0,1';	
		
		//return $query;
		
		$query = $this->db->query($query);							
		
		foreach($query->result() as $row)

		{

			$leafStatus = $row->leafStatus;
			//$draftLeafId = $row->leafId;

		}	
		
		return $leafStatus;

		}

	}
	
	public function updateReservedUserRecord($usrArray, $status)

	{
		if($usrArray['treeId'] != '' && $usrArray['userId'] != '')
		{
			$this->db->trans_begin();
			
			/*Added by Dashrath- Add if condition for check leafid set*/
			if(isset($usrArray['leafId']) && $usrArray['leafId']>0)
			{
				/*Changed by Dashrath- Add leafId in where condition for update record*/
				$query  = 'UPDATE teeme_leaf_reservation SET status='.$status.' WHERE treeId='.$usrArray['treeId'].' AND userId='.$usrArray['userId'].' AND leafId='.$usrArray['leafId'];
			}
			else
			{
				$query  = 'UPDATE teeme_leaf_reservation SET status='.$status.' WHERE treeId='.$usrArray['treeId'].' AND userId='.$usrArray['userId'];
			}
			
			
			$query = $this->db->query($query);	
	
			if($this->db->trans_status()=== FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return true;
			}	
		}			

	}
	
	public function getLeafParentIdByNodeOrder($treeId,$nodeOrder)

	{
		if($treeId != '' && $nodeOrder != '')
		{

			$query = 'SELECT a.leafStatus, a.userId, b.leafId, b.id FROM teeme_leaf a, teeme_node b WHERE b.treeIds='.$treeId .' AND b.nodeOrder='.$nodeOrder.' AND b.leafId = a.id AND b.predecessor=0 LIMIT 0,1';	
			
			$query = $this->db->query($query);							
			
			$parentLeafArray = array();
			foreach($query->result() as $row)
			{
				$parentLeafArray['parentLeafId'] = $row->leafId;
				$parentLeafArray['parentNodeId'] = $row->id;
				$parentLeafArray['parentLeafUserId'] = $row->userId;
				$parentLeafArray['leafStatus'] = $row->leafStatus;
			}
			
			return $parentLeafArray;

		}

	}
	
	public function updateLeafStatus($leafId, $status)

	{
		if($leafId!='' && $status!='')
		{
			$this->db->trans_begin();
				
			$query  = 'UPDATE teeme_leaf SET leafStatus="'.$status.'" WHERE id='.$leafId;
			
			$query = $this->db->query($query);	
	
			if($this->db->trans_status()=== FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return true;
			}	
		}			

	}
	
	function getDocTreeNodesByTreeId( $treeId, $treeVersion )

	{

	

		$arrNodes = array();

		/*Commented by Dashrath- Comment old query and changes query add below with add leaf version column in query*/
		// $query = 'SELECT a.id as nodeId,a.tag, a.treeIds,b.id as leafId, b.type, b.authors,b.userId, b.contents,b.lockedStatus,b.createdDate, b.leafStatus, a.nodeOrder, b.userLocked FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.successors = 0 AND a.treeIds = '.$treeId.' ORDER BY nodeOrder';

		/*Added by Dashrath- Add version column in query*/
		$query = 'SELECT a.id as nodeId,a.tag, a.treeIds,b.id as leafId, b.type, b.authors,b.userId, b.contents,b.lockedStatus,b.createdDate, b.leafStatus, a.nodeOrder, b.userLocked, b.version FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.successors = 0 AND a.treeIds = '.$treeId.' ORDER BY nodeOrder';	
		/*Dashrath- code end*/
		
		$query = $this->db->query($query);									
		
		if($query->num_rows() > 0)

		{		

			$i = 0;							

			foreach ($query->result() as $nodeData)

			{
				if($nodeData->leafStatus=='draft' && $nodeData->nodeId!='')
				{
					/*Commented by Dashrath- Comment old query and changes query add below with add leaf version column in query*/
					// $subquery = 'SELECT a.id as nodeId,a.tag, a.treeIds,b.id as leafId, b.type, b.authors,b.userId, b.contents,b.lockedStatus,b.createdDate, b.leafStatus, a.nodeOrder, b.userLocked FROM teeme_node a, teeme_leaf b WHERE a.successors='.$nodeData->nodeId.' AND b.leafStatus = "publish" AND a.treeIds = '.$treeId.' AND a.leafId = b.id ORDER BY nodeOrder LIMIT 0,1';

					/*Added by Dashrath- Add version column in query*/
					$subquery = 'SELECT a.id as nodeId,a.tag, a.treeIds,b.id as leafId, b.type, b.authors,b.userId, b.contents,b.lockedStatus,b.createdDate, b.leafStatus, a.nodeOrder, b.userLocked, b.version FROM teeme_node a, teeme_leaf b WHERE a.successors='.$nodeData->nodeId.' AND b.leafStatus = "publish" AND a.treeIds = '.$treeId.' AND a.leafId = b.id ORDER BY nodeOrder LIMIT 0,1';
					/*Dashrath- code end*/	
		
					$subquery = $this->db->query($subquery);	
					if($subquery->num_rows() > 0)
					{
						foreach($subquery->result() as $row)
						{
							$arrNodes[$i]['nodeId'] 	= $row->nodeId;
	
							$arrNodes[$i]['leafId'] 	= $row->leafId;
			
							$arrNodes[$i]['tag'] 		= $row->tag;
			
							$arrNodes[$i]['treeIds'] 	= $row->treeIds;
			
							$arrNodes[$i]['type'] 		= $row->type;
			
							$arrNodes[$i]['authors'] 	= $row->authors;
			
							$arrNodes[$i]['userId'] 	= $row->userId;
			
							$arrNodes[$i]['contents'] 	= $row->contents;
			
							$arrNodes[$i]['lockedStatus'] 	= $row->lockedStatus;
			
							$arrNodes[$i]['createdDate'] 	= $row->createdDate;
							
							$arrNodes[$i]['leafStatus'] 	= $row->leafStatus;
							
							$arrNodes[$i]['nodeOrder'] 	= $row->nodeOrder;
							
							$arrNodes[$i]['userLocked'] 	= $row->userLocked;

							//Added by Dashrath- version add in array
							$arrNodes[$i]['version'] 	= $row->version;
							
							$i++;
						}		
					}						
				}
				
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

				//Added by Dashrath- version add in array
				$arrNodes[$i]['version'] 	= $nodeData->version;

				$i++;	

			}

		}	

		return $arrNodes;		

	}
	
	public function updateNodeNextPreviousId($nodeId, $currentNodeId)

	{	
		if($nodeId!='' && $currentNodeId!='')
		{
			$this->db->trans_begin();
		
			$bResult  = $this->db->query('UPDATE teeme_node SET successors=\''.$currentNodeId.'\' WHERE id='.$nodeId);	
	
			if($bResult)
	
			{		
			
				$result  = $this->db->query('UPDATE teeme_node SET predecessor=\''.$nodeId.'\' WHERE id='.$currentNodeId);									
	
				if($this->db->trans_status()=== FALSE)
				{
					$this->db->trans_rollback();
					return false;
				}
				else
				{
					$this->db->trans_commit();
					return true;
				}		
	
			}	
	
			else
	
			{
	
				return false;
	
			}
		}				
	}
	
	public function getNodeDataByLeafId($leafId)
	{
		if($leafId != '')
		{
			$node = array();		
			
			$query = $this->db->query('SELECT a.id as nodeId,a.leafId,a.nodeOrder as leafOrder,a.treeIds, b.contents as contents,c.type
			FROM teeme_node	a, teeme_leaf b, teeme_tree c WHERE b.id=a.leafId AND a.treeIds=c.id AND a.leafId='.$leafId);
			foreach($query->result() as $row)
			{
				
				$node['nodeId'] = $row->nodeId;
				$node['leafId'] = $row->leafId;
				$node['nodeOrder'] = $row->leafOrder;
				$node['treeType'] = $row->type;
				$node['treeId'] = $row->treeIds;
				$node['contents'] = $row->contents;
			}	
			
			return $node;	
		}
	}
	
	public function getUserDraftLeafAccess($treeId,$nodeId,$parentLeafId,$nodeOrder,$userId)

	{
		if($treeId != '' && $nodeId != '' && $leafId != '' && $nodeOrder != '' && $userId != '')
		{

			$query = 'SELECT a.id FROM teeme_leaf_reservation a WHERE a.leafId = '.$parentLeafId.' AND a.userId = '.$userId.' AND a.status = 1 LIMIT 0,1';	
			
			//return $query;
			
			$query = $this->db->query($query);							
			
			foreach($query->result() as $row)
	
			{
	
				$leafStatus = $row->leafStatus;
				//$draftLeafId = $row->leafId;
	
			}	
			
			return $leafStatus;

		}

	}
	
	/*Changed by Dashrath- Add $newLeafDiscarded for when discarded new leaf*/
	public function discardLeafNextPrevId($prevNodeId, $currentNodeId,$currentLeafId, $newLeafDiscarded=0)

	{	
		/*Changed by Dashrath- check $newLeafDiscarded condition and add else condition*/
		if($prevNodeId!='' && $currentNodeId!='' && $currentLeafId!='' && $newLeafDiscarded==0)
		{
			$this->db->trans_begin();
		
			$bResult  = $this->db->query('UPDATE teeme_node SET successors=0 WHERE id='.$prevNodeId);	
	
			if($bResult)
	
			{		
			
				$result  = $this->db->query('UPDATE teeme_node SET predecessor=0 WHERE id='.$currentNodeId);
				
				if($result)
				{
					$result2  = $this->db->query('UPDATE teeme_leaf SET leafStatus=\'discarded\' WHERE id='.$currentLeafId);
				}									
	
				if($this->db->trans_status()=== FALSE)
				{
					$this->db->trans_rollback();
					return false;
				}
				else
				{
					$this->db->trans_commit();
					return true;
				}		
	
			}	
	
			else
	
			{
	
				return false;
	
			}
		}
		else
		{
			$result2  = $this->db->query('UPDATE teeme_leaf SET leafStatus=\'discarded\' WHERE id='.$currentLeafId);

			if($result2)
			{
				return true;
			}
			else
			{
				return false;
			}

		}				
	}
	
	public function getLeafReserveStatus($treeId,$leafId)
	{
		if($treeId!='' && $leafId!='')
		{		
			$query = $this->db->query("SELECT count(*) AS total FROM teeme_leaf_reservation WHERE treeId = '".$treeId."' AND leafId = '".$leafId."'");
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					if ($row->total > 0)
					{
						return false;				
					}
				}		
			}		
			return true;	
			
				
		}
	}
	
	public function applyReservedListStatus($usrArray, $status)

	{
		if($usrArray['treeId'] != '' && $usrArray['userId'] != '' && $usrArray['userId'] != '')
		{
			$this->db->trans_begin();
				
			$query  = 'UPDATE teeme_leaf_reservation SET status='.$status.' WHERE treeId='.$usrArray['treeId'].' AND userId='.$usrArray['userId'].' AND leafId='.$usrArray['leafId'];
			
			$query = $this->db->query($query);	
	
			if($this->db->trans_status()=== FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return true;
			}	
		}			

	}
	
	public function getUserNonContReserveStatus($treeId,$leafId,$userId)
	{
		if($treeId!='' && $leafId!='' && $userId!='')
		{		
			$result = $this->getLeafReserveStatus($treeId,$leafId);
			if($result==1)
			{		
				$contributors = $this->getDocsContributors($treeId);
	
				$contributorsUserId			= array();	
				foreach($contributors  as $userData)
				{
					$contributorsUserId[] 	= $userData['userId'];	
				}
				if(in_array($userId,$contributorsUserId))
				{
					return true;
				}
			}
		}
	}
	
	public function deleteReservedUsers($treeId)
	{
		if($treeId!='')
		{
			$strResultSQL = "DELETE FROM teeme_leaf_reservation WHERE treeId='".$treeId."'";
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
	}
	//get leaf status by node id
	public function getLeafStatusByNodeId ($nodeId)
	{
		if($nodeId!='')
		{
			$query = $this->db->query("SELECT leafStatus FROM teeme_leaf WHERE nodeId = '".$nodeId."'");
	
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$arrLeaf['leafStatus']  = $row->leafStatus;	
				}				
			}		
			return $arrLeaf;	
		}
	}
	
	//Update user locked id
	public function updateLeafLockedUsersId($leafId,$userId)

	{	
		if($leafId!='' && $userId!='')
		{

			$bResult  = $this->db->query('UPDATE teeme_leaf SET userLocked ='.$userId.' WHERE id='.$leafId);			
	
			if($bResult)
	
			{									
	
				return true;
	
			}	
	
			else
	
			{
	
				return false;
	
			}	
		}			

	}
			
	//code end


	/*Added by Dashrath- Update draft leaf content by autosave feature*/
	public function updateDraftLeafDetails($curContent, $nodeId, $leafStatus, $updateFrom='add')
	{
		if($updateFrom=='edit')
		{
			$query = $this->db->query("UPDATE teeme_leaf SET contents='".$curContent."' WHERE nodeId=".$nodeId);
		}
		else
		{
			$query = $this->db->query("UPDATE teeme_leaf SET contents='".$curContent."', leafStatus='".$leafStatus."' WHERE nodeId=".$nodeId." AND leafStatus='draft'");
		}

		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	/*Dashrath- code end*/

	/*Added by Dashrath- updateDraftLeafStatusByNodeId function start*/
	public function updateDraftLeafStatusByNodeId($nodeId, $leafStatus)
	{
		$query = $this->db->query("UPDATE teeme_leaf SET leafStatus='".$leafStatus."' WHERE nodeId=".$nodeId." AND leafStatus='draft'");

		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	/*Dashrath- code end*/
 }

?>