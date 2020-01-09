<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: tree.php

	* Description 		  	: A class file used to set and get the artifact tree entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 12-08-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the document Information into the Class variable and return it according to their need.

* @author Ideavate Solutions (www.ideavate.com)

*/

class tree extends CI_Model

{

	/**

	* This variable will be used to store the id of the tree.

	*/

	private  $id = '';

	/**

	* This variable will be used to store the parent tree id of the tree.

	*/

	private  $parentTreeId = 0;

	/**

	* This variable will be used to store the name of the tree.

	*/

	private  $name = '';

  

   /**

	* This variable will be used to store the type of tree.

	*/

	private $type = '';

	

	/**

	* This variable will be used to store owner id of tree.

	*/

	private $userId = '';



	/**

	* This variable will be used to store created date of tree.

	*/

	private $createdDate = '';

	

	/**

	* This variable will be used to store modified date of tree.

	*/

	private $editedDate = '';



	/**

	* This variable will be used to store the list of workspaces of tree.

	*/

	private $workSpaces = '';



	/**

	* This variable will be used to store the workspace type.

	*/

	private $workSpaceType = 0;





	/**

	* This variable will be used to store the list of node ids of tree.

	*/

	private $nodeIds = '';

	/**

	* This variable will be used to store the version of the tree.

	*/

	private $treeVersion = 1;

	/**

	* This variable will be used to store the mainversion of the tree.

	*/

	private $treeMainVersion = 1;

	/**

	* This variable will be used to store the latest version status of the tree.

	*/

	private $treeLatestVersion = 1;

	/**

	* This variable will be used to store the autonumbering of the tree.

	*/

	private $autonumbering = 0;


	/**

	* This variable will be used to store the position of the tree.

	*/

	private $position = 1;

	

   /**

	* This method will be used to set the tree Id into class variable.

	* @param $treeId This is the variable that will set the value into class variable.

	*/

	public function setTreeId($treeId)

	{

		if($treeId !=  NULL)

		{

			$this->id = $treeId;

		}

	}

   /**

	* This method will be used to retrieve the tree id.

	* @return The tree id

 	*/

	public function getTreeId()

	{

		return $this->id;

 	}



	 /**

	* This method will be used to set the parent tree Id into class variable.

	* @param $parentTreeId This is the variable that will set the value into class variable.

	*/

	public function setParentTreeId($treeId)

	{

		if($treeId !=  NULL)

		{

			$this->parentTreeId = $treeId;

		}

	}

   /**

	* This method will be used to retrieve the parent tree id.

	* @return The parent tree id

 	*/

	public function getParentTreeId()

	{

		return $this->parentTreeId;

 	}



	/**

	* This method will be used to set the tree name into class variable.

	* @param $treeName This is the variable that will set the value into class variable.

	*/

	public function setTreeName($treeName)

	{

		if($treeName !=  NULL)

		{

			$this->name = $treeName;

		}

	}

   /**

	* This method will be used to retrieve the tree name.

	* @return The tree name

 	*/

	public function getTreeName()

	{

		return $this->name;

 	}



	 /**

	* This method will be used to set the tree type into class variable.

	* @param $treeType This is the variable that will set the value into class variable.

	*/

	public function setTreeType($treeType)

	{

		if($treeType !=  NULL)

		{

			$this->type = $treeType;

		}

	}

   /**

	* This method will be used to retrieve the tree type.

	* @return The tree type

 	*/

	public function getTreeType()

	{

		return $this->type;

 	}

	

	 /**

	* This method will be used to set the ownerId of the tree.

	* @param $userIdVal This is the variable that will set the value into class variable.

	*/

	public function setUserId($userIdVal)

	{

		if($userIdVal !=  NULL)

		{

			$this->userId = $userIdVal;

		}

	}

   /**

	* This method will be used to retrieve the owner id of the tree.

	* @return The owner user id of the tree

 	*/

	public function getUserId()

	{

		return $this->userId;

 	}



	 /**

	* This method will be used to set the created date of tree.

	* @param $treeCreatedDate This is the variable that will set the value into class variable.

	*/

	public function setCreatedDate($treeCreatedDate)

	{

		if($treeCreatedDate !=  NULL)

		{

			$this->createdDate = $treeCreatedDate;

		}

	}

   /**

	* This method will be used to retrieve the created date of tree.

	* @return The created date of the tree

 	*/

	public function getCreatedDate()

	{

		return $this->createdDate;

 	}



	 /**

	* This method will be used to set the edited date of tree.

	* @param $treeEditedDate This is the variable that will set the value into class variable.

	*/

	public function setEditedDate($treeEditedDate)

	{

		if($treeEditedDate !=  NULL)

		{

			$this->editedDate = $treeEditedDate;

		}

	}

   /**

	* This method will be used to retrieve the edited date of tree.

	* @return The edited date of the tree

 	*/

	public function getEditedDate()

	{

		return $this->createdDate;

 	}



	 /**

	* This method will be used to set the workspaces of tree.

	* @param $treeWorkspace This is the variable that will set the value into class variable.

	*/

	public function setWorkspaces($treeWorkspace)

	{

		if($treeWorkspace !=  NULL)

		{

			$this->workspaces = $treeWorkspace;

		}

	}

   /**

	* This method will be used to retrieve the workspace of tree.

	* @return The workspace of the tree

 	*/

	public function getWorkspaces()

	{

		return $this->workspaces;

 	}



	 /**

	* This method will be used to set the workspace type of tree.

	* @param $treeWorkSpaceType This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceType($treeWorkSpaceType)

	{

		if($treeWorkSpaceType !=  NULL)

		{

			$this->workSpaceType = $treeWorkSpaceType;

		}

	}

   /**

	* This method will be used to retrieve the workspac type of tree.

	* @return The workspace type of the tree

 	*/

	public function getWorkSpaceType()

	{

		return $this->workSpaceType;

 	}

 	

  	 /**

	* This method will be used to set the node ids of tree.

	* @param $treeNodeIds This is the variable that will set the value into class variable.

	*/

	public function setNodes($treeNodeIds)

	{

		if($treeNodeIds !=  NULL)

		{

			$this->nodeIds = $treeNodeIds;

		}

	}

   /**

	* This method will be used to retrieve the node Ids of the tree.

	* @return The node ids of the tree

 	*/

	public function getNodes()

	{

		return $this->nodeIds;

 	}



	/**

	* This method will be used to set the version number of the tree.

	* @param $treeVersionVal This is the variable that will set the value into class variable.

	*/

	public function setTreeVersion($treeVersionVal)

	{

		if($treeVersionVal !=  NULL)

		{

			$this->treeVersion = $treeVersionVal;

		}

	}

   /**

	* This method will be used to retrieve the version number of the tree.

	* @return The version number of the tree

 	*/

	public function getTreeVersion()

	{

		return $this->treeVersion;

 	}

	/**

	* This method will be used to set the main version number of the tree.

	* @param $treeMainVersionVal This is the variable that will set the value into class variable.

	*/

	public function setTreeMainVersion($treeMainVersionVal)

	{

		if($treeMainVersionVal !=  NULL)

		{

			$this->treeMainVersion = $treeMainVersionVal;

		}

	}

   /**

	* This method will be used to retrieve the main version number of the tree.

	* @return The main version number of the tree

 	*/

	public function getTreeMainVersion()

	{

		return $this->treeMainVersion;

 	}

	/**

	* This method will be used to set the latest version status of the tree.

	* @param $setTreeLatestVersionVal This is the variable that will set the value into class variable.

	*/

	public function setTreeLatestVersion($setTreeLatestVersionVal)

	{

		if($setTreeLatestVersionVal !=  NULL)

		{

			$this->treeLatestVersion = $setTreeLatestVersionVal;

		}

	}

   /**

	* This method will be used to retrieve the latest version status of the tree.

	* @return The latest version status of the tree

 	*/

	public function getTreeLatestVersion()

	{

		return $this->treeLatestVersion;

 	}

 	/**

	* This method will be used to set the autonumbering of the tree.

	* @param $setAutonumberingVal This is the variable that will set the value into class variable.

	*/

	public function setAutonumbering($setAutonumberingVal)
	{
		if($setAutonumberingVal > 0)
		{
			$this->autonumbering = $setAutonumberingVal;
		}
	}
 	/**

	* This method will be used to retrieve the autonumbering status of the tree.

	* @return The autonumbering of the tree

 	*/

	public function getAutonumbering()
	{
		return $this->autonumbering;
 	}

 	/**

	* This method will be used to set the position of the add document.

	* @param $setDocumentPosition This is the variable that will set the value into class variable.

	*/

	public function setDocumentPosition($setDocumentPosition)
	{
		if($setDocumentPosition > 0)
		{
			$this->position = $setDocumentPosition;
		}
	}
 	/**

	* This method will be used to retrieve the position status of the add document.

	* @return The position of the document

 	*/

	public function getDocumentPosition()
	{
		return $this->position;
 	}

}

?>