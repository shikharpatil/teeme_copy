<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: time_manager.php

	* Description 		  	: A class file used to handle teeme timezone functionalities

	* External Files called	: 

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 21-11-2008				Nagalingam						Created the file.			

	**********************************************************************************************************/

/**

* A PHP class to manage the timing according to the server time, machine time, GMT time and user defined timezone

* @author   Ideavate Solutions (www.ideavate.com)

*/

class Time_manager extends CI_Model

{	

	/**

	* This is the constructor of time_manager class that call the contstructor of the Parent Class CI_Model.

	*/

	public function __construct()

	{   

		//Parent class constructor.

		parent::__construct();

	}

	/**

	* This function used to convert the user time to GMT time

	* @params $userDateTimeVal. User input time

	* rerurn the GMT date time

	*/

	public function getGMTTimeFromUserTime( $userDateTimeVal, $format = 'Y-m-d H:i:s' )

    {	

		$tmpvar = explode(' ',$userDateTimeVal);

		$tmpDate = explode('-',$tmpvar[0]);

		$tmpTime = explode(':',$tmpvar[1]);

		if(count($tmpTime) == 2)

		{

			$tmpSec = 0;

		}		

		else

		{

			$tmpSec = $tmpTime[2];

		}

		if($_SESSION['timeDiff'] < 0)

		{

			$diffHour 	= ceil($_SESSION['timeDiff']);

		}

		else

		{

			$diffHour 	= floor($_SESSION['timeDiff']);

		}

		$diffMin	= ($_SESSION['timeDiff']*60)%60;		

		return date($format, mktime($tmpTime[0]-$diffHour,$tmpTime[1]-$diffMin,$tmpSec,$tmpDate[1],$tmpDate[2],$tmpDate[0]));	

	}

	/**

	*this function used to get the GMT date and time

	*/

	public function getGMTTime($format = 'Y-m-d H:i:s')

	{	
		/*$offset = $_SESSION['placeTimezone']; // Offset
		$is_DST = 0; 
		$timezone_name = timezone_name_from_abbr('', ($offset * 3600), $is_DST); // e.g. "Australia/Sydney"
		if($offset!='')
		{
			date_default_timezone_set($timezone_name);
		}
		else
		{
			date_default_timezone_set('UTC');
		}*/
		if(isset($_SESSION['placeTimezone']) && $_SESSION['placeTimezone'] != '')
		{
			$offset = $_SESSION['placeTimezone']; // Offset
			date_default_timezone_set('UTC');
			$gmt_datetime = strtotime(date($format));
			$localtime = $gmt_datetime + ($offset*3600);
			return date($format,$localtime);
		}
		else
		{
			date_default_timezone_set('UTC');
			return date($format);
		}
	}	

	/**

	* This function used to convert the GMT time to user time

	* @params $GMTTimeVal. This is a GMT time

	* rerurn the user time

	*/

	public function getUserTimeFromGMTTime( $GMTTimeVal, $format = 'd-m-Y H:i:s', $timeAgo = 0, $timeDiff='' )

    {
		
		$tmpvar = explode(' ',$GMTTimeVal);

		$tmpDate = explode('-',$tmpvar[0]);

		$tmpTime = explode(':',$tmpvar[1]);

		if(count($tmpTime) == 2)

		{

			$tmpSec = 0;

		}		

		else

		{

			$tmpSec = $tmpTime[2];

		}
		
		if($timeDiff=='')
		{
		
			if($_SESSION['timeDiff'] < 0)
	
			{
	
				$diffHour 	= ceil($_SESSION['timeDiff']);
	
			}
	
			else
	
			{
	
				$diffHour 	= floor($_SESSION['timeDiff']);
	
			}
	
			$diffMin	= ($_SESSION['timeDiff']*60)%60;
		}
		else
		{
			if($timeDiff < 0)
	
			{
	
				$diffHour 	= ceil($timeDiff);
	
			}
	
			else
	
			{
	
				$diffHour 	= floor($timeDiff);
	
			}
	
			$diffMin	= ($timeDiff*60)%60;
		}

		

		if($format=='m-d-Y h:i A'){
		

			$now = time();

			$difference     = $now - strtotime($GMTTimeVal);
			
			//return $diffHour.'==='.$diffMin;

/*			if(date('Y')==date('Y',strtotime($GMTTimeVal))){	

				$tym = date("jS M",mktime($tmpTime[0]+$diffHour,$tmpTime[1]+$diffMin,$tmpSec,$tmpDate[1],$tmpDate[2],$tmpDate[0]));

			}

			else{

				$tym = date("jS M y",mktime($tmpTime[0]+$diffHour,$tmpTime[1]+$diffMin,$tmpSec,$tmpDate[1],$tmpDate[2],$tmpDate[0]));

			}

			if($difference < (60*60*24*7)){

				$tym .= date(" H:i",mktime($tmpTime[0]+$diffHour,$tmpTime[1]+$diffMin,$tmpSec,$tmpDate[1],$tmpDate[2],$tmpDate[0]));

			}*/


			$tym = date("jS M y H:i",mktime($tmpTime[0]+$diffHour,$tmpTime[1]+$diffMin,$tmpSec,$tmpDate[1],$tmpDate[2],$tmpDate[0]));
			
			return $tym;

		}

		else{

		    return date($format, mktime($tmpTime[0]+$diffHour,$tmpTime[1]+$diffMin,$tmpSec,$tmpDate[1],$tmpDate[2],$tmpDate[0]));

		}

	}



	/*== get the last day of the month ==*/

	function getLastDayofMonth($mon,$year)

	{

		for($tday=28; $tday <= 31; $tday++) 

		{

			$tdate = getdate(mktime(0,0,0,$mon,$tday,$year));

			if ($tdate["mon"] != $mon) 

			{ 

				break; 

			}

		}

		$tday--;	

		return $tday;

	}

}

?>