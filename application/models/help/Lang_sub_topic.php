<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: lang_sub_topic.php

	* Description 		  	: A class file used to set and get the each language help sub topic entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 20-05-2009				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class keep the teeme help sub topic Information for multiple langaueges into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class lang_sub_topic extends CI_Model

{

   /**

	* This variable will be used to store the sub topic id.

	*/

	private  $subTopicId = 0;

	 /**

	* This variable will be used to store the language code.

	*/

	private  $langCode = '';

	 /**

	* This variable will be used to store the sub topic text.

	*/

	private  $subTopicText = ''; 

	 /**

	* This variable will be used to store the sub topic contents.

	*/

	private  $contents = ''; 

	

			

	/**

	* This method will be used to set the sub topic Id into class variable.

	* @param $subTopicIdVal This is the variable that will set the value into class variable.

	*/

	public function setSubTopicId($subTopicIdVal)

	{

		if($subTopicIdVal !=  NULL)

		{

			$this->subTopicId = $subTopicIdVal;

		}

	}



   /**

	* This method will be used to retrieve the sub topic Id.

	* @return The Id of the help sub topic

 	*/

	public function getSubTopicId()

	{

		return $this->subTopicId;

 	}



	/**

	* This method will be used to set the help sub topic language code into class variable.

	* @param $langCodeVal This is the variable that will set the value into class variable.

	*/

	public function setSubTopicLangCode($langCodeVal)

	{

		if($langCodeVal !=  NULL)

		{

			$this->langCode = $langCodeVal;

		}

	}



   /**

	* This method will be used to retrieve the sub topic language code.

	* @return The teeme sub topic language code

 	*/

	public function getSubTopicLangCode()

	{

		return $this->langCode;

 	}	

	/**

	* This method will be used to set the help sub topic text into class variable.

	* @param $subTopicTextVal This is the variable that will set the value into class variable.

	*/

	public function setSubTopicText($subTopicTextVal)

	{

		if($subTopicTextVal !=  NULL)

		{

			$this->subTopicText = $subTopicTextVal;

		}

	}



   /**

	* This method will be used to retrieve the sub topic text.

	* @return The teeme sub topic text

 	*/

	public function getSubTopicText()

	{

		return $this->subTopicText;

 	}

	/**

	* This method will be used to set the help sub topic contents into class variable.

	* @param $subTopicContentsVal This is the variable that will set the value into class variable.

	*/

	public function setSubTopicContents($subTopicContentsVal)

	{

		if($subTopicContentsVal !=  NULL)

		{

			$this->contents = $subTopicContentsVal;

		}

	}



   /**

	* This method will be used to retrieve the sub topic contents.

	* @return The teeme sub topic contents

 	*/

	public function getSubTopicContents()

	{

		return $this->contents;

 	}	

}

?>