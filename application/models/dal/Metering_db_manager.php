<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

	/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: metering_db_manager.php

	* Description 		  	: A class file used to show the metering related function.

	* External Files called	:  models/dal/metering_db_manager.php,

								

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 24-11-2011				Arun julwania						Created the file.	

	**********************************************************************************************************/





class metering_db_manager extends CI_Model

{ 

	

	

	

	/**

	* This is the constructor  that call the contstructor of the Parent Class.

	*/

	public function __construct()

	{   

		//Parent class constructor.teeme_node

		parent::__construct();

	}



			

		 /**

	* This method will be used to get details of db,filesize and members in place

	* @param $documentName This is the variable used to hold the document name 

	*/

	public function getMeteringDetail()

	{	

	

	    $data= array();

		

		//fetch data from db to get place db size,file size and member detail of each month

		$query = $this->db->query('SELECT * FROM `teeme_metering_place`') ;	

									

		if($query->num_rows() > 0)

			{	

				$i = 0;			

				$curr=0;

				foreach ($query->result() as $row)

				{	

					$data[$i]['id'] 				= $row->id;

					$data[$i]['lastUpdate'] 		= $row->lastUpdate;

					$data[$i]['dbSize'] 			= ($i==0)?$row->dbSize:$row->dbSize-$curr->dbSize;

					$data[$i]['importedFileSize'] 	= ($i==0)?$row->importedFileSize:$row->importedFileSize-$curr->importedFileSize;

					$data[$i]['membersCount'] 		= ($i==0)?$row->membersCount:$row->membersCount-$curr->membersCount;

					$data[$i]['month']		 		= ($row->month==date('M, Y'))?date('jS M, Y'):$row->month;

					$curr=$row;

					$i++;					

				}

			}

		return $data;	

		

	}	

	

	//This function returns metertin details to admin with all places details 

	public function getMeteringDetailsToAdmin($placeId='')

	{	

	    $data= array();

		

		//fetch data from db to get place db size,file size and member detail of each month

		$query = $this->db->query('SELECT * FROM `'.$this->config->item('instanceDb').'`.`teeme_metering_instance`  WHERE  `placeId`="'.$placeId.'" ') ;	

									

		if($query->num_rows() > 0)

			{	

				$curr=0;

				$i = 0;			

				foreach ($query->result() as $row)

				{	

					$data[$i]['id'] 				= $row->id;	

					$data[$i]['lastUpdate'] 		= $row->lastUpdate;

					$data[$i]['dbSize'] 			= $row->dbSize;

					$data[$i]['importedFileSize'] 	= ($i==0)?$row->importedFileSize:$row->importedFileSize-$curr->importedFileSize;	

					$data[$i]['membersCount'] 		= $row->membersCount;	

					$data[$i]['month']		 		= $row->month;

					$curr = $row;

					$i++;					

				}

			}

			

		return $data;	

		

	}	

	

	

	//function returns total number of  previous month users 

	function getPreviousMonthMembers()

	{

		$query = $this->db->query("SELECT `membersCount` FROM `teeme_metering_place` ORDER BY id desc LIMIT 1 ") ;	

		if($query->num_rows()>0)

		{  

			$row=$query->row();

			

			 return $row->membersCount;



		}

		return 0;

	}

	

	//function returns total number of users which registered in curren month 

	function getCurrentMonthNewRegisterMembers()

	{

	     $current_month=date('m');

         $current_year=date('Y');

	    $query="SELECT count(userId) AS total FROM teeme_users WHERE registeredDate BETWEEN '".date('Y-m-d', mktime(0,0,0,$current_month,01,$current_year))."' AND '". date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00')))) ." ' ";

	

		$query = $this->db->query($query);	

		

		if($query->num_rows()>0)

		{  

			 $row=$query->row();

			 return $row->total;

		}

		return 0;

	}

		

	//function returns total number of users 

	function deactivatedPreviousMonthMembers()

	{

	     $current_month=date('m');

         $current_year=date('Y');

	   $query="SELECT count(userId) AS total FROM teeme_users WHERE 	deletedDate BETWEEN '".date("Y-m-d",strtotime("-1 month",strtotime(date("m")."/01/".date("Y")." 00:00:00")))."' AND '". date('Y-m-d',strtotime('-1 second',strtotime('+0 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00')))) ." ' AND status='1' ";

	

		$query = $this->db->query($query);	

		

		if($query->num_rows()>0)

		{  

			$row=$query->row();

			

			 return $row->total;



		}

		return 0;

	}

	

	

	//function returns to size of data base

	function getDbSize($placeId=0)
	{ 
		$this->load->model('dal/identity_db_manager');	
		
		$objIdentity = $this->identity_db_manager;
		
		$workPlaceData = $objIdentity->getWorkPlaceDetails($placeId);
		$place_name = mb_strtolower($workPlaceData['companyName']);
		
		$config = array();
		
        $config['hostname'] = $workPlaceData['server'];
        $config['username'] = $workPlaceData['server_username'];
        $config['password'] = $workPlaceData['server_password'];
        $config['database'] = $this->config->item('instanceDb').'_'.$place_name;
        $config['dbdriver'] = $this->db->dbdriver;
        $config['dbprefix'] = $this->db->dbprefix;
        $config['pconnect'] = FALSE;
        $config['db_debug'] = $this->db->db_debug;
        $config['cache_on'] = $this->db->cache_on;
        $config['cachedir'] = $this->db->cachedir;
        $config['char_set'] = $this->db->char_set;
        $config['dbcollat'] = $this->db->dbcollat;
		
		$placedb = $this->load->database($config,TRUE);
		
		//print_r ($placedb); exit;

		$total=0;

	    if($placeId!=0)
		{ 

			$query = $placedb->query('SHOW TABLE STATUS');
		  
				if($query->num_rows() > 0)
				{  
					foreach($query->result() as $row)
					{
						$total=$total+ $row->Data_length+$row->Index_length;
					}
					return  round(($total/1024)/1024,2);	
				}
				return false;	
		}
		return false;
	}
	
	//function returns total number of users which registered in curren month 

	function currentMonthActivatedUsers($placeId=0)
	{
	
 
		$this->load->model('dal/identity_db_manager');	
		
		$objIdentity = $this->identity_db_manager;
		
		$workPlaceData = $objIdentity->getWorkPlaceDetails($placeId);
		$place_name = mb_strtolower($workPlaceData['companyName']);
		
		$config = array();
		
        $config['hostname'] = $workPlaceData['server'];
        $config['username'] = $workPlaceData['server_username'];
        $config['password'] = $workPlaceData['server_password'];
        $config['database'] = $this->config->item('instanceDb').'_'.$place_name;
        $config['dbdriver'] = $this->db->dbdriver;
        $config['dbprefix'] = $this->db->dbprefix;
        $config['pconnect'] = FALSE;
        $config['db_debug'] = $this->db->db_debug;
        $config['cache_on'] = $this->db->cache_on;
        $config['cachedir'] = $this->db->cachedir;
        $config['char_set'] = $this->db->char_set;
        $config['dbcollat'] = $this->db->dbcollat;
		
		$placedb = $this->load->database($config,TRUE);
		
		//print_r ($placedb); exit;

		$total=0;

	    if($placeId!=0)
		{ 

			$query = $placedb->query('SELECT count(userId) AS total FROM teeme_users WHERE  status=\'0\'');
		  
				if($query->num_rows() > 0)
				{  
					foreach($query->result() as $row)
					{
						return  $row->total;					
					}
				}
				return false;	
		}
		return false;
	}

	function getDirectorySize($path)

        { 

            $totalsize = 0;

            $totalcount = 0;

            $dircount = 0;

            if ($handle = opendir ($path))

            {

                while (false !== ($file = readdir($handle)))

                { 

                    $nextpath = $path . '/' . $file;

                    if ($file != '.' && $file != '..' && !is_link ($nextpath))

                    { 

					

                        if (is_dir ($nextpath))

                        { 

                            $dircount++;

                            $result = $this->getDirectorySize($nextpath);

                            $totalsize += $result['size'];

                            $totalcount += $result['count'];

                            $dircount += $result['dircount'];

                        }

                        elseif (is_file ($nextpath))

                        { 

						

                            $totalsize += filesize ($nextpath);

                            $totalcount++;

                        }

                    }

                }

            }

            closedir ($handle);

            $total['size'] = $totalsize; //converted in MB

            $total['count'] = $totalcount;

            $total['dircount'] = $dircount;

            return $total;

        }



		//function retuns size of file with units

        function sizeFormat($size)

        {

            if($size<1024)

            {

                return $size." bytes";

            }

            else if($size<(1024*1024))

            {

                $size=round($size/1024,2);

                return $size." KB";

            }

            else if($size<(1024*1024*1024))

            {

                $size=round($size/(1024*1024),2);

                return $size." MB";

            }

            else

            {

                $size=round($size/(1024*1024*1024),2);

                return $size." GB";

            }

        }

   

		//set all the details of place 

		function setPlaceLog($dbSize,$folderSize,$members,$placeName='')

		{

		   $placeName=strtolower($placeName);

		    if($placeName!='')

			{ 
				
				//$db = mysql_connect (base64_decode($this->config->item('hostname')), base64_decode($this->config->item('username')), base64_decode($this->config->item('password')));
				
				//Manoj: replace code of mysql connection 
				$config = array();
				
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = 'teeme_'.$placeName;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;

				$db = $this->load->database($config,TRUE);
			

				//if(mysql_select_db('teeme_'.$placeName,$db))
				if($db)
				{

				

					$result = $db->query( "SELECT lastUpdate,id FROM teeme_metering_place WHERE lastUpdate BETWEEN '".date('Y-m-d', mktime(0,0,0,date('m'),01,date('Y')))."' AND '".date('Y-m-d', mktime(0,0,0,date('m')+1,01,date('Y'))) ." ' ");

					

					//if((mysql_num_rows($result)) > 0) 
					if($result->num_rows() > 0)
					{

						//$r = mysql_fetch_assoc ($result);
						$r = $result->row();
						

						$query="UPDATE  `teeme_metering_place` SET lastUpdate=NOW() ,dbSize='".$dbSize."',importedFileSize='".$folderSize."',membersCount='".$members."' WHERE id=  ".$r->id;	

					}

					else

					{

						$query="INSERT INTO `teeme_metering_place`(lastUpdate,dbSize,importedFileSize,membersCount,month) values(NOW(),'".$dbSize."','".$folderSize."','".$members."','".date("M, Y")."') ";

					}

				

					$db->query($query);

					return true;	

				}

							

				

			}

			else

			{

		 

			 $query="SELECT lastUpdate,id FROM teeme_metering_place WHERE lastUpdate BETWEEN '".date('Y-m-d', mktime(0,0,0,date('m'),01,date('Y')))."' AND '".date('Y-m-d', mktime(0,0,0,date('m')+1,01,date('Y'))) ." ' "; 

			$query=$this->db->query($query);

		if($query->num_rows() > 0)

		{

			$result=$query->row();

			

$query="UPDATE  `teeme_metering_place` SET lastUpdate=NOW() ,dbSize='".$dbSize."',importedFileSize='".$folderSize."',membersCount='".$members."' WHERE id=  ".$result->id;				

		}

		else

		{		

		

		

			$query="INSERT INTO `teeme_metering_place`(lastUpdate,dbSize,importedFileSize,membersCount,month) values(NOW(),'".$dbSize."','".$folderSize."','".$members."','".date("M, Y")."') ";

			

			

			

		}	

			

			$this->db->query($query);

			return true;

			

			}

		

		}

		

		//function set meterint result in base data base

		function setMeteringResultBaseDb($dbSize,$folderSize,$members,$placeId)

		{

		  

		  	 $query="SELECT lastUpdate,id FROM `".$this->config->item('instanceDb')."`.`teeme_metering_instance` WHERE lastUpdate BETWEEN '".date('Y-m-d', mktime(0,0,0,date('m'),01,date('Y')))."' AND '".date('Y-m-d', mktime(0,0,0,date('m')+1,01,date('Y'))) ." ' AND placeId='$placeId'  "; 

			$query=$this->db->query($query);

			if($query->num_rows() > 0)

			{

				$result=$query->row();

			

$query="UPDATE  `".$this->config->item('instanceDb')."`.`teeme_metering_instance` SET lastUpdate=NOW() ,dbSize='".$dbSize."',importedFileSize='".$folderSize."',membersCount='".$members."' WHERE id=  ".$result->id;	

			}

			else

			{

		  

			$query="INSERT INTO `".$this->config->item('instanceDb')."`.`teeme_metering_instance`(placeId,lastUpdate,dbSize,importedFileSize,membersCount,month) values('".$placeId."',NOW(),'".$dbSize."','".$folderSize."','".$members."','".date("M, Y")."') ";

			}

			$this->db->query($query);

			

			return true;

			

		}

		

		//FUNCTION RETURNS ALL PLACES

		function getAllPlaces()

		{

		

			$data= array();

		

			//fetch data from db to get place db size,file size and member detail of each month

			$query = $this->db->query('SELECT workPlaceId,companyName FROM `teeme_work_place` ') ;	

									

			if($query->num_rows() > 0)

			{	

				$i = 0;			

				foreach ($query->result() as $row)

				{	

					$data[$i]['workPlaceId'] 		= $row->workPlaceId;	

					$data[$i]['companyName'] 		= $row->companyName;				

					$i++;					

				}

			}

			return $data;	

		

		}

		

		

		

 }

?>