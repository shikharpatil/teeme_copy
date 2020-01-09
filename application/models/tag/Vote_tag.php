<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: vote_tag.php

	* Description 		  	: A class file used to set and get the each vote tag entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 04-12-2008				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class keep the teeme vorting tag Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class vote_tag extends CI_Model

{

   /**

	* This variable will be used to store the voting topic id.

	*/

	private  $votingTopicId = '';

	 /**

	* This variable will be used to store the tag id.

	*/

	private  $tagId = '';

  

	/**

	* This variable will be used to store the voting topic.

	*/

	private  $votingTopic = '';	

	

		

	/**

	* This method will be used to set the voting topic Id into class variable.

	* @param $votingTopicIdVal This is the variable that will set the value into class variable.

	*/

	public function setVotingTopicId($votingTopicIdVal)

	{

		if($votingTopicIdVal !=  NULL)

		{

			$this->votingTopicId = $votingTopicIdVal;

		}

	}



   /**

	* This method will be used to retrieve the voting topic Id.

	* @return The Id of the voting tag

 	*/

	public function getVotingTopicId()

	{

		return $this->votingTopicId;

 	}



	/**

	* This method will be used to set the tag id into class variable.

	* @param $tagIdVal This is the variable that will set the value into class variable.

	*/

	public function setTagId($tagIdVal)

	{

		if($tagIdVal !=  NULL)

		{

			$this->tagId = $tagIdVal;

		}

	}



   /**

	* This method will be used to retrieve the tag id.

	* @return The tag id

 	*/

	public function getTagId()

	{

		return $this->tagId;

 	}	



	/**

	* This method will be used to set the voting topic into class variable.

	* @param $voteTopicVal This is the variable that will set the value into class variable.

	*/

	public function setVotingTopic($votingTopicVal)

	{

		if($votingTopicVal !=  NULL)

		{

			$this->votingTopic = $votingTopicVal;

		}

	}



   /**

	* This method will be used to retrieve the voting topic.

	* @return The voting topic

 	*/

	public function getVotingTopic()

	{

		return $this->votingTopic;

 	}	

	

}

?>