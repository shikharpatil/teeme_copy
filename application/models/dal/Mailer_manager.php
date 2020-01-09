<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: mailer_manager.php

	* Description 		  	: A class file used to mail functionalities

	* External Files called	: models/dal/mailer_manager.php

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 13-10-2008				Nagalingam						Created the file.			

	* 18-10-2013				Parv						Modified file.			

	**********************************************************************************************************/

/**

* A PHP class to access mailer functionalities

* with various operation send mail etc..

* @author   Ideavate Solutions (www.ideavate.com)

*/



class mailer_manager extends CI_Model

{ 	

	/**

	* This is the constructor of mailer_manager that call the contstructor of the Parent Class.

	*/

	public function __construct()

	{   

		//Parent class constructor.

		parent::__construct();

	}	

   /**

	* This method is used to send the mail.	

	*/

	public function sendMail($object,$fromMail = "info@teeme.net\r\n")

    {		

		$message 	= $object->getMailContents();	

		$subject 	= $object->getMailSubject();

		$to			= $object->getMailTo();

		$headers 	= "Content-type: text/html; charset=iso-8859-1\r\n";	

		$headers 	.= "Sender: Teeme"."\r\n";    

		$headers.= "From: ".$fromMail;

		if(	$object->getMailCC() != '')

		{	

			$headers .= "CC: ".$object->getMailCC(). "\r\n"; 

		}   

		if(	$object->getMailBCC() != '')

		{	

			$headers .= "BCC: ".$object->getMailBCC(). "\r\n"; 

		} 		



		global $GLOBAL;

		$GLOBAL["SMTP_SERVER"] = 'smtp.1and1.com';

		$GLOBAL["SMTP_PORT"] = 25;

		$GLOBAL["SMTP_USERNAME"] = 'test_teeme@ideavate.com';

		$GLOBAL["SMTP_PASSWORD"] = 'ideavate@123';

		// get From address

		if ( preg_match("/From:.*?[A-Za-z0-9\._%-]+\@[A-Za-z0-9\._%-]+.*/", $headers, $froms) )

		{

			preg_match("/[A-Za-z0-9\._%-]+\@[A-Za-z0-9\._%-]+/", $froms[0], $fromarr);

			$from = $fromarr[0];

		}

	

		  // Open an SMTP connection

		  $cp = fsockopen ($GLOBAL["SMTP_SERVER"], $GLOBAL["SMTP_PORT"], &$errno, &$errstr, 1);

		  if (!$cp)

		   return "Failed to even make a connection";

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "220") return "Failed to connect";

		

		  // Say hello...

		  fputs($cp, "HELO ".$GLOBAL["SMTP_SERVER"]."\r\n");

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "250") return "Failed to Introduce";

		 

		  // perform authentication

		  fputs($cp, "auth login\r\n");

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "334") return "Failed to Initiate Authentication";

		 

		  fputs($cp, base64_encode($GLOBAL["SMTP_USERNAME"])."\r\n");

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "334") return "Failed to Provide Username for Authentication";

		 

		  fputs($cp, base64_encode($GLOBAL["SMTP_PASSWORD"])."\r\n");

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "235") return "Failed to Authenticate";

		

		  // Mail from...

		  fputs($cp, "MAIL FROM: <$from>\r\n");

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "250") return "MAIL FROM failed";

		

		  // Rcpt to...

		  fputs($cp, "RCPT TO: <$to>\r\n");

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "250") return "RCPT TO failed";

		

		  // Data...

		  fputs($cp, "DATA\r\n");

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "354") return "DATA failed";

		

		  // Send To:, From:, Subject:, other headers, blank line, message, and finish

		  // with a period on its own line (for end of message)

		  fputs($cp, "To: $to\r\nFrom: $from\r\nSubject: $subject\r\n$headers\r\n\r\n$message\r\n.\r\n");

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "250") return "Message Body Failed";

		

		  // ...And time to quit...

		  fputs($cp,"QUIT\r\n");

		  $res=fgets($cp,256);

		  if(substr($res,0,3) != "221") return "QUIT failed";		

		  return true;

	}

 }

?>