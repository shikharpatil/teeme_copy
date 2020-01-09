<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: sub_work_place.php

	* Description 		  	: A class file used to set and get the sub work place entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 13-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the teeme sub work place Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class sub_work_place extends CI_Model

{

   /**

	* This variable will be used to store the sub work place id.

	*/

	private  $subWorkPlaceId = '';

  

	/**

	* This variable will be used to store the work place id.

	*/

	private  $workPlaceId = '';



	/**

	* This variable will be used to store the sub work place manager id.

	*/

	private  $subWorkPlaceManagerId = '';

	

	/**

	* This variable will be used to store the sub work place name.

	*/

	private  $subWorkPlaceName = '';

	

  

  	/**

	* This method will be used to set the sub work place Id into class variable.

	* @param $subWorkPlaceIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkPlaceId($subWorkPlaceIdVal)

	{

		if($subWorkPlaceIdVal !=  NULL)

		{

			$this->subWorkPlaceId = $subWorkPlaceIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sub work place Id.

	* @return The sub Id of the work place

 	*/

	public function getSubWorkPlaceId()

	{

		return $this->subWorkPlaceId;

 	}



	/**

	* This method will be used to set the sub workplace manager id into class variable.

	* @param $subWorkPlaceManagerIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkPlaceManagerId($subWorkPlaceManagerIdVal)

	{

		if($subWorkPlaceManagerIdVal !=  NULL)

		{

			$this->subWorkPlaceManagerId = $subWorkPlaceManagerIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sub work place manager Id.

	* @return The sub work place manager Id

 	*/

	public function getSubWorkPlaceManagerId()

	{

		return $this->subWorkPlaceManagerId;

 	}



	/**

	* This method will be used to set the sub work place name into class variable.

	* @param $subWorkPlaceNameVal This is the variable that will set the value into class variable.

	*/

	public function setSubWorkPlaceName($subWorkPlaceNameVal)

	{

		if($subWorkPlaceNameVal !=  NULL)

		{

			$this->subWorkPlaceName = $subWorkPlaceNameVal;

		}

	}



	 /**

	* This method will be used to retrieve the sub work place name.

	* @return The sub work place name

 	*/

	public function getSubWorkPlaceName()

	{

		return $this->subWorkPlaceName;

 	}   

}

?>