<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: identity_db_manager.php

	* Description 		  	: A class file used to handle teeme identity management functionalities with database

	* External Files called	: models/dal/time_manager.php

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 10-10-2008				Nagalingam						Created the file.			

	********************************************************************************************************** 

	* ---------------------------------------------------------------------------------------------------------

	* 02-12-2008				Vinaykant						Added New function called add_user_unread($workspaceId, $workplaceId, $leafId).			

	**********************************************************************************************************/



/**

* A PHP class to access teeme work place, work space and users database with convenient methods

* with various operation Add, update, delete & retrieve teeme work place, work space and user details

* @author   Ideavate Solutions (www.ideavate.com)

*/

class backup_manager extends CI_Model

{	/**

	* This is the constructor of user DB Manager that call the contstructor of the Parent Class.

	*/

	public function __construct()

	{   

		//Parent class constructor.

		parent::__construct();

	}

	  



    public $compressedData = array();

    public $centralDirectory = array(); // central directory   

    public $endOfCentralDirectory = "\x50\x4b\x05\x06\x00\x00\x00\x00"; //end of Central directory record

    public $oldOffset = 0;

	

  var $server = 'localhost';

  var $port = 3306;

  var $username = 'root';

  var $password = '';

  var $database = '';

  var $link_id = -1;

  var $connected = false;

  var $tables = array();

  var $drop_tables = true;

  var $struct_only = false;

  var $comments = true;

  var $backup_dir = '';

  var $fname_format = 'd_m_y__H_i_s';

  var $error = '';

  

  	var $MSB_VERSION = '1.0.0';

	var $MSB_NL = "\r\n";

	var $MSB_STRING = 0;

	var $MSB_DOWNLOAD = 1;

	var $MSB_SAVE = 2;



    /**

     * Function to create the directory where the file(s) will be unzipped

     *

     * @param $directoryName string

     *

     */

    

    public function addDirectory($directoryName) {

        $directoryName = str_replace("\\", "/", $directoryName);  

        $feedArrayRow = "\x50\x4b\x03\x04";

        $feedArrayRow .= "\x0a\x00";    

        $feedArrayRow .= "\x00\x00";    

        $feedArrayRow .= "\x00\x00";    

        $feedArrayRow .= "\x00\x00\x00\x00";



        $feedArrayRow .= pack("V",0);

        $feedArrayRow .= pack("V",0);

        $feedArrayRow .= pack("V",0);

        $feedArrayRow .= pack("v", strlen($directoryName) );

        $feedArrayRow .= pack("v", 0 );

        $feedArrayRow .= $directoryName;  



        $feedArrayRow .= pack("V",0);

        $feedArrayRow .= pack("V",0);

        $feedArrayRow .= pack("V",0);



        $this -> compressedData[] = $feedArrayRow;

        

        $newOffset = strlen(implode("", $this->compressedData));



        $addCentralRecord = "\x50\x4b\x01\x02";

        $addCentralRecord .="\x00\x00";    

        $addCentralRecord .="\x0a\x00";    

        $addCentralRecord .="\x00\x00";    

        $addCentralRecord .="\x00\x00";    

        $addCentralRecord .="\x00\x00\x00\x00";

        $addCentralRecord .= pack("V",0);

        $addCentralRecord .= pack("V",0);

        $addCentralRecord .= pack("V",0);

        $addCentralRecord .= pack("v", strlen($directoryName) );

        $addCentralRecord .= pack("v", 0 );

        $addCentralRecord .= pack("v", 0 );

        $addCentralRecord .= pack("v", 0 );

        $addCentralRecord .= pack("v", 0 );

        $ext = "\x00\x00\x10\x00";

        $ext = "\xff\xff\xff\xff";  

        $addCentralRecord .= pack("V", 16 );



        $addCentralRecord .= pack("V", $this -> oldOffset );

        $this -> oldOffset = $newOffset;



        $addCentralRecord .= $directoryName;  



        $this -> centralDirectory[] = $addCentralRecord;  

    }    

    

    /**

     * Function to add file(s) to the specified directory in the archive

     *

     * @param $directoryName string

     *

     */

    

    public function addFile($data, $directoryName)   {



        $directoryName = str_replace("\\", "/", $directoryName);  

    

        $feedArrayRow = "\x50\x4b\x03\x04";

        $feedArrayRow .= "\x14\x00";    

        $feedArrayRow .= "\x00\x00";    

        $feedArrayRow .= "\x08\x00";    

        $feedArrayRow .= "\x00\x00\x00\x00";



        $uncompressedLength = strlen($data);  

        $compression = crc32($data);  

        $gzCompressedData = gzcompress($data);  

        $gzCompressedData = substr( substr($gzCompressedData, 0, strlen($gzCompressedData) - 4), 2);

        $compressedLength = strlen($gzCompressedData);  

        $feedArrayRow .= pack("V",$compression);

        $feedArrayRow .= pack("V",$compressedLength);

        $feedArrayRow .= pack("V",$uncompressedLength);

        $feedArrayRow .= pack("v", strlen($directoryName) );

        $feedArrayRow .= pack("v", 0 );

        $feedArrayRow .= $directoryName;  



        $feedArrayRow .= $gzCompressedData;  



        $feedArrayRow .= pack("V",$compression);

        $feedArrayRow .= pack("V",$compressedLength);

        $feedArrayRow .= pack("V",$uncompressedLength);



        $this -> compressedData[] = $feedArrayRow;



        $newOffset = strlen(implode("", $this->compressedData));



        $addCentralRecord = "\x50\x4b\x01\x02";

        $addCentralRecord .="\x00\x00";    

        $addCentralRecord .="\x14\x00";    

        $addCentralRecord .="\x00\x00";    

        $addCentralRecord .="\x08\x00";    

        $addCentralRecord .="\x00\x00\x00\x00";

        $addCentralRecord .= pack("V",$compression);

        $addCentralRecord .= pack("V",$compressedLength);

        $addCentralRecord .= pack("V",$uncompressedLength);

        $addCentralRecord .= pack("v", strlen($directoryName) );

        $addCentralRecord .= pack("v", 0 );

        $addCentralRecord .= pack("v", 0 );

        $addCentralRecord .= pack("v", 0 );

        $addCentralRecord .= pack("v", 0 );

        $addCentralRecord .= pack("V", 32 );



        $addCentralRecord .= pack("V", $this -> oldOffset );

        $this -> oldOffset = $newOffset;



        $addCentralRecord .= $directoryName;  



        $this -> centralDirectory[] = $addCentralRecord;  

    }



    /**

     * Fucntion to return the zip file

     *

     * @return zipfile (archive)

     */



    public function getZippedfile() {



        $data = implode("", $this -> compressedData);  

        $controlDirectory = implode("", $this -> centralDirectory);  
		
		$centralDir = $this -> centralDirectory;
		//Manoj: added compressdata null for automatic backup 
		$this -> compressedData = '';
		$this -> centralDirectory = '';
		$this -> oldOffset ='';
		$newOffset='';
		//Manoj: code end
		
        
		return   

 			$data.  

            $controlDirectory.  

            $this -> endOfCentralDirectory.  

            pack("v", sizeof($centralDir)).     

            pack("v", sizeof($centralDir)).     

            pack("V", strlen($controlDirectory)).             

            pack("V", strlen($data)).                

            "\x00\x00";                             

    }

	

	

	function directoryToArray($directory, $recursive) {

    $array_items = array();

    if ($handle = opendir($directory)) {

        while (false !== ($file = readdir($handle))) {

            if ($file != "." && $file != "..") {

                if (is_dir($directory. "/" . $file)) {

                    if($recursive) {

                        $array_items = array_merge($array_items, $this->directoryToArray($directory. "/" . $file, $recursive));

                    }

                    $file = $directory . "/" . $file ."/";

                    $array_items[] = preg_replace("/\/\//si", "/", $file);

                } else {

                    $file = $directory . "/" . $file;

                    $array_items[] = preg_replace("/\/\//si", "/", $file);

                }

            }

        }

        closedir($handle);

    }

    return $array_items;

	}

	

	

	



  function Execute($task = '', $fname = '', $compress = false)

  {
	
  	$task = MSB_STRING;
	//echo "task= " .$task; exit;
   /*$test=$this->_Retrieve();
   return $test;*/
    if (!($sql = $this->_Retrieve()))

    {
	//echo "here"; exit;	
      return false;

    }

    if ($task == MSB_SAVE)

    {
		//echo "ho"; exit;
      if (empty($fname))

      {

        $fname = $this->backup_dir;

        $fname .= date($this->fname_format);

        $fname .= ($compress ? '.sql.gz' : '.sql');

      }

      return $this->_SaveToFile($fname, $sql, $compress);

    }

    elseif ($task == MSB_DOWNLOAD)

    {
	//echo "lubam"; exit;
      if (empty($fname))

      {

        $fname = date($this->fname_format);

        $fname .= ($compress ? '.sql.gz' : '.sql');

      }

      return $this->_DownloadFile($fname, $sql, $compress);

    }

    else

    {
		//echo "dump= " .$sql; exit;
      return $sql;

    }

  }





  function _Connect()

  {

    //$value = false;
//return $this->username.'==='.$this->password.'==='.$this->database.'==='.$this->server;
    
	  
      $host = $this->server;
	
     // $this->link_id = mysql_connect($host, $this->username, $this->password);
	 
	 //Manoj: replace code of mysql connection 
				$config = array();
				
				$config['hostname'] = $host;
				$config['username'] = $this->username;
				$config['password'] = $this->password;
				$config['database'] = $this->database;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
        $config['dbcollat'] = $this->db->dbcollat;
        
        //print_r($config); exit;

        $value = $this->load->database($config,TRUE);
        //print_r($value); exit;
				//return $this->username.'==='.$this->password.'==='.$this->database.'==='.$this->server;
				return $value;
  

    /*if ($this->link_id)

    {

      if (empty($this->database))

      {

        $value = true;

      }

      elseif ($this->link_id !== -1)

      {
		//Manoj: select database and replace mysql function
				$config = array();
				
				$config['hostname'] = $host;
				$config['username'] = $this->username;
				$config['password'] = $this->password;
				$config['database'] = $this->database;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;

				$value = $this->load->database($config,TRUE);

        //$value = mysql_select_db($this->database, $this->link_id);

      }

      else

      {
	  		$config = array();
				
			$config['hostname'] = $host;
			$config['username'] = $this->username;
			$config['password'] = $this->password;
			$config['database'] = $this->database;
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;

			$value = $this->load->database($config,TRUE);
       	 	//$value = mysql_select_db($this->database);

      }

    }*/

    if (!$value)

    {

      $this->error = $this->db->error();

    }

    

  }





  function _Query($sql)

  {

    
				$config = array();
				
				$config['hostname'] = $this->server;
				$config['username'] = $this->username;
				$config['password'] = $this->password;
				$config['database'] = $this->database;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;

				$value = $this->load->database($config,TRUE);
    
	//$result = mysql_query($sql);
    $result = $value->query($sql);

    if (!$result)

    {

      $this->error = $value->error();

    }

    return $result;

  }





  function _GetTables()

  {

    $value = array();

    if (!($result = $this->_Query('SHOW TABLES')))

    {

      return false;

    }
	//return $result;
   // while ($row = mysql_fetch_row($result))
  
   //return $result->result();
   
   foreach($result->result() as $row)
   {
   	 foreach($row as $data)
	  {
		//return $data;
		$value[]= $data;
	  }
   
   }
   //return $value;
 /*  while ($row = $result->row())
   {
//return $row;
      if (empty($this->tables) || in_array($row->Tables_in_beta, $this->tables))

      {

        $value[] = $row->Tables_in_beta;

      }

    }*/

    if (!sizeof($value))

    {

      $this->error = $this->lang->line('no_tables_found_in_db');

      return false;

    }
	
    return $value;

  }





  function _DumpTable($table)

  {
  

    $value = '';

    $this->_Query('LOCK TABLES ' . $table . ' WRITE');

/*    if ($this->comments)

    {

      $value .= '#' . $MSB_NL;

      $value .= '# Table structure for table `' . $table . '`' . $MSB_NL;

      $value .= '#' . $MSB_NL . $MSB_NL;

    }*/

    if ($this->drop_tables)

    {

     // Andy
	 // $value .= 'DROP TABLE IF EXISTS `' . $table . '`;' . $MSB_NL;
	 $value .= 'DROP TABLE IF EXISTS `' . $table . '`||' . $MSB_NL;

    }

    if (!($result = $this->_Query('SHOW CREATE TABLE ' . $table)))

    {

      return false;

    }

    //$row = mysql_fetch_assoc($result);
	$row = $result->row();
	//return $row->{'Create Table'};
	

    // Andy 
	// $value .= str_replace("\n", $MSB_NL, $row['Create Table']) . ';';
	$value .= str_replace("\n", $MSB_NL, $row->{'Create Table'}) . '||';

    $value .= $MSB_NL . $MSB_NL;

    if (!$this->struct_only)

    {

/*      if ($this->comments)

      {

        $value .= '#' . $MSB_NL;

        $value .= '# Dumping data for table `' . $table . '`' . $MSB_NL;

        $value .= '#' . $MSB_NL . $MSB_NL;

      }*/

            

      $value .= $this->_GetInserts($table);
	  //return $value;

    }

    $value .= $MSB_NL . $MSB_NL;

    $this->_Query('UNLOCK TABLES');

    return $value;

  }





  function _GetInserts($table)

  {

    $value = '';

    if (!($result = $this->_Query('SELECT * FROM ' . $table)))

    {

      return false;

    }

    //while ($row = mysql_fetch_row($result))
	/*while ($row = $result->row())
	{

      $values = '';
	 //Manoj: replace mysql_escape_str function

      foreach ($row as $data)

      {
			return $data;
			$values .= '\'' . $this->db->escape_str(html_entity_decode($data, ENT_QUOTES)) . '\', ';
      }

      $values = substr($values, 0, -2);

      // Andy
	  // $value .= 'INSERT INTO ' . $table . ' VALUES (' . $values . ');' . $MSB_NL;
	  $value .= 'INSERT INTO ' . $table . ' VALUES (' . $values . ')||' . $MSB_NL;

    }*/
	foreach($result->result() as $row)
   {
   	  $values = '';
	  foreach ($row as $data)
	  {
			//return $data;
			$values .= '\'' . $this->db->escape_str(html_entity_decode($data, ENT_QUOTES)) . '\', ';
      }
	    $values = substr($values, 0, -2);

      // Andy
	  // $value .= 'INSERT INTO ' . $table . ' VALUES (' . $values . ');' . $MSB_NL;
	  $value .= 'INSERT INTO ' . $table . ' VALUES (' . $values . ')||' . $MSB_NL;
   
   }

    return $value;

  }





  function _Retrieve()

  {

    $value = '';
/*$test_conn=$this->_Connect();
return $test_conn;*/
//echo "here"; exit;
    if (!$this->_Connect())

    {

      return false;

    }

   if ($this->comments)

    {

      $value .= '#' . $MSB_NL;

      $value .= '# MySQL database dump' . $MSB_NL;

      $value .= '# Created by MySQL_Backup class, ver. ' . $MSB_VERSION . $MSB_NL;

      $value .= '#' . $MSB_NL;

      $value .= '# Host: ' . $this->server . $MSB_NL;

      $value .= '# Generated: ' . date('M j, Y') . ' at ' . date('H:i') . $MSB_NL;

      $value .= '# PHP version: ' . phpversion() . $MSB_NL;

      if (!empty($this->database))

      {

        $value .= '#' . $MSB_NL;

        $value .= '# Database: `' . $this->database . '`' . $MSB_NL;

      }

      $value .= '#' . $MSB_NL . $MSB_NL . $MSB_NL;

    }
//return $this->_GetTables();
    if (!($tables = $this->_GetTables()))

    {

      return false;

    }
//return $tables;
    foreach ($tables as $table)

    {
	

      if (!($table_dump = $this->_DumpTable($table)))

      {

        $this->error = $this->db->error();

        return false;

      }

      $value .= $table_dump;

    }

    return $value;

  }





  function _SaveToFile($fname, $sql, $compress)

  {

    if ($compress)

    {

      if (!($zf = gzopen($fname, 'w9')))

      {

        $this->error = $this->lang->line('output_file_not_created');

        return false;

      }

      gzwrite($zf, $sql);

      gzclose($zf);

    }

    else

    {

      if (!($f = fopen($fname, 'w')))

      {

        $this->error = $this->lang->line('output_file_not_created');

        return false;

      }

      fwrite($f, $sql);

      fclose($f);

    }

    return true;

  }

  

  function pr($val)

	{

    echo '<pre>';

    print_r($val);

    echo '</pre>';

	}
  public function sendHeaders($file, $type, $name=NULL)
  {
      if (empty($name))
      {
          $name = basename($file);
      }
      header('Pragma: public');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Cache-Control: private', false);
      header('Content-Transfer-Encoding: binary');
      header('Content-Disposition: attachment; filename="'.$name.'";');
      header('Content-Type: ' . $type);
      header('Content-Length: ' . filesize($file));
  }
	function downloadBackup ($filename='', $fullPath='')
	{
				if (headers_sent()) {
					echo $this->lang->line('http_header_sent');
				} 		
				else
				{
					if (!is_file($fullPath)) {
						header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
						echo 'File not found';
					} else if (!is_readable($fullPath)) {
						header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
						echo $this->lang->line('file_not_readable');
					}	
					else
					{
            /*
						$this->load->helper('download');
            $data = file_get_contents($fullPath); // Read the file's contents
						ob_end_clean();
						force_download($filename, $data);
						exit;
            */
                  $this->sendHeaders($fullPath, mime_content_type($fullPath), $filename);
                  $chunkSize = 1024 * 1024;
                  $handle = fopen($fullPath, 'rb');
                  while (!feof($handle))
                  {
                      $buffer = fread($handle, $chunkSize);
                      echo $buffer;
                      ob_flush();
                      flush();
                  }
                  fclose($handle);
                  exit;          			
				  }	
        }
  }
	
	function extractZip ($fullPath='')
	{
		
		$zip = new ZipArchive;
		chmod($fullPath,0777);
			if ($zip->open($fullPath) === TRUE) {
				$newdir = 'restore_'.time();
				 $zip->extractTo('./uploads/'.$newdir.'/');
				 $zip->close();
				 return $newdir;
			} else {
				 return 'failed';
			}
	}
	
	function moveBackup ($source='',$destination='')
	{
		$dir = ".";//"path/to/targetFiles";
		$dirNew = "viejo2014";//path/to/destination/files
		// Open a known directory, and proceed to read its contents
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
				echo '<br>Archivo: '.$file;
				//exclude unwanted 
				if ($file=="move.php")continue;
				if ($file==".") continue;
				if ($file=="..")continue;
				if ($file=="viejo2014")continue;
				if ($file=="viejo2013")continue;
				if ($file=="cgi-bin")continue;
				//if ($file=="index.php") continue; for example if you have index.php in the folder
				if (rename($dir.'/'.$file,$dirNew.'/'.$file))
					{
					echo $this->lang->line('file_copied_successfully');
					echo ": $dirNew/$file"; 
					//if files you are moving are images you can print it from 
					//new folder to be sure they are there 
					}
					else {echo $this->lang->line('file_not_copy');}
				}
				closedir($dh);
			}
		}	
	}

	
	function copyr($source, $dest,$place_name='')
	{ 
		if(is_dir($source)) {
			$dir_handle=opendir($source);
			while($file=readdir($dir_handle)){
				if($file!="." && $file!=".."){
					if(is_dir($source."/".$file)){
					
						if ($file=='workplaces')
						{
							return false;
						}

						if ($place_name!='')
						{
							rename ($source."/".$file,$source."/".$place_name);
								if(!is_dir($dest."/".$place_name)){
									mkdir($dest."/".$place_name);
								}
							$this->copyr($source."/".$place_name, $dest."/".$place_name);	
						}	
						else
						{
								if(!is_dir($dest."/".$file)){
									mkdir($dest."/".$file);
								}
							$this->copyr($source."/".$file, $dest."/".$file);	
						}

						$this->copyr($source."/".$file, $dest."/".$file);
/*						if(!is_dir($dest."/".$file)){
							mkdir($dest."/".$file);
						}

						$this->copyr($source."/".$file, $dest."/".$file);*/
					} 
					else {
						$ext = pathinfo($file, PATHINFO_EXTENSION);
						if ($ext != 'sql')
						{
							copy($source."/".$file, $dest."/".$file);
						}
					}
				}
			}
			closedir($dir_handle);
		} else {
			copy($source, $dest);
		}
		return true;
	}

	function rrmdir($dir) {
	   if (is_dir($dir)) {
		 $objects = scandir($dir);
		 foreach ($objects as $object) {
		   if ($object != "." && $object != "..") {
			 if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
		   }
		 }
		 reset($objects);
		 rmdir($dir);
	   }
  } 
  
  function zipWithoutMemoryLimit ($source=''){
    if (!extension_loaded('zip') || !file_exists($source)) {
      return false;
    }
    $zip = new ZipArchive();

    $zip->open("" .$source. ".zip", ZipArchive::CREATE);

    $files = scandir("" .$source. "");
    unset($files[0], $files[1]);

    foreach ($files as $file){
        $zip->addFile("" .$source. "/{$file}");
    }
    $zip->close(); 
  }

  public function zip_files( $source, $destination ) 
  {
    $zip = new ZipArchive();
    if($zip->open($destination, ZIPARCHIVE::CREATE) === true) {
      $source = realpath($source);
      if(is_dir($source)) {
        
        $iterator = new RecursiveDirectoryIterator($source);
        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
      // $zip->addEmptyDir(basename($source));
        foreach($files as $file) {
          $file = realpath($file);
          //echo "<li>File= " .$file;
          if(is_dir($file)) {
            $zip->addEmptyDir(str_replace($source . DIRECTORY_SEPARATOR, '', $file . DIRECTORY_SEPARATOR));
          }elseif(is_file($file)) {
            $zip->addFile($file,str_replace($source . DIRECTORY_SEPARATOR, '', $file));
          }
        }
      }elseif(is_file($source)) {
        $zip->addFile($source,basename($source));
      }
    }
    exit;
    return $zip->close();
  }

  public function folderToZip($folder, &$zipFile, $exclusiveLength) { 
    $handle = opendir($folder); 
    while (false !== $f = readdir($handle)) { 
      if ($f != '.' && $f != '..') { 
        $filePath = "$folder/$f"; 
        // Remove prefix from file path before add to zip. 
        $localPath = substr($filePath, $exclusiveLength); 
        if (is_file($filePath)) { 
          $zipFile->addFile($filePath, $localPath); 
        } elseif (is_dir($filePath)) { 
          // Add sub-directory. 
          $zipFile->addEmptyDir($localPath); 
          self::folderToZip($filePath, $zipFile, $exclusiveLength); 
        } 
      } 
    } 
    closedir($handle); 
  } 

  /** 
   * Zip a folder (include itself). 
   * Usage: 
   *   HZip::zipDir('/path/to/sourceDir', '/path/to/out.zip'); 
   * 
   * @param string $sourcePath Path of directory to be zip. 
   * @param string $outZipPath Path of output zip file. 
   */ 
  public function zipDir($sourcePath, $outZipPath,$configBackupDB='') 
  { 
    $pathInfo = pathInfo($sourcePath); 
    $parentPath = $pathInfo['dirname']; 
    $dirName = $pathInfo['basename']; 

    $z = new ZipArchive(); 
    $z->open($outZipPath, ZIPARCHIVE::CREATE); 
    $z->addEmptyDir($dirName); 
    self::folderToZip($sourcePath, $z, strlen("$parentPath/")); 
    $z->close(); 
  }
}
?>