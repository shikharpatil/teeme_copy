<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: work_space.php

	* Description 		  	: A class file used to set and get the workspace entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 08-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the teeme work space Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class work_space extends CI_Model

{

   /**

	* This variable will be used to store the work space id.

	*/

	private  $workSpaceId = '';

  

	/**

	* This variable will be used to store the work place id.

	*/

	private  $workPlaceId = '';



	/**

	* This variable will be used to store the work space manager id.

	*/

	private  $workSpaceManagerId = 0;

	

	/**

	* This variable will be used to store the work space name.

	*/

	private  $workSpaceName = '';

	/**

	* This variable will be used to store the work space created date.

	*/

	private  $workSpaceCreatedDate = '';

	

	/**

	* This variable will be used to store the work space created date.

	*/

	private  $treeAccess = '';
	
	private $defaultPlaceManagerSpace = 0;

	

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

	* This method will be used to set the work place Id into class variable.

	* @param $workPlaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setWorkPlaceId($workPlaceIdVal)

	{

		if($workPlaceIdVal !=  NULL)

		{

			$this->workPlaceId = $workPlaceIdVal;

		}

	}



   /**

	* This method will be used to retrieve the work place Id.

	* @return The Id of the work place

 	*/

	public function getWorkPlaceId()

	{

		return $this->workPlaceId;

 	}



	/**

	* This method will be used to set the workspace manager id into class variable.

	* @param $workSpaceManagerIdVal This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceManagerId($workSpaceManagerIdVal)

	{

		if($workSpaceManagerIdVal !=  NULL)

		{

			$this->workSpaceManagerId = $workSpaceManagerIdVal;

		}

	}



	/**

	* This method will be used to set the work space Id into class variable.

	* @param $workSpaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setTreeAccessValue($treeAccessVal)

	{

		if($treeAccessVal !=  NULL)

		{

			$this->treeAccess = $treeAccessVal;

		}

	}

	

	 /**

	* This method will be used to retrieve the work space manager Id.

	* @return The work space manager Id

 	*/

	public function getTreeAccessValue()

	{

		return $this->treeAccess;

 	}



   /**

	* This method will be used to retrieve the work space manager Id.

	* @return The work space manager Id

 	*/

	public function getWorkSpaceManagerId()

	{

		return $this->workSpaceManagerId;

 	}



	/**

	* This method will be used to set the work space name into class variable.

	* @param $workSpaceNameVal This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceName($workSpaceNameVal)

	{

		if($workSpaceNameVal !=  NULL)

		{

			$this->workSpaceName = $workSpaceNameVal;

		}

	}



	 /**

	* This method will be used to retrieve the work space name.

	* @return The work space name

 	*/

	public function getWorkSpaceName()

	{

		return $this->workSpaceName;

 	} 



	/**

	* This method will be used to set the work space created date into class variable.

	* @param $workSpaceCreatedDateVal This is the variable that will set the value into class variable.

	*/

	public function setWorkSpaceCreatedDate($workSpaceCreatedDateVal)

	{

		if($workSpaceCreatedDateVal !=  NULL)

		{

			$this->workSpaceCreatedDate = $workSpaceCreatedDateVal;

		}

	}



	 /**

	* This method will be used to retrieve the work space created date.

	* @return The work space created date

 	*/

	public function getWorkSpaceCreatedDate()

	{

		return $this->workSpaceCreatedDate;

 	}   

	

	public function getDefaultWorkSpace($placeId=0,$config=0)
	{
		if ($placeId==0)
		{
			$qry = "SELECT workSpaceId as ws FROM teeme_work_space WHERE workPlaceId = '".$_SESSION['workPlaceId']."' AND workSpaceName='Try Teeme' order by workSpaceId LIMIT 1";
		}
		else
		{
			$qry = "SELECT workSpaceId as ws FROM teeme_work_space WHERE workPlaceId = '".$placeId."' AND workSpaceName='Try Teeme' order by workSpaceId LIMIT 1";
		}


		if($config!=0)
		{
			$placedb = $this->load->database($config,TRUE);	
			$query = $placedb->query($qry);		
		}
		else
		{
			$query = $this->db->query($qry);		
		}
		
		if($query->num_rows() > 0)

		{

			foreach ($query->result() as $row)

			{

			   $ws=$row->ws;

			   return $ws;	

			}   

		}

		else

		{

		    return 0;	  

		}
 	}  
	
	public function setDefaultPlaceManagerSpace($defaultPlaceManagerSpace)

	{

		if($defaultPlaceManagerSpace !=  NULL)

		{

			$this->defaultPlaceManagerSpace = $defaultPlaceManagerSpace;

		}

	}
	
	public function getDefaultPlaceManagerSpace()

	{

		return $this->defaultPlaceManagerSpace;

 	} 
	
}

?>