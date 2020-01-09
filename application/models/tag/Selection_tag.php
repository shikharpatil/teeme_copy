<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: selection_tag.php

	* Description 		  	: A class file used to set and get the each selection tag entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 04-12-2008				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class keep the teeme selection tag Information into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class selection_tag extends CI_Model

{

   /**

	* This variable will be used to store the selection option id.

	*/

	private  $selectionId = '';

	 /**

	* This variable will be used to store the tag id.

	*/

	private  $tagId = '';

  

	/**

	* This variable will be used to store the selection option name.

	*/

	private  $selectionOption = '';	

	

		

	/**

	* This method will be used to set the selection Id into class variable.

	* @param $selectionIdVal This is the variable that will set the value into class variable.

	*/

	public function setSelectionId($selectionIdVal)

	{

		if($selectionIdVal !=  NULL)

		{

			$this->selectionId = $selectionIdVal;

		}

	}



   /**

	* This method will be used to retrieve the selection Id.

	* @return The Id of the selection tag

 	*/

	public function getSelectionId()

	{

		return $this->selectionId;

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

	* This method will be used to set the selection option into class variable.

	* @param $selectionOptionVal This is the variable that will set the value into class variable.

	*/

	public function setSelectionOption($selectionOptionVal)

	{

		if($selectionOptionVal !=  NULL)

		{

			$this->selectionOption = $selectionOptionVal;

		}

	}



   /**

	* This method will be used to retrieve the selection option.

	* @return The selection option

 	*/

	public function getSelectionOption()

	{

		return $this->selectionOption;

 	}	

	

}

?>