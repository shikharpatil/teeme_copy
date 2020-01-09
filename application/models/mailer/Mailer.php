<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: mailer.php

	* Description 		  	: A class file used to set and get the mail entities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 10-10-2008				Nagalingam						Created the file.			

		

	**********************************************************************************************************/

/**

* A PHP class keep the mailer functionalities into the Class variable and return it according to their need.

* @author   Ideavate Solutions (www.ideavate.com)

*/

class mailer extends CI_Model

{

   /**

	* This variable will be used to store the from mail id.

	*/

	private  $mailFrom = 'info@teeme.com';

  

	/**

	* This variable will be used to store mail receipient ids.

	*/

	private  $mailTo = '';



	/**

	* This variable will be used to store the cc mail ids.

	*/

	private  $mailCC = '';

	

	/**

	* This variable will be used to store the BCC mail ids.

	*/

	private  $mailBCC = '';



	/**

	* This variable will be used to store the subject of mail.

	*/

	private  $mailSubject = '';

	/**

	* This variable will be used to store the contents of mail.

	*/

	private  $mailContents = '';

	

  	/**

	* This method will be used to set the from mail id into class variable.

	* @param $mailFromVal This is the variable that will set the value into class variable.

	*/

	public function setMailFrom($mailFromVal)

	{

		if($mailFromVal !=  NULL)

		{

			$this->mailFrom = $mailFromVal;

		}

	}



   /**

	* This method will be used to retrieve the from mail Id.

	* @return The from mail id

 	*/

	public function getMailFrom()

	{

		return $this->mailFrom;

 	}



	/**

	* This method will be used to set the to mail id into class variable.

	* @param $mailToVal This is the variable that will set the value into class variable.

	*/

	public function setMailTo($mailToVal)

	{

		if($mailToVal !=  NULL)

		{

			$this->mailTo = $mailToVal;

		}

	}



   /**

	* This method will be used to retrieve the to mail Id.

	* @return The to mail id

 	*/

	public function getMailTo()

	{

		return $this->mailTo;

 	}





	/**

	* This method will be used to set the CC mail ids into class variable.

	* @param $mailCCVal This is the variable that will set the value into class variable.

	*/

	public function setMailCC($mailCCVal)

	{

		if($mailCCVal !=  NULL)

		{

			$this->mailCC = $mailCCVal;

		}

	}



   /**

	* This method will be used to retrieve the CC mail Ids.

	* @return The CC mail ids

 	*/

	public function getMailCC()

	{

		return $this->mailCC;

 	}



	/**

	* This method will be used to set the BCC mail ids into class variable.

	* @param $mailBCCVal This is the variable that will set the value into class variable.

	*/

	public function setMailBCC($mailBCCVal)

	{

		if($mailBCCVal !=  NULL)

		{

			$this->mailBCC = $mailBCCVal;

		}

	}



   /**

	* This method will be used to retrieve the BCC mail Ids.

	* @return The BCC mail ids

 	*/

	public function getMailBCC()

	{

		return $this->mailBCC;

 	} 



	/**

	* This method will be used to set the mail subject into class variable.

	* @param $mailSubjectVal This is the variable that will set the value into class variable.

	*/

	public function setMailSubject($mailSubjectVal)

	{

		if($mailSubjectVal !=  NULL)

		{

			$this->mailSubject = $mailSubjectVal;

		}

	}



   /**

	* This method will be used to retrieve the mail subject.

	* @return The mail subject

 	*/

	public function getMailSubject()

	{

		return $this->mailSubject;

 	} 



	/**

	* This method will be used to set the mail contents into class variable.

	* @param $mailContentsVal This is the variable that will set the value into class variable.

	*/

	public function setMailContents($mailContentsVal)

	{

		if($mailContentsVal !=  NULL)

		{

			$this->mailContents = $mailContentsVal;

		}

	}



   /**

	* This method will be used to retrieve the mail contents.

	* @return The mail contents

 	*/

	public function getMailContents()

	{

		return $this->mailContents;

 	}                     

}

?>