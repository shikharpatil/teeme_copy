<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: tag_db_manager.php

	* Description 		  	: A class file used to manage the teeme tag functionalities with database

	* External Files called	: models/dal/time_manager.php

	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 25-11-2008				Nagalingam						Created the file.			

	**********************************************************************************************************/



/**

* A PHP class to manage the teeme tag functionalities with database 

* @author   Ideavate Solutions (www.ideavate.com)

*/

class Tag_db_manager extends CI_Model

{	

	/**

	* This is the constructor of tag_db_manager class that call the contstructor of the Parent Class CI_Model.

	*/

	public function __construct()

	{   

		//Parent class constructor.

		parent::__construct();

	}

	 /**

	* This method is used to insert the tag datas to database.

	* @param $object This is the object that will get inserted into the database.

	* @return inserted staus of record.

	*/



	public function insertRecord($object)

    {

		if($object!= NULL && ($object instanceof Tag))

		{

			//Get data from the object and set it to according to their Database field name.

			//Inserting teeme tag details

			 $strResultSQL = "INSERT INTO teeme_tag

							 (

							 tagType, tag, comments, ownerId, artifactId, artifactType, createdDate, startTime, endtime, sequenceTagId, sequenceOrder )

							VALUES

							(

							'".$object->getTagType()."','".$object->getTag()."','".addslashes($object->getTagComments())."','".$object->getTagOwnerId()."','".$object->getTagArtifactId()."','".$object->getTagArtifactType()."','".$object->getTagCreatedDate()."','".$object->getTagStartTime()."','".$object->getTagEndTime()."','".$object->getSequenceTagId()."','".$object->getSequenceOrder()."')";



		}

		

		//Inserting request tag comments 

		if($object!= NULL && ($object instanceof RequestTag))

		{

			$strResultSQL = "INSERT INTO teeme_request_tag(tagId, comments, commentType, createdDate

						)

						VALUES

						(

						'".$object->getTagId()."','".addslashes($object->getTagComments())."',".$object->getTagCommentType().",'".$object->getTagCommentedDate()."'

						)";



		}

		//Inserting tagged users

		if($object!= NULL && ($object instanceof Tagged_users))

		{

			$strResultSQL = "INSERT INTO teeme_tagged_users(tagId, userId

						)

						VALUES

						(

						'".$object->getTagId()."','".$object->getTaggedUserId()."'

						)";

			

		}

		//Query to insert the voting tag question

		if($object!= NULL && ($object instanceof Vote_tag))

		{

			$strResultSQL = "INSERT INTO teeme_vote_tag(tagId, votingTopic

						)

						VALUES

						(

						'".$object->getTagId()."','".$object->getVotingTopic()."'

						)";

			

		}

		//Query to insert the selection tag options

		if($object!= NULL && ($object instanceof Selection_tag))

		{

			$strResultSQL = "INSERT INTO teeme_selection_tag(tagId, selectionOptions

						)

						VALUES

						(

						'".$object->getTagId()."','".$object->getSelectionOption()."'

						)";

			

		}

		//Query to insert the simple tag response

		if($object!= NULL && ($object instanceof Simple_tag))

		{

			$strResultSQL = "INSERT INTO teeme_simple_tag(tagId, userId, comments, status, selectedOption, createdDate

						)

						VALUES

						(

						'".$object->getTagId()."','".$object->getTagUserId()."','".addslashes($object->getTagComments())."', '".$object->getTagStatus()."', '".$object->getSelectedOption()."', '".$object->getTagResponseDate()."'

						)";

			

		}



		//Query to insert the sequence tag

		if($object!= NULL && ($object instanceof Sequence_tag))

		{

			$strResultSQL = "INSERT INTO teeme_sequence_tag(createdDate, userId

						)

						VALUES

						(

						'".$object->getSequenceTagCreatedDate()."','".$object->getUserId()."'

						)";			

		}

		

		

		$bResult = $this->db->query($strResultSQL);

		

		

		if( $bResult )

		{

			return true;

		}		

		else

		{

			return false;

		}

	}	

	

	public function deleteTaggedUsersByTagId ($tagId)

	{

		$delSQL = "DELETE FROM teeme_tagged_users WHERE tagId='".$tagId."'";

		$this->db->query( $delSQL );

		return true;

	}

	public function deleteSelectionOptionsByTagId ($tagId)

	{

		$delSQL = "DELETE FROM teeme_selection_tag WHERE tagId='".$tagId."'";

		$this->db->query( $delSQL );

		return true;

	}

	

	public function updateRecord($object)

	{



		if($object!= NULL && ($object instanceof Tag))

		{

			$strResultSQL= "UPDATE teeme_tag 

							SET comments = '".addslashes($object->getTagComments())."',

							artifactId = '".$object->getTagArtifactId()."', 

							artifactType = '".$object->getTagArtifactType()."',

							endTime = '".$object->getTagEndTime()."', 

							sequenceTagId = '".$object->getSequenceTagId()."',

							sequenceOrder = '".$object->getSequenceOrder()."' 

							WHERE tagId = '".$object->getTagId()."'";

		}

		//Inserting request tag comments 

		if($object!= NULL && ($object instanceof RequestTag))

		{

			$strResultSQL = "UPDATE teeme_request_tag SET tagId = '".$object->getTagId()."',

							 comments = '".addslashes($object->getTagComments())."',

							 commentType = '".$object->getTagCommentType()."',

							 createdDate = '".$object->getTagCreatedDate()."'

							 WHERE tagId = '".$object->getTagId()."'";

			

		}

		//Inserting tagged users

		if($object!= NULL && ($object instanceof Tagged_users))

		{

			

			$strResultSQL = "INSERT INTO teeme_tagged_users(tagId, userId

						)

						VALUES

						(

						'".$object->getTagId()."','".$object->getTaggedUserId()."'

						)";

		}

		//Query to insert the voting tag question

		if($object!= NULL && ($object instanceof Vote_tag))

		{

			$strResultSQL = "UPDATE teeme_vote_tag SET tagId = '".$object->getTagId()."',

							 votingTopic = '".$object->getVotingTopic()."'

							 WHERE tagId = '".$object->getTagId()."'";		

		}

		//Query to insert the selection tag options

		if($object!= NULL && ($object instanceof Selection_tag))

		{

			$strResultSQL = "INSERT INTO teeme_selection_tag(tagId, selectionOptions

						)

						VALUES

						(

						'".$object->getTagId()."','".$object->getSelectionOption()."'

						)";

						

		}

		//Query to insert the simple tag response

		if($object!= NULL && ($object instanceof Simple_tag))

		{

			$strResultSQL = "INSERT INTO teeme_simple_tag(tagId, userId, comments, status, selectedOption, createdDate

						)

						VALUES

						(

						'".$object->getTagId()."','".$object->getTagUserId()."','".addslashes($object->getTagComments())."', '".$object->getTagStatus()."', '".$object->getSelectedOption()."', '".$object->getTagResponseDate()."'

						)";

			

		}



		//Query to insert the sequence tag

		if($object!= NULL && ($object instanceof Sequence_tag))

		{

			$strResultSQL = "UPDATE teeme_sequence_tag SET createdDate = '".$object->getSequenceTagCreatedDate()."',

							 userId = '".$object->getUserId()."'

							 WHERE userId = '".$object->getUserId()."'";	

		}

		

		$bResult = $this->db->query( $strResultSQL );

		if( $bResult )

		{

			return true;

		}		

		else

		{

			return false;

		}

			

	}

	

	

	public function deleteTag($tagId,$artifactId=0,$artifactType=0,$tagType=0)
	{
		if ($tagType==0)
			$strResultSQL = $this->db->query("DELETE FROM teeme_tag WHERE tag='".$tagId."' AND artifactId='".$artifactId."' AND artifactType='".$artifactType."'");
		else
			$strResultSQL = $this->db->query("DELETE FROM teeme_tag WHERE tag='".$tagId."' AND tagType='".$tagType."' AND artifactId='".$artifactId."' AND artifactType='".$artifactType."'");
		

		if ($strResultSQL)

		{

			return true;

		}

	}

	

	public function deleteResponseTag($tagId)

	{

		$strResultSQL = $this->db->query("DELETE FROM teeme_tag WHERE tagId=".$tagId);

		

		if ($strResultSQL)

		{

			return true;

		}

	}



	 /**

	* This method will be used for fetch the tags from the database.

 	* @param $userId This is the variable used to hold the user ID .

	* @return The tags contents as an array

	*/

	public function getTagsByUserId1( $userId, $tag = '0', $date = 0, $categoryId = 0 )

	{

			$arrTagDetails = array();

			

			// Get information of particular document

			$this->load->model('dal/time_manager');

			$curTime	= time_manager::getGMTTime();

			$where = '';	

			if($tag == 'today')

			{

					

				$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d'),date('Y')));

				$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d'),date('Y')));

				$where.=' AND a.startTime >= \''.$tagStartTime.'\' AND a.startTime <= \''.$curTime.'\'';

			}

			else if($tag == 'tomorrow')

			{

				$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')+1,date('Y')));

				$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+1,date('Y')));

				$where.=' AND a.startTime >= \''.$tagStartTime.'\' AND a.startTime <= \''.$tagEndTime.'\'';

			}	

			else if($tag == 'this_week')

			{

				$wDay			= 6-date('w');

				$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d'),date('Y')));

				$tagEndTime		= date('Y-m-d H:i:s', mktime(23,59,0,date('m'),date('d')+$wDay,date('Y')));

				$where.=' AND a.startTime >= \''.$tagStartTime.'\' AND a.startTime <= \''.$tagEndTime.'\'';

			}	

			else if($tag == 'this_month')

			{

				$monthDays		= cal_days_in_month( CAL_GREGORIAN, 11, 2008 );

				$tagStartTime	= date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d'),date('Y')));

				$tagEndTime		= date('Y-m-d H:i:s', mktime(23, 59, 0, 12, $monthDays, date('Y')));

				$where.=' AND a.startTime >= \''.$tagStartTime.'\' AND a.startTime <= \''.$tagEndTime.'\'';

			}	

			else

			{

				if($tag != '0')

				{

					$where.=' AND a.tag = '.$tag;

				}	

				$where.=' AND a.startTime <= \''.$curTime.'\' AND a.endTime >= \''.$curTime.'\'';		

			}	

		

			if($categoryId == 5)

			{

				$i = 0;		

				$query = $this->db->query('SELECT a.*, b.name as tagType1, c.userId FROM teeme_tag a, teeme_tree b, teeme_tagged_users c 

				WHERE a.tag = b.id AND c.userId = '.$userId.$where.' AND a.tagType = 5 AND a.tag = '.$tag.' AND a.tagId NOT IN (SELECT tagId FROM teeme_simple_tag WHERE userId='.$userId.') GROUP BY a.tagID ORDER BY a.createdDate DESC');

				if($query->num_rows() > 0)

				{

					

					foreach ($query->result() as $tagData)

					{	

						$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

						$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;	

						$arrTagDetails[$i]['tagType'] 		= $tagData->tagType1;

						$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;

						$arrTagDetails[$i]['userId'] 		= $tagData->userId;

						$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

						$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

						$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

						$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

						$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

						$i++;

					}

				}

			}

			else

			{

				$i = 0;		

				$query = $this->db->query('SELECT a.*,b.tagType as tagType1, c.userId FROM teeme_tag a, teeme_tag_types b , teeme_tagged_users c WHERE a.tag = b.tagTypeId AND c.userId = '.$userId.$where.' AND a.tagId NOT IN (SELECT tagId FROM teeme_simple_tag WHERE userId='.$userId.') GROUP BY a.tagID ORDER BY a.createdDate DESC');

				if($query->num_rows() > 0)

				{

					

					foreach ($query->result() as $tagData)

					{	

						$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

						$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;	

						$arrTagDetails[$i]['tagType'] 		= $tagData->tagType1;

						$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;

						$arrTagDetails[$i]['userId'] 		= $tagData->userId;

						$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

						$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

						$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

						$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

						$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

						$i++;

					}

				}

				if($categoryId == 0)

				{	

					$query = $this->db->query('SELECT a.*, b.name as tagType1, c.userId FROM teeme_tag a, teeme_tree b, teeme_tagged_users c WHERE a.tag = b.id AND c.userId = '.$userId.$where.' AND a.tagType = 5  AND a.tagId NOT IN (SELECT tagId FROM teeme_simple_tag WHERE userId='.$userId.') GROUP BY a.tagID ORDER BY a.createdDate DESC');

					if($query->num_rows() > 0)

					{						

						foreach ($query->result() as $tagData)

						{	

							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

							$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;	

							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType1;

							$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;

							$arrTagDetails[$i]['userId'] 		= $tagData->userId;

							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

							$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

							$i++;

						}

					}

				}				

			}	

			

		

		return $arrTagDetails;

	}

	

	 /**

	* This method will be used to fetch the tag types from the database.

 	* @return The tag types as an array

	*/

	public function getTagTypes($tagCategoryId = '')

	{

		$arrTagDetails = array();		

		// Get tag types 

		if($tagCategoryId != 5)

		{

			if( $tagCategoryId == '')

			{

				$where = 'WHERE a.tag = b.tagTypeId AND a.tagId = c.tagId AND c.userId = '.$_SESSION['userId'];

				$query = $this->db->query('SELECT b.* FROM teeme_tag a, teeme_tag_types b, teeme_tagged_users c  '.$where.' GROUP BY a.tag');

			}	

			else

			{

				$where = 'WHERE categoryId='.$tagCategoryId;

				$query = $this->db->query('SELECT * FROM teeme_tag_types  '.$where);

			}

	

			$i = 0;

			if($query->num_rows() > 0)

			{

				

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagTypeId;

					$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;

					$arrTagDetails[$i]['categoryId'] 	= $tagData->categoryId;

					$i++;					

				}

			}

			if( $tagCategoryId == '')

			{

				$where = 'WHERE a.tag = b.id AND a.tagId = c.tagId AND a.tagType = 5 AND c.userId = '.$_SESSION['userId'];			

				$query = $this->db->query('SELECT a.tagType as categoryId, b.id, b.name FROM teeme_tag a, teeme_tree b, teeme_tagged_users c  '.$where.' GROUP BY a.tag');

				if($query->num_rows() > 0)

				{				

					foreach ($query->result() as $tagData)

					{	

						$arrTagDetails[$i]['tagTypeId'] 	= $tagData->id;

						$arrTagDetails[$i]['tagType'] 		= $tagData->name;	

						$arrTagDetails[$i]['categoryId'] 	= $tagData->categoryId;						

						$i++;					

					}

				}

			}		

		}	

		return $arrTagDetails;

	}



	 /**

	* This method will be used to fetch the contacts from the database.

 	* @return The contacts as an array

	*/

	public function getContactsByWorkspaceId($workSpaceId, $workSpaceType)

	{

		$arrContactDetails = array();		

		$userId = $_SESSION['userId'];

		// Get tag types 		

		if($workSpaceId == 0)

		{	

	

			/* <!--Changed by Surbhi IV add Order by -->*/
			
			$qry = 'SELECT a.*, b.sharedStatus FROM teeme_tree a, teeme_contact_info b, teeme_users u WHERE a.userId=u.userId AND a.id=b.treeId AND a.workspaces=0 AND b.workplaceId='.$_SESSION["workPlaceId"].' AND a.type=5 
			ORDER BY lower(a.name)';

			$query = $this->db->query($qry);	
			
			//$query = $this->db->query( "SELECT a.*, b.firstname, b.lastname, b.sharedStatus, b.company FROM teeme_tree a, teeme_contact_info b, teeme_users u WHERE a.userId=u.userId AND a.id = b.treeId AND a.workspaces=0 AND b.workplaceId = '".$_SESSION['workPlaceId']."' AND a.type=5".$orderBy);

            /* <!--End of Changed by Surbhi IV add Order by -->*/

		}

		else	

		{

			/* <!--Changed by Surbhi IV add Order by -->*/	
			
			//$query = $this->db->query('SELECT a.name, a.id, b.sharedStatus FROM teeme_tree a, teeme_contact_info b WHERE a.id=b.treeId AND a.type = 5 AND ((a.workspaces=\''.$workSpaceId.'\' AND workSpaceType = \''.$workSpaceType.'\') OR b.sharedStatus!=2) AND b.workplaceId='.$_SESSION["workPlaceId"].' ORDER BY lower(a.name)');	

			$query = $this->db->query('SELECT a.*, b.sharedStatus FROM teeme_tree a, teeme_contact_info b, teeme_users u WHERE a.userId=u.userId AND a.id=b.treeId AND b.workplaceId = '.$_SESSION["workPlaceId"].' AND a.type=5 ORDER BY lower(a.name)');	
			
						//$query = $this->db->query( "SELECT a.*, b.firstname, b.lastname, b.sharedStatus, b.company, u.tagName FROM teeme_tree a, teeme_users u, teeme_contact_info b WHERE a.userId=u.userId AND a.id = b.treeId AND b.workplaceId = '".$_SESSION['workPlaceId']."' AND a.type=5".$orderBy);
			
		

		    /* <!--End of Changed by Surbhi IV add Order by -->*/

		}

		if($query->num_rows() > 0)

		{
			//echo $qry; exit;
			$i = 0;
				$this->load->model('dal/identity_db_manager');
				$userGroup= $this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId']);
				
				//echo "usergroup= " .$userGroup; exit;
					if ($workSpaceType==2)
					{
						$workSpaceDetails=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					}
					else
					{
						$workSpaceDetails=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					}				

			foreach ($query->result() as $contactData)
			{	
				if ($workSpaceId==0)
				{
					if($contactData->isShared==1 || ($contactData->sharedStatus == 1 && $userGroup>0) || ($workSpaceId == $contactData->workspaces && $contactData->sharedStatus == 2 && $contactData->userId == $_SESSION['userId']))
					{
						$arrContactDetails[$i]['tagTypeId'] 	= $contactData->id;
		
						$arrContactDetails[$i]['tagType'] 		= $contactData->name;	
		
						$i++;					
					}

				}
				else
				{
					if( (($contactData->sharedStatus == 1 && $userGroup>0) && $workSpaceDetails['workSpaceName']!='Try Teeme') || ($workSpaceId == $contactData->workspaces && $workSpaceType == $contactData->workSpaceType))
					{
						$arrContactDetails[$i]['tagTypeId'] 	= $contactData->id;
		
						$arrContactDetails[$i]['tagType'] 		= $contactData->name;	
		
						$i++;					
					}
				}
			}

		}			

		return $arrContactDetails;

	}





	 /**

	* This method will be used to fetch the tag categories from the database.

 	* @return The tag categories as an array

	*/

	public function getTagCategories()

	{

		$arrTagCategoryDetails = array();		

		// Get tag types 

		$query = $this->db->query('SELECT * FROM teeme_tag_category');

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $tagData)

			{	

				$arrTagCategoryDetails[$i]['categoryId'] 		= $tagData->categoryId;

				$arrTagCategoryDetails[$i]['categoryName'] 		= $tagData->categoryName;	

				$i++;					

			}

		}		

		return $arrTagCategoryDetails;

	}



	/**

	* This method will be used to fetch the voting topic from the database.

 	* @return The voting topic as an string

	*/

	public function getVotingTopic($tagId)

	{

		$votingTopic = array();		

		// Get tag types 

		$query = $this->db->query('SELECT votingTopic FROM teeme_vote_tag WHERE tagId = '.$tagId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $tagData)

			{	

				$votingTopic 		= $tagData->votingTopic;				

			}

		}		

		return $votingTopic;

	}



	 /**

	* This method will be used to fetch the tree type from the database.

 	* @return The type of the tree

	*/

	public function getTreeTypeByTreeId($treeId)

	{

		$treeType = 0;		

		// Get tag types 

		$query = $this->db->query('SELECT type FROM teeme_tree WHERE id = '.$treeId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $treeDate)

			{	

				$treeType 		= $treeDate->type;				

			}

		}		

		return $treeType;

	}



	 /**

	* This method will be used to fetch the tree id from the database.

 	* @return The id of the tree

	*/

	public function getTreeIdByNodeId($nodeId)

	{

		$treeId= 0;		

		// Get tree id 

		$query = $this->db->query('SELECT treeIds FROM teeme_node WHERE id = '.$nodeId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $treeDate)

			{	

				$treeId 		= $treeDate->treeIds;				

			}

		}		

		return $treeId;

	}



	 /**

	* This method will be used to fetch the time tags from the database.

 	* @return The time tags of the tree

	*/

	public function getTagsByCategoryId($categoryId)

	{

		$arrTags = array();				

		$query = $this->db->query('SELECT * FROM teeme_tag_types WHERE categoryId = '.$categoryId .' AND workPlaceId='.$_SESSION["workPlaceId"].' ORDER BY tagType ASC');

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $tagData)

			{	

				$arrTags[$i]['tagTypeId'] 		= $tagData->tagTypeId;

				$arrTags[$i]['cateogryId'] 		= $tagData->categoryId;	

				$arrTags[$i]['tagType'] 		= $tagData->tagType;	

				$i++;				

			}

		}		

		return $arrTags;

	}

	

	public function getTagsByCategoryId2($categoryId)

	{

		$arrTags = array();				

		$query = $this->db->query('SELECT * FROM teeme_tag_types WHERE categoryId = '.$categoryId .' AND workPlaceId='.$_SESSION["workPlaceId"].' ORDER BY tagType ASC');

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $tagData)

			{	

				$arrTags[$i]['tag'] 		= $tagData->tagTypeId;

				$arrTags[$i]['tagType'] 		= $tagData->categoryId;	

				$arrTags[$i]['tagName'] 		= $tagData->tagType;	

				$arrTags[$i]['systemTag']   = $tagData->systemTag;

				$i++;				

			}

		}		

		return $arrTags;

	}



	/**

	* This method will be used to fetch the tree id from the database accordign to the contact id.

 	* @return The id of the tree

	*/

	public function getTreeIdByContactId( $contactId )

	{

		$treeId= 0;		

		// Get tree id 

		$query = $this->db->query('SELECT treeId FROM teeme_contact_info WHERE id = '.$contactId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $treeDate)

			{	

				$treeId 		= $treeDate->treeId;				

			}

		}		

		return $treeId;

	}



	/**

	* This method will be used to fetch the selection tag options from the database.

 	* @return The selection options as a array

	*/

	public function getSelectionOptions($tagId)

	{

	 

		$selectionOptions = array();		

		// Get tag types 

		$query = $this->db->query('SELECT selectionId, selectionOptions FROM teeme_selection_tag WHERE tagId = '.$tagId.' ORDER BY selectionId');

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $optionData)

			{	

				$selectionOptions[$optionData->selectionId] 	= $optionData->selectionOptions;				

			}

		}		

		return $selectionOptions;

	}



	 /**

	* This method will be used to fetch the selection tag options from the database.

 	* @return The selection options as a array

	*/

	public function getTaggedUsersByTagId($tagId)

	{

		$selectionOptions = array();		

		// Get tag types 

		$query = $this->db->query('SELECT userId FROM teeme_tagged_users WHERE tagId = '.$tagId);

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $optionData)

			{	

				$selectionOptions[] 	= $optionData->userId;				

			}

		}		

		return $selectionOptions;

	}

	

	

	/**

	* This method will be used to get the page link by using tag id.

 	* @return The page link

	*/

	public function getLinkByTag($tagId, $tag, $artifactId, $artifactType)

	{

		$link = array();	

		if($artifactType == 1)

		{

			$query = $this->db->query('SELECT a.tagType,b.type,b.name,b.workspaces,b.workSpaceType FROM teeme_tag a, teeme_tree b WHERE a.artifactId = b.id AND a.tagId='.$tagId);		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$tagType		= $treeData->tagType;

					$treeType 		= $treeData->type;

					$workSpaceId 	= $treeData->workspaces;

					$workSpaceType 	= $treeData->workSpaceType;

					$treeName		= $treeData->name;

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$artifactId.'&doc=exist&node='.$artifactId.'&tagId='.$tag.'&curVersion='.$curVersion.'&option=3&tagResponseId='.$tagId.'&tagType='.$tagType;

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;

				}	

				if($treeType == 2)

				{

					$link[0] = 'view_discussion/node/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagType;

					$link[1] = $this->lang->line('disucssion').': '.$treeName;

				}	

				if($treeType == 3)

				{

					$link[0] = 'view_chat/chat_view/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$tagType."/0/";

					$link[1] = $this->lang->line('chat').': '.$treeName;

				}	

				if($treeType == 4)

				{

					$link[0] = 'view_task/node/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$tagType."/0/";

					$link[1] = $this->lang->line('txt_Task').': '.$treeName;

				}

				if($treeType == 5)

				{

					$link[0] = 'contact/contactDetails/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$tagType.'/0/';

	

					$link[1] = $this->lang->line('txt_Contact').': '.$treeName;

				}	

				if($treeType == 6)

				{

					$link[0] = 'notes/Details/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$tagType."/0/";

	

					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;

				}

				return $link;

			}

		}

		if($artifactType == 2)

		{

			$query = $this->db->query('SELECT a.tagType,b.id, b.name, c.version,  b.type,b.workspaces,b.workSpaceType, c.predecessor FROM teeme_tag a, teeme_tree b, teeme_node c WHERE a.artifactId = c.id AND b.id=c.treeIds AND a.tagId='.$tagId);		

	

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$tagType	= $treeData->tagType;

					$treeType 	= $treeData->type;

					$workSpaceId = $treeData->workspaces;

					$workSpaceType = $treeData->workSpaceType;

					$treeId =$treeData->id;

					$curVersion	= $treeData->version;	

					$treeName		= $treeData->name;

					$predecessor	= $treeData->predecessor;	

					 	

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$artifactId.'&tagId='.$tag.'&curVersion='.$curVersion.'&option=3&tagResponseId='.$tagId.'&tagType='.$tagType;

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;

				}	

				if($treeType == 2)

				{

					if($predecessor == 0)

					{					

						$link[0] = 'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagId.'/'.$tagType."/0/";

						$link[1] = $this->lang->line('disucssion').': '.$treeName;

					}	

					else

					{

						$link[0] = 'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagId.'/'.$tagType;

						$link[1] = $this->lang->line('disucssion').': '.$treeName;

					}	

				}

				if($treeType == 3)

				{						

					$link[0] = 'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$tagType."/0/";//.'/'.$tagId.'/'.$artifactId;

					$link[1] = $this->lang->line('chat').': '.$treeName;				

				}

				if($treeType == 4)

				{

					if($predecessor == 0)

					{		

						$link[0] = 'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$tagType."/0/";			

						$link[1] = $this->lang->line('txt_Task').': '.$treeName;

					}	

					else

					{

						$link[0] = 'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$tagType."/0/";

						$link[1] = $this->lang->line('txt_Task').': '.$treeName;

					}	

				}	

				if($treeType == 5)

				{

					$link[0] = 'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$tagType."/0/";

					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;		

				}				

				if($treeType == 6)

				{

					$link[0] = 'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$tagType."/0/";

					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;		

				}	

					

				return $link;

			}

		}	

		if($artifactType == 3)

		{

			

			$query = $this->db->query('SELECT a.tagType, b.id, b.name, b.type, c.version, c.id as nodeId, b.workspaces,b.workSpaceType FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE a.artifactId = d.id AND b.id=c.treeIds AND d.nodeId=c.id AND a.tagId='.$tagId);		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{

					$tagType	= $treeData->tagType;

					$treeType 	= $treeData->type;

					$workSpaceId = $treeData->workspaces;

					$workSpaceType = $treeData->workSpaceType;

					$treeId =	$treeData->id; 

					$curVersion	= $treeData->version;	

					$nodeId	= $treeData->nodeId;

					$treeName		= $treeData->name;

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'&tagId='.$tagId.'&curVersion='.$curVersion.'&tagType='.$tagType;

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;	

				}	

				return $link;

			}

		}				

	}	

	

	

	/**

	* This method will be used to get the page link by using tag id.

 	* @return The page link

	*/

	public function getLinkByFinishedChatTags($tagId, $tag, $artifactId, $artifactType)

	{

		$link = array();	

	

		if($artifactType == 1)

		{

			$query = $this->db->query('SELECT a.tagType,b.type,b.name,b.workspaces,b.workSpaceType FROM teeme_tag a, teeme_tree b WHERE a.artifactId = b.id AND a.tagId='.$tagId);		

	

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$tagType		= $treeData->tagType;

					$treeType 		= $treeData->type;

					$workSpaceId 	= $treeData->workspaces;

					$workSpaceType 	= $treeData->workSpaceType;

					$treeName		= $treeData->name;

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$artifactId.'&doc=exist'.'&tagId='.$tagId.'&tagType='.$tagType;

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;

				}	

				if($treeType == 2)

				{

					$link[0] = 'view_discussion/node/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('disucssion').': '.$treeName;

				}	

				if($treeType == 3)

				{

					$link[0] = 'view_chat/node1/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/2/'.$tag.'/'.$artifactId;

					$link[1] = $this->lang->line('chat').': '.$treeName;

				}	

				if($treeType == 4)

				{

					$link[0] = 'view_activity/node/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('activity').': '.$treeName;

				}	

				if($treeType == 5)

				{

					$link[0] = 'contact/contactDetails/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('txt_Contact').': '.$treeName;

				}	

				if($treeType == 6)

				{

					$link[0] = 'notes/Details/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;

				}	

				return $link;

			}

		}

		if($artifactType == 2)

		{

			$query = $this->db->query('SELECT a.tagType, b.id, b.name, c.version,  b.type,b.workspaces,b.workSpaceType, c.predecessor FROM teeme_tag a, teeme_tree b, teeme_node c WHERE a.artifactId = c.id AND b.id=c.treeIds AND a.tagId='.$tagId);		

			

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$tagType	= $treeData->tagType;

					$treeType 	= $treeData->type;

					$workSpaceId = $treeData->workspaces;

					$workSpaceType = $treeData->workSpaceType;

					$treeId =$treeData->id;

					$curVersion	= $treeData->version;	

					$treeName		= $treeData->name;

					$predecessor	= $treeData->predecessor;	

					 	

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$artifactId.'&tagId='.$tagId.'&curVersion='.$curVersion.'&tagType='.$tagType;

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;	

				}	

				if($treeType == 2)

				{

					if($predecessor == 0)

					{					

						$link[0] = 'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagId.'/'.$tagType;

						$link[1] = $this->lang->line('disucssion').': '.$treeName;

					}	

					else

					{

						$link[0] = 'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagId.'/'.$tagType;

						$link[1] = $this->lang->line('disucssion').': '.$treeName;

					}	

				}

				if($treeType == 3)

				{						

					$link[0] = 'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagId.'/'.$tagType;

					$link[1] = $this->lang->line('chat').': '.$treeName;				

				}

				if($treeType == 4)

				{

					if($predecessor == 0)

					{					

						$link[0] = 'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagId.'/'.$tagType;

						$link[1] = $this->lang->line('txt_Task').': '.$treeName;

					}	

					else

					{

						$link[0] = 'view_task/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagId.'/'.$tagType;

						$link[1] = $this->lang->line('txt_Task').': '.$treeName;

					}	

				}	

				if($treeType == 5)

				{

					$link[0] = 'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagId.'/'.$tagType;

					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;		

				}				

				if($treeType == 6)

				{

					$link[0] = 'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tag.'/'.$artifactId.'/'.$tagId.'/'.$tagType;

					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;		

				}	

					

				return $link;

			}

		}	

		if($artifactType == 3)

		{

			

			$query = $this->db->query('SELECT a.tagType, b.id, b.name, b.type, c.version, c.id as nodeId, b.workspaces,b.workSpaceType FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE a.artifactId = d.id AND b.id=c.treeIds AND d.nodeId=c.id AND a.tagId='.$tagId);		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{

					$tagType	= $treeData->tagType;

					$treeType 	= $treeData->type;

					$workSpaceId = $treeData->workspaces;

					$workSpaceType = $treeData->workSpaceType;

					$treeId =	$treeData->id; 

					$curVersion	= $treeData->version;	

					$nodeId	= $treeData->nodeId;

					$treeName		= $treeData->name;

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'&tagId='.$tagId.'&curVersion='.$curVersion.'&tagType='.$tagType;

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;	

				}	

				return $link;

			}

		}				

	}	

	

	

	

	

	/**

	* This method will be used to get the page link by using tag id.

 	* @return The page link

	*/

	public function getLinkByTagId($tagId, $artifactId, $artifactType)

	{

		$link = array();	

		if($artifactType == 1)

		{

			$query = $this->db->query('SELECT b.type,b.name,b.workspaces,b.workSpaceType FROM teeme_tag a, teeme_tree b WHERE a.artifactId = b.id AND a.tagId='.$tagId);		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$treeType 		= $treeData->type;

					$workSpaceId 	= $treeData->workspaces;

					$workSpaceType 	= $treeData->workSpaceType;

					$treeName		= $treeData->name;

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$artifactId.'&doc=exist'.'&tagId='.$tagId;

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;

				}	

				if($treeType == 2)

				{

					$link[0] = 'view_discussion/node/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('disucssion').': '.$treeName;

				}	

				if($treeType == 3)

				{

					$link[0] = 'view_chat/chat_view/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tagId.'/'.$artifactId;

					$link[1] = $this->lang->line('chat').': '.$treeName;

				}	

				if($treeType == 4)

				{

					$link[0] = 'view_activity/node/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('activity').': '.$treeName;

				}	

				if($treeType == 5)

				{

					$link[0] = 'contact/contactDetails/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('txt_Contact').': '.$treeName;

				}	

				if($treeType == 6)

				{

					$link[0] = 'notes/Details/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;

				}	

				return $link;

			}

		}

		if($artifactType == 2)

		{

			$query = $this->db->query('SELECT b.id, b.name, c.version,  b.type,b.workspaces,b.workSpaceType, c.predecessor FROM teeme_tag a, teeme_tree b, teeme_node c WHERE a.artifactId = c.id AND b.id=c.treeIds AND a.tagId='.$tagId);		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$treeType 	= $treeData->type;

					$workSpaceId = $treeData->workspaces;

					$workSpaceType = $treeData->workSpaceType;

					$treeId =$treeData->id;

					$curVersion	= $treeData->version;	

					$treeName		= $treeData->name;

					$predecessor	= $treeData->predecessor;	

					 	

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$artifactId.'&tagId='.$tagId.'&curVersion='.$curVersion;

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;	

				}	

				if($treeType == 2)

				{

					if($predecessor == 0)

					{					

						$link[0] = 'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagId;

						$link[1] = $this->lang->line('disucssion').': '.$treeName;

					}	

					else

					{

						$link[0] = 'view_discussion/Discussion_reply/'.$predecessor.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagId;

						$link[1] = $this->lang->line('disucssion').': '.$treeName;

					}	

				}

				if($treeType == 3)

				{						

					$link[0] = 'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tagId.'/'.$artifactId;

					$link[1] = $this->lang->line('chat').': '.$treeName;				

				}

				if($treeType == 4)

				{

					if($predecessor == 0)

					{					

						$link[0] = 'view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagId;

						$link[1] = $this->lang->line('activity').': '.$treeName;

					}	

					else

					{

						$link[0] = 'view_activity/node_activity/'.$predecessor.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagId;

						$link[1] = $this->lang->line('activity').': '.$treeName;

					}	

				}	

				if($treeType == 6)

				{

					$link[0] = 'Notes/details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagId;

					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;		

				}	

					

				return $link;

			}

		}	

		if($artifactType == 3)

		{

			

			$query = $this->db->query('SELECT b.id, b.name, b.type, c.version, c.id as nodeId, b.workspaces,b.workSpaceType FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE a.artifactId = d.id AND b.id=c.treeIds AND d.nodeId=c.id AND a.tagId='.$tagId);		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$treeType 	= $treeData->type;

					$workSpaceId = $treeData->workspaces;

					$workSpaceType = $treeData->workSpaceType;

					$treeId =	$treeData->id; 

					$curVersion	= $treeData->version;	

					$nodeId	= $treeData->nodeId;

					$treeName		= $treeData->name;

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'&tagId='.$tagId.'&curVersion='.$curVersion;

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;	

				}	

				return $link;

			}

		}				

	}



	/**

	* This method will be used to get the page link to view the artifact in tag view.

 	* @return The page link for tag view

	*/

	public function getLinkByTagIdTagView($tagId, $artifactId, $artifactType, $option = 1)

	{

		$link = array();			

		if($artifactType == 1)

		{

			$query = $this->db->query('SELECT b.type,b.name,b.workspaces,b.workSpaceType FROM teeme_tag a, teeme_tree b WHERE a.artifactId = b.id AND a.tagId='.$tagId);

	

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$treeType 		= $treeData->type;

					$workSpaceId 	= $treeData->workspaces;

					$workSpaceType 	= $treeData->workSpaceType;

					$treeName		= $treeData->name;

				}

				if($treeType == 1)

				{

	

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$artifactId.'&doc=exist'.'&tagId='.$tagId;

					

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;

				}	

				if($treeType == 2)

				{

					$link[0] = 'view_Discussion/node/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagId.'/'.$artifactId;

					$link[1] = $this->lang->line('disucssion').': '.$treeName;

				}	

				if($treeType == 3)

				{

					$link[0] = 'view_Chat/chat_view/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tagId.'/'.$artifactId;

					$link[1] = $this->lang->line('chat').': '.$treeName;

				}	

				if($treeType == 4)

				{

					$link[0] = 'view_Activity/node/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('activity').': '.$treeName;

				}	

				if($treeType == 5)

				{

					$link[0] = 'contact/contactDetails/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType;

					$link[1] = $this->lang->line('txt_Contact').': '.$treeName;

				}	

				if($treeType == 6)

				{

					$link[0] = 'Notes/Details/'.$artifactId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$option.'/'.$tagId;

					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;

				}	

				return $link;

			}

		}

		if($artifactType == 2)

		{

			$query = $this->db->query('SELECT b.id, b.name, c.version,  b.type,b.workspaces,b.workSpaceType, c.predecessor FROM teeme_tag a, teeme_tree b, teeme_node c WHERE a.artifactId = c.id AND b.id=c.treeIds AND a.tagId='.$tagId);		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$treeType 	= $treeData->type;

					$workSpaceId = $treeData->workspaces;

					$workSpaceType = $treeData->workSpaceType;

					$treeId =$treeData->id;

					$curVersion	= $treeData->version;	

					$treeName		= $treeData->name;

					$predecessor	= $treeData->predecessor;	

					 	

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$artifactId.'&tagId='.$tagId.'&curVersion='.$curVersion;

					

					$link[1] = $this->lang->line('txt_Document').': '.strip_tags($treeName);	

				}	

				if($treeType == 2)

				{

					if($predecessor == 0)

					{					

						$link[0] = 'view_Discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagId.'/'.$artifactId;

						$link[1] = $this->lang->line('disucssion').': '.strip_tags($treeName);	

					}	

					else

					{

						$link[0] = 'view_Discussion/Discussion_reply/'.$predecessor.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$tagId.'/'.$artifactId;

						$link[1] = $this->lang->line('disucssion').' : '.strip_tags($treeName);	

					}	

				}

				if($treeType == 3)

				{						

					$link[0] = 'view_Chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tagId.'/'.$artifactId;

					$link[1] = $this->lang->line('chat').': '.strip_tags($treeName);					

				}

				if($treeType == 4)

				{

					if($predecessor == 0)

					{					

						$link[0] = 'view_Activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tagId.'/'.$artifactId;

						$link[1] = $this->lang->line('activity').': '.strip_tags($treeName);	

					}	

					else

					{

						$link[0] = 'view_Activity/node_activity/'.$predecessor.'/'.$workSpaceId.'/type/'.$workSpaceType.'/3/'.$tagId.'/'.$artifactId;

						$link[1] = $this->lang->line('activity').': '.strip_tags($treeName);	

					}	

				}	

				if($treeType == 5)

				{

					$link[0] = 'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$option.'/'.$tagId.'/'.$artifactId;

					$link[1] = $this->lang->line('txt_Contact').': '.strip_tags($treeName);			

				}	

				if($treeType == 6)

				{

					$link[0] = 'Notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/'.$option.'/'.$tagId.'/'.$artifactId;

					$link[1] = $this->lang->line('txt_Notes').': '.strip_tags($treeName);			

				}	

					

				return $link;

			}

		}	

		if($artifactType == 3)

		{			

			$query = $this->db->query('SELECT b.id, b.name, b.type, c.version, c.id as nodeId, b.workspaces,b.workSpaceType FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE a.artifactId = d.id AND b.id=c.treeIds AND d.id=c.leafId AND a.tagId='.$tagId);		

			if($query->num_rows() > 0)

			{

				$i = 0;

				foreach ($query->result() as $treeData)

				{	

					$treeType 	= $treeData->type;

					$workSpaceId = $treeData->workspaces;

					$workSpaceType = $treeData->workSpaceType;

					$treeId =	$treeData->id; 

					$curVersion	= $treeData->version;	

					$nodeId	= $treeData->nodeId;

					$treeName		= $treeData->name;

				}

				if($treeType == 1)

				{

					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$nodeId.'&tagId='.$tagId.'&curVersion='.$curVersion.'&option=3';

					$link[1] = $this->lang->line('txt_Document').': '.$treeName;	

				}	

				return $link;

			}

		}				

	}



	 /**

	* This method will be used to fetch the tag details from the database.

 	* @return The tag details as an array

	*/

	public function getTagDetailsByTagId( $tagId )

	{

		$arrTagDetails = array();		

		// Get tag types 

		

		$query1 = $this->db->query('SELECT tagType FROM teeme_tag WHERE tagId = '.$tagId);

		if($query1->num_rows() > 0)

		{

			foreach ($query1->result() as $tagData)

			{

				$tagType 		= $tagData->tagType;	

			}

		}

		

		if($tagType == 5)

		{

			$query = $this->db->query('SELECT a.*, b.name as contactName, c.userId FROM teeme_tag a, teeme_tree b, teeme_tagged_users c WHERE a.tag = b.id AND a.tagId = c.tagId AND a.tagId = '.$tagId);

		}

		else if($tagType == 3) //parv - 2 - els if

		{

			$query = $this->db->query('SELECT a.*,a.tag as teemeTagType,c.userId FROM teeme_tag a, teeme_tagged_users c WHERE  a.tagId = c.tagId AND a.tagId = '.$tagId);

		}

		else

		{			

			$query = $this->db->query('SELECT a.*,b.tagType as teemeTagType,c.userId FROM teeme_tag a, teeme_tag_types b, teeme_tagged_users c WHERE a.tag = b.tagTypeId AND a.tagId = c.tagId AND a.tagId = '.$tagId);

		}	

		

		if($query->num_rows() > 0)

		{

			$i = 0;

			foreach ($query->result() as $tagData)

			{

				$arrTagDetails['tagId'] 		= $tagData->tagId;		

				$arrTagDetails['tag'] 			= $tagData->tag;	

				$arrTagDetails['ownerId'] 		= $tagData->ownerId;

				$arrTagDetails['userId'] 		= $tagData->userId;

				$arrTagDetails['tagComments']	= $tagData->comments;

				$arrTagDetails['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails['artifactType'] 	= $tagData->artifactType;	

				$arrTagDetails['createdDate'] 	= $tagData->createdDate;	

				$arrTagDetails['startTime'] 	= $tagData->startTime;	

				$arrTagDetails['endTime'] 		= $tagData->endTime;	

				if( $tagType == 5 )

				{	

					$arrTagDetails['tagType'] 		= $tagData->contactName;	

				}

				else

				{

					if ($arrTagDetails['tag'] == 4 )

						$type = 'Authorize';

					if ($arrTagDetails['tag'] == 3 )

						$type = 'Vote';

					if ($arrTagDetails['tag'] == 2 )

						$type = 'Select';

					if ($arrTagDetails['tag'] == 1 )

						$type = 'Ask';

						

					$arrTagDetails['tagType'] 		= $type;	

				}				

				$arrTagDetails['tagCategory']	= $tagData->tagType;	

								

			}

		}		

		return $arrTagDetails;

	}



	/**

	* This method will be used to fetch the act tag details from the database.

 	* @return The tag details as an array

	*/

	public function getTagDetailsByTagId1( $tagId )

	{		

		$arrTagDetails = array();		

		// Get tag types 

		$query1 = $this->db->query('SELECT * FROM teeme_tag WHERE tagId = '.$tagId);

		

		if($query1->num_rows() > 0)

		{

			foreach ($query1->result() as $tagData)

			{

				$arrTagDetails['tagId'] 		= $tagData->tagId;

				$arrTagDetails['tagType'] 		= $tagData->tagType;

				$arrTagDetails['tag'] 			= $tagData->tag;					

				$arrTagDetails['comments'] 		= $tagData->comments;

				$arrTagDetails['ownerId'] 		= $tagData->ownerId;				

				$arrTagDetails['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails['artifactType']	= $tagData->artifactType;

				$arrTagDetails['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails['startTime'] 	= $tagData->startTime;

				$arrTagDetails['endTime'] 		= $tagData->endTime;	

			}

		}	

		return $arrTagDetails;

	}

	

	

	function getTagsByArtifactId($artifactId, $artifactType, $time = 0)	

	{		

		$arrTagDetails = array();

		$userId = $_SESSION['userId'];			

		$this->load->model('dal/time_manager');

		if($time == 0)

		{

			$curTime	= time_manager::getGMTTime();

		}

		else

		{

			$curTime	= $time;

		}

		$where = '';				

		$where.=' AND a.startTime <= \''.$curTime.'\' AND a.endTime >= \''.$curTime.'\' AND a.artifactId = '.$artifactId.' AND artifactType = '.$artifactType;		

		$i = 0;	

	

		$query = $this->db->query('SELECT a.*,b.tagType as tagType1, c.userId FROM teeme_tag a, teeme_tag_types b , teeme_tagged_users c WHERE a.tag = b.tagTypeId AND c.userId = '.$userId.$where.' AND a.tagId NOT IN (SELECT tagId FROM teeme_simple_tag WHERE userId='.$userId.') GROUP BY a.tagID ORDER BY a.createdDate DESC');

		if($query->num_rows() > 0)

		{

			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;	

				$arrTagDetails[$i]['tagType'] 		= $tagData->tagType1;

				$arrTagDetails[$i]['comments'] 		= $tagData->comments;

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;

				$arrTagDetails[$i]['userId'] 		= $tagData->userId;

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$i++;

			}

		}		

		$query = $this->db->query('SELECT a.*, b.name as tagType1, c.userId FROM teeme_tag a, teeme_tree b, teeme_tagged_users c WHERE a.tag = b.id AND c.userId = '.$userId.$where.' AND a.tagType = 5  AND a.tagId NOT IN (SELECT tagId FROM teeme_simple_tag WHERE userId='.$userId.') GROUP BY a.tagID ORDER BY a.createdDate DESC');

		if($query->num_rows() > 0)

		{						

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;	

				$arrTagDetails[$i]['tagType'] 		= $tagData->tagType1;

				$arrTagDetails[$i]['comments'] 		= $tagData->comments;

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;

				$arrTagDetails[$i]['userId'] 		= $tagData->userId;

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$i++;

			}

		}

		return $arrTagDetails;											

	}

	//This method is used to fetch the sequence tags by artifact id

	function getSequenceTagsByArtifactId($artifactId, $artifactType)	

	{

		$arrTagDetails = array();

		$userId = $_SESSION['userId'];

		$sequenceTags = array();

		$seqQuery = $this->db->query('SELECT sequenceId, createdDate FROM teeme_sequence_tag WHERE userId='.$userId.' ORDER BY createdDate');	

		if($seqQuery->num_rows() > 0)

		{

			foreach ($seqQuery->result() as $seqData)

			{	

				$this->load->model('dal/time_manager');

				$curTime	= time_manager::getGMTTime();

				$sequenceId = $seqData->sequenceId;	

				$where = '';				

				$where.=' AND a.startTime <= \''.$curTime.'\' AND a.endTime >= \''.$curTime.'\' AND a.artifactId = '.$artifactId.' AND artifactType = '.$artifactType.' AND sequenceTagId = '.$sequenceId;		

				$i = 0;	

	

				$query = $this->db->query('SELECT a.*,b.tagType as tagType1, c.userId FROM teeme_tag a, teeme_tag_types b , teeme_tagged_users c WHERE a.tag = b.tagTypeId AND c.userId = '.$userId.$where.' AND a.tagId NOT IN (SELECT tagId FROM teeme_simple_tag WHERE userId='.$userId.') GROUP BY a.tagID ORDER BY a.sequenceOrder ASC');

				if($query->num_rows() > 0)

				{

					

					foreach ($query->result() as $tagData)

					{	

						$arrTagDetails[$sequenceId][$i]['tagId'] 		= $tagData->tagId;

						$arrTagDetails[$sequenceId][$i]['tagTypeId'] 	= $tagData->tagType;	

						$arrTagDetails[$sequenceId][$i]['tagType'] 		= $tagData->tagType1;

						$arrTagDetails[$sequenceId][$i]['ownerId'] 		= $tagData->ownerId;

						$arrTagDetails[$sequenceId][$i]['userId'] 		= $tagData->userId;

						$arrTagDetails[$sequenceId][$i]['artifactId'] 	= $tagData->artifactId;

						$arrTagDetails[$sequenceId][$i]['artifactType']	= $tagData->artifactType;

						$arrTagDetails[$sequenceId][$i]['createdDate'] 	= $tagData->createdDate;

						$arrTagDetails[$sequenceId][$i]['startTime'] 	= $tagData->startTime;

						$arrTagDetails[$sequenceId][$i]['endTime'] 		= $tagData->endTime;

						$i++;

					}

				}		

				$query = $this->db->query('SELECT a.*, b.name as tagType1, c.userId FROM teeme_tag a, teeme_tree b, teeme_tagged_users c WHERE a.tag = b.id AND c.userId = '.$userId.$where.' AND a.tagType = 5  AND a.tagId NOT IN (SELECT tagId FROM teeme_simple_tag WHERE userId='.$userId.') GROUP BY a.tagID ORDER BY a.createdDate ASC');

				if($query->num_rows() > 0)

				{						

					foreach ($query->result() as $tagData)

					{	

						$arrTagDetails[$sequenceId][$i]['tagId'] 		= $tagData->tagId;

						$arrTagDetails[$sequenceId][$i]['tagTypeId'] 	= $tagData->tagType;	

						$arrTagDetails[$sequenceId][$i]['tagType'] 		= $tagData->tagType1;

						$arrTagDetails[$sequenceId][$i]['ownerId'] 		= $tagData->ownerId;

						$arrTagDetails[$sequenceId][$i]['userId'] 		= $tagData->userId;

						$arrTagDetails[$sequenceId][$i]['artifactId'] 	= $tagData->artifactId;

						$arrTagDetails[$sequenceId][$i]['artifactType']	= $tagData->artifactType;

						$arrTagDetails[$sequenceId][$i]['createdDate'] 	= $tagData->createdDate;

						$arrTagDetails[$sequenceId][$i]['startTime'] 	= $tagData->startTime;

						$arrTagDetails[$sequenceId][$i]['endTime'] 		= $tagData->endTime;

						$i++;

					}

				}

			}

		}

		return $arrTagDetails;											

	}

	

	function getSequenceTagsBySequenceId( $sequenceId )	

	{		

		$arrTagDetails = array();		

		$i = 0;	

		$query = $this->db->query('SELECT a.* FROM teeme_tag a WHERE  a.sequenceTagId = '.$sequenceId.' ORDER BY a.sequenceOrder ASC');

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagCategory'] 	= $tagData->tagType;	

				$arrTagDetails[$i]['tagType']	 	= $tagData->tag;				

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;		

				$arrTagDetails[$i]['comments'] 		= $tagData->comments;				

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}			

		return $arrTagDetails;											

	}

	// this method used to fetch the tags according to the contact ID.



	function getTagsByContactId( $contactId )	

	{		

		$arrTagDetails = array();

		$userId = $_SESSION['userId'];			

		$this->load->model('dal/time_manager');

		$curTime	= time_manager::getGMTTime();

		$where = '';				

	

		$i = 0;	

		$query = $this->db->query('SELECT a.* FROM teeme_tag a WHERE a.tag = '.$contactId.$where.' GROUP BY a.tagID ORDER BY a.createdDate DESC');

		if($query->num_rows() > 0)

		{

			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;					

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;							

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$i++;

			}

		}		

		

		return $arrTagDetails;											

	}



	function getUserTagsByArtifactId($artifactId, $artifactType)	

	{		

		$arrTagDetails = array();

		$userId 	= $_SESSION['userId'];			

		$query 		= $this->db->query('SELECT tagId FROM teeme_tag WHERE ownerId = '.$userId.' AND artifactId = '.$artifactId.' AND artifactType = '.$artifactType.' AND sequenceTagId = 0 ORDER BY createdDate ASC');

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[] 		= $tagData->tagId;				

			}

		}		

		return $arrTagDetails;											

	}

	

	function checkUserTagStatus($artifactId, $artifactType)	

	{		

		$status = false;

		$userId = $_SESSION['userId'];			

		$query = $this->db->query('SELECT tagId FROM teeme_tag WHERE ownerId = '.$userId.' AND artifactId = '.$artifactId.' AND artifactType = '.$artifactType);

		if($query->num_rows() > 0)

		{			

			$status = true;

		}		

		return $status;											

	}

	



	function getTotalUsersByTagId($tagId)	

	{		

		$totalUsers = 0;

		$query = $this->db->query('SELECT count(tagId) as totalUsers FROM teeme_tagged_users WHERE tagId = '.$tagId);

		$tmpData = $query->row();

		$totalUsers = $tmpData->totalUsers;

		return $totalUsers;											

	}

	function getTotalUsersYesByTagId($tagId)	

	{		

		$totalUsers = 0;

		$query = $this->db->query('SELECT count(tagId) as totalUsers FROM teeme_simple_tag WHERE status = 1 AND tagId = '.$tagId);

		$tmpData = $query->row();

		$totalUsers = $tmpData->totalUsers;

		return $totalUsers;											

	}

	function getTotalUsersNoByTagId($tagId)	

	{		

		$totalUsers = 0;

		$query = $this->db->query('SELECT count(tagId) as totalUsers FROM teeme_simple_tag WHERE status = 0 AND tagId = '.$tagId);

		$tmpData = $query->row();

		$totalUsers = $tmpData->totalUsers;

		return $totalUsers;											

	}

	function checkTagResponse($tagId, $userId)	

	{		

	

		$status = false;

		if (!empty($tagId))

		{

			$query1 = $this->db->query('SELECT tagId,userId FROM teeme_tagged_users WHERE userId = '.$userId.' AND tagId = '.$tagId);

	

		

			if ($query1->num_rows()> 0)

			{

				$query2 = $this->db->query('SELECT tagId FROM teeme_simple_tag WHERE userId = '.$userId.' AND tagId = '.$tagId);

				if($query2->num_rows() > 0)

				{	

					$status = true;

				}

			}

			else

			{

				$status = true;

			}

		}

		return $status;											

	}

	

	function getTotalUsersBySelectionId($tagId, $selectionId)	

	{		

		$totalUsers = 0;

		$query = $this->db->query('SELECT count(tagId) as totalUsers FROM teeme_simple_tag WHERE selectedOption = '.$selectionId.' AND tagId = '.$tagId);

		$tmpData = $query->row();

		$totalUsers = $tmpData->totalUsers;

		return $totalUsers;											

	}

	function getSimpleTagResponse( $tagId )	

	{		

		$arrResponse = array();

	

		$query = $this->db->query('SELECT a.*,b.userName, b.tagName, b.nickName FROM teeme_simple_tag a, teeme_users b WHERE a.userId = b.userId AND a.tagId = '.$tagId.' ORDER BY createdDate');

		if($query->num_rows() > 0)

		{	

			$i = 0;	

			foreach ($query->result() as $resData)

			{		

				$arrResponse[$i]['userId']	 	= $resData->userId;

				$arrResponse[$i]['userName'] 	= $resData->userName;

				$arrResponse[$i]['status'] 		= $resData->status;

				$arrResponse[$i]['comments'] 	= $resData->comments;
				
				if($resData->nickName!='')
				{
					$arrResponse[$i]['userTagName'] = $resData->nickName;
				}
				else
				{
					$arrResponse[$i]['userTagName']	= $resData->tagName;	
				}			

				$i++;	

			}

		}		

		return $arrResponse;											

	}

	

	function getOptionTagResponse( $tagId )	

	{		

		$arrResponse = array();

	

		$query = $this->db->query('SELECT a.*,b.userName,c.selectionOptions FROM teeme_simple_tag a, teeme_users b, teeme_selection_tag c WHERE a.userId = b.userId AND a.selectedOption = c.selectionId AND a.tagId = '.$tagId.' ORDER BY createdDate');

		if($query->num_rows() > 0)

		{	

			$i = 0;	

			foreach ($query->result() as $resData)

			{		

				$arrResponse[$i]['userId']	 	= $resData->userId;

				$arrResponse[$i]['userName'] 	= $resData->userName;

				$arrResponse[$i]['status'] 		= $resData->status;

				$arrResponse[$i]['selectedOption'] 	= $resData->selectionOptions;	

				$i++;	

			}

		}		

		return $arrResponse;											

	}



	 /**

	* This method will be used to get the tag Name by using tagCategory and tag type id.

 	* @return The name of the tag

	*/

	public function getTagName( $tagCategory, $tagType )

	{

		$tagName= '';		

		// Get tree id 

		if($tagCategory != 5)

		{

			$query = $this->db->query('SELECT tagType FROM teeme_tag_types WHERE tagTypeId = '.$tagType);

		}

		else if($tagCategory == 5)

		{

			$query = $this->db->query('SELECT name as tagType FROM teeme_tree WHERE id = '.$tagType);

		}

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $tagData)

			{	

				$tagName = $tagData->tagType;				

			}

		}		

		return $tagName;

	}



	

	 /**

	* This method used to update the tag sequence order. 	

	*/

	public function updateSequenceOrder( $tagId, $tagOrder )

	{

		$query = $this->db->query('UPDATE teeme_tag SET sequenceOrder = '.$tagOrder.' WHERE tagId = '.$tagId);

		if($query)

		{

			return true;

		}

		else

		{

			return false;

		}			

	}



	 /**

	* This method used to delete the tag for particular user. 	

	*/

	public function deleteTagByUserId($userId, $tagId)

	{

		$query = $this->db->query('UPDATE teeme_tagged_users SET status = 0 WHERE tagId = '.$tagId.' AND userId = '.$userId);

		if($query)

		{

			return true;

		}

		else

		{

			return false;

		}			

	}

	 /**

	* This method used to insert the tag type. 	

	*/

	public function insertTagType( $tagCategory, $tagType,$workPlaceId=0 )

	{

		$qry = $this->db->query("SELECT tagType FROM teeme_tag_types WHERE tagType = '".$this->db->escape_str(addslashes($tagType))."'");

			if ($qry->num_rows() > 0)

			{

				return false;

			}

			else

			{

				$query = $this->db->query('INSERT INTO teeme_tag_types(categoryId, tagType, workPlaceId) VALUES ('.$tagCategory.',\''.$this->db->escape_str(addslashes($tagType)).'\','.$workPlaceId.')');

				if($query)

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

	* This method used to insert the task id. 	

	*/

	public function insertTaskId( $tagId, $noteId, $date )

	{

		$query = $this->db->query('INSERT INTO teeme_tasks(tagId, noteId, createdDate) VALUES ('.$tagId.','.$noteId.',\''.$date.'\')');

		if($query)

		{

			return true;

		}

		else

		{

			return false;

		}			

	}



	//Get the task id of the create tag

	function getTaskId($tagId, $date)	

	{		

		$noteId = 0;

		$query = $this->db->query('SELECT noteId FROM teeme_tasks WHERE tagId = '.$tagId.' AND DATE_FORMAT(createdDate,\'%Y-%m-%d\') = \''.$date.'\' ORDER BY createdDate DESC LIMIT 0,1');

		if($query->num_rows() > 0)

		{			

			$tmpData 	= $query->row();

			$noteId = $tmpData->noteId;

		}		

		

		return $noteId;											

	}

	/**

	* This method will be used for fetch the tags from the database.

	* @param $tagCategory This is the variable used to hold the tag category.

 	* @param $userId This is the variable used to hold the user ID.

	* @param $artifactId This is the variable used to hold the artifact ID.

	* @param $artifactType This is the variable used to hold the artifact type.

	* @return The tags contents as an array

	*/

	

	public function getTagsbyTagId($tagId)

	{

		$i = 0;		



		$query = $this->db->query('SELECT a.* FROM teeme_tag a, teeme_tagged_users b WHERE a.tagId = b.tagId AND a.tagId = '.$tagId.' ORDER BY createdDate DESC');



		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

				$arrTagDetails[$i]['tag'] 			= $tagData->tag;

				$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

				$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}

		return $arrTagDetails;

	}

	public function getTags($tagCategory, $userId, $artifactId, $artifactType, $workspaceId = 0)

	{

		$arrTagDetails = array();			

		// Get information of particular document

		if($tagCategory == 3  ||  $tagCategory == 4)

		{	

			$i = 0;		



			$query = $this->db->query('SELECT a.* FROM teeme_tag a, teeme_tagged_users b WHERE a.tagId = b.tagId AND a.tagType = '.$tagCategory.' AND b.status = 1 AND a.artifactId = '.$artifactId.' AND a.artifactType = '.$artifactType.' GROUP BY a.tagId ORDER BY a.comments ASC');

			

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}

		else if($tagCategory == 5)

		{	

			$i = 0;		



			$query = $this->db->query('SELECT a.*, b.name as contactName FROM teeme_tag a, teeme_tree b WHERE a.tag = b.id AND a.tagType = '.$tagCategory.' AND a.artifactId = '.$artifactId.' AND a.artifactType = '.$artifactType.' ORDER BY contactName ASC');



			

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['contactName'] 	= $tagData->contactName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}

		else if($tagCategory == 6)

		{	

			$i = 0;		

			$query = $this->db->query('SELECT a.*, b.tagName as userTagName, b.nickName as nickName FROM teeme_tag a, teeme_users b WHERE a.tag = b.userId AND a.tagType = '.$tagCategory.' AND a.ownerId = '.$userId.' AND a.artifactId = '.$artifactId.' AND a.artifactType = '.$artifactType.' ORDER BY comments ASC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;
					
					if($tagData->nickName!='')
					{
						$arrTagDetails[$i]['userTagName']   = $tagData->nickName;
					}
					else
					{
						$arrTagDetails[$i]['userTagName'] 	= $tagData->userTagName;
					}	

					$i++;

				}

			}

		}	

		else if($tagCategory == 1 || $tagCategory == 2 )

		{	

			$i = 0;		



		 	$query = $this->db->query('SELECT a.*, b.tagType as tagName,b.systemTag FROM teeme_tag a, teeme_tag_types b WHERE a.tag = b.tagTypeId AND a.tagType = '.$tagCategory.' AND a.artifactId = '.$artifactId.' AND a.artifactType = '.$artifactType.' ORDER BY b.systemTag DESC ,comments ASC');



			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['systemTag'] 	= $tagData->systemTag;

					$arrTagDetails[$i]['tagName'] 		= $tagData->tagName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}																													

		return $arrTagDetails;

	}

	

	

	public function getCurrentTags($tagCategory, $userId, $artifactId, $artifactType, $workspaceId = 0,$lastLogin)

	{



		$arrTagDetails = array();			



		if($tagCategory == 3  ||  $tagCategory == 4)

		{	

			$i = 0;		

			

			$query = $this->db->query('SELECT a.* FROM teeme_tag a, teeme_tagged_users b WHERE a.tagId = b.tagId AND a.tagType = '.$tagCategory.' AND b.userId = '.$userId.' AND b.status = 1 AND artifactId = '.$artifactId.' AND artifactType = '.$artifactType.' AND (a.createdDate >\''.$lastLogin.'\') ORDER BY createdDate DESC');

			

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}

		else if($tagCategory == 5)

		{	

			$i = 0;		

			$query = $this->db->query('SELECT a.*, b.name as contactName FROM teeme_tag a, teeme_tree b WHERE a.tag = b.id AND a.tagType = '.$tagCategory.' AND a.ownerId = '.$userId.' AND a.artifactId = '.$artifactId.' AND a.artifactType = '.$artifactType.' AND (a.createdDate >\''.$lastLogin.'\') ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['contactName'] 	= $tagData->contactName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}

		else if($tagCategory == 6)

		{	

			$i = 0;		

			$query = $this->db->query('SELECT a.*, b.tagName as userTagName FROM teeme_tag a, teeme_users b WHERE a.tag = b.userId AND a.tagType = '.$tagCategory.' AND a.ownerId = '.$userId.' AND a.artifactId = '.$artifactId.' AND a.artifactType = '.$artifactType.' AND (a.createdDate >\''.$lastLogin.'\') ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['userTagName'] 	= $tagData->userTagName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}	

		else if($tagCategory == 1 || $tagCategory == 2 )

		{	

			$i = 0;		



			$query = $this->db->query('SELECT a.*, b.tagType as tagName FROM teeme_tag a, teeme_tag_types b WHERE a.tag = b.tagTypeId AND a.tagType = '.$tagCategory.' AND a.ownerId = '.$userId.' AND a.artifactId = '.$artifactId.' AND a.artifactType = '.$artifactType.' AND (a.createdDate >\''.$lastLogin.'\') ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['tagName'] 		= $tagData->tagName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}																															

		return $arrTagDetails;

	}



	 /**

	* This method will be used for fetch the artifact tags from the database.

	* @param $tagCategory This is the variable used to hold the tag category.

 	* @param $userId This is the variable used to hold the user ID.

	* @param $workspaceId This is the variable used to hold the artifact ID.

	* @return The tags contents as an array

	*/

	public function getWorkspaceTags($userId, $workspaceId, $workspaceType = 0)

	{



		$arrTagDetails = array();			

		$userId 	= $_SESSION['userId'];		

		$i = 0;		

		$userWorkspace = '';

		if($workspaceId == 0)

		{

			$userWorkspace = ' AND c.userId = '.$userId;

			$query = $this->db->query('SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c WHERE a.artifactId = c.id AND a.tagId = b.tagId AND (a.tagType = 3 OR a.tagType = 4) AND b.userId = '.$userId.' AND b.status = 1 AND c.workspaces = \''.$workspaceId.'\''.$userWorkspace.' AND a.artifactType = 1 ORDER BY a.createdDate DESC');	

		}		

		else

		{

			$query = $this->db->query('SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c WHERE a.artifactId = c.id AND a.tagId = b.tagId AND (a.tagType = 3 OR a.tagType = 4) AND b.userId = '.$userId.' AND b.status = 1 AND c.workspaces = \''.$workspaceId.'\' AND c.workSpaceType = '.$workspaceType.' AND a.artifactType = 1 ORDER BY a.createdDate DESC');

		}		

		

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

				$arrTagDetails[$i]['tag'] 			= $tagData->tag;

				$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

				$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}				

		$query = $this->db->query('SELECT a.*, b.name as contactName FROM teeme_tag a, teeme_tree b, teeme_tree c WHERE a.artifactId = c.id AND a.tag = b.id AND a.tagType = 5 AND a.ownerId = '.$userId.' AND c.workspaces = \''.$workspaceId.'\''.$userWorkspace.' AND a.artifactType = 1 ORDER BY a.createdDate DESC');

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

				$arrTagDetails[$i]['tag'] 			= $tagData->tag;

				$arrTagDetails[$i]['contactName'] 	= $tagData->contactName;

				$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

				$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}					

		$query = $this->db->query('SELECT a.*, b.tagName as userTagName FROM teeme_tag a, teeme_users b, teeme_tree c WHERE a.artifactId = c.id AND a.tag = b.userId AND a.tagType = 6 AND a.ownerId = '.$userId.' AND c.workspaces = \''.$workspaceId.'\''.$userWorkspace.' AND a.artifactType = 1 ORDER BY a.createdDate DESC');

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

				$arrTagDetails[$i]['tag'] 			= $tagData->tag;

				$arrTagDetails[$i]['userTagName'] 	= $tagData->userTagName;

				$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

				$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}		

		

		$query = $this->db->query('SELECT a.*, b.tagType as tagName FROM teeme_tag a, teeme_tag_types b, teeme_tree c WHERE a.artifactId = c.id AND a.tag = b.tagTypeId  AND (a.tagType = 1 OR a.tagType = 2) AND c.workspaces = \''.$workspaceId.'\''.$userWorkspace.' AND a.artifactType = 1 ORDER BY a.createdDate DESC');		



		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

				$arrTagDetails[$i]['tag'] 			= $tagData->tag;

				$arrTagDetails[$i]['comments'] 		= $tagData->tagName;							

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

				$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}		

		return $arrTagDetails;	

	}



	 /**

	* This method will be used for fetch the tags from the database and store this into memcache.

	* @param $workspaceId This is the variable used to hold the workspace id.

 	* @param $workspaceType This is the variable used to hold the workspace type.

	* @return The tags contents as an array

	*/

	public function getAllWorkspaceTags($workspaceId, $workspaceType = 1)

	{

		$arrTagDetails = array();

		/*$memc = new Memcached;

		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));	*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wpTag'.$_SESSION['workPlaceId'];	

		$value = $memc->get($memCacheId);		

		if($value)

		{

			$arrTagDetails = $value;

			return $arrTagDetails;

		}

		else

		{				

			$i = 0;		

			#************************ Query to the fetch workspace tags by tree id *******************************************#

			$query = $this->db->query('SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c WHERE a.artifactId = c.id AND a.tagId = b.tagId AND a.tagType = 3 AND b.status = 1 AND c.workspaces = \''.$workspaceId.'\' AND a.artifactType = 1 ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

			#************************ Query to fetch the workspace tags by node id *******************************************#	

			$query = $this->db->query('SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.artifactId = d.id AND c.id = d.treeIds AND a.tagId = b.tagId AND a.tagType = 3  AND b.status = 1 AND c.workspaces = \''.$workspaceId.'\' AND a.artifactType = 2 ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}								

			$query = $this->db->query('SELECT a.*, b.name as contactName FROM teeme_tag a, teeme_tree b, teeme_tree c WHERE a.artifactId = c.id AND a.tag = b.id AND a.tagType = 5 AND c.workspaces = \''.$workspaceId.'\' ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['contactName'] 	= $tagData->contactName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

			$query = $this->db->query('SELECT a.*, b.tagName as userTagName FROM teeme_tag a, teeme_users b, teeme_tree c WHERE a.artifactId = c.id AND a.tag = b.userId AND a.tagType = 6 AND a.ownerId = '.$userId.' AND c.workspaces = \''.$workspaceId.'\''.$userWorkspace.' AND a.artifactType = 1 ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['userTagName'] 	= $tagData->userTagName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}		

			

			$query = $this->db->query('SELECT a.*, b.tagType as tagName FROM teeme_tag a, teeme_tag_types b, teeme_tree c WHERE a.artifactId = c.id AND a.tag = b.tagTypeId  AND a.tagType = 2 AND c.workspaces = \''.$workspaceId.'\' AND a.artifactType = 1 ORDER BY a.createdDate DESC');		

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['comments'] 		= $tagData->tagName;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}	

		}	

		return $arrTagDetails;	

	}



	 /**

	* This method will be used for fetch the tags from the database.

	* @param $tagCategory This is the variable used to hold the tag category.

 	* @param $userId This is the variable used to hold the user ID.

	* @param $artifactId This is the variable used to hold the artifact ID.

	* @param $artifactType This is the variable used to hold the artifact type.

	* @return The tags contents as an array

	*/

	public function getTagsByUserId($tagCategory, $userId)

	{

		$arrTagDetails = array();			

		if($tagCategory == 3  ||  $tagCategory == 4)

		{	

			$i = 0;		



			$query = $this->db->query('SELECT a.* FROM teeme_tag a, teeme_tagged_users b WHERE a.tagId = b.tagId AND a.tagType = '.$tagCategory.' AND b.userId = '.$userId.' AND b.status = 1 ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}

		else if($tagCategory == 5)

		{	

			$i = 0;		

			$query = $this->db->query('SELECT  a.*, b.name as contactName FROM teeme_tag a, teeme_tree b, teeme_tagged_users c WHERE a.tag = b.id AND a.tagId = c.tagId AND a.tagType = '.$tagCategory.' AND c.userId = '.$userId.' GROUP BY a.tag ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['contactName'] 	= $tagData->contactName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}

		else if($tagCategory == 6)

		{	

			$i = 0;		

			$query = $this->db->query('SELECT a.*, b.tagName as userTagName FROM teeme_tag a, teeme_users b WHERE a.tag = b.userId AND a.tagType = '.$tagCategory.' AND a.tag = '.$userId.' ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['userTagName'] 	= $tagData->userTagName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}	

		else if($tagCategory == 1 || $tagCategory == 2)

		{	

			$i = 0;		



			$query = $this->db->query('SELECT a.*, b.tagType as tagName FROM teeme_tag a, teeme_tag_types b WHERE a.tag = b.tagTypeId AND a.tagType = '.$tagCategory.' AND a.ownerId = '.$userId.' ORDER BY a.createdDate DESC');

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

					$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

					$arrTagDetails[$i]['tag'] 			= $tagData->tag;

					$arrTagDetails[$i]['tagName'] 		= $tagData->tagName;

					$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

					$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

					$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

					$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

					$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

					$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

					$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

					$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

					$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

					$i++;

				}

			}

		}																															

		return $arrTagDetails;

	}



	 /**

	* This method will be used for fetch the tags from the database.

	* @param $tagCategory This is the variable used to hold the tag category.

 	* @param $userId This is the variable used to hold the user ID.

	* @param $artifactId This is the variable used to hold the artifact ID.

	* @param $artifactType This is the variable used to hold the artifact type.

	* @return The tags contents as an array

	*/

	public function getTagsByTagType($tagCategory, $tagType, $userId)

	{

		$arrTagDetails = array();			

		$i = 0;		

		

		$query = $this->db->query('SELECT * FROM teeme_tag  WHERE tag = '.$tagType.' AND tagType = '.$tagCategory.' AND ownerId = '.$userId.' ORDER BY createdDate DESC');

		if($query->num_rows() > 0)

		{			

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails[$i]['tagTypeId'] 	= $tagData->tagType;

				$arrTagDetails[$i]['tag'] 			= $tagData->tag;				

				$arrTagDetails[$i]['comments'] 		= $tagData->comments;							

				$arrTagDetails[$i]['ownerId'] 		= $tagData->ownerId;					

				$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails[$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails[$i]['sequenceTagId']	= $tagData->sequenceTagId;

				$arrTagDetails[$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}																															

		return $arrTagDetails;

	}

	 /**

	* This method will be used for update the tree edited Date.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @param $editedDate This is the variable used to hold the tree modified date.

	* @update the tree edited date

	*/

	public function updateTreeModifiedDate( $treeId, $editedDate )

	{	

		$bResult  = $this->db->query('UPDATE teeme_tree SET editedDate=\''.$editedDate.'\' WHERE id='.$treeId);			

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

	* This method will be used for fetch the leaf ids from the database.

 	* @param $treeId This is the variable used to hold the tree ID .

	* @return The leaf ids as an array

	*/

	public function getLeafIdsByTreeId($treeId)

	{

		$arrIdDetails = array();

		if($treeId != NULL)

		{

			// Get information of particular document

			$query = $this->db->query('SELECT 

			a.id as teemLeafId FROM teeme_leaf a, teeme_node b WHERE a.id=b.leafId AND b.treeIds='.$treeId);

			if($query->num_rows() > 0)

			{				

				foreach ($query->result() as $leafData)

				{	

					$arrIdDetails[] = $leafData->teemLeafId;						

				}

			}

		}

		return $arrIdDetails;

	}

	 /**

	* This method will be used for fetch the node ids from the database.

 	* @param $treeId This is the variable used to hold the tree ID.

	* @return The node ids as an array

	*/

	public function getNodeIdsByTreeId($treeId)

	{

		$arrIdDetails = array();

		if($treeId != NULL)

		{

			// Get information of particular document

			$query = $this->db->query('SELECT 

			id  FROM teeme_node WHERE treeIds='.$treeId);

			if($query->num_rows() > 0)

			{				

				foreach ($query->result() as $nodeData)

				{	

					$arrIdDetails[] = $nodeData->id;						

				}

			}

		}

		return $arrIdDetails;

	}

	 /**

	* This method will be used for fetch the leaf or node tags from the database.

 	* @param $leafIds This is the variable used to hold the leaf ids or node IDs.

	* @return The leaf ids as an array

	*/

	function getLeafTagsByLeafIds($leafIds, $artifactType, $searchDate1 = '', $searchDate2 = '')	

	{		



		$arrTagDetails = array();

		$userId 	= $_SESSION['userId'];

		$i = 0;



		$query = $this->db->query('SELECT DISTINCT a.* FROM teeme_tag a, teeme_tagged_users b WHERE a.tagId = b.tagId AND a.tagType = 3 AND b.status = 1 AND a.artifactId IN('.$leafIds.') AND a.artifactType = '.$artifactType.' ORDER BY a.comments');



		if($query->num_rows() > 0)

		{	

			foreach ($query->result() as $tagData)

			{

				$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails['response'][$i]['tagTypeId'] 	= $tagData->tagType;

				$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;

				$arrTagDetails['response'][$i]['comments'] 		= $tagData->comments;							

				$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;					

				$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails['response'][$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails['response'][$i]['sequenceTagId']	= $tagData->sequenceTagId;

				$arrTagDetails['response'][$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}

		$query = $this->db->query('SELECT a.*, b.name as contactName FROM teeme_tag a, teeme_tree b WHERE a.tag = b.id AND a.tagType = 5 AND a.artifactId IN('.$leafIds.') AND a.artifactType = '.$artifactType.' ORDER BY contactName');



		if($query->num_rows() > 0)

		{		

			foreach ($query->result() as $tagData)

			{

				$arrTagDetails['contact'][$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails['contact'][$i]['tagTypeId'] 	= $tagData->tagType;

				$arrTagDetails['contact'][$i]['tag'] 			= $tagData->tag;

				$arrTagDetails['contact'][$i]['contactName'] 	= $tagData->contactName;

				$arrTagDetails['contact'][$i]['comments'] 		= $tagData->contactName;							

				$arrTagDetails['contact'][$i]['ownerId'] 		= $tagData->ownerId;					

				$arrTagDetails['contact'][$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails['contact'][$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails['contact'][$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails['contact'][$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails['contact'][$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails['contact'][$i]['sequenceTagId']	= $tagData->sequenceTagId;

				$arrTagDetails['contact'][$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}

		

		$query = $this->db->query('SELECT a.*, b.tagType as tagName FROM teeme_tag a, teeme_tag_types b WHERE a.tag = b.tagTypeId  AND a.artifactId IN('.$leafIds.') AND (a.tagType = 1 OR a.tagType = 2) AND a.artifactType = '.$artifactType.' ORDER BY tagName');		



		if($query->num_rows() > 0)

		{		

			foreach ($query->result() as $tagData)

			{	

				$arrTagDetails['simple'][$i]['tagId'] 		= $tagData->tagId;

				$arrTagDetails['simple'][$i]['tagTypeId'] 	= $tagData->tagType;

				$arrTagDetails['simple'][$i]['tag'] 			= $tagData->tag;

				$arrTagDetails['simple'][$i]['comments'] 		= $tagData->tagName;							

				$arrTagDetails['simple'][$i]['ownerId'] 		= $tagData->ownerId;					

				$arrTagDetails['simple'][$i]['artifactId'] 	= $tagData->artifactId;

				$arrTagDetails['simple'][$i]['artifactType']	= $tagData->artifactType;

				$arrTagDetails['simple'][$i]['createdDate'] 	= $tagData->createdDate;

				$arrTagDetails['simple'][$i]['startTime'] 	= $tagData->startTime;

				$arrTagDetails['simple'][$i]['endTime'] 		= $tagData->endTime;

				$arrTagDetails['simple'][$i]['sequenceTagId']	= $tagData->sequenceTagId;

				$arrTagDetails['simple'][$i]['sequenceOrder']	= $tagData->sequenceOrder;

				$i++;

			}

		}		

		return $arrTagDetails;

	}

	

	/**

	* This method will be used to insert the date of create tag.

 	* @param $tagId This is the variable used to hold the tag ID.

	* @param $createDate This is the variable used to hold task created date.

	* @return The node ids as an array

	*/

	public function insertCreateTagDate($tagId, $taskCreateDate)

	{		

		// Get information of particular document

		$strResultSQL = "INSERT INTO teeme_create_tag_date(tagId, taskCreateDate

				)

				VALUES

				(

				'".$tagId."','".$taskCreateDate."'

				)";

		$query = $this->db->query($strResultSQL);	

		if($query)

		{

			return true;

		}

		else

		{

			return false;

		}		

	}

	

	/**

	* This method will be used to retrieve the date of task create tag.

	* @return The task create date

	*/

	function getTaskCreateTagByTagId( $tagId )	

	{		

		$taskCreateDate = 0;

		$query = $this->db->query('SELECT taskCreateDate FROM teeme_create_tag_date WHERE tagId = '.$tagId);

		$tmpData = $query->row();

		$taskCreateDate = $tmpData->taskCreateDate;

		return $taskCreateDate;											

	}

	

	/*this function is used to get the tags comment text*/

	public function getTagCommentByTagId ($tagId )

	{

		$tagComment= '';		



		if ($tagId!='')

		{

			$query = $this->db->query('SELECT comments FROM teeme_tag WHERE tagId = '.$tagId);

		

			if($query->num_rows() > 0)

			{			

				foreach ($query->result() as $tagData)

				{	

					$tagComment = $tagData->comments;				

				}

			}

				

			return $tagComment;

		}

	}

	

	/*this function is used to get all the tags  applied to a tree*/

	public function  getTagsByTreeId($treeId){

		$query = $this->db->query("SELECT tag,group_concat(artifactId) as leaves FROM `teeme_tag` WHERE tag = '$treeId' group by `tag`");

		if($query->num_rows()){

			$result = $query->row_array();

			return $result['leaves'];

		}

		else{

			return 0;

		}

 	}

 	
 	/*Added by Dashrath- Get t*/
 	public function getResponseTag($tagId)
	{
		$tagComment = '';
		$query = $this->db->query("SELECT comments FROM teeme_tag WHERE tagId=".$tagId);

		if($query->num_rows() > 0)
		{			
			foreach ($query->result() as $tagData)
			{	

				$tagComment = $tagData->comments;				
			}
		}

		return $tagComment;
	}
	/*Dashrath- code end*/


 

 }

?>