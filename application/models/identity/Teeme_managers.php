<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: teeme_managers.php

	* Description 		  	: A class file used to set and get the teeme managers entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 06-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the Teeme manager Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class teeme_managers extends CI_Model

{

   /**

	* This variable will be used to store the work place/sub work place/work space/sub work space id.

	*/

	private  $placeId = 0;

  

	/**

	* This variable will be used to store the work place/sub work place/work space/sub work space manager id.

	*/

	private  $managerId = 0;



	/**

	* This variable will be used to store the place type(work place/sub work place/work space/sub work space).

	*/

	private  $placeType = 0;



  	/**

	* This method will be used to set the work place/sub work place/work space/sub work space Id into class variable.

	* @param $placeIdVal This is the variable that will set the value into class variable.

	*/

	public function setPlaceId($placeIdVal)

	{

		if($placeIdVal !=  NULL)

		{

			$this->placeId = $placeIdVal;

		}

	}



   /**

	* This method will be used to retrieve the place Id.

	* @return The Id of the work place/sub work place/work space/sub work space

 	*/

	public function getPlaceId()

	{

		return $this->placeId;

 	}



	/**

	* This method will be used to set the work place/sub work place/work space/sub work space manager id into class variable.

	* @param $managerIdVal This is the variable that will set the value into class variable.

	*/

	public function setManagerId($managerIdVal)

	{

		if($managerIdVal !=  NULL)

		{

			$this->managerId = $managerIdVal;

		}

	}



   /**

	* This method will be used to retrieve the work place/sub work place/work space/sub work space manager Id.

	* @return The work place/sub work place/work space/sub work space manager Id

 	*/

	public function getManagerId()

	{

		return $this->managerId;

 	}



	/**

	* This method will be used to set the work place/sub work place/work space/sub work space type into class variable.

	* @param $placeTypeVal This is the variable that will set the value into class variable.

	*/

	public function setPlaceType($placeTypeVal)

	{

		if($placeTypeVal !=  NULL)

		{

			$this->placeType = $placeTypeVal;

		}

	}



	 /**

	* This method will be used to retrieve the place type.

	* @return The place type

 	*/

	public function getPlaceType()

	{

		return $this->placeType;

 	} 

}

?>