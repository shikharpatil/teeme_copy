<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: notes_periodic.php

	* Description 		  	: A class file used to set and get the notes periodic information

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 10-03-2009				Nagalingam						Created the file.	

			

		

	**********************************************************************************************************/

/**

* A PHP class file used to set and get the notes periodic information

* @author Ideavate Solutions (www.ideavate.com)

*/

class notes_periodic extends CI_Model

{

   /**

	* This variable will be used to store the notes tree Id.

	*/

	private  $notesId = 0;



	/**

	* This variable will be used to store the notes periodic option.

	*/

	private  $periodicOption = 0;

  

   /**

	* This variable will be used to store the start date of the notes creation.

	*/

	private $startDate = '';

   /**

	* This variable will be used to store the end date of the notes creation.

	*/

	private $endDate = '';

	

		

   /**

	* This method will be used to set the notesId 	

 	*/

	public function setNotesId($notesIdVal)

	{

		if($notesIdVal !=  NULL)

		{

			$this->notesId = $notesIdVal;

		}

	}

   /**

	* This method will be used to retrieve the notes id.

	* @return The notes id

 	*/

	public function getNotesId()

	{

		return $this->notesId;

 	}



	 /**

	* This method will be used to set the notes periodic option 	

 	*/

	public function setNotesPeriodicOption($optionVal)

	{

		if($optionVal !=  NULL)

		{

			$this->periodicOption = $optionVal;

		}

	}

   /**

	* This method will be used to retrieve the notes periodic option.

	* @return The notes periodic option

 	*/

	public function getNotesPeriodicOption()

	{

		return $this->periodicOption;

 	}

	/**

	* This method will be used to set the notes periodic option 	

 	*/

	public function setNotesStartDate($startDateVal)

	{

		if($startDateVal !=  NULL)

		{

			$this->startDate = $startDateVal;

		}

	}

   /**

	* This method will be used to retrieve the notes start date.

	* @return The notes start date

 	*/

	public function getNotesStartDate()

	{

		return $this->startDate;

 	}

	/**

	* This method will be used to set the notes end date 	

 	*/

	public function setNotesEndDate($endDateVal)

	{

		if($endDateVal !=  NULL)

		{

			$this->endDate = $endDateVal;

		}

	}

   /**

	* This method will be used to retrieve the notes end date.

	* @return The notes end date

 	*/

	public function getNotesEndDate()

	{

		return $this->endDate;

 	}

}

?>