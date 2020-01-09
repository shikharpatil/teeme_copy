<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: tag.php

	* Description 		  	: A class file used to set and get the each tag entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 26-11-2008				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class keep the tag Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class tag extends CI_Model

{

   /**

	* This variable will be used to store the tag id.

	*/

	private  $tagId = '';

  

	/**

	* This variable will be used to store the tag Type.

	*/

	private  $tagType = '';



	/**

	* This variable will be used to store the tag.

	*/

	private  $tagName = '';



	/**

	* This variable will be used to store tag comments.

	*/

	private  $comments = '';

	/**

	* This variable will be used to store tag owner Id.

	*/

	private  $ownerId = ''; 



   /**

	* This variable will be used to store the user title.

	*/

	private $userTitle = '';

	

	/**

	* This variable will be used to store the artifact Id.

	*/

	private $artifactId = '';

	

	/**

	* This variable will be used to store the temme artifact type such as tree, node and leaf.

	*/

	private $artifactType = '';



	/**

	* This variable will be used to store the tag created tag.

	*/

	private $createdDate = '';

	/**

	* This variable will be used to store the tag start time.

	*/

	private $tagStartTime = '';	

	/**

	* This variable will be used to store the tag end time.

	*/

	private $tagEndTime = '';	

	/**

	* This variable will be used to store the sequence tag id.

	*/

	private $sequenceTagId = 0;	

	/**

	* This variable will be used to store the sequence tag order.

	*/

	private $sequenceOrder = 0;	

	/**

	* This method will be used to set the tag Id into class variable.

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

	* This method will be used to retrieve the tag Id.

	* @return The Id of the tag

 	*/

	public function getTagId()

	{

		return $this->tagId;

 	}



	/**

	* This method will be used to set the tag type id into class variable.

	* @param $tagType This is the variable that will set the value into class variable.

	*/

	public function setTagType($tagTypeVal)

	{

		if($tagTypeVal !=  NULL)

		{

			$this->tagType = $tagTypeVal;

		}

	}



   /**

	* This method will be used to retrieve the tag type.

	* @return The tag type

 	*/

	public function getTagType()

	{

		return $this->tagType;

 	}



	/**

	* This method will be used to set the tag into class variable.

	* @param $tagVal This is the variable that will set the value into class variable.

	*/

	public function setTag($tagVal)

	{

		if($tagVal !=  NULL)

		{

			$this->tagName = $tagVal;

		}

	}



   /**

	* This method will be used to retrieve the tag.

	* @return The tag

 	*/

	public function getTag()

	{

		return $this->tagName;

 	}



	/**

	* This method will be used to set the tag comments into class variable.

	* @param $commentsVal This is the variable that will set the value into class variable.

	*/

	public function setTagComments($commentsVal)

	{

		if($commentsVal !=  NULL)

		{

			$this->comments = $commentsVal;

		}

	}



   /**

	* This method will be used to retrieve the tag comments.

	* @return The tag comments

 	*/

	public function getTagComments()

	{

		return $this->comments;

 	}



	/**

	* This method will be used to set the tag owner id into class variable.

	* @param $ownerIdVal This is the variable that will set the value into class variable.

	*/

	public function setTagOwnerId($ownerIdVal)

	{

		if($ownerIdVal !=  NULL)

		{

			$this->ownerId = $ownerIdVal;

		}

	}

	 /**

	* This method will be used to retrieve the tag owner id.

	* @return The owner id of the tag

 	*/

	public function getTagOwnerId()

	{

		return $this->ownerId;

 	}

	

 

  

	/**

	* This method will be used to set the artifact id into class variable.

	* @param $artifactIdVal This is the variable that will set the value into class variable.

	*/

	public function setTagArtifactId($artifactIdVal)

	{

		if($artifactIdVal != NULL)

		{

			$this->artifactId = $artifactIdVal;

		}

	}

 

   /**

	* This method will be used to retrieve the artifact id.

	* @return the artifact id of the tag

 	*/

	public function getTagArtifactId()

	{

		return $this->artifactId;

	}

	

	/**

	* This method will be used to set the tag artifact type into class variable.

	* @param $artifactTypeVal This is the variable that will set the value into class variable.

	*/



	public function setTagArtifactType($artifactTypeVal)

	{

		if($artifactTypeVal != null)

		{

			$this->artifactType = $artifactTypeVal;

		}

	}



   /**

	* This method will be used to retrieve the tag artifact type.

	* @return The artifact type of the tag

 	*/

	public function getTagArtifactType()

	{

		return $this->artifactType;

 	}  



	/**

	* This method will be used to set the tag created date into class variable.

	* @param $tagCreatedDateVal This is the variable that will set the value into class variable.

	*/



	public function setTagCreatedDate($tagCreatedDateVal)

	{

		if($tagCreatedDateVal != null)

		{

			$this->createdDate = $tagCreatedDateVal;

		}

	}



   /**

	* This method will be used to retrieve the tag created date.

	* @return The created date of the tag

 	*/

	public function getTagCreatedDate()

	{

		return $this->createdDate;

 	} 



	/**

	* This method will be used to set the tag start date time into class variable.

	* @param $tagStartTimeVal This is the variable that will set the value into class variable.

	*/



	public function setTagStartTime( $tagStartTimeVal )

	{

		if( $tagStartTimeVal != null)

		{

			$this->tagStartTime = $tagStartTimeVal;

		}

	}



   /**

	* This method will be used to retrieve the tag start date and time.

	* @return The tag start date & time 

 	*/

	public function getTagStartTime()

	{

		return $this->tagStartTime;

 	}



	/**

	* This method will be used to set the tag expiry date time into class variable.

	* @param $tagEndTimeVal This is the variable that will set the value into class variable.

	*/



	public function setTagEndTime( $tagEndTimeVal )

	{

		if( $tagEndTimeVal != null)

		{

			$this->tagEndTime = $tagEndTimeVal;

		}

	}



   /**

	* This method will be used to retrieve the tag end date and time.

	* @return The tag end date & time 

 	*/

	public function getTagEndTime()

	{

		return $this->tagEndTime;

 	} 



	/**

	* This method will be used to set the sequence tag id into class variable.

	* @param $tagIdVal This is the variable that will set the value into class variable.

	*/



	public function setSequenceTagId( $tagIdVal )

	{

		if( $tagIdVal != null)

		{

			$this->sequenceTagId = $tagIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sequence tag id

	* @return The sequence tag id

 	*/

	public function getSequenceTagId()

	{

		return $this->sequenceTagId;

 	}   



	/**

	* This method will be used to set the sequence tag order into class variable.

	* @param $sequenceOrderVal This is the variable that will set the value into class variable.

	*/



	public function setSequenceOrder( $sequenceOrderVal )

	{

		if( $sequenceOrderVal != null)

		{

			$this->sequenceOrder = $sequenceOrderVal;

		}

	}



   /**

	* This method will be used to retrieve the sequence tag order

	* @return The sequence tag order

 	*/

	public function getSequenceOrder()

	{

		return $this->sequenceOrder;

 	}         

}

?>