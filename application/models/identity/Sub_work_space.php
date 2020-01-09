<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: sub_work_space.php

	* Description 		  	: A class file used to set and get the sub work space entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 11-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the teeme sub work space Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class sub_work_space extends CI_Model

{

   /**

	* This variable will be used to store the sub work space id.

	*/

	private  $subWorkSpaceId = '';

  

	/**

	* This variable will be used to store the work space id.

	*/

	private  $workSpaceId = '';



	/**

	* This variable will be used to store the sub work space manager id.

	*/

	private  $subWorkSpaceManagerId = '';

	

	/**

	* This variable will be used to store the sub work space name.

	*/

	private  $subWorkSpaceName = '';

	/**

	* This variable will be used to store the sub work space created date.

	*/

	private  $subWorkSpaceCreatedDate = '';

  

  	/**

	* This method will be used to set the sub work space Id into class variable.

	* @param $subWorkSpaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkSpaceId($workSpaceIdVal)

	{

		if($workSpaceIdVal !=  NULL)

		{

			$this->subWorkSpaceId = $workSpaceIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sub work space Id.

	* @return The sub Id of the work space

 	*/

	public function getSubWorkSpaceId()

	{

		return $this->subWorkSpaceId;

 	}





	/**

	* This method will be used to set the work space Id into class variable.

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

	* This method will be used to retrieve the work space Id.

	* @return The Id of the work space

 	*/

	public function getWorkSpaceId()

	{

		return $this->workSpaceId;

 	}



	/**

	* This method will be used to set the sub work space manager id into class variable.

	* @param $subWorkSpaceManagerIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkSpaceManagerId($subWorkSpaceManagerIdVal)

	{

		if($subWorkSpaceManagerIdVal !=  NULL)

		{

			$this->subWorkSpaceManagerId = $subWorkSpaceManagerIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sub work space manager Id.

	* @return The sub work space manager Id

 	*/

	public function getSubWorkSpaceManagerId()

	{

		return $this->subWorkSpaceManagerId;

 	}



	/**

	* This method will be used to set the sub work space name into class variable.

	* @param $subWorkSpaceNameVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkSpaceName($subWorkSpaceNameVal)

	{

		if($subWorkSpaceNameVal !=  NULL)

		{

			$this->subWorkSpaceName = $subWorkSpaceNameVal;

		}

	}



	 /**

	* This method will be used to retrieve the sub work space name.

	* @return The sub work space name

 	*/

	public function getSubWorkSpaceName()

	{

		return $this->subWorkSpaceName;

 	}

	/**

	* This method will be used to set the sub work space created date into class variable.

	* @param $subWorkSpaceCreatedDateVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkSpaceCreatedDate($subWorkSpaceCreatedDateVal)

	{

		if($subWorkSpaceCreatedDateVal !=  NULL)

		{

			$this->subWorkSpaceCreatedDate = $subWorkSpaceCreatedDateVal;

		}

	}



	 /**

	* This method will be used to retrieve the sub work space created date.

	* @return The sub work space created date

 	*/

	public function getSubWorkSpaceCreatedDate()

	{

		return $this->subWorkSpaceCreatedDate;

 	}       

}

?>