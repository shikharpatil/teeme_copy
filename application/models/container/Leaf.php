<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: leaf.php

	* Description 		  	: A class file used to set and get the document leaf entities

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

class leaf extends CI_Model

{

   /**

	* This variable will be used to store the id of the leaf.

	*/

	private  $id = '';



	/**

	* This variable will be used to store the type of the leaf.

	*/

	private  $type = '';

  

   /**

	* This variable will be used to store the author names of the leaf.

	*/

	private $authors = '';

	

	/**

	* This variable will be used to store the status of the leaf.

	*/

	private $status = 0;



	/**

	* This variable will be used to store the owner id of the leaf.

	*/

	private $userId = '';

	

	/**

	* This variable will be used to store the created date of leaf.

	*/

	private $createdDate = '';



	/**

	* This variable will be used to store the contents of the leaf.

	*/

	private $contents = '';

	/**

	* This variable will be used to store the version of the leaf.

	*/

	private $version = 1;

	/**

	* This variable will be used to store the parent id of the leaf.

	*/

	private $parentId = 0;

	/**

	* This variable will be used to store the locked status of the leaf.

	*/

	private $lockedStatus = 0;

	/**

	* This variable will be used to store the locked user id of the leaf.

	*/

	private $userLocked = 0;

	 /**

	* This method will be used to set the leaf Id into class variable.

	* @param $leafId This is the variable that will set the value into class variable.

	*/

	public function setLeafId($leafId)

	{

		if($leafId !=  NULL)

		{

			$this->id = $leafId;

		}

	}

   /**

	* This method will be used to retrieve the leaf id.

	* @return The leaf id

 	*/

	public function getLeafId()

	{

		return $this->id;

 	}



	 /**

	* This method will be used to set the leaf type into class variable.

	* @param $leafTypeVal This is the variable that will set the value into class variable.

	*/

	public function setLeafType($leafTypeVal)

	{

		if($leafTypeVal !=  NULL)

		{

			$this->type = $leafTypeVal;

		}

	}

   /**

	* This method will be used to retrieve the leaf type.

	* @return The leaf type

 	*/

	public function getLeafType()

	{

		return $this->type;

 	}



	/**

	* This method will be used to set the leaf authors into class variable.

	* @param $leafAuthors This is the variable that will set the value into class variable.

	*/

	public function setLeafAuthors($leafAuthors)

	{

		if($leafAuthors !=  NULL)

		{

			$this->authors = $leafAuthors;

		}

	}

   /**

	* This method will be used to retrieve the leaf authors.

	* @return The leaf authors

 	*/

	public function getLeafAuthors()

	{

		return $this->authors;

 	}



	 /**

	* This method will be used to set the leaf status into class variable.

	* @param $leafStatus This is the variable that will set the value into class variable.

	*/

	public function setLeafStatus($leafStatus)

	{

		if($leafStatus !=  NULL)

		{

			$this->status = $leafStatus;

		}

	}

   /**

	* This method will be used to retrieve the leaf status.

	* @return The leaf status

 	*/

	public function getLeafStatus()

	{

		return $this->status;

 	}

	

	 /**

	* This method will be used to set the owner id of the leaf.

	* @param $leafOwnerId This is the variable that will set the value into class variable.

	*/

	public function setLeafUserId($leafUserIdVal)

	{

		if($leafUserIdVal !=  NULL)

		{

			$this->userId = $leafUserIdVal;

		}

	}

   /**

	* This method will be used to retrieve the user id of the leaf.

	* @return The user id of the leaf

 	*/

	public function getLeafUserId()

	{

		return $this->userId;

 	}



	 /**

	* This method will be used to set the created date of leaf.

	* @param $leafCreatedDate This is the variable that will set the value into class variable.

	*/

	public function setLeafCreatedDate($leafCreatedDate)

	{

		if($leafCreatedDate !=  NULL)

		{

			$this->createdDate = $leafCreatedDate;

		}

	}

   /**

	* This method will be used to retrieve the crated date of the leaf.

	* @return The created date of the leaf

 	*/

	public function getLeafCreatedDate()

	{

		return $this->createdDate;

 	}



	 /**

	* This method will be used to set the contents of the leaf.

	* @param $leafContents This is the variable that will set the value into class variable.

	*/

	public function setLeafContents($leafContents)

	{

		if($leafContents !=  NULL)

		{

			$this->contents = $leafContents;

		}

	}

   /**

	* This method will be used to retrieve the contents of the leaf.

	* @return The contents of the leaf

 	*/

	public function getLeafContents()

	{

		return $this->contents;

 	}	



	 /**

	* This method will be used to set the version of the leaf.

	* @param $leafVersion This is the variable that will set the value into class variable.

	*/

	public function setLeafVersion($leafVersion)

	{

		if($leafVersion !=  NULL)

		{

			$this->version = $leafVersion;

		}

	}

   /**

	* This method will be used to retrieve the version of the leaf.

	* @return The version of the leaf

 	*/

	public function getLeafVersion()

	{

		return $this->version;

 	}



	 /**

	* This method will be used to set the parent id of the leaf.

	* @param $leafParentId This is the variable that will set the value into class variable.

	*/

	public function setLeafParentId($leafParentId)

	{

		if($leafParentId !=  NULL)

		{

			$this->parentId = $leafParentId;

		}

	}

   /**

	* This method will be used to retrieve the parent id of the leaf.

	* @return The parent id of the leaf

 	*/

	public function getLeafParentId()

	{

		return $this->parentId;

 	}



	 /**

	* This method will be used to set the locked status of the leaf.

	* @param $lockedStatusVal This is the variable that will set the value into class variable.

	*/

	public function setLeafLockedStatus($lockedStatusVal)

	{

		if($lockedStatusVal !=  NULL)

		{

			$this->lockedStatus = $lockedStatusVal;

		}

	}

   /**

	* This method will be used to retrieve the locaked status of the leaf.

	* @return The locaked status of the leaf

 	*/

	public function getLeafLockedStatus()

	{

		return $this->lockedStatus;

 	}



	 /**

	* This method will be used to set the locked user id of the leaf.

	* @param $userLockedVal This is the variable that will set the value into class variable.

	*/

	public function setLeafUserLocked($userLockedVal)

	{

		if($userLockedVal !=  NULL)

		{

			$this->userLocked = $userLockedVal;

		}

	}

   /**

	* This method will be used to retrieve the user locked id of the leaf.

	* @return The uset locaked id of the leaf

 	*/

	public function getLeafUserLocked()

	{

		return $this->userLocked;

 	}
	
	/*
	This method will be used to set the leaf post status.
	*/

	public function setLeafPostStatus($leafPostStatus)

	{

		if($leafPostStatus !=  NULL)

		{

			$this->leafStatus = $leafPostStatus;

		}

	}

   /* 
   This method will be used to retrieve the leaf post status.
   */

	public function getLeafPostStatus()

	{

		return $this->leafStatus;

 	}

}

?>