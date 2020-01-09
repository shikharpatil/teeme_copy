<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: external_docs.php

	* Description 		  	: A class file used to set and get the each external documents entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 12-01-2009				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class keep the external documents Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class external_doc extends CI_Model

{

   /**

	* This variable will be used to store the document id.

	*/

	private  $docId = 0;

	 /**

	* This variable will be used to store the workspace id.

	*/

	private  $workSpaceId = 0;

  

	/**

	* This variable will be used to store the workspace type.

	*/

	private  $workSpaceType = 0;	

	 /**

	* This variable will be used to store the user id.

	*/

	private  $userId = 0;

	 /**

	* This variable will be used to store the document caption.

	*/

	private  $docCaption = '';

	 /**

	* This variable will be used to store the document name.

	*/

	private  $docName = '';

	 /**

	* This variable will be used to store the document path.

	*/

	private  $docPath = '';

	 /**

	* This variable will be used to store the document created date.

	*/

	private  $createdDate = '';

	 /**

	* This variable will be used to store the document version date.

	*/

	private  $version = 1;

	/**

	* This variable will be used to store the folder id.

	*/

	private  $folderId = 0;

	/**

	* This variable will be used to store the file order.

	*/

	private  $fileOrder = '';

	 /**

	* This variable will be used to store the document origin modified  date.

	*/

	private  $origModifiedDate = '';

	 /**

		

	/**

	* This method will be used to set the document Id into class variable.

	* @param $docIdVal This is the variable that will set the value into class variable.

	*/

	public function setDocId($docIdVal)

	{

		if($docIdVal !=  NULL)

		{

			$this->docId = $docIdVal;

		}

	}



   /**

	* This method will be used to retrieve the document Id.

	* @return The Id of the document

 	*/

	public function getDocId()

	{

		return $this->docId;

 	}



	/**

	* This method will be used to set the workspace id into class variable.

	* @param $workSpaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceId($workSpaceIdVal)

	{

		if($workSpaceIdVal !=  NULL)

		{

			$this->workSpaceId = $workSpaceIdVal;

		}

	}



   /**

	* This method will be used to retrieve the workspace id.

	* @return The workspace id

 	*/

	public function getWorkSpaceId()

	{

		return $this->workSpaceId;

 	}	



	/**

	* This method will be used to set the workspace type into class variable.

	* @param $workSpaceTypeVal This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceType($workSpaceTypeVal)

	{

		if($workSpaceTypeVal !=  NULL)

		{

			$this->workSpaceType = $workSpaceTypeVal;

		}

	}



   /**

	* This method will be used to retrieve the workspace type

	* @return The workspace type

 	*/

	public function getWorkSpaceType()

	{

		return $this->workSpaceType;

 	}	

	/**

	* This method will be used to set the user id into class variable.

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

	* This method will be used to retrieve the user id.

	* @return The user id

 	*/

	public function getUserId()

	{

		return $this->userId;

 	}	

	/**

	* This method will be used to set the document caption into class variable.

	* @param $docCaptionVal This is the variable that will set the value into class variable.

	*/

	public function setDocCaption($docCaptionVal)

	{

		if($docCaptionVal !=  NULL)

		{

			$this->docCaption = $docCaptionVal;

		}

	}



   /**

	* This method will be used to retrieve the document Caption.

	* @return The document caption

 	*/

	public function getDocCaption()

	{

		return $this->docCaption;

 	}



	/**

	* This method will be used to set the document into class variable.

	* @param $docNameVal This is the variable that will set the value into class variable.

	*/

	public function setDocName($docNameVal)

	{

		if($docNameVal !=  NULL)

		{

			$this->docName = $docNameVal;

		}

	}



   /**

	* This method will be used to retrieve the document name.

	* @return The document name

 	*/

	public function getDocName()

	{

		return $this->docName;

 	}



	/**

	* This method will be used to set the document path class variable.

	* @param $docPathVal This is the variable that will set the value into class variable.

	*/

	public function setDocPath($docPathVal)

	{

		if($docPathVal !=  NULL)

		{

			$this->docPath = $docPathVal;

		}

	}



   /**

	* This method will be used to retrieve the document path.

	* @return The document path

 	*/

	public function getDocPath()

	{

		return $this->docPath;

 	}



	/**

	* This method will be used to set the document created date into class variable.

	* @param $createdDateVal This is the variable that will set the value into class variable.

	*/

	public function setDocCreatedDate($createdDateVal)

	{

		if($createdDateVal !=  NULL)

		{

			$this->createdDate = $createdDateVal;

		}

	}



   /**

	* This method will be used to retrieve the document created date.

	* @return The document created date

 	*/

	public function getDocCreatedDate()

	{

		return $this->createdDate;

 	}



	/**

	* This method will be used to set the document version into class variable.

	* @param $versionVal This is the variable that will set the value into class variable.

	*/

	public function setDocVersion($versionVal)

	{

		if($versionVal !=  NULL)

		{

			$this->version = $versionVal;

		}

	}



   /**

	* This method will be used to retrieve the document version.

	* @return The document version

 	*/

	public function getDocVersion()

	{

		return $this->version;

 	}

 	/**

	* This method will be used to set the folder id into class variable.

	* @param $folderId This is the variable that will set the value into class variable.

	*/

	public function setFolderId($folderId)

	{

		$this->folderId = $folderId;

	}



   /**

	* This method will be used to retrieve the folder id.

	* @return The document version

 	*/

	public function getFolderId()

	{

		return $this->folderId;

 	}


 	/**

	* This method will be used to set the file order into class variable.

	* @param $fileOrder This is the variable that will set the value into class variable.

	*/

	public function setFileOrder($fileOrder)

	{

		$this->fileOrder = $fileOrder;

	}



   /**

	* This method will be used to retrieve the file order.

	* @return The file order

 	*/

	public function getFileOrder()

	{

		return $this->fileOrder;

 	}

 	/**

	* This method will be used to set the document origin modified date into class variable.

	* @param $origModifiedDateVal This is the variable that will set the value into class variable.

	*/

	public function setDocOrigModifiedDate($origModifiedDateVal)
	{
		if($origModifiedDateVal !=  NULL)
		{

			$this->origModifiedDate = $origModifiedDateVal;
		}
	}



    /**
	* This method will be used to retrieve the document origin modified date.

	* @return The document origin modified date

 	*/

	public function getDocOrigModifiedDate()
	{
		return $this->origModifiedDate;
 	}
}

?>