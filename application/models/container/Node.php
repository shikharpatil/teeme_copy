<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: node.php

	* Description 		  	: A class file used to set and get the document node entities

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

class node extends CI_Model

{

   /**

	* This variable will be used to store the id of the node.

	*/

	private  $id = '';



	/**

	* This variable will be used to store the predecessor of the node.

	*/

	private  $predecessor = '';

  

   /**

	* This variable will be used to store the successor of the node.

	*/

	private $successor = '';

	

	/**

	* This variable will be used to store the leaf id of the node.

	*/

	private $leafId = '';



	/**

	* This variable will be used to store the tag of the node.

	*/

	private $tag = '';

	

	/**

	* This variable will be used to store tree ids of node.

	*/

	private $treeIds = '';

	

	/**

	* This variable will be used to store the order of the node.

	*/

	private $nodeOrder = 1;

	/**

	* This variable will be used to set the node version.

	*/

	private $version = 1;

	 /**

	* This method will be used to set the node Id into class variable.

	* @param $nodeId This is the variable that will set the value into class variable.

	*/

	public function setNodeId($nodeId)

	{

		if($nodeId !=  NULL)

		{

			$this->id = $nodeId;

		}

	}

   /**

	* This method will be used to retrieve the node id.

	* @return The node id

 	*/

	public function getNodeId()

	{

		return $this->id;

 	}

	/**

	* This method will be used to set the node predecessor into class variable.

	* @param $nodePredecessor This is the variable that will set the value into class variable.

	*/

	public function setNodePredecessor($nodePredecessor)

	{

		if($nodePredecessor !=  NULL)

		{

			$this->predecessor = $nodePredecessor;

		}

	}

   /**

	* This method will be used to retrieve the node predecessor.

	* @return The node predecessor

 	*/

	public function getNodePredecessor()

	{

		return $this->predecessor;

 	}



	 /**

	* This method will be used to set the node successor into class variable.

	* @param $nodeSuccessor This is the variable that will set the value into class variable.

	*/

	public function setNodeSuccessor($nodeSuccessor)

	{

		if($nodeSuccessor !=  NULL)

		{

			$this->successor = $nodeSuccessor;

		}

	}

   /**

	* This method will be used to retrieve the node successor.

	* @return The node successor

 	*/

	public function getNodeSuccessor()

	{

		return $this->successor;

 	}

	

	 /**

	* This method will be used to set the leaf id of the node.

	* @param $nodeLeafId This is the variable that will set the value into class variable.

	*/

	public function setLeafId($nodeLeafId)

	{

		if($nodeLeafId !=  NULL)

		{

			$this->leafId = $nodeLeafId;

		}

	}

   /**

	* This method will be used to retrieve the leaf id of the node.

	* @return The leaf id of the node

 	*/

	public function getLeafId()

	{

		return $this->leafId;

 	}



	 /**

	* This method will be used to set the content tag of node.

	* @param $nodeTag This is the variable that will set the value into class variable.

	*/

	public function setNodeTag($nodeTag)

	{

		if($nodeTag !=  NULL)

		{

			$this->tag = $nodeTag;

		}

	}

   /**

	* This method will be used to retrieve the content tag of the node.

	* @return The content tag of the node

 	*/

	public function getNodeTag()

	{

		return $this->tag;

 	}



	 /**

	* This method will be used to set the tree ids of the node.

	* @param $nodeTreeId This is the variable that will set the value into class variable.

	*/

	public function setNodeTreeIds($nodeTreeId)

	{

		if($nodeTreeId !=  NULL)

		{

			$this->treeIds = $nodeTreeId;

		}

	}

   /**

	* This method will be used to retrieve the tree ids of node.

	* @return The tree id of the node

 	*/

	public function getNodeTreeIds()

	{

		return $this->treeIds;

 	}	



	 /**

	* This method will be used to set the order node.

	* @param $nodeOrderVal This is the variable that will set the value into class variable.

	*/

	public function setNodeOrder($nodeOrderVal)

	{

		if($nodeOrderVal !=  NULL)

		{

			$this->nodeOrder = $nodeOrderVal;

		}

	}

   /**

	* This method will be used to retrieve the order of node.

	* @return The order of the node

 	*/

	public function getNodeOrder()

	{

		return $this->nodeOrder;

 	}



	 /**

	* This method will be used to set the node version.

	* @param $versionVal This is the variable that will set the value into class variable.

	*/

	public function setVersion($versionVal)

	{

		if($versionVal !=  NULL)

		{

			$this->version = $versionVal;

		}

	}

   /**

	* This method will be used to retrieve the version of node.

	* @return The version of the node

 	*/

	public function getVersion()

	{

		return $this->version;

 	}

}

?>