<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: topic.php

	* Description 		  	: A class file used to set and get the each help topic entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 20-05-2009				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class keep the teeme help topic Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class topic extends CI_Model

{

   /**

	* This variable will be used to store the topic id.

	*/

	private  $topicId = 0;

	 /**

	* This variable will be used to store the topic name.

	*/

	private  $topicName = '';

  	 /**

	* This variable will be used to store the trees of topic name.

	*/

	private  $trees = '';

	/**

	* This variable will be used to store the topic created date.

	*/

	private  $createdDate = 0;	

	 /**

	* This variable will be used to store the created users id.

	*/

	private  $createdBy = 0;

	/**

	* This variable will be used to store the topic modified date.

	*/

	private  $modifiedDate = 0;	

	 /**

	* This variable will be used to store the topic status.

	*/

	private  $status = 1;

			

	/**

	* This method will be used to set the topic Id into class variable.

	* @param $topicIdVal This is the variable that will set the value into class variable.

	*/

	public function setTopicId($topicIdVal)

	{

		if($topicIdVal !=  NULL)

		{

			$this->topicId = $topicIdVal;

		}

	}



   /**

	* This method will be used to retrieve the topic Id.

	* @return The Id of the help topic

 	*/

	public function getTopicId()

	{

		return $this->topicId;

 	}



	/**

	* This method will be used to set the help topic name into class variable.

	* @param $topicNameVal This is the variable that will set the value into class variable.

	*/

	public function setTopicName($topicNameVal)

	{

		if($topicNameVal !=  NULL)

		{

			$this->topicName = $topicNameVal;

		}

	}



   /**

	* This method will be used to retrieve the topic name.

	* @return The teeme topic name

 	*/

	public function getTopicName()

	{

		return $this->topicName;

 	}	



	/**

	* This method will be used to set the help topic trees into class variable.

	* @param $treesVal This is the variable that will set the value into class variable.

	*/

	public function setTopicTrees($treesVal)

	{

		if($treesVal !=  NULL)

		{

			$this->trees = $treesVal;

		}

	}



   /**

	* This method will be used to retrieve the topic name trees.

	* @return The teeme topic trees

 	*/

	public function getTopicTrees()

	{

		return $this->trees;

 	}

	/**

	* This method will be used to set the topic created date into class variable.

	* @param $topicCreatedDateVal This is the variable that will set the value into class variable.

	*/

	public function setTopicCreatedDate($topicCreatedDateVal)

	{

		if($topicCreatedDateVal !=  NULL)

		{

			$this->createdDate = $topicCreatedDateVal;

		}

	}



   /**

	* This method will be used to retrieve the topic created date

	* @return The topic created date

 	*/

	public function getTopicCreatedDate()

	{

		return $this->createdDate;

 	}	

	/**

	* This method will be used to set the topic created user's user id.

	* @param $userIdVal This is the variable that will set the value into class variable.

	*/

	public function setTopicCreatedBy($userIdVal)

	{

		if($userIdVal !=  NULL)

		{

			$this->createdBy = $userIdVal;

		}

	}



   /**

	* This method will be used to retrieve the created admin's user id.

	* @return The user id

 	*/

	public function getTopicCreatedBy()

	{

		return $this->createdBy;

 	}	

	/**

	* This method will be used to set the topic modified date into class variable.

	* @param $modifiedDateVal This is the variable that will set the value into class variable.

	*/

	public function setTopicModifiedDate($modifiedDateVal)

	{

		if($modifiedDateVal !=  NULL)

		{

			$this->modifiedDate = $modifiedDateVal;

		}

	}



   /**

	* This method will be used to retrieve the document modified date.

	* @return The document modified date

 	*/

	public function getTopicModifiedDate()

	{

		return $this->modifiedDate;

 	}



	/**

	* This method will be used to set the topic status into class variable.

	* @param $statusVal This is the variable that will set the value into class variable.

	*/

	public function setTopicStatus($statusVal)

	{

		if($statusVal !=  NULL)

		{

			$this->status = $statusVal;

		}

	}



   /**

	* This method will be used to retrieve the topic status

	* @return The topic status

 	*/

	public function getTopicStatus()

	{

		return $this->status;

 	}	

}

?>