<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: help_db_manager.php

	* Description 		  	: A class file used to handle teeme help system functionalities with database

	* External Files called	: models/dal/idenityDBManage.php, models/dal/time_manager.php

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 20-05-2009				Nagalingam						Created the file.			

	**********************************************************************************************************/



/**

* A PHP class to access the teeme help system Database with convenient methods

* with various operation Add, update, delete & retrieve help topic, sub topics & sub topic contents

* @author   Ideavate Solutions (www.ideavate.com)

*/

// file that have the code for DBmanager class; 

//require('DBManager.php'); 

class help_db_manager extends CI_Model

{ 	

	/**

	* This is the constructor of user DB Manager that call the contstructor of the Parent Class.

	*/

	public function __construct()

	{   

		//Parent class constructor.

		parent::__construct();

	}	

   /**

	* This is the implmentation of the abstract method from the parent DBManager class .

	* @param $object This is the object that will get inserted into the database.

	* @return This function used to indert the help system values into database.

	*/



	public function insertRecord($object)

    {

		//Inserting teeme help topic details

		if($object instanceof topic)

		{

			//Get data from the object and set it to according to their Database field name.			

			$strResultSQL = 'INSERT INTO teeme_help_main_topic

							 (

							topicId, topicName, trees, createdDate, createdBy, modifiedDate, status )

							VALUES

							(

							'.$object->getTopicId().',\''.$object->getTopicName().'\',\''.$object->getTopicTrees().'\',\''.$object->getTopicCreatedDate().'\','.$object->getTopicCreatedBy().',\''.$object->getTopicModifiedDate().'\','.$object->getTopicStatus().')';

							

		}

		//Inserting teeme help topic details for different languages

		if($object instanceof lang_topic)

		{

			//Get data from the object and set it to according to their Database field name.			

			$strResultSQL = 'INSERT INTO teeme_language_help_topic

							 (

							topicId, langCode, topicText )

							VALUES

							(

							'.$object->getTopicId().',\''.$object->getTopicLangCode().'\',\''.$object->getTopicText().'\')';

							

		}

		//Inserting teeme help sub topic details

		if($object instanceof sub_topic)

		{

			//Get data from the object and set it to according to their Database field name.			

			$strResultSQL = 'INSERT INTO teeme_help_sub_topic

							 (

							subTopicId, topicId, subTopicName, contents, createdDate, createdBy, modifiedDate, status )

							VALUES

							(

							'.$object->getSubTopicId().','.$object->getTopicId().',\''.$object->getSubTopicName().'\',\''.$object->getSubTopicContents().'\',\''.$object->getSubTopicCreatedDate().'\','.$object->getSubTopicCreatedBy().',\''.$object->getSubTopicModifiedDate().'\','.$object->getSubTopicStatus().')';

							

		}

		//Inserting teeme help sub topic details for different languages

		if($object instanceof lang_sub_topic)

		{

			//Get data from the object and set it to according to their Database field name.			

			$strResultSQL = 'INSERT INTO teeme_language_help_sub_topic

							 (

							subTopicId, langCode, subTopicText, contents )

							VALUES

							(

							'.$object->getSubTopicId().',\''.$object->getSubTopicLangCode().'\',\''.$object->getSubTopicText().'\',\''.$object->getSubTopicContents().'\')';

							

		}

		

		$bResult = $this->db->query($strResultSQL);

		if($bResult)

		{

			return true;

		}		

		else

		{

			return false;

		}

	}



	 /**

	* This is the implmentation of the abstract method from the parent DBManager class .

	* @param $object This is the object that will get updated into the database.

	* update the teeme help system details into database.

	*/



	public function updateRecord($object)

    {

		//This variable hold the query for insert menu information into Database.

		$strResultSQL = '';

		if($object != NULL)

		{		

			//Updating help topic details	

			if($object instanceof topic)

			{

				//Get data from the object and set it to according to their Database field name.				

				$strResultSQL = 'UPDATE 

									teeme_help_main_topic 

								SET

									topicName 		= \''.$object->getTopicName().'\', 

									trees 			= \''.$object->getTopicTrees().'\', 

									modifiedDate 	= \''.$object->getTopicModifiedDate().'\',	

									status = \''.$object->getTopicStatus().'\'									

								WHERE

									topicId = '.$object->getTopicId();

								

								

			}

			//Updating help sub topic details	

			if($object instanceof sub_topic)

			{

				//Get data from the object and set it to according to their Database field name.				

				$strResultSQL = 'UPDATE 

									teeme_help_sub_topic 

								SET

									subTopicName 	= \''.$object->getSubTopicName().'\',

									contents		= \''.$object->getSubTopicContents().'\',  

									modifiedDate 	= \''.$object->getSubTopicModifiedDate().'\',	

									status 			= \''.$object->getSubTopicStatus().'\'									

								WHERE

									subTopicId = '.$object->getSubTopicId();

								

								

			}

			//Updating help language topic details	

			if($object instanceof lang_topic)

			{

				//Get data from the object and set it to according to their Database field name.				

				$strResultSQL = 'UPDATE 

									teeme_language_help_topic 

								SET

									topicText 		= \''.$object->getTopicText().'\'										

								WHERE

									topicId = '.$object->getTopicId().' AND langCode = \''.$object->getTopicLangCode().'\'';							

			}		

			//Updating help language sub topic details	

			if($object instanceof lang_sub_topic)

			{

				//Get data from the object and set it to according to their Database field name.				

				$strResultSQL = 'UPDATE 

									teeme_language_help_sub_topic 

								SET

									subTopicText 		= \''.$object->getSubTopicText().'\',		

									contents 			= \''.$object->getSubTopicContents().'\'									

								WHERE

									subTopicId = '.$object->getSubTopicId().' AND langCode = \''.$object->getSubTopicLangCode().'\'';						

			}	

			$bResult = $this->db->query($strResultSQL);

			if($bResult)

			{

				return true;

			}		

			else

			{

				return false;

			}																	

		}		

	}

	

	 /**

	* This method will be used for fetch all the topic details from database

 	* @return The topic details

	*/

	public function getAllTopics()

	{

		$topicsData = array();		

		$query = $this->db->query('SELECT a.*, b.userName FROM teeme_help_main_topic a, teeme_admin b WHERE a.createdBy = b.id AND a.status = 1');

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach($query->result() as $row)

			{

				$topicsData[$i]['topicId'] 		= $row->topicId;											

				$topicsData[$i]['topicName'] 	= $row->topicName;

				$topicsData[$i]['trees'] 	= $row->trees;					

				$topicsData[$i]['modifiedDate'] = $row->modifiedDate;		

				$topicsData[$i]['userName'] 	= $row->userName;

				$i++;			

			}				

		}						

		return $topicsData;			

	}

	 /**

	* This method will be used delete all the sub topic and particular topic from database

 	* @return delettion status

	*/

	public function deleteRecord($topicId)

	{

		 

		$query = $this->db->query("delete FROM teeme_help_sub_topic   WHERE  topicId = ".$topicId);

		$query = $this->db->query("delete FROM teeme_help_main_topic   WHERE  topicId = ".$topicId);				

		return true;			

	}

	 /**

	* This method will be used for fetch all the sub topic details from database

 	* @return The sub topic details

	*/

	public function getAllSubTopics()

	{

		$topicsData = array();		

		$query = $this->db->query('SELECT a.*, b.userName, c.topicName FROM teeme_help_sub_topic a, teeme_admin b, teeme_help_main_topic c WHERE a.createdBy = b.id AND a.topicId = c.topicId AND a.status = 1');

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach($query->result() as $row)

			{

				$topicsData[$i]['subTopicId'] 	= $row->subTopicId;	

				$topicsData[$i]['topicId'] 		= $row->topicId;	

				$topicsData[$i]['subTopicName'] = $row->subTopicName;											

				$topicsData[$i]['topicName'] 	= $row->topicName;	

				$topicsData[$i]['modifiedDate'] = $row->modifiedDate;		

				$topicsData[$i]['userName'] 	= $row->userName;

				$i++;			

			}				

		}						

		return $topicsData;			

	}

	 /**

	* This method will be used for fetch the topic details by topic id

 	* @return The topic details

	*/

	public function getTopicDetailsByTopicId($topicId)

	{

		$topicsData = array();		

		$query = $this->db->query('SELECT a.*, b.userName FROM teeme_help_main_topic a, teeme_admin b WHERE a.createdBy = b.id AND a.status = 1 AND a.topicId = '.$topicId);

		if($query->num_rows() > 0)

		{			

			foreach($query->result() as $row)

			{

				$topicsData['topicId'] 		= $row->topicId;	

				$topicsData['trees'] 		= $row->trees;										

				$topicsData['topicName'] 	= $row->topicName;	

				$topicsData['modifiedDate'] = $row->modifiedDate;	

				$topicsData['createdDate'] = $row->createdDate;		

				$topicsData['userName'] 	= $row->userName;						

			}				

		}						

		return $topicsData;			

	}

	 /**

	* This method will be used for fetch the sub topic details by sub topic id

 	* @return The sub topic details

	*/

	public function getSubTopicDetailsBySubTopicId($subTopicId, $langCode = '')

	{	

		$topicsData = array();	

		if($langCode == '')

		{	

			$query = $this->db->query('SELECT a.*, b.userName, c.topicName FROM teeme_help_sub_topic a, teeme_admin b, teeme_help_main_topic c WHERE a.createdBy = b.id AND a.topicId = c.topicId AND a.subTopicId = '.$subTopicId.' AND a.status = 1');

			if($query->num_rows() > 0)

			{			

				foreach($query->result() as $row)

				{

					$topicsData['subTopicId'] 	= $row->subTopicId;	

					$topicsData['topicId'] 		= $row->topicId;	

					$topicsData['subTopicName'] = $row->subTopicName;		

					$topicsData['contents'] 	= $row->contents;										

					$topicsData['topicName'] 	= $row->topicName;	

					$topicsData['modifiedDate'] = $row->modifiedDate;				

					$topicsData['userName'] 	= $row->userName;					

				}				

			}	

		}		

		else

		{

			$query = $this->db->query('SELECT * FROM teeme_language_help_sub_topic  WHERE subTopicId = '.$subTopicId.' AND langCode = \''.$langCode.'\'');

			if($query->num_rows() > 0)

			{			

				foreach($query->result() as $row)

				{

					$topicsData['subTopicId'] 	= $row->subTopicId;					

					$topicsData['subTopicName'] = $row->subTopicName;		

					$topicsData['contents'] 	= $row->contents;		

								

				}				

			}	else{	

				$query = $this->db->query('SELECT a.*, b.userName, c.topicName FROM teeme_help_sub_topic a, teeme_admin b, teeme_help_main_topic c WHERE a.createdBy = b.id AND a.topicId = c.topicId AND a.subTopicId = '.$subTopicId.' AND a.status = 1');

				if($query->num_rows() > 0)

				{			

					foreach($query->result() as $row)

					{

						$topicsData['subTopicId'] 	= $row->subTopicId;	

						$topicsData['topicId'] 		= $row->topicId;	

						$topicsData['subTopicName'] = $row->subTopicName;		

						$topicsData['contents'] 	= $row->contents;										

						$topicsData['topicName'] 	= $row->topicName;	

						$topicsData['modifiedDate'] = $row->modifiedDate;				

						$topicsData['userName'] 	= $row->userName;					

					}				

				}	

			}	

		}			

		return $topicsData;			

	}

	 /**

	* This method will be used for fetch all the language topic details from database

 	* @return The topic details in all languages

	*/

	public function getLangTopicsByTopicId($topicId)

	{

		$topicsData = array();		

		$query = $this->db->query('SELECT * FROM teeme_language_help_topic WHERE topicId = '.$topicId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach($query->result() as $row)

			{

				$topicsData[$i]['topicId'] 		= $row->topicId;											

				$topicsData[$i]['langCode'] 	= $row->langCode;					

				$topicsData[$i]['topicText']	= $row->topicText;				

				$i++;			

			}				

		}						

		return $topicsData;			

	}



	 /**

	* This method will be used for fetch all the language topic details from database

 	* @return The sub topic details in all languages

	*/

	public function getLangSubTopicsBySubTopicId($subTopicId)

	{

		$topicsData = array();		

		$query = $this->db->query('SELECT * FROM teeme_language_help_sub_topic WHERE subTopicId = '.$subTopicId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach($query->result() as $row)

			{

				$topicsData[$i]['subTopicId'] 	= $row->subTopicId;											

				$topicsData[$i]['langCode'] 	= $row->langCode;					

				$topicsData[$i]['subTopicText']	= $row->subTopicText;	

				$topicsData[$i]['contents']		= $row->contents;		

				$i++;			

			}				

		}						

		return $topicsData;			

	}



	 /**

	* This method will be used to send all the languages as an array

 	* @return The languages details as an array

	*/

	public function getLanguages()

	{

		$languages = array('FRE'=>'French', 'GER'=>'German', 'SPA'=>'Spanish', 'JAP'=>'Japanese');	

		

		return $languages;			

	}



	 /**

	* This method will be used for fetch all the language codes by topic id

 	* @return The language codes by topic id

	*/

	public function getLangCodesByTopicId($topicId)

	{

		$topicsData = array();		

		$query = $this->db->query('SELECT langCode FROM teeme_language_help_topic WHERE topicId = '.$topicId);

		if($query->num_rows() > 0)

		{			

			foreach($query->result() as $row)

			{														

				$topicsData[] 	= $row->langCode;					

			}				

		}						

		return $topicsData;			

	}



	 /**

	* This method will be used for fetch all the language codes by sub topic id

 	* @return The language codes by sub topic id

	*/

	public function getLangCodesBySubTopicId($subTopicId)

	{

		$topicsData = array();		

		$query = $this->db->query('SELECT langCode FROM teeme_language_help_sub_topic WHERE subTopicId = '.$subTopicId);

		if($query->num_rows() > 0)

		{			

			foreach($query->result() as $row)

			{														

				$topicsData[] 	= $row->langCode;					

			}				

		}						

		return $topicsData;			

	}



	 /**

	* This method will be used for fetch all the language topic details by topic id

 	* @return The topic details

	*/

	public function getLangTopicDetailsByTopicId($topicId, $langCode)

	{

		$topicsData = array();		

		$query = $this->db->query('SELECT * FROM teeme_language_help_topic WHERE topicId = '.$topicId.' AND langCode = \''.$langCode.'\'');

		if($query->num_rows() > 0)

		{			

			foreach($query->result() as $row)

			{														

				$topicsData['topicId'] 		= $row->topicId;	

				$topicsData['langCode'] 	= $row->langcode;				

				$topicsData['topicText'] 	= $row->topicText;	

			}				

		}						

		return $topicsData;			

	}



	 /**

	* This method will be used for fetch all the language sub opic details by topic id

 	* @return The topic details

	*/

	public function getLangSubTopicDetailsBySubTopicId($subTopicId, $langCode)

	{

		$topicsData = array();		

		$query = $this->db->query('SELECT * FROM teeme_language_help_sub_topic WHERE subTopicId = '.$subTopicId.' AND langCode = \''.$langCode.'\'');

		if($query->num_rows() > 0)

		{			

			foreach($query->result() as $row)

			{														

				$topicsData['subTopicId'] 		= $row->subTopicId;	

				$topicsData['langCode'] 		= $row->langcode;				

				$topicsData['subTopicText'] 	= $row->subTopicText;	

				$topicsData['contents'] 		= $row->contents;		

			}				

		}	else{

			$query = $this->db->query('SELECT * FROM teeme_help_sub_topic WHERE subTopicId = '.$subTopicId);

			if($query->num_rows() > 0)

			{			

				foreach($query->result() as $row)

				{														

					$topicsData['subTopicId'] 		= $row->subTopicId;	

					$topicsData['langCode'] 		= $langCode;				

					$topicsData['subTopicText'] 	= $row->subTopicName;	

					$topicsData['contents'] 		= $row->contents;		

				}				

			}

		}					

		return $topicsData;			

	}



	 /**

	* This method will be used for fetch the topics by tree

 	* @return The topic details

	*/

	public function getTopicsByTree($tree, $langCode ='')

	{

		$topicsData = array();	

		if($langCode == '')

		{	

			$query = $this->db->query('SELECT * FROM teeme_help_main_topic WHERE trees LIKE \'%'.$tree.'%\' order by topicName');

			if($query->num_rows() > 0)

			{	

				$i = 0;			

				foreach($query->result() as $row)

				{														

					$topicsData[$i]['topicId'] 			= $row->topicId;	

					$topicsData[$i]['topicName'] 		= $row->topicName;				

					$i++;	

				}				

			}

		}	

		else

		{

			$query = $this->db->query('SELECT b.* FROM teeme_help_main_topic a, teeme_language_help_topic b WHERE a.topicId = b.topicId AND b.langCode = \''.$langCode.'\' AND a.trees LIKE \'%'.$tree.'%\' order by b.topicText');

			if($query->num_rows() > 0)

			{	

				$i = 0;			

				foreach($query->result() as $row)

				{														

					$topicsData[$i]['topicId'] 			= $row->topicId;	

					$topicsData[$i]['topicName'] 		= $row->topicText;				

					$i++;	

				}				

			}else{

				$query = $this->db->query('SELECT * FROM teeme_help_main_topic WHERE trees LIKE \'%'.$tree.'%\' order by topicName');

				if($query->num_rows() > 0)

				{	

					$i = 0;			

					foreach($query->result() as $row)

					{														

						$topicsData[$i]['topicId'] 			= $row->topicId;	

						$topicsData[$i]['topicName'] 		= $row->topicName;				

						$i++;	

					}				

				}

			}

			

		}					

		return $topicsData;			

	}



	 /**

	* This method will be used for fetch the sub topics by topic id

 	* @return The sub topic details

	*/

	public function getSubTopicsByTopicId($topicId, $langCode = '')

	{

		$topicsData = array();	

		if($langCode == '')

		{	

			$query = $this->db->query('SELECT * FROM teeme_help_sub_topic WHERE topicId = '.$topicId.' order by subTopicName');

			if($query->num_rows() > 0)

			{	

				$i = 0;			

				foreach($query->result() as $row)

				{														

					$topicsData[$i]['subTopicId'] 			= $row->subTopicId;	

					$topicsData[$i]['subTopicName'] 		= $row->subTopicName;

					$topicsData[$i]['contents'] 			= $row->contents;				

					$i++;	

				}				

			}

		}

		else

		{

			$query = $this->db->query('SELECT b.* FROM teeme_help_sub_topic a, teeme_language_help_sub_topic b WHERE a.subTopicId = b.subTopicId AND b.langCode = \''.$langCode.'\' AND a.topicId = '.$topicId);

			if($query->num_rows() > 0)

			{	

				$i = 0;			

				foreach($query->result() as $row)

				{														

					$topicsData[$i]['subTopicId'] 			= $row->subTopicId;	

					$topicsData[$i]['subTopicName'] 		= $row->subTopicText;

					$topicsData[$i]['contents'] 			= $row->contents;				

					$i++;	

				}				

			}	else{

				$query = $this->db->query('SELECT * FROM teeme_help_sub_topic WHERE topicId = '.$topicId.' order by subTopicName');

				if($query->num_rows() > 0)

				{	

					$i = 0;			

					foreach($query->result() as $row)

					{														

						$topicsData[$i]['subTopicId'] 			= $row->subTopicId;	

						$topicsData[$i]['subTopicName'] 		= $row->subTopicName;

						$topicsData[$i]['contents'] 			= $row->contents;				

						$i++;	

					}				

				}

			}	

		}				

		return $topicsData;			

	}

 }

?>