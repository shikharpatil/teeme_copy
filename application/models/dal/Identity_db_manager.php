<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/
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
class Identity_db_manager extends CI_Model
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
	* @return This function returns SQL query for addding new user into database.
	*/

	public function insertRecord($object, $option='user' , $config=0)
        {
	
		if($config!=0){
			$placedb = $this->load->database($config,TRUE);		
			
			//transaction begin here
			$placedb->trans_begin();	
		}
		else
		{
			$this->db->trans_begin();	
		}
		 switch($option)
		 {
			case 'user':
				//Get data from the object and set it to according to their Database field name.
				//Inserting user details
				//Manoj: Inserting user expire date 
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'INSERT INTO 
									teeme_users
									( 
										workPlaceId, userName, password, tagName, userCommunityId, userTitle, firstName, lastName, role, skills, department, address1, address2, city, state, country, zip, phone, mobile, email, status, emailSent, registeredDate, activation, photo, statusUpdate, other, userGroup, isPlaceManager, defaultSpace, userTimezone, nickName
									)
								VALUES
									(
										\''.$object->getUserWorkPlaceId().'\',\''.$this->db->escape_str($object->getUserName()).'\',\''.$this->db->escape_str($object->getUserPassword()).'\',\''.$this->db->escape_str($object->getUserTagName()).'\',\''.$object->getUserCommunityId().'\',\''.$this->db->escape_str($object->getUserTitle()).'\',\''.$this->db->escape_str($object->getUserFirstName()).'\',\''.$this->db->escape_str($object->getUserLastName()).'\', \''.$this->db->escape_str($object->getUserRole()).'\', \''.$this->db->escape_str($object->getUserSkills()).'\', \''.$this->db->escape_str($object->getUserDepartment()).'\',\''.$this->db->escape_str(htmlentities($object->getUserAddress1())).'\', \''.$this->db->escape_str(htmlentities($object->getUserAddress2())).'\', \''.$this->db->escape_str($object->getUserCity()).'\', \''.$this->db->escape_str($object->getUserState()).'\', \''.$this->db->escape_str($object->getUserCountry()).'\', \''.$this->db->escape_str($object->getUserZip()).'\', \''.$this->db->escape_str($object->getuserPhone()).'\', \''.$this->db->escape_str($object->getUserMobile()).'\', \''.$this->db->escape_str($object->getUserEmail()).'\', \''.$this->db->escape_str($object->getUserStatus()).'\', \''.$this->db->escape_str($object->getUserEmailSent()).'\', NOW(), \''.$this->db->escape_str($object->getUserActivation()).'\', \''.$this->db->escape_str($object->getUserPhoto()).'\', \''.$this->db->escape_str(htmlentities($object->getUserStatusUpdate())).'\', \''.$this->db->escape_str(htmlentities($object->getUserOther())).'\', \''.$this->db->escape_str($object->getUserGroup()).'\',\''.$this->db->escape_str($object->getIsPlaceManager()).'\', \''.$this->db->escape_str($object->getUserSelectSpace()).'\', \''.$this->db->escape_str($object->getUserTimezone()).'\', \''.$this->db->escape_str($object->getUserNickName()).'\'
									)';

				break;
			case 'work_place':
				//Inserting company details
				//Inserting Number of users value when creating place by admin 
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'INSERT INTO 
									teeme_work_place
									( 
										workPlaceManagerId, placeTimezone, companyName, companyAddress1, companyAddress2, companyCity, companyState, companyCountry, companyZip, companyPhone, companyFax, companyOther, companyStatus, companyCreatedDate, server, server_username, server_password, instanceName, 	NumOfUsers, ExpireDate
									)
								VALUES
									(
										\''.$object->getWorkPlaceManagerId().'\',\''.$this->db->escape_str($object->getCompanyTimezone()).'\',\''.$this->db->escape_str($object->getCompanyName()).'\',\''.$this->db->escape_str($object->getCompanyAddress1()).'\',\''.$this->db->escape_str($object->getCompanyAddress2()).'\',\''.$this->db->escape_str($object->getCompanyCity()).'\',\''.$this->db->escape_str($object->getCompanyState()).'\',\''.$this->db->escape_str($object->getCompanyCountry()).'\',\''.$this->db->escape_str($object->getCompanyZip()).'\',\''.$this->db->escape_str($object->getCompanyPhone()).'\',\''.$this->db->escape_str($object->getCompanyFax()).'\',\''.$this->db->escape_str($object->getCompanyOther()).'\',\''.$this->db->escape_str($object->getCompanyStatus()).'\',\''.$this->db->escape_str($object->getCompanyCreatedDate()).'\',\''.$this->db->escape_str($object->getCompanyServer()).'\',\''.$this->db->escape_str($object->getCompanyServerUsername()).'\',\''.$this->db->escape_str($object->getCompanyServerPassword()).'\',\''.$this->db->escape_str($object->getInstanceName()).'\',\''.$object->getNumOfUsers().'\',\''.$this->db->escape_str($object->getPlaceExpDate()).'\'
									)';
				break;	
			case 'sub_work_place':
				//Inserting company sub work place details 
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'INSERT INTO 
									teeme_sub_work_place
									( 
										workPlaceId, subWorkPlaceManagerId, subWorkPlaceName 
									)
								VALUES
									(
										\''.$object->getWorkPlaceId().'\',\''.$object->getSubWorkPlaceManagerId().'\', \''.$this->db->escape_str($object->getSubWorkPlaceName()).'\'
									)';
				break;				
			case 'sub_work_place_members':
				//Inserting company sub work place members details 
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'INSERT INTO 
									teeme_sub_work_place_members
									( 
										subWorkPlaceId, userId, userAccess 
									)
								VALUES
									(
										\''.$object->getSubWorkPlaceId().'\',\''.$object->getSubWorkPlaceUserId().'\',\''.$this->db->escape_str($object->getSubWorkPlaceUserAccess()).'\'
									)';
				break;	
			case 'work_space':
			
				if ($object->getDefaultPlaceManagerSpace()==0)
				{
				//Inserting company work space details 
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'INSERT INTO 
									teeme_work_space
									( 
										workPlaceId, workSpaceName, treeAccess, workSpaceCreatedDate, workSpaceCreatorId
									)
								VALUES
									(
										\''.$object->getWorkPlaceId().'\',\''.$this->db->escape_str($object->getWorkSpaceName()).'\',\''.$object->getTreeAccessValue().'\', \''.$this->db->escape_str($object->getWorkSpaceCreatedDate()).'\', \''.$this->db->escape_str($object->getWorkSpaceManagerId()).'\'
									)';
				}
				else
				{
				//Inserting company work space details 
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'INSERT INTO 
									teeme_work_space
									( 
										workPlaceId, workSpaceName, treeAccess, workSpaceCreatedDate, defaultPlaceManagerSpace
									)
								VALUES
									(
										\''.$object->getWorkPlaceId().'\',\''.$this->db->escape_str($object->getWorkSpaceName()).'\',\''.$object->getTreeAccessValue().'\', \''.$this->db->escape_str($object->getWorkSpaceCreatedDate()).'\', \''.$this->db->escape_str($object->getDefaultPlaceManagerSpace()).'\'
									)';
				}
							
				break;	
			case 'work_space_members':
				//Inserting company work space members details 
				//Manoj: replace mysql_escape_str function
				if ($object->getWorkSpaceUserAccess()!='')
				{
					$strResultSQL = 'INSERT INTO 
									teeme_work_space_members
									( 
										workSpaceId, workSpaceUserId, workSpaceUserAccess 
									)
								VALUES
									(
										\''.$object->getWorkSpaceId().'\',\''.$object->getWorkSpaceUserId().'\',\''.$this->db->escape_str($object->getWorkSpaceUserAccess()).'\'
									)';
				}
				else
				{
					$strResultSQL = 'INSERT INTO 
									teeme_work_space_members
									( 
										workSpaceId, workSpaceUserId
									)
								VALUES
									(
										\''.$object->getWorkSpaceId().'\',\''.$object->getWorkSpaceUserId().'\')';
				}
				break;
			case 'sub_work_space':
				//Inserting company sub work space details 
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'INSERT INTO 
									teeme_sub_work_space
									( 
										workSpaceId, subWorkSpaceName, subWorkSpaceManagerId, subWorkspaceCreatedDate
									)
								VALUES
									(
										\''.$object->getWorkSpaceId().'\',\''.$this->db->escape_str($object->getSubWorkSpaceName()).'\', \''.$object->getSubWorkSpaceManagerId().'\',\''.$this->db->escape_str($object->getSubWorkSpaceCreatedDate()).'\'
									)';
				break;	
			case 'sub_work_space_members':
				//Inserting company sub work space members details 
				//Manoj: replace mysql_escape_str function
				if ($object->getSubWorkSpaceUserAccess()!='')
				{
					$strResultSQL = 'INSERT INTO 
									teeme_sub_work_space_members
									( 
										subWorkSpaceId, subWorkSpaceUserId, subWorkSpaceUserAccess 
									)
								VALUES
									(
										\''.$object->getSubWorkSpaceId().'\',\''.$object->getSubWorkSpaceUserId().'\',\''.$this->db->escape_str($object->getSubWorkSpaceUserAccess()).'\'
									)';
				}
				else
				{
					$strResultSQL = 'INSERT INTO 
									teeme_sub_work_space_members
									( 
										subWorkSpaceId, subWorkSpaceUserId
									)
								VALUES
									(
										\''.$object->getSubWorkSpaceId().'\',\''.$object->getSubWorkSpaceUserId().'\')';	
				}
				break;	
			case 'teeme_managers':
				//Inserting space manager details
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'INSERT INTO 
									teeme_managers
									( 
										placeId, managerId, placeType 
									)
								VALUES
									(
										\''.$object->getPlaceId().'\',\''.$object->getManagerId().'\',\''.$this->db->escape_str($object->getPlaceType()).'\'
									)';
				break;			
				case 'login_users':
				//Inserting company work space details 
				//Manoj: replace mysql_escape_str function
				$strResultSQL = 'INSERT INTO 
									teeme_login_users
									( 
										userId, sessionId, loginTime, loginStatus 
									)
								VALUES
									(
										'.$object->getUserId().',\''.$object->getSessionId().'\', \''.$this->db->escape_str($object->getLoginTime()).'\','.$this->db->escape_str($object->getLoginStatus()).'
									)';
				break;		
				case 'external_doc':
				//Inserting company work space details 
				//Manoj: replace mysql_escape_str function
				/*Changed by Dashrath- Add file_order column in query*/
				/*Changed by Dashrath- Add orig_modified_date column in query*/
				$strResultSQL = 'INSERT INTO 
									teeme_external_docs
									( 
										workSpaceId, workSpaceType, userId, folderId, docCaption, docName, file_order, path, createdDate, orig_modified_date, version 
									)
								VALUES
									(
										'.$object->getWorkSpaceId().','.$object->getWorkSpaceType().','.$object->getUserId().','.$object->getFolderId().',\''.$this->db->escape_str($object->getDocCaption()).'\',\''.$this->db->escape_str($object->getDocName()).'\','.$object->getFileOrder().',\''.$this->db->escape_str($object->getDocPath()).'\',\''.$object->getDocCreatedDate().'\',\''.$object->getDocOrigModifiedDate().'\','.$object->getDocVersion().'
									)';
				break;		
				case 'admin':
				//Inserting company work space details 
				$strResultSQL = 'INSERT INTO 
									teeme_admin
									( 
										userName, password, superAdmin, first_name, last_name
									)
								VALUES
									(
										\''.$this->db->escape_str($object->getAdminUserName()).'\',\''.$this->db->escape_str($object->getAdminPassword()).'\','.$this->db->escape_str($object->getSuperAdminStatus()).',\''.$this->db->escape_str($object->getAdminFirstName()).'\',\''.$this->db->escape_str($object->getAdminLastName()).'\'
									)';
				break;																
			default:				
				break;
		}	
		
		if($config!=0){
			$bResult = $placedb->query($strResultSQL); 
			
			//Checking transaction status here
			if($placedb->trans_status()=== FALSE)
			{
				$placedb->trans_rollback();
				return false;
			}
			else
			{
				$lastId = $placedb->insert_id();
			
				$placedb->trans_commit();
				
				if($option != 'teeme_managers')
				{
					return $lastId;
				}
				else
				{
					return true;
				}
			}
		}
		else{
			$bResult = $this->db->query($strResultSQL);
			
			//Checking transaction status here
			if($this->db->trans_status()=== FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$lastId = $this->db->insert_id();
			
				$this->db->trans_commit();
				
				if($option != 'teeme_managers')
				{
					return $lastId;
				}
				else
				{
					return true;
				}
			}
		}
		
		/*if($bResult)
		{
			return true;
		}		
		else
		{
			return false;
		}*/
		
	}
	
	function updateEditorStatus ($adv_id,$simple_id,$status)
	{
		
		$strResultSQL = "UPDATE teeme_editors SET active='".$status."' WHERE id='".$adv_id."' OR id='".$simple_id."'";
		
		$bResult = $this->db->query($strResultSQL);

		$strResultSQL = "UPDATE teeme_editors SET active=0 WHERE id!='".$adv_id."' AND id!='".$simple_id."' ";
		
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
	
	
	public function insertImportedFile($object)
	{
		//Manoj: replace mysql_escape_str function
		$strResultSQL = 'INSERT INTO 
									teeme_external_docs
									( 
										workSpaceId, workSpaceType, userId, docCaption, docName, path, createdDate, version 
									)
								VALUES
									(
										'.$object->getWorkSpaceId().','.$object->getWorkSpaceType().','.$object->getUserId().',\''.$this->db->escape_str($object->getDocCaption()).'\',\''.$this->db->escape_str($object->getDocName()).'\',\''.$this->db->escape_str($object->getDocPath()).'\',\''.$object->getDocCreatedDate().'\','.$object->getDocVersion().'
									)';
							
		$bResult = $this->db->query($strResultSQL);
		 
		if($bResult)
		{    
			return $this->db->insert_id();
		}		
		else
		{
			return false;
		}							
	
	}
	
	
	function updateEditorOptions ($editor_id,$option_id='')
	{
	
		if ($option_id=='')
		{
			
			$strResultSQL = "UPDATE teeme_editor_options SET allowed=0 WHERE editor_id='".$editor_id."'";
		
			$bResult = $this->db->query($strResultSQL);	
		}

		else
		{
			
			$strResultSQL = "UPDATE teeme_editor_options SET allowed=1 WHERE editor_id='".$editor_id."' AND id='".$option_id."'";
		
			$bResult = $this->db->query($strResultSQL);		
		}
		
		
		
		
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
	* This method will be used for update the 'tree updates count' to database.
 	* @param $treeId This is the variable used to hold the tree ID .
	* @param $documentName This is the variable used to hold the document name
	* @update the document name
	*/
	public function updateTreeUpdateCount( $treeId)
	{	
		$bResult  = $this->db->query('UPDATE teeme_tree SET updateCount = (updateCount+1) WHERE id='.$treeId);	
		$_SESSION['treeUpdateCount'.$treeId] = $_SESSION['treeUpdateCount'.$treeId]+1;		
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
	* This method will be used to set the tree update count
 	* @param $treeId This is the variable used to hold the tree ID .
	* @param $documentName This is the variable used to hold the document name
	* @update the document name
	*/
	public function setTreeUpdateCount($treeId)
	{	
		$query = $this->db->query('select updateCount from teeme_tree WHERE id='.$treeId);	
									
		foreach($query->result() as $row)
		{
			$updateCount = $row->updateCount;
		}	
		$_SESSION['treeUpdateCount'.$treeId] = $updateCount;	
		return $updateCount;
	}

		 /**
	* This method will be used to get the tree update count
 	* @param $treeId This is the variable used to hold the tree ID .
	* @param $documentName This is the variable used to hold the document name
	* @update the document name
	*/
	public function getTreeUpdateCount($treeId)
	{	
		$query = $this->db->query('select updateCount from teeme_tree WHERE id='.$treeId);	
									
		foreach($query->result() as $row)
		{
			$updateCount = $row->updateCount;
		}		
		return $updateCount;
	}	
	
	
	function getActiveEditorSimple()
	{
	
		$query = $this->db->query('SELECT id FROM teeme_editors WHERE active=1 AND id > 2');	
				
		foreach($query->result() as $row)
		{
			$editorId	= $row->id;

		}	
		return $editorId; 	
	
	}
	
	function getActiveEditorAdv()
	{
	
		$query = $this->db->query('SELECT id FROM teeme_editors WHERE active=1 AND id < 3');	
				
		foreach($query->result() as $row)
		{
			$editorId	= $row->id;

		}	
		return $editorId; 	
	
	}
	
	function setEditorOptionsAdv($editor_id="")
	{
	
		if ($editor_id=="") $editor_id = 1;
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
		$qry = "SELECT * FROM teeme_editor_options WHERE editor_id='".$editor_id."' AND allowed=1";
		$query = $instancedb->query($qry);
		
		$count = 0;
		
		
		if ($editor_id==2 || $editor_id==4)
		{
			foreach($query->result() as $row)
			{
				if ($count < 20)
				{
					if ($count==0)
						$options1 = $row->name;
					else	
						$options1 .= ',' .$row->name;
					$count++;
				}
				if ($count >= 20 && $count < 32)
				{
					if ($count==20)
						$options2 = $row->name;
					else	
						$options2 .= ',' .$row->name;
					$count++;
				}
				if ($count >= 32 && $count < 48)
				{
					if ($count==32)
						$options3 = $row->name;
					else	
						$options3 .= ',' .$row->name;
					$count++;
				}
				if ($count >= 48)
				{
					if ($count==48)
						$options4 = $row->name;
					else	
						$options4 .= ',' .$row->name;
					$count++;
				}
			}
			setcookie('editor_options1',$options1);
			setcookie('editor_options2',$options2);
			setcookie('editor_options3',$options3);
			setcookie('editor_options4',$options4);
		}
		else if ($editor_id==1 || $editor_id==3)
		{
			foreach($query->result() as $row)
			{
				if ($count < 15)
				{
					if ($count==0)
						$options1 = $row->name;
					else	
						$options1 .= ',' .$row->name;
			
				}
				if ($count >= 15 && $count < 31)
				{
					if ($count==15)
						$options2 = $row->name;
					else	
						$options2 .= ',' .$row->name;
			
				}
				if ($count >= 31)
				{
					if ($count==31)
						$options3 = $row->name;
					else	
						$options3 .= ',' .$row->name;
		
				}
                $count++;
			}
			setcookie('editor_options1',$options1);
			setcookie('editor_options2',$options2);
			setcookie('editor_options3',$options3);
		}
		else
		{
			foreach($query->result() as $row)
			{
				if ($count==0)
					$options = $row->name;
				else	
					$options .= ',' .$row->name;
			
				$count++;
			}	
			
			setcookie('editor_options',$options);
		}

		return 1;
	
	}


	function setEditorOptionsSimple($editor_id="")
	{
	
		if ($editor_id=="") $editor_id = 1;
		
		
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
		
		$qry = "SELECT * FROM teeme_editor_options WHERE editor_id='".$editor_id."' AND allowed=1";
		$query = $instancedb->query($qry);
		
	
		$count = 0;
		
		if ($editor_id==2 || $editor_id==4)
		{
			foreach($query->result() as $row)
			{
				if ($count < 15)
				{
					if ($count==0)
						$options1 = $row->name;
					else	
						$options1 .= ',' .$row->name;
					$count++;
				}
				if ($count >= 15 && $count < 32)
				{
					if ($count==15)
						$options2 = $row->name;
					else	
						$options2 .= ',' .$row->name;
					$count++;
				}
				if ($count >= 32 && $count < 48)
				{
					if ($count==32)
						$options3 = $row->name;
					else	
						$options3 .= ',' .$row->name;
					$count++;
				}
				if ($count >= 48)
				{
					if ($count==48)
						$options4 = $row->name;
					else	
						$options4 .= ',' .$row->name;
					$count++;
				}
			}
			setcookie('simple_editor_options1',$options1);
			setcookie('simple_editor_options2',$options2);
			setcookie('simple_editor_options3',$options3);
			setcookie('simple_editor_options4',$options4);
		}
		else if ($editor_id==1 || $editor_id==3)
		{
			foreach($query->result() as $row)
			{
				if ($count < 15)
				{
					if ($count==0)
						$options1 = ucfirst($row->name);
					else	
						$options1 .= ',' .ucfirst($row->name);
					$count++;
				}
				if ($count >= 15 && $count < 31)
				{
					if ($count==15)
						$options2 = ucfirst($row->name);
					else	
						$options2 .= ',' .ucfirst($row->name);
					$count++;
				}
				if ($count >= 31)
				{
					if ($count==31)
						$options3 = ucfirst($row->name);
					else	
						$options3 .= ',' .ucfirst($row->name);
					$count++;
				}

			}
			setcookie('simple_editor_options1',$options1);
			setcookie('simple_editor_options2',$options2);
			setcookie('simple_editor_options3',$options3);
		}
		else
		{
			foreach($query->result() as $row)
			{
				if ($count==0)
					$options = $row->name;
				else	
					$options .= ',' .$row->name;
			
				$count++;
			}	
			
			setcookie('editor_options',$options);
		}
  
  		return 1;
	
	}
	
	
	/*
		This function is used to "update a tree's workspace/Move tree to a workspace"
	*/
	
	function updateTreeWorkSpace($workSpaceId,$treeId,$type,$userId='')
	{
		if($userId!='')
		{
			$strResultSQL = "UPDATE teeme_tree SET workspaces='".$workSpaceId."', workSpaceType='".$type."',userId='".$userId."',isShared=0 WHERE id='".$treeId."'";
		}
		else
		{
			$strResultSQL = "UPDATE teeme_tree SET workspaces='".$workSpaceId."', workSpaceType='".$type."',isShared=0 WHERE id='".$treeId."'";
		}
		$this->db->query("delete from teeme_trees_shared WHERE treeId='".$treeId."'");	
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
	
	function updateTalkWorkSpace($treeId,$workSpaceId,$type)
	{
		$strResultSQL = "UPDATE teeme_tree SET workspaces='".$workSpaceId."', workSpaceType='".$type."' WHERE parentTreeId='".$treeId."'";
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
	
	/*
		This function is used to copy a tree and all its nodes and leaves to the same workspace
	*/
	
	function copyTree($treeId)
	{
			$strResultSQL = "insert into teeme_tree (parentTreeId,name,type,userId,createdDate,editedDate,workspaces,workSpaceType,nodes,nodeType1,nodeType,version
,latestVersion,treeVersion,viewCalendar,status) select parentTreeId,name,type,userId,createdDate,editedDate,workspaces,workSpaceType,nodes,nodeType1,nodeType,version
,latestVersion,treeVersion,viewCalendar,status  from teeme_tree where id='".$treeId."'";
		
			$bResult = $this->db->query($strResultSQL);
			$inserted_tree_id = $this->db->insert_id();
			
			$strResultSQL =
			"update teeme_tree set name=concat('(Copy) ',name),createdDate=now(),editedDate=now() where id='".$inserted_tree_id."'";
			$bResult = $this->db->query($strResultSQL);
			
			$strResultSQL =
			"insert into teeme_node 
(predecessor,successors,leafId,tag,treeIds,nodeOrder,starttime,endtime,version,nodeTitle,viewCalendar,userId,workSpaceId,workSpaceType) select predecessor,successors,leafId,tag,'".$inserted_tree_id."', nodeOrder,starttime,endtime,version,nodeTitle,viewCalendar,userId,workSpaceId,workSpaceType from teeme_node where treeIds='".$treeId."'";
			$bResult = $this->db->query($strResultSQL);
			$inserted_node_id = $this->db->insert_id();
			
			$strResultSQL =
			"insert into teeme_leaf (leafParentId,type,authors,status,userId,createdDate,contents,nodeId,latestContent,version)
select a.leafParentId,a.type,a.authors,a.status,a.userId,a.createdDate,a.contents,b.id, a.latestContent,a.version from
teeme_leaf a,teeme_node b where a.id=b.leafId and b.treeIds='".$inserted_tree_id."'";
			$bResult = $this->db->query($strResultSQL);
			$inserted_leaf_id = $this->db->insert_id();



	
			
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
	* This method will be used for fetch the node ids from the database.
 	* @param $treeId This is the variable used to hold the tree ID.
	* @return The node ids as an array
	*/
	public function getNodeIdsByTreeId($treeId)
	{
	
		//echo "<li>treeId= " .$treeId;
		$arrIdDetails = array();
		if($treeId != NULL)
		{
			// Get information of particular document
			$query = $this->db->query('SELECT 
			id FROM teeme_node WHERE treeIds='.$treeId);
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

	public function getNodeIdsByLinkedTreeId($treeId)
	{
	
	
		$arrIdDetails = array();
		if($treeId != NULL)
		{
			// Get information of particular document
			$query = $this->db->query('SELECT artifactId FROM teeme_links WHERE treeId='.$treeId);
			if($query->num_rows() > 0)
			{				
				foreach ($query->result() as $nodeData)
				{	
					$arrIdDetails[] = $nodeData->artifactId;						
				}
			}
		}
		return $arrIdDetails;
	}	
	
	public function getLinkedArtifactsByLinkedTreeId($treeId,$linkType='',$workSpaceId,$workSpaceType)
	{
	 
	
		$arrIdDetails = array();
		if($treeId != NULL && $linkType=='' )
		{ 
			// Get information of particular document
			$query = $this->db->query('SELECT artifactId,artifactType FROM teeme_links WHERE treeId='.$treeId);
			if($query->num_rows() > 0)
			{				
				foreach ($query->result() as $nodeData)
				{	
					$arrIdDetails[$nodeData->artifactId] = $nodeData->artifactType;						
				}
			}
		}
		elseif($linkType=='external')
		{
	
		   // Get information of particular document
		  
			$query = $this->db->query('SELECT artifactId,artifactType FROM teeme_links_external WHERE linkedDocId='.$treeId);
			if($query->num_rows() > 0)
			{				
				foreach ($query->result() as $nodeData)
				{	
					$arrIdDetails[$nodeData->artifactId] = $nodeData->artifactType;						
				}
			}
		
		}
		//applied url leaf link
		elseif($linkType=='url' && $workSpaceId!='' && $workSpaceType!='')
		{
	
		   // Get information of particular document
		  
			$query = $this->db->query('SELECT a.artifactId,a.artifactType FROM teeme_applied_url a, teeme_node b, teeme_tree c WHERE a.urlId='.$treeId.' AND a.artifactId=b.id AND b.treeIds=c.id AND c.workspaces='.$workSpaceId.' AND c.workSpaceType= '.$workSpaceType.'');
			if($query->num_rows() > 0)
			{				
				foreach ($query->result() as $nodeData)
				{	
					$arrIdDetails[$nodeData->artifactId] = $nodeData->artifactType;						
				}
			}
		
		}
	
		return $arrIdDetails;
	}

	
	public function getNodeIdsByLinkedExternalDocsId($docId)
	{
	
		
		$arrIdDetails = array();
		if($docId != NULL)
		{
			// Get information of particular document
			$query = $this->db->query('SELECT artifactId FROM teeme_links_external WHERE linkedDocId='.$docId);
			if($query->num_rows() > 0)
			{				
				foreach ($query->result() as $nodeData)
				{	
					$arrIdDetails[] = $nodeData->artifactId;						
				}
			}
		}
		return $arrIdDetails;
	}
	
	public function getLinkedArtifactsByLinkedExternalDocsId($docId)
	{
	
		
		$arrIdDetails = array();
		if($docId != NULL)
		{
			// Get information of particular document
			$query = $this->db->query('SELECT artifactId,artifactType FROM teeme_links_external WHERE linkedDocId='.$docId);
			if($query->num_rows() > 0)
			{				
				foreach ($query->result() as $nodeData)
				{	
					$arrIdDetails[$nodeData->artifactId] = $nodeData->artifactType;						
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
	function getLeafLinksByLeafIds($leafIds, $artifactType, $searchDate1 = '', $searchDate2 = '')	
	{		
		$arrLinkDetails = array();			
		$userId 	= $_SESSION['userId'];		
		$i = 0;	
		
		
		$query = $this->db->query('SELECT c.id,c.name FROM teeme_links a, teeme_leaf b, teeme_tree c WHERE a.artifactId=b.nodeId AND a.treeId=c.id AND a.artifactId IN('.$leafIds.')');	
		
		if($query->num_rows() > 0)
		{			
			foreach ($query->result() as $linkData)
			{	
				
				$arrLinkDetails['response'][$i]['treeId'] = $linkData->id;
				$arrLinkDetails['response'][$i]['treeName'] = $linkData->name;
		
				$i++;
				
			}

		}					
	
		return $arrLinkDetails;											
	}
	//to get parent tree by nodeId
	
	/**
	* This method will be used to get the page link by using tag id.
 	* @return The page link
	*/
	public function getLinkByLinkedTreeId($treeId)
	{
		$link = array();	
			$query = $this->db->query('SELECT type,name,workspaces,workSpaceType FROM teeme_tree WHERE id='.$treeId);		

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
					$link[0] = 'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist';
					$link[1] = $this->lang->line('txt_Document').': '.$treeName;
				}	
				if($treeType == 2)
				{
					$link[0] = 'view_discussion/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('disucssion').': '.$treeName;
				}	
				if($treeType == 3)
				{
					$link[0] = 'view_chat/node1/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('chat').': '.$treeName;
				}	
				if($treeType == 4)
				{
					$link[0] = 'view_activity/node/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('activity').': '.$treeName;
				}	
				if($treeType == 5)
				{
					$link[0] = 'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('txt_Contact').': '.$treeName;
				}	
				if($treeType == 6)
				{
					$link[0] = 'notes/Details/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType;
					$link[1] = $this->lang->line('txt_Notes').': '.$treeName;
				}	
				return $link;
			}
		
	}


	 /**
	* This is the implmentation of the abstract method from the parent DBManager class .
	* @param $object This is the object that will get updated into the database.
	* @return This function returns SQL query for updating teeme document details into database.
	*/

	public function updateRecord( $object, $option="" )
    {
	
		//This variable hold the query for insert menu information into Database.
		$strResultSQL = '';
		switch($option)
		{
			case 'user':
		
				//Get data from the object and set it to according to their Database field name.
				//Updating user details
				//Manoj: replace mysql_escape_str function
				if ($object->getUserPhoto() != '')
				{
					$strResultSQL = 'UPDATE
									teeme_users
								SET
									workPlaceId 	= \''.$object->getUserWorkPlaceId().'\',
									userName		= \''.$this->db->escape_str($object->getUserName()).'\',									
									userCommunityId	= \''.$object->getUserCommunityId().'\',
									userTitle		= \''.$this->db->escape_str($object->getUserTitle()).'\',
									firstName		= \''.$this->db->escape_str($object->getUserFirstName()).'\', 
									lastName		= \''.$this->db->escape_str($object->getUserLastName()).'\',
									address1		= \''.$this->db->escape_str($object->getUserAddress1()).'\',
									address2		= \''.$this->db->escape_str($object->getUserAddress2()).'\',
									city			= \''.$this->db->escape_str($object->getUserCity()).'\', 
									state			= \''.$this->db->escape_str($object->getUserState()).'\',
									country			= \''.$this->db->escape_str($object->getUserCountry()).'\',
									zip				= \''.$this->db->escape_str($object->getUserZip()).'\',
									phone			= \''.$this->db->escape_str($object->getuserPhone()).'\',
									mobile			= \''.$this->db->escape_str($object->getUserMobile()).'\',
									email			= \''.$this->db->escape_str($object->getUserEmail()).'\',
									status			= \''.$this->db->escape_str($object->getUserStatus()).'\',
									emailSent		= \''.$this->db->escape_str($object->getUserEmailSent()).'\',
									activation 		= \''.$this->db->escape_str($object->getUserActivation()).'\',
									password 		= \''.$this->db->escape_str($object->getUserPassword()).'\',
									tagName 		= \''.$this->db->escape_str($object->getUserTagName()).'\',
									photo			= \''.$this->db->escape_str($object->getUserPhoto()).'\',
									other			= \''.$this->db->escape_str($object->getUserOther()).'\',
									role			= \''.$this->db->escape_str($object->getUserRole()).'\',
									skills			= \''.$this->db->escape_str($object->getUserSkills()).'\',
									department		= \''.$this->db->escape_str($object->getUserDepartment()).'\',
									userGroup		= \''.$this->db->escape_str($object->getUserGroup()).'\',
									defaultSpace		= \''.$this->db->escape_str($object->getUserSelectSpace()).'\',
									userTimezone	= \''.$this->db->escape_str($object->getUserTimezone()).'\',
									statusUpdate	= \''.$this->db->escape_str($object->getUserStatusUpdate()).'\',
									nickName	= \''.$this->db->escape_str($object->getUserNickName()).'\'								
								WHERE
									userId			= \''.$object->getUserId().'\'';
				}
				else
				{
					$strResultSQL = 'UPDATE teeme_users
								SET
									workPlaceId 	= \''.$object->getUserWorkPlaceId().'\',
									userName		= \''.$this->db->escape_str($object->getUserName()).'\',									
									userCommunityId	= \''.$this->db->escape_str($object->getUserCommunityId()).'\',
									userTitle		= \''.$this->db->escape_str($object->getUserTitle()).'\',
									firstName		= \''.$this->db->escape_str($object->getUserFirstName()).'\', 
									lastName		= \''.$this->db->escape_str($object->getUserLastName()).'\',
									address1		= \''.$this->db->escape_str($object->getUserAddress1()).'\',
									address2		= \''.$this->db->escape_str($object->getUserAddress2()).'\',
									city			= \''.$this->db->escape_str($object->getUserCity()).'\', 
									state			= \''.$this->db->escape_str($object->getUserState()).'\',
									country			= \''.$this->db->escape_str($object->getUserCountry()).'\',
									zip				= \''.$this->db->escape_str($object->getUserZip()).'\',
									phone			= \''.$this->db->escape_str($object->getuserPhone()).'\',
									mobile			= \''.$this->db->escape_str($object->getUserMobile()).'\',
									email			= \''.$this->db->escape_str($object->getUserEmail()).'\',
									status			= \''.$this->db->escape_str($object->getUserStatus()).'\',
									emailSent		= \''.$this->db->escape_str($object->getUserEmailSent()).'\',
									activation 		= \''.$this->db->escape_str($object->getUserActivation()).'\',
									password 		= \''.$this->db->escape_str($object->getUserPassword()).'\',
									tagName 		= \''.$this->db->escape_str($object->getUserTagName()).'\',
									other			= \''.$this->db->escape_str($object->getUserOther()).'\',
									role			= \''.$this->db->escape_str($object->getUserRole()).'\',
									skills			= \''.$this->db->escape_str($object->getUserSkills()).'\',
									department		= \''.$this->db->escape_str($object->getUserDepartment()).'\',
									userGroup		= \''.$this->db->escape_str($object->getUserGroup()).'\',
									defaultSpace		= \''.$this->db->escape_str($object->getUserSelectSpace()).'\',
									userTimezone	= \''.$this->db->escape_str($object->getUserTimezone()).'\',
									statusUpdate	= \''.$this->db->escape_str($object->getUserStatusUpdate()).'\',
									nickName	= \''.$this->db->escape_str($object->getUserNickName()).'\' 							
								WHERE
									userId			= \''.$object->getUserId().'\'';
				}
									
			
			
				break;
				
			case 'userByPlaceManager':
				
				//Get data from the object and set it to according to their Database field name.
				//Updating user details
				//Manoj: replace mysql_escape_str function
				if ($object->getUserPhoto() != '')
				{
					$strResultSQL = 'UPDATE
									teeme_users
								SET
									workPlaceId 	= \''.$object->getUserWorkPlaceId().'\',
									userName		= \''.$this->db->escape_str($object->getUserName()).'\',									
									userCommunityId	= \''.$object->getUserCommunityId().'\',
									userTitle		= \''.$this->db->escape_str($object->getUserTitle()).'\',
									firstName		= \''.$this->db->escape_str($object->getUserFirstName()).'\', 
									lastName		= \''.$this->db->escape_str($object->getUserLastName()).'\',
									address1		= \''.$this->db->escape_str($object->getUserAddress1()).'\',
									address2		= \''.$this->db->escape_str($object->getUserAddress2()).'\',
									city			= \''.$this->db->escape_str($object->getUserCity()).'\', 
									state			= \''.$this->db->escape_str($object->getUserState()).'\',
									country			= \''.$this->db->escape_str($object->getUserCountry()).'\',
									zip			= \''.$this->db->escape_str($object->getUserZip()).'\',
									phone			= \''.$this->db->escape_str($object->getuserPhone()).'\',
									mobile			= \''.$this->db->escape_str($object->getUserMobile()).'\',
									email			= \''.$this->db->escape_str($object->getUserEmail()).'\',
									status			= \''.$this->db->escape_str($object->getUserStatus()).'\',
									emailSent		= \''.$this->db->escape_str($object->getUserEmailSent()).'\',
									activation 		= \''.$this->db->escape_str($object->getUserActivation()).'\',
									password 		= \''.$this->db->escape_str($object->getUserPassword()).'\',
									tagName 		= \''.$this->db->escape_str($object->getUserTagName()).'\',
									photo			= \''.$this->db->escape_str($object->getUserPhoto()).'\',
									other			= \''.$this->db->escape_str($object->getUserOther()).'\',
									role			= \''.$this->db->escape_str($object->getUserRole()).'\',
									skills			= \''.$this->db->escape_str($object->getUserSkills()).'\',
									department		= \''.$this->db->escape_str($object->getUserDepartment()).'\',
									statusUpdate	= \''.$this->db->escape_str($object->getUserStatusUpdate()).'\',
									userGroup		= \''.$this->db->escape_str($object->getUserGroup()).'\',
                                    isPlaceManager	= \''.$this->db->escape_str($object->getIsPlaceManager()).'\',
									userTimezone	= \''.$this->db->escape_str($object->getUserTimezone()).'\',
									nickName	= \''.$this->db->escape_str($object->getUserNickName()).'\'
								WHERE
									userId			= \''.$object->getUserId().'\'';
				}
				else
				{
					$strResultSQL = 'UPDATE teeme_users
								SET
									workPlaceId 	= \''.$object->getUserWorkPlaceId().'\',
									userName		= \''.$this->db->escape_str($object->getUserName()).'\',									
									userTitle		= \''.$this->db->escape_str($object->getUserTitle()).'\',
									firstName		= \''.$this->db->escape_str($object->getUserFirstName()).'\', 
									lastName		= \''.$this->db->escape_str($object->getUserLastName()).'\',
									address1		= \''.$this->db->escape_str($object->getUserAddress1()).'\',
									address2		= \''.$this->db->escape_str($object->getUserAddress2()).'\',
									city			= \''.$this->db->escape_str($object->getUserCity()).'\', 
									state			= \''.$this->db->escape_str($object->getUserState()).'\',
									country			= \''.$this->db->escape_str($object->getUserCountry()).'\',
									zip			= \''.$this->db->escape_str($object->getUserZip()).'\',
									phone			= \''.$this->db->escape_str($object->getuserPhone()).'\',
									mobile			= \''.$this->db->escape_str($object->getUserMobile()).'\',
									email			= \''.$this->db->escape_str($object->getUserEmail()).'\',
									status			= \''.$this->db->escape_str($object->getUserStatus()).'\',
									emailSent		= \''.$this->db->escape_str($object->getUserEmailSent()).'\',
									activation 		= \''.$this->db->escape_str($object->getUserActivation()).'\',
									password 		= \''.$this->db->escape_str($object->getUserPassword()).'\',
									tagName 		= \''.$this->db->escape_str($object->getUserTagName()).'\',
									other			= \''.$this->db->escape_str($object->getUserOther()).'\',
									role			= \''.$this->db->escape_str($object->getUserRole()).'\',
									skills			= \''.$this->db->escape_str($object->getUserSkills()).'\',
									department		= \''.$this->db->escape_str($object->getUserDepartment()).'\',
									statusUpdate	= \''.$this->db->escape_str($object->getUserStatusUpdate()).'\',
									userGroup		= \''.$this->db->escape_str($object->getUserGroup()).'\',
                                    isPlaceManager	= \''.$this->db->escape_str($object->getIsPlaceManager()).'\',
									userTimezone	= \''.$this->db->escape_str($object->getUserTimezone()).'\',
									nickName	= \''.$this->db->escape_str($object->getUserNickName()).'\'    
								WHERE
									userId			= \''.$object->getUserId().'\'';
				}
									
			
				
				break;
			case 'work_place':
				//Updating company details 
				$strResultSQL = 'UPDATE 
									teeme_work_place
								SET 
									workPlaceManagerId	= \''.$object->getWorkPlaceManagerId().'\', 
									companyName			= \''.$this->db->escape_str($object->getCompanyName()).'\',
									companyAddress1		= \''.$this->db->escape_str($object->getCompanyAddress1()).'\',
									companyAddress2		= \''.$this->db->escape_str($object->getCompanyAddress2()).'\',
									companyCity			= \''.$this->db->escape_str($object->getCompanyCity()).'\',
									companyState		= \''.$this->db->escape_str($object->getCompanyState()).'\',
									companyCountry		= \''.$this->db->escape_str($object->getCompanyCountry()).'\',	
									companyZip			= \''.$this->db->escape_str($object->getCompanyZip()).'\',	
									companyPhone		= \''.$this->db->escape_str($object->getCompanyPhone()).'\',
									companyFax			= \''.$this->db->escape_str($object->getCompanyFax()).'\',	
									companyStatus		= \''.$this->db->escape_str($object->getCompanyStatus()).'\',									
									companyCreatedDate 	= \''.$this->db->escape_str($object->getCompanyCreatedDate()).'\'								
								WHERE
									workPlaceId	= \''.$object->getWorkPlaceId().'\'';
				
				break;	
			case 'sub_work_place':
				//Updating company sub aork place details 
				$strResultSQL = 'UPDATE 
									teeme_sub_work_place
								SET	 
									workPlaceId				= \''.$object->getWorkPlaceId().'\',
									subWorkPlaceManagerId	= \''.$object->getSubWorkPlaceManagerId().'\',
									subWorkPlaceName		= \''.$this->db->escape_str($object->getSubWorkPlaceName()).'\'
								WHERE
									subWorkPlaceId	= \''.$object->getSubWorkPlaceId().'\'';
				break;				
			case 'sub_work_place_members':
				//Updating company sub aork place members details 
				$strResultSQL = 'UPDATE 
									teeme_sub_work_place_members
								SET
									subWorkPlaceId	= \''.$object->getSubWorkPlaceId().'\',
									userId			= \''.$object->getSubWorkPlaceUserId().'\',
									userAccess 		= \''.$this->db->escape_str($object->getSubWorkPlaceUserAccess()).'\'								
								WHERE
									subWorkPlaceMembersId	= \''.$object->getSubWorkPlaceMembersId().'\'';
				break;	
			case 'work_space':
				//Updating company aork space details 
				$strResultSQL = 'UPDATE 
									teeme_work_space
								SET 																	
									workSpaceName 		= \''.$this->db->escape_str($object->getWorkSpaceName()).'\', treeAccess=\''.$this->db->escape_str($object->getTreeAccessValue()) .'\'
								WHERE
									workSpaceId	= \''.$object->getWorkSpaceId().'\'';
				break;	
			case 'work_space_members':
				//Updating company work space members details 
				if ($object->getWorkSpaceUserAccess()!='')
				{
					$strResultSQL = 'UPDATE 
									teeme_work_space_members
								SET
									workSpaceId				= \''.$object->getWorkSpaceId().'\',
									workSpaceUserId			= \''.$object->getWorkSpaceUserId().'\',
									workSpaceUserAccess 	= \''.$this->db->escape_str($object->getWorkSpaceUserAccess()).'\'
								WHERE
									workSpaceMembersId	= \''.$object->getWorkSpaceMembersId().'\'';
				}
				else
				{
					$strResultSQL = 'UPDATE 
									teeme_work_space_members
								SET
									workSpaceId				= \''.$object->getWorkSpaceId().'\',
									workSpaceUserId			= \''.$object->getWorkSpaceUserId().'\'
								WHERE
									workSpaceMembersId	= \''.$object->getWorkSpaceMembersId().'\'';
				}
			break;
			case 'sub_work_space':
				//Updating company sub work space details 
				$strResultSQL = 'UPDATE 
									teeme_sub_work_space
								SET									
									subWorkSpaceName		= \''.$this->db->escape_str($object->getSubWorkSpaceName()).'\' 
								WHERE
									subWorkSpaceId			= \''.$object->getSubWorkSpaceId().'\'';
				break;	
			case 'sub_work_space_members':
				//Updating company sub work space members details 
				if ($object->getSubWorkSpaceUserAccess()!='')
				{
					$strResultSQL = 'UPDATE 
									teeme_sub_work_space_members
								SET 
									subWorkSpaceId	= \''.$object->getSubWorkSpaceId().'\',
									userId			= \''.$object->getSubWorkSpaceUserId().'\',
									userAccess 		= \''.$this->db->escape_str($object->getSubWorkSpaceUserAccess()).'\'
								WHERE
									subWorkSpaceMembersId	= \''.$object->getSubWorkSpaceMembersId().'\'';
				}
				else
				{
					$strResultSQL = 'UPDATE 
									teeme_sub_work_space_members
								SET 
									subWorkSpaceId	= \''.$object->getSubWorkSpaceId().'\',
									userId			= \''.$object->getSubWorkSpaceUserId().'\'
								WHERE
									subWorkSpaceMembersId	= \''.$object->getSubWorkSpaceMembersId().'\'';
				}
				break;
			case 'admin':
				//Updating instance manager details 
				$strResultSQL = 'UPDATE 
									teeme_admin
								SET 
									first_name      = \''.$this->db->escape_str($object->getAdminFirstName()).'\',
									last_name      = \''.$this->db->escape_str($object->getAdminLastName()).'\',
									userName		= \''.$this->db->escape_str($object->getAdminUserName()).'\',
									password		= \''.$this->db->escape_str($object->getAdminPassword()).'\'									
								WHERE
									id	= '.$object->getAdminId();
				break;												
			default:				
				break;
		
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
	* @param $username This is the variable that will be used to verify the yahoo authentication.
	* @return the status of user authentication.
	*/

	public function getYahooAuthentication( $userName, $password )
    {
		$ch = curl_init();
		/******************************** AUTHENTICATION SECTION ********************************/
		curl_setopt( $ch, CURLOPT_URL, 'http://login.yahoo.com/config/login?' );
		curl_setopt( $ch, CURLOPT_POST, 22 );
		$postFields = 'login='.$this->db->escape_str($userName).'&passwd='.$this->db->escape_str($password).'&.src=&.tries=5&.bypass=&.partner=&.md5=&.hash=&.intl=us&.tries=1&.challenge=ydKtXwwZarNeRMeAufKa56.oJqaO&.u=dmvmk8p231bpr&.yplus=&.emailCode=&pkg=&stepid=&.ev=&hasMsgr=0&.v=0&.chkP=N&.last=&.done=http://address.mail.yahoo.com/';
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );		
		if( strstr( curl_exec( $ch ), 'Invalid ID or password' ) ) 
		{
			return false;
		}
		else
		{
			return true;
		}
	}

    
	public function getGoogleAuthentication( $userName, $password )
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIEJAR);

		curl_setopt($ch, CURLOPT_HEADER, 0);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
		curl_setopt($ch, CURLOPT_TIMEOUT, 120);

		curl_setopt($ch, CURLOPT_URL, 
		  'https://accounts.google.com/ServiceLogin?hl=en&service=alerts&continue=http://www.google.com/alerts/manage');
		$data = curl_exec($ch);
		
		$formFields = $this->getFormFields($data);
		
		$formFields['Email']  = $userName;
		$formFields['Passwd'] = $password;
		unset($formFields['PersistentCookie']);
		
		$post_string = '';
		foreach($formFields as $key => $value) {
			$post_string .= $key . '=' . urlencode($value) . '&';
		}

		$post_string = substr($post_string, 0, -1);
		
		curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/ServiceLoginAuth');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
		
		$result = curl_exec($ch);
		
		if (strpos($result, '<title>Redirecting') === false) {
			return false;
		} else {
			return true;
		}

	}

    function getFormFields($data)
	{
		if (preg_match('/(<form.*?id=.?gaia_loginform.*?<\/form>)/is', $data, $matches)) {
			$inputs = $this->getInputs($matches[1]);
	
			return $inputs;
		} else {
			die('didnt find login form');
		}
	}
	
	function getInputs($form)
	{
		$inputs = array();
	
		$elements = preg_match_all('/(<input[^>]+>)/is', $form, $matches);
	
		if ($elements > 0) {
			for($i = 0; $i < $elements; $i++) {
				$el = preg_replace('/\s{2,}/', ' ', $matches[1][$i]);
	
				if (preg_match('/name=(?:["\'])?([^"\'\s]*)/i', $el, $name)) {
					$name  = $name[1];
					$value = '';
	
					if (preg_match('/value=(?:["\'])?([^"\'\s]*)/i', $el, $value)) {
						$value = $value[1];
					}
	
					$inputs[$name] = $value;
				}
			}
		}
	
		return $inputs;
	}

	 /**	
	* @return the user community names and ids
	*/

	public function getUserCommunities()
    {
		$communityDetails = array();		
		$query = $this->db->query('SELECT * FROM teeme_user_communities');	
		$i = 0;							
		foreach($query->result() as $row)
		{
			$communityDetails[$i]['communityId'] 	= $row->communityId;
			$communityDetails[$i]['communityName'] 	= $row->communityName;
			$i++;
		}	
		return $communityDetails; 		
	}

	/**	
	* @return the user community name according to community id
	*/

	public function getUserCommunityNameByCommunityId($communityId)
    {
		$communityDetails = array();		
		$query = $this->db->query('SELECT communityName FROM teeme_user_communities WHERE communityId ='.$communityId);							
		foreach($query->result() as $row)
		{
			$userCommunityName = $row->communityName;				
		}	
		return $userCommunityName; 		
	}

	/*Changed by Dashrath- Add $config for load db*/
	public function getUserCommunityIdByUsername($username, $config=0)
    {
		
		/*Changed by Dashrath- Add if else condition for load db*/
		if ($config!=0)
        {
            $placedb = $this->load->database($config,TRUE);

            $query = $placedb->query("SELECT userCommunityId FROM teeme_users WHERE userName ='".$this->db->escape_str($username)."'");
        }
		else
		{
			$query = $this->db->query("SELECT userCommunityId FROM teeme_users WHERE userName ='".$this->db->escape_str($username)."'");
		}
		/*Dashrath- changes end*/

		$userCommunityId='';					
		if($query->num_rows()){
			return $userCommunityId; 		
		}
		else{
			return 1;
		}
	}
	
	/**	
	* @return the teeme countries
	*/

	public function deleteWorkSpaceByWorkspaceId($workSpaceId, $workSpaceType)
    {	
		if($workSpaceType == 1)
		{
			$query = $this->db->query('UPDATE teeme_work_space SET status = 0, deleted=1 WHERE workSpaceId ='.$workSpaceId);
		}
		else
		{		
			//$query = $this->db->query('DELETE FROM teeme_sub_work_space WHERE subWorkSpaceId ='.$workSpaceId);
			$query = $this->db->query('UPDATE teeme_sub_work_space SET status = 0 WHERE subWorkSpaceId ='.$workSpaceId);
		}			
		return true; 		
	}
	/**	
	* @return the teeme countries
	*/

	public function deleteWorkplaceMemberByMemberId($userId)
    {		
		$query = $this->db->query('UPDATE teeme_users SET status = 1 WHERE userId ='.$userId);	
		
		return true; 		
	}
	/**	
	* @return the teeme countries
	*/

	public function getCountries()
    {
		$countryDetails = array();		
		$query = $this->db->query('SELECT * FROM teeme_countries');	
		$i = 0;							
		foreach($query->result() as $row)
		{
			$countryDetails[$i]['countryId'] 	= $row->countryId;
			$countryDetails[$i]['countryName'] 	= $row->countryName;
			$i++;
		}	
		return $countryDetails; 		
	}

	/**	
	* @check whther user name already exist
	*/

	public function checkUserName($username, $communityId, $workPlaceId = 0, $config=0)
    {		
		//Manoj: replace mysql_escape_str function	
		$qry = 'SELECT userId FROM teeme_users WHERE workPlaceId = \''.$workPlaceId.'\' AND userName = \''.$this->db->escape_str($username).'\'';	
		
			if($config!=0){
				$placedb = $this->load->database($config,TRUE);		
				$query = $placedb->query($qry);	
			}
			else
			{
				$query = $this->db->query($qry);
			}
		
		if($query->num_rows()> 0)
		{
			return false;
		}
		else
		{
			return true;
		}		
	}
	/**	
	* @check whther tag name already exist
	*/

	public function checkTagName($tagName, $placeId = 0,$config=0)
    {
		if($config!=0){
			$placedb = $this->load->database($config,TRUE);		
		}
		
		$qry = 'SELECT userId FROM teeme_users WHERE workPlaceId = \''.$placeId.'\' AND tagName = \''.$this->db->escape_str($tagName).'\'';
		
		if ($config!=0)
		{
			$query = $placedb->query($qry);	
		}
		else
		{
			$query = $this->db->query($qry);
		}
		
		if($query->num_rows()> 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}

	/**	
	* @check whether user is manager or not
	*/

	public function checkManager($userId, $placeId, $placeType)
    {			
		$query = $this->db->query('SELECT managerId FROM teeme_managers WHERE managerId = '.$userId.' AND placeId = '.$placeId.' AND placeType='.$placeType);	
		if($query->num_rows()> 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	/**	
	* @check whther work place already exist
	*/

	public function checkWorkPlace($workPlace)
    {
		$config = array();
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);	
		$qry = 'SELECT workPlaceId FROM teeme_work_place WHERE companyName = \''.$workPlace.'\'';		
		$query = $instancedb->query($qry);
	
		if($query->num_rows()> 0)
		{
			return false;
		}
		else
		{
			return true;
		}		
	}

	public function checkWorkSpace($workSpaceName,$workPlaceId)
    {		
		$query = $this->db->query('SELECT workSpaceId FROM teeme_work_space WHERE workSpaceName = \''.$this->db->escape_str($workSpaceName).'\' AND workPlaceId = \''.$workPlaceId.'\' AND deleted=0');	
		if($query->num_rows()> 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}


	public function checkSubSpace($subSpaceName,$workSpaceId)
    {		
		$query = $this->db->query('SELECT subWorkSpaceId FROM teeme_sub_work_space WHERE subWorkSpaceName = \''.$this->db->escape_str($subSpaceName).'\' AND workSpaceId = \''.$workSpaceId.'\'');	
		if($query->num_rows()> 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	/**	
	* @return all the work places detail
	*/

	public function getWorkPlaces($placeOrder='')
    {	
		$config = array();
		$instancedb = '';
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config, TRUE);	

		$workPlaceDetails = array();
		if($placeOrder!='' && $placeOrder=='ASC')
		{
			$qry = "SELECT * FROM teeme_work_place ORDER BY companyName ASC";
		}
		else
		{
			$qry = "SELECT * FROM teeme_work_place ORDER BY companyCreatedDate DESC";	
		}
		$query = $instancedb->query($qry);	

		if($query->num_rows()> 0)
		{
			$i = 0;	
		
			foreach($query->result() as $row)
			{
				
				$workPlaceDetails[$i]['workPlaceId'] 		= $row->workPlaceId;
				$workPlaceDetails[$i]['companyName'] 		= $row->companyName;
				$workPlaceDetails[$i]['workPlaceManagerId'] = $row->workPlaceManagerId;
				$workPlaceDetails[$i]['companyCreatedDate'] = $row->companyCreatedDate;
				$workPlaceDetails[$i]['status'] 			= $row->status;
				$workPlaceDetails[$i]['server'] 			= $row->server;
				$workPlaceDetails[$i]['server_username'] 	= $row->server_username;
				$workPlaceDetails[$i]['server_password'] 	= $row->server_password;
				//Manoj: return place expiry date during cron job
				$workPlaceDetails[$i]['placeExpDate'] 	= $row->ExpireDate;
				$i++;
			}	
		}	
	
		return $workPlaceDetails;	
	}	
	
	/** Get All The Editor from the database **/
	function getEditors ()
	{
		$editorDetails = array();			
		$query = $this->db->query('SELECT * FROM teeme_editors');	
		if($query->num_rows()> 0)
		{
			$i = 0;	
			foreach($query->result() as $row)
			{
				$editorDetails[$i]['editorId'] 		= $row->id;
				$editorDetails[$i]['editorName'] 	= $row->name;
				$editorDetails[$i]['editorStatus'] 	= $row->active;
				$i++;
			}	
		}	
		return $editorDetails;	
	}


	function getEditorOptions ($editor_id)
	{
	
		$editorDetails = array();			
		$qry = "SELECT * FROM teeme_editor_options WHERE editor_id='".$editor_id."' ORDER BY ordering";
		
		$query = $this->db->query($qry);
		if($query->num_rows()> 0)
		{
			$i = 0;	
			foreach($query->result() as $row)
			{
				$editorDetails[$i]['optionId'] 		= $row->id;
				$editorDetails[$i]['optionName'] 	= $row->name;
				$editorDetails[$i]['optionAllowed'] 	= $row->allowed;
				$i++;
			}	
		}	
		return $editorDetails;	
	}
	/**	
	* @return all the work spaces of current work place
	*/

	public function getWorkSpacesByWorkPlaceId($workPlaceId, $userId)
    {	
		$workSpaceDetails = array();	
	
		$query = $this->db->query('SELECT b.workSpaceId, b.status, b.workPlaceId, b.workSpaceName, date_format(b.workSpaceCreatedDate, \'%Y-%m-%d %H:%i:%s\') as workSpaceCreatedDate FROM teeme_work_space_members a, teeme_work_space b WHERE a.workSpaceId = b.workSpaceId AND b.workPlaceId = '.$workPlaceId.' AND a.workSpaceUserId = '.$userId.' AND b.status = 1');	
		if($query->num_rows()> 0)
		{
			$i = 0;	
			foreach($query->result() as $row)
			{
				$workSpaceDetails[$i]['workSpaceId'] 		= $row->workSpaceId;
				$workSpaceDetails[$i]['status'] 			= $row->status;
				$workSpaceDetails[$i]['workPlaceId'] 		= $row->workPlaceId;
				$workSpaceDetails[$i]['workSpaceName'] 		= $row->workSpaceName;
				$workSpaceDetails[$i]['workSpaceManagerId'] = $row->workSpaceManagerId;
				$workSpaceDetails[$i]['workSpaceCreatedDate'] = $row->workSpaceCreatedDate;
				$i++;
			}	
		}	
		return $workSpaceDetails;	
	}	


	public function getWorkSpacesByWorkPlaceId2($workPlaceId,$order_by='')
    {	
		$workSpaceDetails = array();
		
			if ($order_by=='')
			{
				$order_by = 'ORDER BY b.workSpaceName ASC';
			}
			else
			{
				$order_by = 'ORDER BY b.workSpaceCreatedDate DESC';
			}	

		$qry = 'SELECT b.workSpaceId, b.status, b.workPlaceId, b.workSpaceName, b.workSpaceCreatedDate as workSpaceCreatedDate FROM teeme_work_space b WHERE b.workPlaceId = '.$workPlaceId.' AND b.deleted=0 '.$order_by.'';	
	
		$query = $this->db->query($qry);	
		//echo $qry; exit;
		if($query->num_rows()> 0)
		{
			$i = 0;	
			foreach($query->result() as $row)
			{
				$workSpaceDetails[$i]['workSpaceId'] 		= $row->workSpaceId;
				$workSpaceDetails[$i]['status'] 			= $row->status;
				$workSpaceDetails[$i]['workPlaceId'] 		= $row->workPlaceId;
				$workSpaceDetails[$i]['workSpaceName'] 		= $row->workSpaceName;
				$workSpaceDetails[$i]['workSpaceManagerId'] = $row->workSpaceManagerId;
				$workSpaceDetails[$i]['workSpaceCreatedDate'] = $row->workSpaceCreatedDate;
				$i++;
			}	
		}	
		return $workSpaceDetails;	
	}

	/*Changed by Dashrath- Add $config for load db*/
	public function getAllWorkSpacesByWorkPlaceId($workPlaceId, $userId, $config=0)
    {	
		$workSpaceDetails = array();	
		
		/*Changed by Dashrath- Add if else condition for load db*/
		if ($config!=0)
        {
            $placedb = $this->load->database($config,TRUE);

            $query = $placedb->query('SELECT b.workSpaceId, b.workPlaceId, b.workSpaceName, b.workSpaceCreatedDate, status, deleted FROM teeme_work_space b WHERE b.workPlaceId = '.$workPlaceId.' AND b.status = 1 ORDER BY b.workSpaceName ASC');
        }
		else
		{
			$query = $this->db->query('SELECT b.workSpaceId, b.workPlaceId, b.workSpaceName, b.workSpaceCreatedDate, status, deleted FROM teeme_work_space b WHERE b.workPlaceId = '.$workPlaceId.' AND b.status = 1 ORDER BY b.workSpaceName ASC');
		}
		/*Dashrath- changes end*/	

			
		
		if($query->num_rows()> 0)
		{
			$i = 0;	
			foreach($query->result() as $row)
			{
				$workSpaceDetails[$i]['workSpaceId'] 			= $row->workSpaceId;
				$workSpaceDetails[$i]['workPlaceId'] 			= $row->workPlaceId;
				$workSpaceDetails[$i]['workSpaceName'] 			= $row->workSpaceName;
				$workSpaceDetails[$i]['workSpaceManagerId'] 	= $row->workSpaceManagerId;
				$workSpaceDetails[$i]['workSpaceCreatedDate'] 	= $row->workSpaceCreatedDate;
				$workSpaceDetails[$i]['status'] 				= $row->status;
				$workSpaceDetails[$i]['deleted'] 				= $row->deleted;
				$i++;
			}	
		}	
		return $workSpaceDetails;	
	}
	/**	
	* @return all the sub work spaces of current work space
	*/

	public function getSubWorkSpacesByWorkSpaceId($workSpaceId)
    {	
		$subWorkSpaceDetails = array();		
		if ($workSpaceId!='')
		{	
			$query = $this->db->query('SELECT subWorkSpaceId, workSpaceId, subWorkSpaceName, subWorkSpaceManagerId, subWorkSpaceCreatedDate, status FROM teeme_sub_work_space WHERE workSpaceId = '.$workSpaceId.' ORDER BY subWorkSpaceName ASC');	
			if($query->num_rows()> 0)
			{
				$i = 0;	
				foreach($query->result() as $row)
				{
					$subWorkSpaceDetails[$i]['subWorkSpaceId'] 			= $row->subWorkSpaceId;
					$subWorkSpaceDetails[$i]['workSpaceId'] 			= $row->workSpaceId;
					$subWorkSpaceDetails[$i]['subWorkSpaceName'] 		= $row->subWorkSpaceName;
					$subWorkSpaceDetails[$i]['subWorkSpaceManagerId'] 	= $row->subWorkSpaceManagerId;
					$subWorkSpaceDetails[$i]['subWorkSpaceCreatedDate'] = $row->subWorkSpaceCreatedDate;
					$subWorkSpaceDetails[$i]['status'] 					= $row->status;
					$i++;
				}	
			}	
		}
		return $subWorkSpaceDetails;	
	}	

	
	/**	
	* @return all the members of work place
	*/

	public function getWorkPlaceMembersByWorkPlaceId($workPlaceId)
    { 
		$userData = array();
		$query = $this->db->query('SELECT * FROM teeme_users WHERE workPlaceId='.$workPlaceId.' ORDER BY firstName ASC');
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				$userData[$i]['userId'] 		= $row->userId;	
				$userData[$i]['workPlaceId'] 	= $row->workPlaceId;
				$userData[$i]['userName']	 	= $row->userName;	
				$userData[$i]['password'] 		= $row->password;	
				$userData[$i]['userCommunityId'] = $row->userCommunityId;
				$userData[$i]['userTitle'] 		= $row->userTitle;									
				$userData[$i]['firstName'] 		= $row->firstName;
				$userData[$i]['lastName'] 		= $row->lastName;		
				$userData[$i]['address1'] 		= $row->address1;
				$userData[$i]['address2'] 		= $row->address2;	
				$userData[$i]['city'] 			= $row->city;		
				$userData[$i]['state'] 			= $row->state;			
				$userData[$i]['country'] 		= $row->country;	
				$userData[$i]['zip'] 			= $row->zip;		
				$userData[$i]['phone'] 			= $row->phone;	
				$userData[$i]['mobile'] 		= $row->mobile;		
				$userData[$i]['email'] 			= $row->email;
				$userData[$i]['status'] 		= $row->status;			
				$userData[$i]['emailSent'] 		= $row->emailSent;	
				$userData[$i]['registeredDate']	= $row->registeredDate;		
				$userData[$i]['activation'] 	= $row->activation;	
				$userData[$i]['photo'] 			= $row->photo;	
				$userData[$i]['statusUpdate'] 	= $row->statusUpdate;
				$userData[$i]['other'] 			= $row->other;
				$userData[$i]['userGroup'] 		= $row->userGroup;
				$userData[$i]['isPlaceManager'] = $row->isPlaceManager;
				if($row->nickName!='')
				{
					$userData[$i]['userTagName']	= $row->nickName;
					$userData[$i]['tagName'] 		= $row->nickName;	
				}
				else
				{
					$userData[$i]['userTagName']	= $row->tagName;	
					$userData[$i]['tagName'] 		= $row->tagName;
				}
				$i++;										
			}				
		}					
		return $userData;				
	}	


	public function getWorkPlaceMembersByWorkPlaceIdSearch($workPlaceId=0,$search='')
    {
		$userData = array();
		$qry = 'SELECT * FROM teeme_users WHERE workPlaceId='.$workPlaceId.' AND tagName LIKE (\''.$search.'%\') OR tagName LIKE(\'pm_'.$search.'%\') ORDER BY firstName ASC';
		$query = $this->db->query($qry);
		//echo $qry; exit;
		
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				$userData[$i]['userId'] 		= $row->userId;	
				$userData[$i]['workPlaceId'] 	= $row->workPlaceId;
				$userData[$i]['userName']	 	= $row->userName;	
				$userData[$i]['password'] 		= $row->password;	
				$userData[$i]['userCommunityId'] = $row->userCommunityId;
				$userData[$i]['userTitle'] 		= $row->userTitle;									
				$userData[$i]['firstName'] 		= $row->firstName;
				$userData[$i]['lastName'] 		= $row->lastName;		
				$userData[$i]['address1'] 		= $row->address1;
				$userData[$i]['address2'] 		= $row->address2;	
				$userData[$i]['city'] 			= $row->city;		
				$userData[$i]['state'] 			= $row->state;			
				$userData[$i]['country'] 		= $row->country;	
				$userData[$i]['zip'] 			= $row->zip;		
				$userData[$i]['phone'] 			= $row->phone;	
				$userData[$i]['mobile'] 		= $row->mobile;		
				$userData[$i]['email'] 			= $row->email;
				$userData[$i]['status'] 		= $row->status;			
				$userData[$i]['emailSent'] 		= $row->emailSent;	
				$userData[$i]['registeredDate']	= $row->registeredDate;		
				$userData[$i]['activation'] 	= $row->activation;	
				$userData[$i]['photo'] 			= $row->photo;	
				$userData[$i]['statusUpdate'] 	= $row->statusUpdate;
				$userData[$i]['other'] 			= $row->other;
				$userData[$i]['userGroup'] 		= $row->userGroup;
				$userData[$i]['isPlaceManager'] = $row->isPlaceManager;
				if($row->nickName!='')
				{
					$userData[$i]['tagName'] 		= $row->nickName;
					$userData[$i]['userTagName']	= $row->nickName;	
				}
				else
				{
					$userData[$i]['tagName'] 		= $row->tagName;
					$userData[$i]['userTagName']	= $row->tagName;
				}		
				$i++;										
			}				
		}					
		return $userData;				
	}
	/**	
	* @return all the members of work space
	*/

	public function getWorkSpaceMembersByWorkSpaceId($workSpaceId, $chat=0)
    {
		$userData = array();
		$userId = $_SESSION['userId'];
		$workplaceId = $_SESSION['workPlaceId'];
		if($workSpaceId == 0 && $chat ==0)
		{
			$query = $this->db->query('SELECT DISTINCT * FROM teeme_users WHERE userId ='.$userId.' ORDER BY firstName ASC');
		}
		else if($workSpaceId == 0 && $chat ==1)
		{
			$query = $this->db->query('SELECT DISTINCT * FROM teeme_users WHERE workPlaceId ='.$workplaceId.' ORDER BY firstName ASC');
		}
		else
		{
			//Memcache code start here
			/*$memc=$this->createMemcacheObject();

			$memCacheId = 'wp'.$workSpaceId.'users1'.'place'.$_SESSION['workPlaceId'];	
			
			$tree = $memc->get($memCacheId);
			
			if(!$tree)
			{*/
			
				 $query = $this->db->query('SELECT DISTINCT b.* FROM teeme_work_space_members a, teeme_users b WHERE a.workSpaceUserId = b.userId AND a.workSpaceId='.$workSpaceId.' ORDER BY firstName ASC');
				
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}	
					
					/*$memc->set($memCacheId, $tree);	
					$tree = $memc->get($memCacheId);*/
								
				}
			/*}*/
			
			if(count($tree) > 0)
			{
				$i = 0;
				foreach ($tree as $row)
				{
					$userData[$i]['userId'] 		= $row->userId;	
					$userData[$i]['workPlaceId'] 	= $row->workPlaceId;
					$userData[$i]['userName']	 	= $row->userName;	
					$userData[$i]['password'] 		= $row->password;
					$userData[$i]['userCommunityId'] = $row->userCommunityId;
					$userData[$i]['userTitle'] 		= $row->userTitle;									
					$userData[$i]['firstName'] 		= $row->firstName;	
					$userData[$i]['lastName'] 		= $row->lastName;		
					$userData[$i]['address1'] 		= $row->address1;
					$userData[$i]['address2'] 		= $row->address2;	
					$userData[$i]['city'] 			= $row->city;		
					$userData[$i]['state'] 			= $row->state;			
					$userData[$i]['country'] 		= $row->country;	
					$userData[$i]['zip'] 			= $row->zip;		
					$userData[$i]['phone'] 			= $row->phone;	
					$userData[$i]['mobile'] 		= $row->mobile;		
					$userData[$i]['email'] 			= $row->email;
					$userData[$i]['status'] 		= $row->status;			
					$userData[$i]['emailSent'] 		= $row->emailSent;	
					$userData[$i]['registeredDate']	= $row->registeredDate;		
					$userData[$i]['lastLoginTime']	= $row->lastLoginTime;	
					$userData[$i]['activation'] 	= $row->activation;	
					$userData[$i]['photo'] 			= $row->photo;	
					$userData[$i]['statusUpdate'] 	= $row->statusUpdate;
					$userData[$i]['other'] 			= $row->other;
					$userData[$i]['role'] 			= $row->role;
					$userData[$i]['skills'] 		= $row->skills;
					$userData[$i]['department'] 	= $row->department;				
					$userData[$i]['userGroup'] 		= $row->userGroup;
					$userData[$i]['isPlaceManager'] = $row->isPlaceManager;
					if($row->nickName!='')
					{
						$userData[$i]['userTagName']	= $row->nickName;	
						$userData[$i]['tagName'] 		= $row->nickName;
					}
					else
					{
						$userData[$i]['userTagName']	= $row->tagName;	
						$userData[$i]['tagName'] 		= $row->tagName;
					}
					$i++;	
	
				}
			}	
			
		}
		//return $chat;
		if($workSpaceId == 0 && ($chat == 0 || $chat ==1) )
		{
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach($query->result() as $row)
				{
					$userData[$i]['userId'] 		= $row->userId;	
					$userData[$i]['workPlaceId'] 	= $row->workPlaceId;
					$userData[$i]['userName']	 	= $row->userName;	
					$userData[$i]['password'] 		= $row->password;
					$userData[$i]['userCommunityId'] = $row->userCommunityId;
					$userData[$i]['userTitle'] 		= $row->userTitle;									
					$userData[$i]['firstName'] 		= $row->firstName;	
					$userData[$i]['lastName'] 		= $row->lastName;		
					$userData[$i]['address1'] 		= $row->address1;
					$userData[$i]['address2'] 		= $row->address2;	
					$userData[$i]['city'] 			= $row->city;		
					$userData[$i]['state'] 			= $row->state;			
					$userData[$i]['country'] 		= $row->country;	
					$userData[$i]['zip'] 			= $row->zip;		
					$userData[$i]['phone'] 			= $row->phone;	
					$userData[$i]['mobile'] 		= $row->mobile;		
					$userData[$i]['email'] 			= $row->email;
					$userData[$i]['status'] 		= $row->status;			
					$userData[$i]['emailSent'] 		= $row->emailSent;	
					$userData[$i]['registeredDate']	= $row->registeredDate;		
					$userData[$i]['lastLoginTime']	= $row->lastLoginTime;	
					$userData[$i]['activation'] 	= $row->activation;	
					$userData[$i]['photo'] 			= $row->photo;	
					$userData[$i]['statusUpdate'] 	= $row->statusUpdate;
					$userData[$i]['other'] 			= $row->other;
					$userData[$i]['role'] 			= $row->role;
					$userData[$i]['skills'] 		= $row->skills;
					$userData[$i]['department'] 	= $row->department;				
					$userData[$i]['userGroup'] 		= $row->userGroup;
					$userData[$i]['isPlaceManager'] = $row->isPlaceManager;
					if($row->nickName!='')
					{
						$userData[$i]['userTagName']	= $row->nickName;	
						$userData[$i]['tagName'] 		= $row->nickName;
					}
					else
					{
						$userData[$i]['userTagName']	= $row->tagName;	
						$userData[$i]['tagName'] 		= $row->tagName;
					}
					$i++;										
				}				
			}
		}	
					
		return $userData;				
	}	


	 /**
	* This method will be used for fetch the sub work space Members from the database.
 	* @param $subWorkspaceId This is the variable used to hold the work space ID .
	* @return The work space details
	*/
	public function getSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId)
	{
		$subWorkSpaceMembersData = array();	
		
		//Memcache code start here
		$memc=$this->createMemcacheObject();

		$memCacheId = 'wp'.$subWorkSpaceId.'users2'.'place'.$_SESSION['workPlaceId'];	
			
		$tree = $memc->get($memCacheId);
			
		if(!$tree)
		{	
	
			$q = 'SELECT a.*,b.* FROM teeme_sub_work_space_members a, teeme_users b WHERE a.subWorkSpaceUserId = b.userId AND a.subWorkSpaceId='.$subWorkSpaceId.' ORDER BY b.firstName ASC';
			$query = $this->db->query ($q);
			
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}	
					
					$memc->set($memCacheId, $tree);	
					$tree = $memc->get($memCacheId);
								
				}
		}
		if(count($tree) > 0)
		{
			$i = 0;
			foreach($tree as $row)
			{										
				$subWorkSpaceMembersData[$i]['subWorkSpaceMembersId']	= $row->subWorkSpaceMembersId;	
				$subWorkSpaceMembersData[$i]['subWorkSpaceId']			= $row->subWorkSpaceId;		
				$subWorkSpaceMembersData[$i]['subWorkSpaceUserId']		= $row->subWorkSpaceUserId;	
				$subWorkSpaceMembersData[$i]['userId']					= $row->subWorkSpaceUserId;				
				$subWorkSpaceMembersData[$i]['subWorkSpaceUserAccess']	= $row->subWorkSpaceUserAccess;
				$subWorkSpaceMembersData[$i]['firstName']				= $row->firstName;
				$subWorkSpaceMembersData[$i]['lastName']				= $row->lastName;	
				$subWorkSpaceMembersData[$i]['registeredDate']			= $row->registeredDate;		
				$subWorkSpaceMembersData[$i]['lastLoginTime']			= $row->lastLoginTime;	
				if($row->nickName!='')
				{
					$subWorkSpaceMembersData[$i]['tagName']	= $row->nickName;	
				}
				else
				{
					$subWorkSpaceMembersData[$i]['tagName']	= $row->tagName;	
				}					
				$i++;													
			}				
		}					
		return $subWorkSpaceMembersData;				



	}	
	

	public function getWorkSpaceMembersByWorkSpaceIdSearch($workSpaceId, $chat=0, $search='')
    {
		$userData = array();
		$userId = $_SESSION['userId'];
		$workplaceId = $_SESSION['workPlaceId'];
		if($workSpaceId == 0 && $chat ==0)
		{
			$q = 'SELECT * FROM teeme_users WHERE workPlaceId ='.$workplaceId.' AND tagName LIKE (\''.$search.'%\') ORDER BY tagName ASC';
			$query = $this->db->query('SELECT * FROM teeme_users WHERE workPlaceId ='.$workplaceId.' AND tagName LIKE (\''.$search.'%\') ORDER BY tagName ASC');
		}
		else if($workSpaceId == 0 && $chat ==1)
		{
			$query = $this->db->query('SELECT * FROM teeme_users WHERE workPlaceId ='.$workplaceId.' AND tagName LIKE (\''.$search.'%\') ORDER BY tagName ASC');
		}
		else
		{
			$query = $this->db->query('SELECT b.* FROM teeme_work_space_members a, teeme_users b WHERE a.workSpaceUserId = b.userId AND a.workSpaceId='.$workSpaceId.' AND tagName LIKE (\''.$search.'%\') ORDER BY tagName ASC');
		}
		
	
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				$userData[$i]['userId'] 		= $row->userId;	
				$userData[$i]['workPlaceId'] 	= $row->workPlaceId;
				$userData[$i]['userName']	 	= $row->userName;	
				$userData[$i]['password'] 		= $row->password;
				$userData[$i]['userCommunityId'] = $row->userCommunityId;
				$userData[$i]['userTitle'] 		= $row->userTitle;									
				$userData[$i]['firstName'] 		= $row->firstName;	
				$userData[$i]['lastName'] 		= $row->lastName;		
				$userData[$i]['address1'] 		= $row->address1;
				$userData[$i]['address2'] 		= $row->address2;	
				$userData[$i]['city'] 			= $row->city;		
				$userData[$i]['state'] 			= $row->state;			
				$userData[$i]['country'] 		= $row->country;	
				$userData[$i]['zip'] 			= $row->zip;		
				$userData[$i]['phone'] 			= $row->phone;	
				$userData[$i]['mobile'] 		= $row->mobile;		
				$userData[$i]['email'] 			= $row->email;
				$userData[$i]['status'] 		= $row->status;			
				$userData[$i]['emailSent'] 		= $row->emailSent;	
				$userData[$i]['registeredDate']	= $row->registeredDate;		
				$userData[$i]['lastLoginTime']	= $row->lastLoginTime;	
				$userData[$i]['activation'] 	= $row->activation;	
				$userData[$i]['photo'] 			= $row->photo;	
				$userData[$i]['statusUpdate'] 	= $row->statusUpdate;
				$userData[$i]['other'] 			= $row->other;
				$userData[$i]['role'] 			= $row->role;
				$userData[$i]['skills'] 		= $row->skills;
				$userData[$i]['department'] 	= $row->department;					
				$userData[$i]['userGroup'] 		= $row->userGroup;
				$userData[$i]['isPlaceManager'] = $row->isPlaceManager;
				if($row->nickName!='')
				{
					$userData[$i]['tagName'] 		= $row->nickName;
					$userData[$i]['userTagName']	= $row->nickName;	
				}
				else
				{
					$userData[$i]['tagName'] 		= $row->tagName;
					$userData[$i]['userTagName']	= $row->tagName;		
				}	
				$i++;										
			}				
		}	
					
		return $userData;				
	}


	public function getSubWorkSpaceMembersIdBySubWorkSpaceId($workSpaceId, $chat=0)
    {
		$userData = array();
		$userId = $_SESSION['userId'];
		$workplaceId = $_SESSION['workPlaceId'];

		$query = $this->db->query('SELECT b.* FROM teeme_sub_work_space_members a, teeme_users b WHERE a.subWorkSpaceUserId = b.userId AND a.subWorkSpaceId='.$workSpaceId.' ORDER BY tagName ASC');

		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				$userData[$i]['userId'] 		= $row->userId;	
				$userData[$i]['workPlaceId'] 	= $row->workPlaceId;
				$userData[$i]['userName']	 	= $row->userName;	
				$userData[$i]['password'] 		= $row->password;
					
				$userData[$i]['userCommunityId'] = $row->userCommunityId;
				$userData[$i]['userTitle'] 		= $row->userTitle;									
				$userData[$i]['firstName'] 		= $row->firstName;	
				
				$userData[$i]['lastName'] 		= $row->lastName;		
				$userData[$i]['address1'] 		= $row->address1;
				$userData[$i]['address2'] 		= $row->address2;	
				$userData[$i]['city'] 			= $row->city;		
				$userData[$i]['state'] 			= $row->state;			
				$userData[$i]['country'] 		= $row->country;	
				$userData[$i]['zip'] 			= $row->zip;		
				$userData[$i]['phone'] 			= $row->phone;	
				$userData[$i]['mobile'] 		= $row->mobile;		
				$userData[$i]['email'] 			= $row->email;
				$userData[$i]['status'] 		= $row->status;			
				$userData[$i]['emailSent'] 		= $row->emailSent;	
				$userData[$i]['registeredDate']	= $row->registeredDate;		
				$userData[$i]['lastLoginTime']	= $row->lastLoginTime;	
				$userData[$i]['activation'] 	= $row->activation;	
				$userData[$i]['photo'] 			= $row->photo;	
				$userData[$i]['statusUpdate'] 	= $row->statusUpdate;
				$userData[$i]['other'] 			= $row->other;
				$userData[$i]['role'] 			= $row->role;
				$userData[$i]['skills'] 		= $row->skills;
				$userData[$i]['department'] 	= $row->department;					
				$userData[$i]['userGroup'] 		= $row->userGroup;
				$userData[$i]['isPlaceManager'] = $row->isPlaceManager;
				if($row->nickName!='')
				{
					$userData[$i]['tagName'] 		= $row->nickName;		
					$userData[$i]['userTagName']	= $row->nickName;		
				}
				else
				{
					$userData[$i]['tagName'] 		= $row->tagName;		
					$userData[$i]['userTagName']	= $row->tagName;	
				}	
				$i++;										
			}				
		}					
		return $userData;				
	}
	
	
	public function getSubWorkSpaceMembersIdBySubWorkSpaceIdSearch($workSpaceId, $chat=0,$search='')
    {
		$userData = array();
		$userId = $_SESSION['userId'];
		$workplaceId = $_SESSION['workPlaceId'];

		$query = $this->db->query('SELECT b.* FROM teeme_sub_work_space_members a, teeme_users b WHERE a.subWorkSpaceUserId = b.userId AND a.subWorkSpaceId='.$workSpaceId.' AND b.userId!=1 AND tagName LIKE (\''.$search.'%\') ORDER BY tagName ASC');

		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				$userData[$i]['userId'] 		= $row->userId;	
				$userData[$i]['workPlaceId'] 	= $row->workPlaceId;
				$userData[$i]['userName']	 	= $row->userName;	
				$userData[$i]['password'] 		= $row->password;
				$userData[$i]['userCommunityId'] = $row->userCommunityId;
				$userData[$i]['userTitle'] 		= $row->userTitle;									
				$userData[$i]['firstName'] 		= $row->firstName;	
				$userData[$i]['lastName'] 		= $row->lastName;		
				$userData[$i]['address1'] 		= $row->address1;
				$userData[$i]['address2'] 		= $row->address2;	
				$userData[$i]['city'] 			= $row->city;		
				$userData[$i]['state'] 			= $row->state;			
				$userData[$i]['country'] 		= $row->country;	
				$userData[$i]['zip'] 			= $row->zip;		
				$userData[$i]['phone'] 			= $row->phone;	
				$userData[$i]['mobile'] 		= $row->mobile;		
				$userData[$i]['email'] 			= $row->email;
				$userData[$i]['status'] 		= $row->status;			
				$userData[$i]['emailSent'] 		= $row->emailSent;	
				$userData[$i]['registeredDate']	= $row->registeredDate;		
				$userData[$i]['lastLoginTime']	= $row->lastLoginTime;	
				$userData[$i]['activation'] 	= $row->activation;	
				$userData[$i]['photo'] 			= $row->photo;	
				$userData[$i]['statusUpdate'] 	= $row->statusUpdate;
				$userData[$i]['other'] 			= $row->other;
				$userData[$i]['role'] 			= $row->role;
				$userData[$i]['skills'] 		= $row->skills;
				$userData[$i]['department'] 	= $row->department;					
				$userData[$i]['userGroup'] 		= $row->userGroup;
				$userData[$i]['isPlaceManager'] = $row->isPlaceManager;
				if($row->nickName!='')
				{
					$userData[$i]['tagName'] 		= $row->nickName;	
					$userData[$i]['userTagName']	= $row->nickName;	
				}
				else
				{
					$userData[$i]['tagName'] 		= $row->tagName;
					$userData[$i]['userTagName']	= $row->tagName;	
				}		
				$i++;										
			}				
		}					
		return $userData;				
	}

	
	public function updatePlaceLogo ($companyLogo,$placeId,$config=0)
	{
		if($config!=0){
			$placedb = $this->load->database($config,TRUE);	
			
			//transaction begin here
			$placedb->trans_begin();	
		}
		else
		{
			$this->db->trans_begin();	
		}
		$strResultSQL  = "UPDATE teeme_work_place SET companyLogo='".$companyLogo."' WHERE workPlaceId='".$placeId."'";
		
		if($config!=0){
			$bResult = $placedb->query($strResultSQL); 
			
			//Checking transaction status here
			if($placedb->trans_status()=== FALSE)
			{
				$placedb->trans_rollback();
				return false;
			}
			else
			{
				$placedb->trans_commit();
				return true;
			}			
		}
		else{
			$bResult = $this->db->query($strResultSQL);
			
			//Checking transaction status here
			if($this->db->trans_status()=== FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return true;
			}
		}
		/*if($bResult)
		{									
			return true;
		}	
		else
		{
			return false;
		}*/
	}


	 /**
	* This method will be used for fetch the user detailse from the database.
 	* @param $userId This is the variable used to hold the user ID .
	* @return The user details
	*/
	public function getUserDetailsByUserId( $userId )
	{
		if($userId!='')
		{
		$userData = array();
		$query = $this->db->query('SELECT * FROM teeme_users WHERE userId='.$userId);
		if($query->num_rows() > 0)
		{
		
			foreach($query->result() as $row)
			{
				$userData['userId'] 		= $row->userId;	
				$userData['workPlaceId'] 	= $row->workPlaceId;
				$userData['userName']	 	= $row->userName;	
				$userData['password'] 		= $row->password;
				$userData['userCommunityId'] = $row->userCommunityId;
				$userData['userTitle'] 		= $row->userTitle;									
				$userData['firstName'] 		= $row->firstName;
				$userData['lastName'] 		= $row->lastName;		
				$userData['address1'] 		= $row->address1;
				$userData['address2'] 		= $row->address2;	
				$userData['city'] 			= $row->city;		
				$userData['state'] 			= $row->state;			
				$userData['country'] 		= $row->country;	
				$userData['zip'] 			= $row->zip;		
				$userData['phone'] 			= $row->phone;	
				$userData['mobile'] 		= $row->mobile;		
				$userData['email'] 			= $row->email;
				$userData['status'] 		= $row->status;			
				$userData['emailSent'] 		= $row->emailSent;	
				$userData['registeredDate']	= $row->registeredDate;	
				$userData['lastLoginTime']	= $row->lastLoginTime;
				$userData['activation'] 	= $row->activation;
				$userData['photo'] 			= $row->photo;	
				$userData['statusUpdate'] 	= $row->statusUpdate;
				$userData['other'] 			= $row->other;
				$userData['role'] 			= $row->role;
				$userData['department'] 	= $row->department;
				$userData['skills'] 		= $row->skills;
				$userData['userGroup'] 		= $row->userGroup;		
				$userData['isPlaceManager'] = $row->isPlaceManager;		
				$userData['notification_language_id'] = $row->notification_language_id;	
				if($row->nickName!='')
				{
					$userData['tagName'] 		= $row->nickName;
					$userData['userTagName']	= $row->nickName;		
				}
				else
				{
					$userData['tagName'] 		= $row->tagName;
					$userData['userTagName']	= $row->tagName;	
				}	
				$userData['editUserTagName']	= $row->tagName;
				$userData['editNickName']	    = $row->nickName;				
			}				
		}					
		return $userData;	
		}		
	}	
	
	public function getUserDetailsByUsername( $username,$config=0,$workPlaceId=0 )
	{
		$userData = array();
		$qry = "SELECT * FROM teeme_users WHERE userName='".$username."'";
		
		//Manoj: add extra condition to check workplace id
		if($workPlaceId>0)
		{
			$qry .= " AND workPlaceId ='".$workPlaceId."'";
		}
		//Manoj: code end
		
                if ($config!=0)
                {
                    $placedb = $this->load->database($config,TRUE);
                    $query = $placedb->query($qry);
                }
				else
				{
					$query = $this->db->query($qry);
				}
		if($query->num_rows() > 0)
		{		
			foreach($query->result() as $row)
			{
				$userData['userId'] 		= $row->userId;	
				$userData['workPlaceId'] 	= $row->workPlaceId;
				$userData['userName']	 	= $row->userName;	
				$userData['password'] 		= $row->password;
				$userData['tagName'] 		= $row->tagName;	
				$userData['userCommunityId'] = $row->userCommunityId;
				$userData['userTitle'] 		= $row->userTitle;									
				$userData['firstName'] 		= $row->firstName;
				$userData['userTagName']	= $row->tagName;		
				$userData['lastName'] 		= $row->lastName;		
				$userData['address1'] 		= $row->address1;
				$userData['address2'] 		= $row->address2;	
				$userData['city'] 			= $row->city;		
				$userData['state'] 			= $row->state;			
				$userData['country'] 		= $row->country;	
				$userData['zip'] 			= $row->zip;		
				$userData['phone'] 			= $row->phone;	
				$userData['mobile'] 		= $row->mobile;		
				$userData['email'] 			= $row->email;
				$userData['status'] 		= $row->status;			
				$userData['emailSent'] 		= $row->emailSent;	
				$userData['registeredDate']	= $row->registeredDate;	
				$userData['lastLoginTime']	= $row->lastLoginTime;
				$userData['activation'] 	= $row->activation;
				$userData['photo'] 			= $row->photo;	
				$userData['statusUpdate'] 	= $row->statusUpdate;
				$userData['other'] 			= $row->other;
				$userData['role'] 			= $row->role;
				$userData['department'] 	= $row->department;
				$userData['userGroup'] 		= $row->userGroup;		
				$userData['isPlaceManager'] = $row->isPlaceManager;
				$userData['needPasswordReset'] = $row->needPasswordReset;
				$userData['defaultSpace'] = $row->defaultSpace;	
				$userData['userTimezone'] = $row->userTimezone;		
				$userData['nickName'] = $row->nickName;	
				$userData['terms'] = $row->terms;
				/*Added by Dashrath- Add loggedInToken in array for keep me logged in*/
				$userData['loggedInToken'] = $row->loggedInToken;						
			}				
		}					
		return $userData;			
	}	
	
	function getUserNameByUserId ($userId)
	{
		$query = $this->db->query("SELECT tagName FROM teeme_users WHERE userId='".$userId."'");
		
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					$username = $row->tagName;
				}
			}
		return $username;
	}
	
	public function getPlaceManagerDetailsByPlaceManagerId( $placeManagerId, $config=0 )
	{
		$userData = array();
		$q = 'SELECT * FROM teeme_work_place_managers WHERE id='.$placeManagerId;
		
                if ($config!=0)
                {
                    $placedb = $this->load->database($config,TRUE);
                    $query = $placedb->query($q);
                }

                else
                {
                    $query = $this->db->query($q);	
                }
				
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$userData['userId'] 		= $row->id;	
				$userData['workPlaceId'] 	= $row->placeId;
		
				
				$userData['password'] 		= $row->managerPassword;	
		
				$userData['userCommunityId'] = $row->managerCommunityId;
		
				$userData['firstName'] 		= $row->managerFname;	
			
				$userData['lastName'] 		= $row->managerLname;		
				$userData['address1'] 		= $row->managerAddress;
				$userData['fax'] 			= $row->managerFax;
				$userData['managerOther'] 	= $row->managerOther;
		
				$userData['phone'] 			= $row->managerPhone;	
				$userData['mobile'] 		= $row->managerMobile;		
				$userData['email'] 			= $row->managerEmail;
	
														
			}				
		}					
		return $userData;			
	}		
	
	public function getPlaceManagerDetailsByPlaceId( $placeId )
	{
		$userData = array();
		$query = $this->db->query('SELECT * FROM teeme_work_place_managers WHERE placeId='.$placeId);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$userData['userId'] 		= $row->id;	
				$userData['workPlaceId'] 	= $row->placeId;
			
				
				$userData['password'] 		= $row->managerPassword;	
		
				$userData['userCommunityId'] = $row->managerCommunityId;
		
				$userData['firstName'] 		= $row->managerFname;	
		
				$userData['lastName'] 		= $row->managerLname;		
				$userData['address1'] 		= $row->managerAddress;
				$userData['fax'] 			= $row->managerFax;
				$userData['managerOther'] 	= $row->managerOther;
			
				$userData['phone'] 			= $row->managerPhone;	
				$userData['mobile'] 		= $row->managerMobile;		
				$userData['email'] 			= $row->managerEmail;
		
														
			}				
		}					
		return $userData;			
	}
        

	 /**
	* This method will be used for fetch the user detailse from the database.
 	* @param $userId This is the variable used to hold the user ID .
	* @return The user details
	*/
	public function getUserDetailsByWorkPlaceId($workPlaceId)
	{
		$userData = array();
		$query = $this->db->query('SELECT * FROM teeme_users WHERE workPlaceId='.$workPlaceId);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$userData['userId'] 		= $row->userId;	
				$userData['workPlaceId'] 	= $row->workPlaceId;
				$userData['userName']	 	= $row->userName;	
				$userData['password'] 		= $row->password;
				$userData['tagName'] 		= $row->tagName;	
				$userData['userCommunityId'] = $row->userCommunityId;
				$userData['userTitle'] 		= $row->userTitle;									
				$userData['firstName'] 		= $row->firstName;
				$userData['userTagName']	= $row->tagName;		
				$userData['lastName'] 		= $row->lastName;		
				$userData['address1'] 		= $row->address1;
				$userData['address2'] 		= $row->address2;	
				$userData['city'] 			= $row->city;		
				$userData['state'] 			= $row->state;			
				$userData['country'] 		= $row->country;	
				$userData['zip'] 			= $row->zip;		
				$userData['phone'] 			= $row->phone;	
				$userData['mobile'] 		= $row->mobile;		
				$userData['email'] 			= $row->email;
				$userData['status'] 		= $row->status;			
				$userData['emailSent'] 		= $row->emailSent;	
				$userData['registeredDate']	= $row->registeredDate;		
				$userData['activation'] 	= $row->activation;	
				$userData['photo'] 			= $row->photo;	
				$userData['statusUpdate'] 	= $row->statusUpdate;
				$userData['other'] 			= $row->other;
														
			}				
		}					
		return $userData;			
	}	

	 /**
	* This method will be used t check the manager status.
 	* @param $managerId This is the variable used to hold the work place/workspace/subworkspace manager ID .
	* @check whether user is manager
	*/
	public function getManagerStatus($managerId, $placeId, $placeType)
	{

		if($placeId == 0)
		{
			return true;
		}
		
		$workPlaceData = array();		
		$query = $this->db->query('SELECT managerId FROM teeme_managers WHERE managerId='.$managerId.' AND placeId = '.$placeId);
	
		if($query->num_rows() > 0)
		{
			return true;
		}					
		else
		{
			return false;
		}	
	}
	
	 /**
	* This method will be used to delete the teeme manager.
 	
	*/
	public function deleteTeemeManager($managerId, $placeId, $placeType)
	{
		$workPlaceData = array();
		
		$query = $this->db->query('DELETE FROM teeme_managers WHERE managerId='.$managerId.' AND placeId = '.$placeId.' AND placeType='.$placeType);
		if($query > 0)
		{
			return true;
		}					
		else
		{
			return false;
		}		
	}
	 /**
	* This method will be used for fetch the work place detailse from the database.
 	* @param $workPlaceId This is the variable used to hold the work place ID .
	* @return The work place details
	*/
	public function getWorkPlaceDetails($workPlaceId)
	{
		$workPlaceData = array();
		
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
		
		$query = $instancedb->query('SELECT * FROM teeme_work_place WHERE workPlaceId='.$workPlaceId);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{										
				$workPlaceData['workPlaceId']	 	= $row->workPlaceId;	
				$workPlaceData['workPlaceManagerId']= $row->workPlaceManagerId;	
				$workPlaceData['placeTimezone']		= $row->placeTimezone;		
				$workPlaceData['companyName'] 		= $row->companyName;
				$workPlaceData['companyAddress1'] 	= $row->companyAddress1;
				$workPlaceData['companyAddress2'] 	= $row->companyAddress2;
				$workPlaceData['companyCity'] 		= $row->companyCity;
				$workPlaceData['companyState'] 		= $row->companyState;
				$workPlaceData['companyCountry'] 	= $row->companyCountry;
				$workPlaceData['companyZip'] 		= $row->companyZip;
				$workPlaceData['companyPhone'] 		= $row->companyPhone;
				$workPlaceData['companyFax'] 		= $row->companyFax;
				$workPlaceData['companyOther'] 		= $row->companyOther;
				$workPlaceData['companyCreatedDate']= $row->companyCreatedDate;
				$workPlaceData['status'] 			= $row->status;		
				//$workPlaceData['securityQuestion'] 	= $row->securityQuestion;	
				//$workPlaceData['securityAnswer'] 	= $row->securityAnswer;
				$workPlaceData['companyLogo'] 		= $row->companyLogo;
				$workPlaceData['server'] 			= $row->server;	
				$workPlaceData['server_username'] 	= $row->server_username;
				$workPlaceData['server_password'] 	= $row->server_password;
				$workPlaceData['instanceName'] 		= $row->instanceName;
				$workPlaceData['companyStatus']		= $row->companyStatus;	
				//Manoj: get number of user and exp date
				$workPlaceData['numOfUsers']		= $row->NumOfUsers;
				$workPlaceData['placeExpireDate']	= $row->ExpireDate;	
				$workPlaceData['placeTimezone']	= $row->placeTimezone;		
			}				
		}					
		return $workPlaceData;				

	}


	 /**
	* This method will be used for fetch the work space detailse from the database.
 	* @param $workspaceId This is the variable used to hold the work space ID .
	* @return The work space details
	*/
	public function getWorkSpaceDetailsByWorkSpaceId($workSpaceId)
	{
		
		$workSpaceData = array();		
		$query = $this->db->query('SELECT * FROM teeme_work_space WHERE workSpaceId='.$workSpaceId);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{										
				$workSpaceData['workSpaceId']	 		= $row->workSpaceId;	
				$workSpaceData['workSpaceName']			= $row->workSpaceName;		
				$workSpaceData['workSpaceManagerId'] 	= $row->workSpaceManagerId;
				$workSpaceData['treeAccess']			= $row->treeAccess;	
				$workSpaceData['workSpaceCreatedDate']	= $row->workSpaceCreatedDate;	
				$workSpaceData['status']				= $row->status;
				$workSpaceData['workSpaceCreatorId']	= $row->workSpaceCreatorId;
			}				
		}				
		return $workSpaceData;				
	}	
	
	 /**
	* This method will be used for fetch the sub work space detailse from the database.
 	* @param $subWorkspaceId This is the variable used to hold the work space ID .
	* @return The work space details
	*/
	public function getWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId)
	{
		$workSpaceData = array();		
		$query = $this->db->query('SELECT a.* FROM teeme_work_space a, teeme_sub_work_space b WHERE a.workSpaceId = b.workSpaceId AND b.subWorkSpaceId='.$subWorkSpaceId);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{										
				$workSpaceData['workSpaceId']	 		= $row->workSpaceId;	
				$workSpaceData['workSpaceName']			= $row->workSpaceName;		
				$workSpaceData['workSpaceCreatedDate']	= $row->workSpaceCreatedDate;		
				$workSpaceData['workSpaceManagerId'] 	= $row->workSpaceManagerId;		
				$workSpaceData['status']				= $row->status;								
			}				
		}					
		return $workSpaceData;		
	}	

	 /**
	* This method will be used for fetch the chat detailse from the database.
 	* @param $workSpaceId This is the variable used to hold the work space ID .
	* @param $workSpaceType This is the variable used to hold the work space type.
	* @return The chat details
	*/
	public function getChatDetailsByWorkSpaceId($workSpaceId, $workSpaceType, $userId = 0, $sortBy = 3, $sortOrder=2)
	{
		$arrChat	= array();	
		if($sortBy == 1)
		{
			$orderBy = ' ORDER BY a.name';
		}
		else if($sortBy == 2)
		{
			$orderBy = ' ORDER BY c.tagName';
		}
		else
		{
			$orderBy = ' ORDER BY a.editedDate';
		}		
		if($sortOrder == 2)
		{
			$orderBy .= ' ASC';
		}
		else
		{
			$orderBy .= ' DESC';
		}
		if($workSpaceId != NULL)
		{
		
			$curTime = date('Y-m-d H:i:s');
			// Get information of particular document
			if($workSpaceId > 0)
			{
				$query = $this->db->query('SELECT 
								a.*,date_format(a.createdDate,\'%Y-%m-%d %H:%i:%s\') as treeCreatedDate FROM teeme_tree a, teeme_users c WHERE a.userId = c.userId AND a.name NOT LIKE(\'untitle%\') AND a.workSpaces = \''.$workSpaceId.'\' AND a.workSpaceType= \''.$workSpaceType.'\' AND a.type=3 AND a.status = 1'.$orderBy);
	
			}
			else
			{
				$query = $this->db->query('SELECT 
								a.*,date_format(a.createdDate,\'%Y-%m-%d %H:%i:%s\') as treeCreatedDate FROM teeme_tree a, teeme_users c WHERE a.userId = c.userId AND a.name NOT LIKE(\'untitle%\') AND (a.userId = '.$_SESSION['userId'].' OR a.isShared=1) AND a.workSpaces = \'0\' AND a.type=3 AND a.status=1'.$orderBy);
			}
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$treeId		= $row->id;	
					
					$arrChat[$treeId]['treeId'] = $row->id;							
					$arrChat[$treeId]['name'] = $row->name;	
					$arrChat[$treeId]['old_name'] = $row->old_name;
					$arrChat[$treeId]['type'] = $row->type;	
					$arrChat[$treeId]['userId'] = $row->userId;
					$arrChat[$treeId]['createdDate'] = $row->treeCreatedDate;
					$arrChat[$treeId]['editedDate'] = $row->editedDate;
					$arrChat[$treeId]['workSpaces'] = $row->workspaces;
					$arrChat[$treeId]['workSpaceType'] = $row->workSpaceType;
					$arrChat[$treeId]['nodes'] = $row->nodes;
					$arrChat[$treeId]['isShared'] 	= $row->isShared;					
				}				
			}
		}
		return $arrChat;						
	}	

	 /**
	* This method will be used for fetch the sub work space detailse from the database.
 	* @param $subWorkspaceId This is the variable used to hold the work space ID .
	* @return The work space details
	*/
	public function getSubWorkSpaceDetailsBySubWorkSpaceId($subWorkSpaceId)
	{
		$subWorkSpaceData = array();		
		$query = $this->db->query('SELECT * FROM teeme_sub_work_space WHERE subWorkSpaceId='.$subWorkSpaceId);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{	
				$subWorkSpaceData['workSpaceId']	 		= $row->workSpaceId;										
				$subWorkSpaceData['subWorkSpaceId']	 		= $row->subWorkSpaceId;	
				$subWorkSpaceData['subWorkSpaceName']		= $row->subWorkSpaceName;		
				$subWorkSpaceData['subWorkSpaceCreatedDate']= $row->subWorkSpaceCreatedDate;	
				$subWorkSpaceData['subWorkSpaceManagerId']	= $row->subWorkSpaceManagerId;	
				$subWorkSpaceData['status']	= $row->status;													
			}				
		}					
		return $subWorkSpaceData;				
	}	



	 /**
	* This method will be used for fetch the sub work space Members from the database.
 	* @param $subWorkspaceId This is the variable used to hold the work space ID .
	* @return The work space details
	*/
	public function getTeemeManagers($placeId, $placeType)
	{
		$managerData = array();		
		$query = $this->db->query('SELECT * FROM teeme_managers WHERE placeId='.$placeId.' AND placeType='.$placeType);
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{										
				$managerData[$i]['placeId']		= $row->placeId;	
				$managerData[$i]['managerId']	= $row->managerId;		
				$managerData[$i]['placeType']	= $row->placeType;	
				
				$i++;													
			}				
		}					
		return $managerData;				
	}	
	
	public function getTeemeManagersDetailsByWorkSpaceId($spaceId, $spaceType)
	{
		$userData = array();
		$userId = $_SESSION['userId'];
		$workplaceId = $_SESSION['workPlaceId'];
		if($spaceId != 0)
		{
			$query = $this->db->query('SELECT b.* FROM teeme_managers a, teeme_users b WHERE a.managerId = b.userId AND a.placeId='.$spaceId.' AND a.placeType='.$spaceType.' AND b.userId!=1 ORDER BY userName ASC');
			if($query->num_rows() > 0)
			{
			$i = 0;
				foreach($query->result() as $row)
				{
				$userData[$i]['userId'] 		= $row->userId;	
				$userData[$i]['workPlaceId'] 	= $row->workPlaceId;
				$userData[$i]['userName']	 	= $row->userName;	
				$userData[$i]['password'] 		= $row->password;
				$userData[$i]['tagName'] 		= $row->tagName;			
				$userData[$i]['userCommunityId'] = $row->userCommunityId;
				$userData[$i]['userTitle'] 		= $row->userTitle;									
				$userData[$i]['firstName'] 		= $row->firstName;	
				$userData[$i]['userTagName']	= $row->tagName;	
				$userData[$i]['lastName'] 		= $row->lastName;		
				$userData[$i]['address1'] 		= $row->address1;
				$userData[$i]['address2'] 		= $row->address2;	
				$userData[$i]['city'] 			= $row->city;		
				$userData[$i]['state'] 			= $row->state;			
				$userData[$i]['country'] 		= $row->country;	
				$userData[$i]['zip'] 			= $row->zip;		
				$userData[$i]['phone'] 			= $row->phone;	
				$userData[$i]['mobile'] 		= $row->mobile;		
				$userData[$i]['email'] 			= $row->email;
				$userData[$i]['status'] 		= $row->status;			
				$userData[$i]['emailSent'] 		= $row->emailSent;	
				$userData[$i]['registeredDate']	= $row->registeredDate;		
				$userData[$i]['lastLoginTime']	= $row->lastLoginTime;	
				$userData[$i]['activation'] 	= $row->activation;	
				$userData[$i]['photo'] 			= $row->photo;	
				$userData[$i]['statusUpdate'] 	= $row->statusUpdate;
				$userData[$i]['other'] 			= $row->other;
				
				$i++;										
				}	
			}			
		}					
		return $userData;				
	}
	
	/**	
	* @assign the work place manager to work place
	*/

	public function changeAdminPassword($newPassword)
    {			
		$bResult  = $this->db->query('UPDATE teeme_admin SET password=\''.$this->db->escape_str($newPassword).'\' WHERE userName=\''.$this->db->escape_str($_SESSION['adminUserName']).'\'');
		if($bResult)
		{									
			return true;
		}	
		else
		{
			return false;
		}				
	}	
	
	public function resetAdminPassword($username,$newPassword)
    {			
		$bResult  = $this->db->query('UPDATE teeme_admin SET password=\''.$this->db->escape_str($newPassword).'\' WHERE userName=\''.$this->db->escape_str($username).'\'');
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
	* @assign the work place manager to work place
	*/

	public function deleteTeemeManagersByPlaceId($placeId,$placeType)	
    {			
		$bResult  = $this->db->query('DELETE FROM teeme_managers WHERE placeId='.$placeId.' AND placeType = '.$placeType);
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
	* @delete the sub work space members 
	*/

	public function deleteSubWorkSpaceMembersBySubWorkSpaceId($subWorkSpaceId)	
    {			
		$bResult  = $this->db->query('DELETE FROM teeme_sub_work_space_members WHERE subWorkSpaceId='.$subWorkSpaceId);
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
	* @delete the work space members 
	*/

	public function deleteWorkSpaceMembersByWorkSpaceId($workSpaceId)	
    {			
		$bResult  = $this->db->query('DELETE FROM teeme_work_space_members WHERE workSpaceId='.$workSpaceId);
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
	* @assign the work place manager to work place
	*/

	public function workPlaceFileContents($workPlaceName, $workPlaceId)
    {	
		$strContents = '';
		$strContents.= '<?php'."\n";
		$strContents.= 'class '.$workPlaceName.' extends CI_Controller {'."\n";
		$strContents.= 'function __Construct()'."\n";
		$strContents.= '{'."\n";
		$strContents.= 'parent::__Construct();'."\n";			
		$strContents.= '}'."\n";
		$strContents.= 'function index()'."\n";
		$strContents.= '{'."\n";
		
		$strContents.= '$arrDetails[\'workPlaceId\'] 			= '.$workPlaceId.';'."\n";
		$strContents.= '$arrDetails[\'contName\'] 			= \''.$workPlaceName.'\';'."\n";
				
		$strContents.= 'if ($_SESSION[\'workPlaceId\']==\'\' && $_SESSION[\'userName\']==\'\' && $_SESSION[\'adminUserName\']==\'\'){$this->load->model(\'dal/identity_db_manager\');'."\n";
	
		$strContents.=  '$cookieDetails = unserialize(base64_decode($_COOKIE[\'rememberme\']));'."\n";

		$strContents.= 'if($_COOKIE[\'rememberme\'] != \'\' && $cookieDetails[\'keep_me_logged_in\']!=\'\' && $cookieDetails[\'user_detail\']!=\'\'){'."\n";

		$strContents.= '$resUrl = $this->identity_db_manager->loginByCookieDetails($cookieDetails,$arrDetails[\'contName\']);'."\n";
		$strContents.= 'if($resUrl!=\'user_login\' && $resUrl!=\'\'){redirect($resUrl, \'location\');}'."\n";
		$strContents.= '}'."\n";
		
		//Memcached flush code commented to prevent flushing of distributed memcache objects
			
	
		$strContents.= '$this->load->view(\'user_login\', $arrDetails);}else if($arrDetails[\'workPlaceId\'] == $_SESSION[\'workPlaceId1\'] && $arrDetails[\'contName\'] == $_SESSION[\'contName1\']){ redirect(\'dashboard/index/0/type/1/1\', \'location\');}else{echo \'Can not load another place while logged in to user/place/admin panel.\';}'."\n";		
		$strContents.= '}'."\n";	
		$strContents.= '}'."\n";
		$strContents.= '?>'."\n";
		return $strContents;
	}

	/**	
	* @delete the table according to field name
	*/

	public function deleteRecordsByFieldName($table, $whereField, $whereVal, $type = 0)
    {
		$where = '';	
		if($type == 0)
		{
			$where = $whereField.'='.$whereVal;
		}
		else
		{		
			$where = $whereField.'=\''.$whereVal.'\'';
		}		
		$bResult  = $this->db->query('DELETE FROM '.$table.' WHERE '.$where);
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
	* @delete records by field names
	*/

	public function deleteRecordsByFieldNames($table, $fields)
    {		
		$arrWhere = array();
		foreach($fields as $arrField)
		{
			if($arrField['fieldType'] == 0)
			{		
				$arrWhere[] = $arrField['fieldName'].'='.$arrField['fieldValue'];
			}
			else
			{		
				$arrWhere[] = $arrField['fieldName'].'=\''.$arrField['fieldValue'].'\'';
			}
		}	
		$where = implode(' AND ',$arrWhere);		
		$bResult  = $this->db->query('DELETE FROM '.$table.' WHERE '.$where);
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
	* @store the login users to online
	*/

	public function updateLogin()
    {	
			
		$loginCount = 0;	
		$sessionId	= session_id();
		$time		= time();
	
		$timeCheck	= 0;	
		$docCount	= 0;
		/*$memc = new Memcached;
		$memc->addServer($this->config->item('memcache_host'), $this->config->item('port_no'));*/
		
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();
		
		if($_SESSION['workPlaceId'] != '')
		{
			$memCacheId = 'wp'.$_SESSION['workPlaceId'].'loginUsers';	
		}
		else
		{
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);
		}
		
		$loginUsers = $memc->get($memCacheId);
		
		
		$curLoginUsers = array();	
		if(isset($_SESSION['userId']) && $_SESSION['userId'] > 0)
		{
			//Delete the document details from memcache if anybody not accessing the document					
			if($this->input->get('doc') !=''  && $this->input->get('treeId') != '')
			{
				$curDocName	= 'wp'.$_SESSION['workPlaceId'].'doc'.$this->input->get('treeId');
				$docCount = 1;
				if(isset($loginUsers[$_SESSION['userId']]['doc']))
				{					
					$docName = $loginUsers[$_SESSION['userId']]['doc'];
					if($curDocName != $docName)
					{	
						unset($loginUsers[$_SESSION['userId']]['doc']);	
					}
					$docAccessCount = 0;
					if(count($loginUsers) > 0)	
					{			
						foreach( $loginUsers as $loginVal)
						{							
							if(isset($loginVal['userId']['doc']) && $loginVal['userId']['doc'] == $docName)
							{									
								$docAccessCount = 1;
								break;	
							}		
						}	
					}										
					if($docAccessCount == 0)
					{
						$memCacheValue = $memc->get($docName);
						if($memCacheValue)
						{	
												
							$memc->delete($docName);		
						}	
					}										
					$loginUsers[$_SESSION['userId']]['doc'] = 'wp'.$_SESSION['workPlaceId'].'doc'.$this->input->get('treeId');
				}
				else
				{
					$loginUsers[$_SESSION['userId']]['doc'] = 'wp'.$_SESSION['workPlaceId'].'doc'.$this->input->get('treeId');
				}					
			}
			else if($this->uri->segment(1) =='view_Chat'  && $this->uri->segment(2) == 'chat_view')
			{
				$curChatName	= 'wp'.$_SESSION['workPlaceId'].'chat'.$this->uri->segment(3);
				$chatCount = 1;
				if(isset($loginUsers[$_SESSION['userId']]['chat']))
				{					
					$chatName = $loginUsers[$_SESSION['userId']]['chat'];
					if($curChatName != $chatName)
					{	
						unset($loginUsers[$_SESSION['userId']]['chat']);	
					}
					$chatAccessCount = 0;
					
					if(count($loginUsers) > 0)	
					{			
						foreach( $loginUsers as $loginVal)
						{
							if(isset($loginVal['userId']['chat']) && $loginVal['userId']['chat'] == $chatName)
							{
								$chatAccessCount = 1;	
								break;
							}		
						}	
					}					
					if($chatAccessCount == 0)
					{
						$memCacheValue = $memc->get($chatName);
						if($memCacheValue)
						{
							$memc->delete($chatName);		
						}	
					}										
					$loginUsers[$_SESSION['userId']]['chat'] = 'wp'.$_SESSION['workPlaceId'].'chat'.$this->uri->segment(3);
				}
				else
				{
					$loginUsers[$_SESSION['userId']]['chat'] = 'wp'.$_SESSION['workPlaceId'].'chat'.$this->uri->segment(3);
				}	
			}
			else if($this->uri->segment(1) =='view_Discussion'  && $this->uri->segment(2) == 'node')
			{	
				$curDisName	= 'wp'.$_SESSION['workPlaceId'].'dis'.$this->uri->segment(3);
				$disCount = 1;
				if(isset($loginUsers[$_SESSION['userId']]['dis']))
				{					
					$disName = $loginUsers[$_SESSION['userId']]['dis'];
					if($curDisName != $disName)
					{	
						unset($loginUsers[$_SESSION['userId']]['dis']);	
					}
					$disAccessCount = 0;
					if(count($loginUsers) > 0)	
					{			
						foreach( $loginUsers as $loginVal)
						{							
							if(isset($loginVal['userId']['dis']) && $loginVal['userId']['dis'] == $disName)
							{									
								$disAccessCount = 1;
								break;	
							}		
						}	
					}					
					if($disAccessCount == 0)
					{
						$memCacheValue = $memc->get($disName);
						if($memCacheValue)
						{							
							$memc->delete($disName);		
						}	
					}										
					$loginUsers[$_SESSION['userId']]['dis'] = 'wp'.$_SESSION['workPlaceId'].'dis'.$this->uri->segment(3);
				}
				else
				{
					$loginUsers[$_SESSION['userId']]['dis'] = 'wp'.$_SESSION['workPlaceId'].'dis'.$this->uri->segment(3);
				}								
				
			}			
			else
			{				
				if(isset($loginUsers[$_SESSION['userId']]['doc']))
				{
					$docName = $loginUsers[$_SESSION['userId']]['doc'];
					unset($loginUsers[$_SESSION['userId']]['doc']);
					$docAccessCount = 0;								
					if(count($loginUsers) > 0)	
					{			
						foreach( $loginUsers as $loginVal)
						{							
							if(isset($loginVal['doc']) && $loginVal['doc'] == $docName)
							{
								$docAccessCount = 1;	
								break;
							}		
						}	
					}				
					
					if($docAccessCount == 0)
					{
						$memCacheValue = $memc->get($docName);
						if($memCacheValue)
						{	
																	
							$memc->delete($docName);		
						}	
					}			
				}
				
				//delete the chat tree from memcache if nobody accessing the chat tree
				if(isset($loginUsers[$_SESSION['userId']]['chat']))
				{
					$chatName = $loginUsers[$_SESSION['userId']]['chat'];
					unset($loginUsers[$_SESSION['userId']]['chat']);
					$chatAccessCount = 0;
					if(count($loginUsers) > 0)	
					{			
						foreach( $loginUsers as $loginVal)
						{
							if(isset($loginVal['chat']) && $loginVal['chat'] == $chatName)
							{
								$chatAccessCount = 1;	
							}		
						}	
					}	
					if($chatAccessCount == 0)
					{
						$memCacheValue = $memc->get($chatName);
						if($memCacheValue)
						{
							$memc->delete($chatName);		
						}	
					}			
				}
				
				//delete the discussion tree from memcache if nobody accessing the discussion tree	
				if(isset($loginUsers[$_SESSION['userId']]['dis']))
				{
					$disName = $loginUsers[$_SESSION['userId']]['dis'];
					unset($loginUsers[$_SESSION['userId']]['dis']);
					$disAccessCount = 0;
					if(count($loginUsers) > 0)	
					{			
						foreach( $loginUsers as $loginVal)
						{
							if(isset($loginVal['dis']) && $loginVal['dis'] == $disName)
							{
								$disAccessCount = 1;	
							}		
						}	
					}	
					if($disAccessCount == 0)
					{
						$memCacheValue = $memc->get($disName);
						if($memCacheValue)
						{
							$memc->delete($disName);		
						}	
					}			
				}					
			}
			
			if($loginUsers)
			{			
				foreach( $loginUsers as $loginVal)
				{
					if($loginVal['userId'] == $_SESSION['userId'] && $loginVal['sessionId'] == $sessionId)
					{
						$loginCount = 1;
						break;
					}						
				}
			}
			
		
			if($loginCount == 0)
			{				
				$loginUsers[$_SESSION['userId']] = array('userId' => $_SESSION['userId'],'sessionId' => $sessionId,'loginTime' => $time);				
				$memc->set($memCacheId, $loginUsers);	
		
			}		
			else
			{
				foreach( $loginUsers as $key=>$loginVal)
				{
					if($loginVal['userId'] != $_SESSION['userId'] && $loginVal['sessionId'] == $sessionId)
					{
													
					}	
					else if($loginVal['userId'] == $_SESSION['userId'] && $loginVal['sessionId'] == $sessionId)
					{
						$curLoginUsers[$_SESSION['userId']] = array('userId' => $_SESSION['userId'],'sessionId' => $sessionId,'loginTime' => $time);							
					}	
					else
					{
						$curLoginUsers[$key] = $loginVal;		
					}													
				}
				if( $docCount == 1)
				{		
					$curLoginUsers[$_SESSION['userId']]['doc']	= 'wp'.$_SESSION['workPlaceId'].'doc'.$this->input->get('treeId');
				}										
				$memc->set($memCacheId, $curLoginUsers);			
			}
			
			$loginUsers = $memc->get($memCacheId);	
			$curLoginUsers = array();
			foreach( $loginUsers as $key=>$loginVal)
			{				
				if($loginVal['loginTime'] > $timeCheck)
				{					
					$curLoginUsers[$key] = $loginVal;						
				}											
			}			
			$memc->set($memCacheId, $curLoginUsers);
												
			
		}
		else
		{
			foreach( $loginUsers as $key=>$loginVal)
			{
				if($loginVal['loginTime'] > $timeCheck)
				{	
					$curLoginUsers[$key] = $loginVal;						
				}											
			}						
			$memc->set($memCacheId, $curLoginUsers);	
			$_SESSION['errorMsg']	= 	$this->lang->line('msg_session_expire'); 
			$this->load->model('dal/identity_db_manager');						
			$objIdentity	= $this->identity_db_manager;	
			$arrDetails['workPlaceDetails'] 	= $objIdentity->getWorkPlaces();	
			$this->load->view('login', $arrDetails);		
		}
	}

	/**	
	* @get the online users id
	*/
	public function getOnlineUsersByUsersId($usersId)
    {	
		$userArray = explode(',',$usersId);	
		$userIds = array();	
		/*$memc = new Memcached;
		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();
		
		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'loginUsers';	
		$loginUsers = $memc->get($memCacheId);

		foreach($loginUsers as $key=>$loginVal)
		{				
			if(in_array($key,$userArray))
			{
				$userIds[]	= $key;		
			}
		}				
	
	
		return $userIds;			
	}



	public function getOnlineUsersByPlaceId()
    {	

		/*$memc = new Memcached;
		$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
		//Manoj: get memcache object	
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();

		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'loginUsers';	
		$loginUsers = $memc->get($memCacheId);

		foreach($loginUsers as $key=>$loginVal)
		{				

				$userIds[]	= $key;		

		}				

		return $userIds;			
	}
	/**	
	* @update user login
	*/
	public function updateLoginTime()
    {		
		$this->load->model('dal/time_manager');
		$curDateTime = time_manager::getGMTTime();
		$bResult  = $this->db->query('UPDATE teeme_users SET lastLoginTime=\''.$curDateTime.'\' WHERE userId=\''.$_SESSION['userId'].'\'');
		$bResult  = $this->db->query('UPDATE teeme_users SET currentLoginTime=\''.$curDateTime.'\' WHERE userId=\''.$_SESSION['userId'].'\'');			
	}
	
	public function getLastLogin()
	{
		$query = $this->db->query('SELECT lastLoginTime FROM teeme_users WHERE userId = \''.$_SESSION['userId'].'\'');
		if($query->num_rows() > 0)
		{	
			$i = 0;		
			foreach($query->result() as $row)
			{	
				$loginTime = $row->lastLoginTime;		
			}
		}
		
		return $loginTime;
	}
	
	public function unreadArtifacts()
    {		
		$unreadArtifacts = array();
		
		$query = $this->db->query('SELECT lastLoginTime FROM teeme_users WHERE userId = \''.$_SESSION['userId'].'\'');
		if($query->num_rows() > 0)
		{	
			$i = 0;		
			foreach($query->result() as $row)
			{	
				$loginTime		= $row->lastLoginTime;		
			}
		}
		
		$query = $this->db->query('SELECT a.id, a.name, a.type, a.workspaces, a.workSpaceType, b.name as artifactType FROM teeme_tree a, teeme_container_types b WHERE a.type = b.id  AND a.createdDate >\''.$loginTime.'\'');
		if($query->num_rows() > 0)
		{	
			$i = 0;		
			foreach($query->result() as $row)
			{										
				$unreadArtifacts[$i]['treeId']		= $row->id;	
				$unreadArtifacts[$i]['treeName']	= $row->name;		
				$unreadArtifacts[$i]['treeTypeName']= $row->artifactType;	
				$unreadArtifacts[$i]['treeType']	= $row->type;	
				$unreadArtifacts[$i]['workSpaceId']	= $row->workspaces;
				$unreadArtifacts[$i]['workSpaceType']	= $row->workSpaceType;							
				$i++;													
			}				
		}
		return $unreadArtifacts;
	}
	public function getWorkPlaceDetailsForEditor($wp,$ws,$userId){
		$treeData=array();
		$config = array();
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
		$query = $instancedb->query("SELECT * FROM `teeme_work_place` where workPlaceId='".$wp."'");
		if($query->num_rows() > 0)
		{	
			foreach($query->result() as $row)
			{
				$treeData['wp']=$row->companyName;
			}
		}else{
			$treeData['wp']='';
		}
		if($ws)
		{	
			$query = $this->db->query("SELECT * FROM `teeme_work_space` where workPlaceId='".$wp."' and workSpaceId='".$ws."'");
			if($query->num_rows() > 0)
			{	
				foreach($query->result() as $row)
				{
					$treeData['ws']=$row->workSpaceName;
				}
			}else{
				$query = $this->db->query("SELECT * FROM `teeme_users` where userId='".$userId."'");
				if($query->num_rows() > 0)
				{	
					foreach($query->result() as $row)
					{
						$treeData['ws']=$row->userName;
					}
				}else{
					$treeData['ws']='';
				}
			}
		}else{
			$query = $this->db->query("SELECT * FROM `teeme_users` where userId='".$userId."'");
				if($query->num_rows() > 0)
				{	
					foreach($query->result() as $row)
					{
						$treeData['ws']=$row->userName;
					}
				}else{
					$treeData['ws']='';
				}
		}
		return $treeData;
	}

	/**
	* This method will be used to fetch the external documents from the database.
 	* @return The external documents as an array
	*/
	public function getExternalDocsByWorkspaceId($workSpaceId, $workSpaceType, $searchDocs, $sortBy = 4, $sortOrder = 1, $folderId = 0)
	{
		$arrDocDetails = array();		
		if($sortBy == 1)
		{
			$orderBy = ' ORDER BY a.docCaption';
		}
		else if($sortBy == 2)
		{
			$orderBy = ' ORDER BY b.tagName';
		}
		else if($sortBy == 4)
		{
			$orderBy = ' ORDER BY a.file_order';
		}
		else if($sortBy == 3)
		{
			$orderBy = ' ORDER BY a.createdDate';
		}
		else if($sortBy == 5)
		{
			$orderBy = ' ORDER BY a.orig_modified_date';
		}
		else
		{
			// $orderBy = ' ORDER BY a.createdDate';
			$orderBy = ' ORDER BY a.file_order';
		}		
		if($sortOrder == 2)
		{
			$orderBy .= ' DESC';
			//$orderBy .= ' ASC';
		}
		else
		{
			$orderBy .= ' ASC';
			//$orderBy .= ' DESC';
		}
		$userId = $_SESSION['userId'];
		// Get tag types 
		$search = '';		
		if($searchDocs != '')
		{
			$search = 'a.docName LIKE \''.$this->db->escape_str($searchDocs).'%\''.' AND';
		}				
		if($workSpaceId == 0)
		{	
			if($folderId > 0)
			{
				$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND '.$search.' a.workSpaceId=0 AND a.userId='.$userId.' AND a.folderId='.$folderId.$orderBy);
			}
			else
			{
				$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND '.$search.' a.workSpaceId=0 AND a.userId='.$userId.' AND a.folderId=0'.$orderBy);
			}
			
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}
				}
		}
		else	
		{
			//Memcache code start here
			$memc=$this->createMemcacheObject();	
			$memCacheId = 'wp'.$workSpaceId.'files'.$workSpaceType.'place'.$_SESSION['workPlaceId'];	
			//$memc->delete($memCacheId);			
			$tree = $memc->get($memCacheId);
			
			if(!$tree && $searchDocs=='')
			{
				$tree=array();

				if($folderId > 0)
				{
					$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND '.$search.' a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.folderId='.$folderId.$orderBy);
				}
				else
				{
					$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND '.$search.' a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.folderId=0'.$orderBy);
				}
				
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}
					if($sortBy==3 && $sortOrder==2 && $searchDocs=='' && $workSpaceId != 0)
					{	
						$memc->set($memCacheId, $tree);
						$tree = $memc->get($memCacheId);	
					}
				}
				
			}
			else
			{
				$tree=array();

				if($folderId > 0)
				{
					$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND '.$search.' a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.folderId='.$folderId.$orderBy);
				}
				else
				{
					$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND '.$search.' a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.folderId=0'.$orderBy);
				}
				
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}
				}
				
			}
		}
		
		//return $tree;
		if(count($tree) > 0)
		{
			$i = 0;
			foreach ($tree as $docData)
			{	
				$arrDocDetails[$i]['docId'] 		= $docData->docId;
				$arrDocDetails[$i]['workSpaceId'] 	= $docData->workSpaceId;
				$arrDocDetails[$i]['workSpaceType'] = $docData->workSpaceType;	
				$arrDocDetails[$i]['userId'] 		= $docData->userId;
				$arrDocDetails[$i]['folderId'] 		= $docData->folderId;			
				$arrDocDetails[$i]['docCaption'] 	= $docData->docCaption;	
				$arrDocDetails[$i]['docName']	 	= $docData->docName;	
				$arrDocDetails[$i]['docPath']	 	= $docData->path;
				$arrDocDetails[$i]['docCreatedDate']= $docData->createdDate;	
				$arrDocDetails[$i]['version']		= $docData->version;
				/*Added by Dashrath- add file order in array*/
				$arrDocDetails[$i]['fileOrder']		= $docData->file_order;
				$arrDocDetails[$i]['orig_modified_date']= $docData->orig_modified_date;		
				$i++;					
			}
		}			
		return $arrDocDetails;
	}

	/**
	* This method will be used to fetch the external file details from the database.
 	* @return The external file details as an array
	*/
	public function getExternalFileDetailsById($fileId)
	{
		$arrFileDetails = array();			
		$query = $this->db->query('SELECT * FROM teeme_external_docs WHERE docId='.$fileId);
		
		if($query->num_rows() > 0)
		{			
			foreach ($query->result() as $docData)
			{	
				$arrFileDetails['docId'] 		= $docData->docId;
				$arrFileDetails['workSpaceId'] 	= $docData->workSpaceId;
				$arrFileDetails['workSpaceType'] = $docData->workSpaceType;	
				$arrFileDetails['userId'] 		= $docData->userId;		
				$arrFileDetails['docCaption'] 	= $docData->docCaption;	
				$arrFileDetails['docName']	 	= $docData->docName;	
				$arrFileDetails['docPath']	 	= $docData->path;
				$arrFileDetails['docCreatedDate']= $docData->createdDate;	
				$arrFileDetails['version']		= $docData->version;									
			}
		}			
		return $arrFileDetails;
	}

	/**
	* This method will be used to delete the external file from the database.
 	* @return The staus of delete
	*/
	public function deleteExternalFileById($fileId)
	{			
		$query = $this->db->query('DELETE FROM teeme_external_docs WHERE docId='.$fileId);
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
	* This method will be used to fetch the document version from the database.
 	* @return The external document version
	*/
	public function getDocVersion($docCaption, $workSpaceId, $workSpaceType, $userId, $folderId=0)
	{
		//Manoj: replace mysql_escape_str function
		$arrDocDetails = array();

		$docVersion = 1;
		
		if($workSpaceId == 0)
		{	
			/*Changed by Dashrath- Add folderId check in where condition*/
			$query = $this->db->query('SELECT docId FROM teeme_external_docs WHERE docCaption = \''.$this->db->escape_str($docCaption).'\' AND workSpaceId=0 AND userId='.$userId.' AND folderId='.$folderId);
		}
		else	
		{
			/*Changed by Dashrath- Add folderId check in where condition*/
			$query = $this->db->query('SELECT docId FROM teeme_external_docs WHERE docCaption = \''.$this->db->escape_str($docCaption).'\' AND workSpaceId='.$workSpaceId.' AND workSpaceType='.$workSpaceType.' AND folderId='.$folderId);
		}
		if($query->num_rows() > 0)
		{
			$docVersion = $query->num_rows()+1;
		}			
		return $docVersion;
	}
	 /**
	* This method will be used for fetch the tree nodes from the database. 		
	* @param $date This is the variable used to hold the required date
	* @param $artifactTreeId This is the variable used to hold the artifact tree id
	* @return The tree datas as an array
	*/
	public function getNodesByDate($artifactTreeId, $searchDate1, $searchDate2)
	{
		$arrNodes	= array();
		//Manoj: replace mysql_escape_str function
			
		$q = 'SELECT a.id FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\'';
	
			if ((!empty($searchDate1)) && (!empty($searchDate2)))
			{
				$q .= ' AND ((date_format(a.starttime, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate1).'\' AND date_format(a.endtime, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\' AND  date_format(a.endtime, \'%Y-%m-%d\')!=\'0000-00-00\') OR (date_format(a.starttime, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\' AND date_format(a.endtime, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate2).'\' AND  date_format(a.endtime, \'%Y-%m-%d\')!=\'0000-00-00\'))';
			}
			else
			{
				if ((!empty($searchDate1)))
					$q .= ' AND date_format(a.starttime, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\'';
				
				if ((!empty($searchDate2)))
					$q .= ' AND date_format(a.endtime, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate2).'\' AND  date_format(a.endtime, \'%Y-%m-%d\')!=\'0000-00-00\'';
			}
		
		
		$query = $this->db->query($q);

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{										
				$arrNodes[] 	= $row->id;						
			}				
		}
		
		return $arrNodes;				
	}



	public function getNodesByDateTimeView($artifactTreeId, $searchDate1, $searchDate2)
	{
		$arrNodes	= array();
		//Manoj: replace mysql_escape_str function
		if ($searchDate1!='' && $searchDate2!='')
		{
			$q = 'SELECT a.id FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\' AND date_format(b.editedDate, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\' AND date_format(b.editedDate, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate2).'\' AND b.editedDate != \'0000-00-00\' 
			UNION
			 SELECT a.id FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\' AND date_format(b.createdDate, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\' AND date_format(b.createdDate, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate2).'\' AND b.editedDate = \'0000-00-00\' ';			
		}
		else if ($searchDate1!='' && $searchDate2=='')
		{
			$q = 'SELECT a.id FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\' AND date_format(b.editedDate, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\' AND b.editedDate != \'0000-00-00\' 
			UNION
			 SELECT a.id FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\' AND date_format(b.createdDate, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\' AND b.editedDate = \'0000-00-00\' ';				
		}
		else if ($searchDate1=='' && $searchDate2!='')
		{
			$q = 'SELECT a.id FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\' AND date_format(b.editedDate, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate2).'\' AND b.editedDate != \'0000-00-00\' 
			UNION
			 SELECT a.id FROM teeme_node a, teeme_leaf b WHERE a.leafId=b.id AND a.treeIds = \''.$artifactTreeId.'\' AND date_format(b.createdDate, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate2).'\' AND b.editedDate = \'0000-00-00\' ';			
		}


		$query = $this->db->query($q);
		
	
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{										
				$arrNodes[] 	= $row->id;						
			}				
		}
		
		return $arrNodes;				
	}	
	/**
	* This method will be used for fetch the tree nodes from the database. 		
	* @param $date This is the variable used to hold the required date
	* @param $artifactTreeId This is the variable used to hold the artifact tree id
	* @return The tree datas as an array
	*/
	public function getNodesBySearchOptions($treeId, $searchDate1='', $searchDate2='', $originator='', $assigned_to = '', $completionStatus = 0, $showUntimed=0)
	{
		//echo "complete= " .$completionStatus; exit;
		$arrNodes	= array();
		
		//$q = 'SELECT distinct(a.id) FROM teeme_node a, teeme_leaf b, teeme_notes_users c WHERE a.leafId=b.id AND a.treeIds = \''.$treeId.'\'';
		$q = "SELECT distinct(a.id) FROM teeme_node a, teeme_leaf b, teeme_notes_users c, teeme_activity_completion_status d WHERE a.id=b.nodeId AND a.id=d.activityId  AND a.treeIds = '".$treeId."'";
			
/*			if ((!empty($searchDate1)) && (!empty($searchDate2)))
			{
				$q .= ' AND ((date_format(a.starttime, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate1).'\' AND date_format(a.endtime, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\' AND  date_format(a.endtime, \'%Y-%m-%d\')!=\'0000-00-00\') OR (date_format(a.starttime, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\' AND date_format(a.endtime, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate2).'\' AND  date_format(a.endtime, \'%Y-%m-%d\')!=\'0000-00-00\'))';
			}
			else
			{
				if ((!empty($searchDate1)))
				{
					$q .= ' AND date_format(a.starttime, \'%Y-%m-%d\')>=\''.$this->db->escape_str($searchDate1).'\'';
				}
				elseif ((!empty($searchDate2)))
				{
					$q .= ' AND date_format(a.endtime, \'%Y-%m-%d\')<=\''.$this->db->escape_str($searchDate2).'\' AND  date_format(a.endtime, \'%Y-%m-%d\')!=\'0000-00-00\'';
				}
				//else
				//{
					//$q .= ' AND date_format(a.endtime, \'%Y-%m-%d\')=\'0000-00-00\' AND date_format(a.endtime, \'%Y-%m-%d\')=\'0000-00-00\'';
				//}
			}*/
				if($showUntimed==1)
				{
					$q .= " AND (a.starttime='0000-00-00 00:00:00' AND a.endtime='0000-00-00 00:00:00')";
				}
				else if($searchDate1!='' && $searchDate2=='')
				{
					$q .= " AND ((a.endtime>= '".$searchDate1." 00:00:00' AND a.endtime!='0000-00-00 00:00:00') OR (a.starttime!='0000-00-00 00:00:00' AND a.endtime='0000-00-00 00:00:00'))";
				}
				else if($searchDate2!='' && $searchDate1=='')
				{
					$q .= " AND ((a.starttime<= '".$searchDate2." 00:00:00' AND a.starttime!='0000-00-00 00:00:00') OR (a.starttime='0000-00-00 00:00:00' AND a.endtime!='0000-00-00 00:00:00'))";
				}
				else if ($searchDate1!='' && $searchDate2!='')
				{
					$q .= " AND ((a.endtime>= '".$searchDate1." 00:00:00' AND a.endtime!='0000-00-00 00:00:00') OR (a.starttime!='0000-00-00 00:00:00' AND a.endtime='0000-00-00 00:00:00')) AND ((a.starttime<= '".$searchDate2." 00:00:00' AND a.starttime!='0000-00-00 00:00:00') OR (a.starttime='0000-00-00 00:00:00' AND a.endtime!='0000-00-00 00:00:00'))";
				}	
						
			//Manoj: replace mysql_escape_str function
			if (!empty ($originator))
				$q .= " AND b.userId = '".$this->db->escape_str($originator)."'";	
				
/*			if (!empty ($assigned_to))
				$q .= " AND a.id=c.notesId AND c.userId = '".$assigned_to."'";	*/
			
			if($completionStatus!='' && $completionStatus!=5){

				$q .=" AND d.status IN(".$completionStatus.")";

			}				
					

		$query = $this->db->query($q);
		
		//echo $q; exit;
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{										
				$arrNodes[] 	= $row->id;						
			}				
		}

		return $arrNodes;				
	}	
	
	
	public function getAllNodesByTreeId($treeId)
	{
		$arrNodes	= array();
		
		$q = 'SELECT a.id FROM teeme_node a, teeme_leaf b, teeme_notes_users c WHERE a.leafId=b.id AND a.treeIds = \''.$treeId.'\'';

		$query = $this->db->query($q);
		

		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{										
				$arrNodes[] 	= $row->id;						
			}				
		}
		
		return $arrNodes;				
	}
	 /**
	* This method will be used for update the tree edited Date.
 	* @param $treeId This is the variable used to hold the tree ID .
	* @param $editedDate This is the variable used to hold the tree modified date.
	* @update the tree edited date
	*/
	public function updateTreeModifiedDate( $treeId, $editedDate )
	{	
		//Manoj: replace mysql_escape_str function
		$bResult  = $this->db->query('UPDATE teeme_tree SET editedDate=\''.$this->db->escape_str($editedDate).'\' WHERE id='.$treeId); 			
		if($bResult)
		{									
			return true;
		}	
		else
		{
			return false;
		}				
	}
	
	//arun
	/**
	* This method will be used for update the leaf edited Date.
 	* @param $leafId This is the variable used to hold the leaf ID .
	* @param $editedDate This is the variable used to hold the tree modified date.
	* @update the leaf edited date
	*/
	public function updateLeafModifiedDate( $leafId, $editedDate )
	{	
	 	//Manoj: replace mysql_escape_str function
		 $bResult  = $this->db->query('UPDATE teeme_leaf SET editedDate=\''.$this->db->escape_str($editedDate).'\' WHERE id='.$leafId); 			
		if($bResult)
		{									
			return true;
		}	
		else
		{
			return false;
		}				
	}
	
	//arun
	/**
	* This method will be used for update the parent node edited Date.
 	* @param $leafId This is the variable used to hold the node ID .
	* @param $editedDate This is the variable used to hold the tree modified date.
	* @update the leaf edited date
	*/
	public function updateParentNodeModifiedDate( $leafId, $editedDate )
	{	
	 
		 $bResult  = $this->db->query('UPDATE teeme_leaf SET editedDate=\''.$this->db->escape_str($editedDate).'\' WHERE nodeId='.$leafId); 			
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
	* This method will be used to fetch the admin details from the database.
 	* @return The admin details as an array
	*/
	public function getAdminDetails()
	{
		$adminDetails = array();			
		$query = $this->db->query('SELECT * FROM teeme_admin WHERE superAdmin = 0 ORDER BY userName ASC');		
		if($query->num_rows() > 0)
		{
			$i = 0;			
			foreach ($query->result() as $adminData)
			{	
				$adminDetails[$i]['adminId'] 		= $adminData->id;
				$adminDetails[$i]['adminUserName'] 	= $adminData->userName;
				$adminDetails[$i]['adminPassword'] 	= $adminData->password;	
				$adminDetails[$i]['superAdminstatus'] 	= $adminData->superAdmin;		
				$adminDetails[$i]['adminFirstName'] = $adminData->first_name;
				$adminDetails[$i]['adminLastName'] = $adminData->last_name;
				$i++;								
			}
		}			
		return $adminDetails;
	}
	
	
	public function getSuperAdminDetails()
	{
		$adminDetails = array();			
		$query = $this->db->query('SELECT * FROM teeme_admin WHERE superAdmin = 1');		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $adminData)
			{			
				$adminDetails['adminId'] 		= $adminData->id;
				$adminDetails['adminUserName'] 	= $adminData->userName;
				$adminDetails['adminPassword'] 	= $adminData->password;	
				$adminDetails['superAdminstatus'] 	= $adminData->superAdmin;	
			}	
		}			
		return $adminDetails;
	}
	/**
	* This method will be used to check whether user name exist.
 	* @return The admin details as an array
	*/
	public function checkAdminUserName($userName)
	{
		$avlStatus = true;			
		$query = $this->db->query('SELECT id FROM teeme_admin WHERE userName = \''.$this->db->escape_str($userName).'\'');		
		if($query->num_rows() > 0)
		{			
			$avlStatus = false;			
		}			
		return $avlStatus;
	}
	/**
	* This method will be used to delete the admin details from the database.
 	* @return The status of delete operation
	*/
	public function deleteAdminDetailsByAdminId($adminId)
	{
		$status = false;			
		$query = $this->db->query('DELETE FROM teeme_admin WHERE id = '.$adminId);		
		if($query)
		{			
			$status = false;			
		}			
		return $status;
	}
	/**
	* This method will be used to fetch the admin details.
 	* @return The admin details as an array
	*/
	public function getAdminDetailsByAdminId($adminId)
	{
		$adminDetails = array();			
		$query = $this->db->query('SELECT * FROM teeme_admin WHERE id = '.$adminId);		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $adminData)
			{				
				$adminDetails['adminId'] = $adminData->id;
				$adminDetails['adminUserName'] = $adminData->userName;
				$adminDetails['adminPassword'] = $adminData->password;
				$adminDetails['superAdminstatus'] = $adminData->superAdmin;
				$adminDetails['adminFirstName'] = $adminData->first_name;
				$adminDetails['adminLastName'] = $adminData->last_name;
			}		
		}			
		return $adminDetails;
	}
	
	public function getAdminDetailsByAdminUsername($username)
	{
		$adminDetails = array();	
		$qry = "SELECT * FROM teeme_admin WHERE userName ='".$username."'";		
		$query = $this->db->query($qry);		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $adminData)
			{				
				$adminDetails['adminId'] = $adminData->id;
				$adminDetails['adminUserName'] = $adminData->userName;
				$adminDetails['adminPassword'] = $adminData->password;
				$adminDetails['superAdminstatus'] = $adminData->superAdmin;
				$adminDetails['adminFirstName'] = $adminData->first_name;
				$adminDetails['adminLastName'] = $adminData->last_name;
			}		
		}			
		return $adminDetails;
	}
	
	/**
	* This method is used to check the memcahe status.
 	* @return The admin details as an array
	*/
	public function displayMemcachedError($host, $port)
	{		
		echo 'Memcahe is not listening from the host: '.$host.' and port: '.$port.' Please check the memcache settings to run the application';
		exit;		
	}


	function getCurrentLinkedTreesByArtifactNodeId( $nodeId, $artifactType, $nodeType, $lastLogin )
	{
		$treeIds = array();
		$query = $this->db->query('SELECT a.id, a.name FROM teeme_tree a, teeme_links b WHERE a.id=b.treeId AND b.artifactId=\''.$nodeId.'\' AND b.artifactType = '.$nodeType.' AND a.type='.$artifactType.' AND a.name NOT LIKE(\'untitle%\') AND (b.createdDate >\''.$lastLogin.'\') ORDER BY a.name');

		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['treeId'] = $treeData->id;
					$treeIds[$i]['name'] = $treeData->name;
					$i++;
				}
			}
		}
		return $treeIds;
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
		
			$query = $this->db->query('SELECT a.name, a.id FROM teeme_tree a, teeme_contact_info b WHERE a.id=b.treeId AND a.type = 5 AND (a.workspaces=\''.$workSpaceId.'\' OR b.sharedStatus!=2) AND b.workplaceId='.$_SESSION["workPlaceId"].' AND a.userId='.$userId);
		}
		else	
		{
		
			$query = $this->db->query('SELECT a.name, a.id FROM teeme_tree a, teeme_contact_info b WHERE a.id=b.treeId AND a.type = 5 AND (a.workspaces=\''.$workSpaceId.'\' OR b.sharedStatus!=2) AND b.workplaceId='.$_SESSION["workPlaceId"].' AND workSpaceType = \''.$workSpaceType.'\'');
		
		}
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach ($query->result() as $contactData)
			{	
				$arrContactDetails[$i]['tagTypeId'] 	= $contactData->id;
				$arrContactDetails[$i]['tagType'] 		= $contactData->name;	
				$i++;					
			}
		}			
		return $arrContactDetails;
	}	
	/**
	* This method will be used to fetch the linked trees by node id.
 	* @param $nodeId This is the variable used to hold the document node id.
	* @param $artifactType This is the variable used to hold the artifact type.	
	* @return the linked trees of current node
	*/
	function getLinkedTreesByArtifactNodeId($nodeId, $artifactType, $nodeType='',$treeId=0)
	{
		$treeIds = array();
		if ($treeId==0)
		{
			if ($nodeType)
			{
				$q = 'SELECT a.id, a.name FROM teeme_tree a, teeme_links b WHERE a.id=b.treeId AND b.artifactId=\''.$nodeId.'\' AND b.artifactType = '.$nodeType.' AND a.type='.$artifactType.' AND a.name NOT LIKE (\'untitle%\') ORDER BY a.name ASC';
			}
			else
			{
				$q = 'SELECT a.id, a.name FROM teeme_tree a, teeme_links b WHERE a.id=b.treeId AND b.artifactId=\''.$nodeId.'\' AND a.type='.$artifactType.' AND a.name NOT LIKE (\'untitle%\') ORDER BY a.name ASC';
		
			}
		}
		else
		{
			if ($nodeType)
			{
				$q = 'SELECT a.id, a.name FROM teeme_tree a, teeme_links b WHERE a.id=\''.$treeId.'\' AND a.id=b.treeId AND b.artifactId=\''.$nodeId.'\' AND b.artifactType = '.$nodeType.' AND a.type='.$artifactType.' AND a.name NOT LIKE (\'untitle%\') ORDER BY a.name ASC';
			}
			else
			{
				$q = 'SELECT a.id, a.name FROM teeme_tree a, teeme_links b WHERE a.id=\''.$treeId.'\' AND a.id=b.treeId AND b.artifactId=\''.$nodeId.'\' AND a.type='.$artifactType.' AND a.name NOT LIKE (\'untitle%\') ORDER BY a.name ASC';
			}
		}
		$query = $this->db->query ($q);
		
		//echo "<li>" .$q;
		
/*		if ($artifactType==1)
		{
			echo "<li>" .$q;
		}*/	
		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['treeId'] = $treeData->id;
					$treeIds[$i]['name'] = $treeData->name;
					$i++;
				}
			}
		}
		
		return $treeIds;
	}
	 /**
	* This method will be used to fetch the not linked trees by node id.
 	* @param $nodeId This is the variable used to hold the document node id.
	* @param $artifactType This is the variable used to hold the artifact type.	
	* @return the not linked trees of current node
	*/
	function getNotLinkedTreesByArtifactNodeId( $artifactType, $workspaceId, $workspaceType, $arrTreeIds, $treeId )
	{
		$treeIds = array();
		$userId = $_SESSION['userId'];
		$where = '';
		if(count($arrTreeIds) > 0)
		{	
			$linkedIds 	= implode(',',$arrTreeIds);
			$where 		= ' AND id NOT IN('.$linkedIds.')';		
		}
		if($workspaceId == 0)
		{	

			if ($artifactType==5)
			{
				$query = $this->db->query('SELECT a.name, a.id, a.isShared FROM teeme_tree a, teeme_contact_info b WHERE a.id=b.treeId AND a.type = 5 AND a.workspaces=\''.$workspaceId.'\' AND b.workplaceId='.$_SESSION["workPlaceId"].' AND a.id NOT IN ('.$linkedIds.') and a.name not like(\'untitle%\') AND (a.userId='.$userId.' OR a.isShared=1)');	
			}
			else
			{
				$query = $this->db->query('SELECT id, name, isShared FROM teeme_tree WHERE type='.$artifactType.' AND (userId='.$userId.' OR isShared=1) AND latestVersion=1 AND embedded=0 '.$where.' and name not like(\'untitle%\') AND workspaces=\''.$workspaceId.'\' ORDER BY name ASC');		
			}
			
			
		}
		else
		{
			if ($artifactType==5)
			{
				$query = $this->db->query('SELECT a.name, a.id, a.isShared FROM teeme_tree a, teeme_contact_info b WHERE a.id=b.treeId AND a.type = 5 AND ((a.workspaces=\''.$workspaceId.'\' AND workSpaceType = \''.$workspaceType.'\') OR b.sharedStatus!=2) AND b.workplaceId='.$_SESSION["workPlaceId"].' and a.name not like(\'untitle%\') AND a.id NOT IN ('.$linkedIds.')');	
			}
			else
			{
				$query = $this->db->query('SELECT id, name, isShared FROM teeme_tree WHERE type='.$artifactType.' AND workspaces=\''.$workspaceId.'\' AND workSpaceType = '.$workspaceType.' and name not like(\'untitle%\') AND latestVersion=1 AND embedded=0 '.$where.' ORDER BY name ASC');				
			}
		}			
		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['treeId'] = $treeData->id;
					$treeIds[$i]['name'] = stripslashes($treeData->name);
					$treeIds[$i]['isShared'] = $treeData->isShared;
					$i++;
				}
			}
		}
		
		
		return $treeIds;
	}

	 /**
	* This method will be used to fetch the linked trees by node id.
 	* @param $nodeId This is the variable used to hold the document node id.
	* @param $artifactType This is the variable used to hold the artifact type.	
	* @return the linked trees of current node
	*/
	function getLinkedExternalDocsByArtifactNodeId( $nodeId,$nodeType='',$treeId=0 )
	{
		$treeIds = array();
		if ($treeId!=0)
		{

			if ($nodeType)
			{
				/*Changed by Dashrath- Add a.docName column name in query*/
				$q ='SELECT a.docId, a.docCaption,a.version,a.docName FROM teeme_external_docs a, teeme_links_external b,teeme_node c WHERE a.docId=b.linkedDocId AND c.treeIds=\''.$treeId.'\' AND b.artifactId=\''.$nodeId.'\' AND b.artifactId=c.treeIds AND b.artifactType = '.$nodeType.' ORDER BY a.docCaption';
				
			}
			else
			{
				/*Changed by Dashrath- Add a.docName column name in query*/
				$q = 'SELECT a.docId, a.docCaption,a.version,a.docName FROM teeme_external_docs a, teeme_links_external b,teeme_node c WHERE a.docId=b.linkedDocId AND c.treeIds=\''.$treeId.'\' AND b.artifactId=\''.$nodeId.'\' AND b.artifactId=c.treeIds ORDER BY a.docCaption';
			}
			$query = $this->db->query($q);
			
		}
		else
		{
			if ($nodeType)
				/*Changed by Dashrath- Add a.docName column name in query*/
				$query = $this->db->query('SELECT a.docId, a.docCaption,a.version,a.docName FROM teeme_external_docs a, teeme_links_external b WHERE a.docId=b.linkedDocId AND b.artifactId=\''.$nodeId.'\' AND b.artifactType = '.$nodeType.' ORDER BY a.docCaption');
			else
				/*Changed by Dashrath- Add a.docName column name in query*/
				$query = $this->db->query('SELECT a.docId, a.docCaption,a.version,a.docName FROM teeme_external_docs a, teeme_links_external b WHERE a.docId=b.linkedDocId AND b.artifactId=\''.$nodeId.'\' ORDER BY a.docCaption');
		}	

		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['docId'] = $treeData->docId;
					/*Changed by Dashrath- Change docName to docCaption in left side*/
					$treeIds[$i]['docCaption'] = $treeData->docCaption;
					$treeIds[$i]['version'] = $treeData->version;
					/*Added by Dashrath- Add docName in array*/
					$treeIds[$i]['docName'] = $treeData->docName;
					$i++;
				}
			}
		}
		
		return $treeIds;
	}
	 /**
	* This method will be used to fetch the not linked trees by node id.
 	* @param $nodeId This is the variable used to hold the document node id.
	* @param $artifactType This is the variable used to hold the artifact type.	
	* @return the not linked trees of current node
	*/
	function getNotLinkedExternalDocsByArtifactNodeId( $artifactType, $workspaceId, $workspaceType, $arrTreeIds )
	{
		$treeIds = array();
		$userId = $_SESSION['userId'];
		$where = '';
		if(count($arrTreeIds) > 0)
		{	
			$linkedIds 	= implode(',',$arrTreeIds);
			$where 		= ' docId NOT IN('.$linkedIds.')';		
		}
		if($workspaceId == 0)
		{	
			/*Changed by Dashrath- Add docName column name in query*/
			$query = $this->db->query('SELECT docId,docCaption,version,docName FROM teeme_external_docs WHERE userId='.$userId.' AND workspaceId=\''.$workspaceId.'\' AND '.$where.' ORDER BY docCaption');		
		}
		else
		{
			/*Changed by Dashrath- Add docName column name in query*/
			$query = $this->db->query('SELECT docId,docCaption,version,docName FROM teeme_external_docs WHERE workspaceId=\''.$workspaceId.'\' AND workSpaceType = '.$workspaceType.' AND '.$where.' ORDER BY docCaption');				
		}			
		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['docId'] = $treeData->docId;
					/*Changed by Dashrath- Change docName to docCaption in left side*/
					$treeIds[$i]['docCaption'] = $treeData->docCaption;
					$treeIds[$i]['version'] = $treeData->version;
					/*Added by Dashrath- Add docName in array*/
					$treeIds[$i]['docName'] = $treeData->docName;
					$i++;
				}
			}
		}
		return $treeIds;
	}
	
	
	
	function getCurrentLinkedExternalDocsByArtifactNodeId( $nodeId,$nodeType,$lastLogin )
	{
		$treeIds = array();
		/*Changed by Dashrath- Add a.docName column name in query*/
		$query = $this->db->query('SELECT a.docId, a.docCaption, a.version, a.docName FROM teeme_external_docs a, teeme_links_external b WHERE a.docId=b.linkedDocId AND b.artifactId=\''.$nodeId.'\' AND b.artifactType = '.$nodeType.' AND (b.createdDate >\''.$lastLogin.'\') ORDER BY a.docCaption');
	
		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['docId'] = $treeData->docId;
					/*Changed by Dashrath- Change docName to docCaption in left side*/
					$treeIds[$i]['docCaption'] = $treeData->docCaption;
					$treeIds[$i]['version'] = $treeData->version;
					/*Added by Dashrath- Add docName in array*/
					$treeIds[$i]['docName'] = $treeData->docName;
					$i++;
				}
			}
		}
		
	
		return $treeIds;
	}
	 /**
	* This method will be used to add the links
	* @param $linkIds This is the variable used to hold the tree ids by comma seperated.
 	* @param $nodeId This is the variable used to hold the document node id.
	* @param $nodeType This is the variable used to hold the node type.	
	* @update the links and return the status
	*/
	function addLinks( $linkIds, $nodeId, $nodeType,$linkCreatedDate='',$ownerId)
	{
		//Manoj: load time manager 
		if($linkCreatedDate=='')
		{
			
			$this->load->model('dal/time_manager');
			$linkCreatedDate	= $this->time_manager->getGMTTime();	
			
		}
		//Manoj load time manager end
		$treeIds = explode(',',$linkIds);
		$status = false;
		if(count($treeIds)>0)
		{
			foreach($treeIds as $treeId)
			{
		
				$query = $this->db->query('INSERT INTO teeme_links(treeId, artifactId, artifactType,createdDate,ownerId) VALUES('.$treeId.','.$nodeId.','.$nodeType.',"'.$linkCreatedDate.'","'.$ownerId.'")');	
				if($query)
				{
					$status = true;
				}	
				else
				{
					$status = false;
				}			
			}
		}
		
		return $status;
	}
	
	function addExternalLinks( $linkIds, $nodeId, $nodeType,$ownerId)
	{
		$docIds = explode(',',$linkIds);
		$status = false;
		if(count($docIds)>0)
		{
			foreach($docIds as $docId)
			{
			
				$query = $this->db->query('INSERT INTO teeme_links_external(linkedDocId, artifactId, artifactType,createdDate,ownerId) VALUES('.$docId.','.$nodeId.','.$nodeType.',NOW(),'.$ownerId.')');	
				if($query)
				{
					$status = true;
				}	
				else
				{
					$status = false;
				}			
			}
		}
		
		return $status;
	}
	
	
	function removeLinks( $linkIds, $nodeId, $nodeType)
	{
		$treeIds = explode(',',$linkIds);
		$status = false;
		if(count($treeIds)>0)
		{
			foreach($treeIds as $treeId)
			{
		
				if (!empty($treeId))
				{
					$query = $this->db->query('DELETE FROM teeme_links WHERE treeId='.$treeId.' AND artifactId='.$nodeId.' AND artifactType='.$nodeType);
					if($query)
					{
						$status = true;
					}	
					else
					{
						$status = false;
					}				
				}
			}
		}
		
		return $status;
	}
	
	function removeAllLinksByNodeId( $nodeId, $nodeType)
	{

		$status = false;
				
				$query = $this->db->query('DELETE FROM teeme_links WHERE artifactId='.$nodeId.' AND artifactType='.$nodeType);
				if($query)
				{
					$status = true;
				}	
				else
				{
					$status = false;
				}			

		
		
		return $status;
	}

	function removeAllExternalDocsByNodeId( $nodeId, $nodeType)
	{

		$status = false;
				
				$query = $this->db->query('DELETE FROM teeme_links_external WHERE artifactId='.$nodeId.' AND artifactType='.$nodeType);
				if($query)
				{
					$status = true;
				}	
				else
				{
					$status = false;
				}			

		
		
		return $status;
	}
	
	function removeExternalLinks( $linkIds, $nodeId, $nodeType)
	{
		$docIds = explode(',',$linkIds);
		$status = false;
		if(count($docIds)>0)
		{
			foreach($docIds as $docId)
			{
				if (!empty($docId))
				{
				$query = $this->db->query('DELETE FROM teeme_links_external WHERE linkedDocId='.$docId.' AND artifactId='.$nodeId.' AND artifactType='.$nodeType);
				if($query)
				{
					$status = true;
				}	
				else
				{
					$status = false;
				}
				}			
			}
		}
		
		return $status;
	}
	
	
	function removeTags($tIds)
	{
		$tagIds = explode(',',$tIds);
		$status = false;
		if(count($tagIds)>0)
		{
			foreach($tagIds as $tagId)
			{
				$query = $this->db->query('DELETE FROM teeme_tag WHERE tagId='.$tagId);
				if($query)
				{
					$status = true;
				}	
				else
				{
					$status = false;
				}			
			}
		}
		
		return $status;
	}
	function insertlink( $treeId, $nodeId, $nodeType)
	{
			
		$query = $this->db->query('INSERT INTO teeme_links(treeId, artifactId, artifactType) VALUES('.$treeId.','.$nodeId.','.$nodeType.')');	
	}				
	//Get the country name by country id
	function getCountryNameByCountryId($countryId)	
	{		
		$countryName = '';
		$query = $this->db->query('SELECT countryName FROM teeme_countries WHERE countryId = '.$countryId);
		if($query->num_rows() > 0)
		{			
			$tmpData 	= $query->row();
			$countryName = $tmpData->countryName;
		}		
		
		return $countryName;											
	}
	 /**
	* This method will be used to fetch the tree id from the database.
 	* @return The id of the tree
	*/
	public function getTreeIdByNodeId_identity($nodeId)
	{
		$treeId= 0;		
		// Get tree id 
		$query = $this->db->query('SELECT treeIds FROM teeme_node WHERE id = '.$nodeId);
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach ($query->result() as $treeDate)
			{	
				$treeId = $treeDate->treeIds;				
			}
		}		
		return $treeId;
	}
	
	// Get Leaf Tree id by Leaf Id
	public function getLeafTreeIdByLeafId ($leafId,$type=2)
	{
		$leafTreeId	= '';						
		$query = $this->db->query("SELECT tree_id FROM teeme_leaf_tree WHERE leaf_id = '".$leafId."' AND type='".$type."'");

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				$leafTreeId = $row->tree_id;					

			}				
		}		
		return $leafTreeId;	
	}	
	
	public function getLeafIdByLeafTreeId ($treeId)
	{
		$leafId = '';		
		$query = $this->db->query("SELECT leaf_id FROM teeme_leaf_tree WHERE tree_id = '".$treeId."'");

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				$leafId = $row->leaf_id;					
			}				
		}		
		return $leafId;	
	}	
	
	public function getNodeIdByLeafId($leafId)
	{
	
		$query = $this->db->query('SELECT id FROM teeme_node WHERE leafId='.$leafId);								
		foreach($query->result() as $row)
		{
			$nodeId = $row->id;
		}	
		return $nodeId; 		
	} 

	public function isTalkActive ($leafTreeId)
	{
				
		$query = $this->db->query("SELECT count(*) AS total FROM teeme_leaf_tree WHERE tree_id = '".$leafTreeId."' AND updates > 0");

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				if ($row->total > 0)
					return 1;				
			}		
		}		
		return 0;
	}
    
    /*Changed by Dashrath- Add $config for load db*/    
	public function isPlaceManager($workPlaceId=0,$userId=0,$config=0)
	{
		if ($workPlaceId!=0)
		{	
			/*Changed by Dashrath- Add if else condition for load db*/
			if ($config!=0)
	        {
	            $placedb = $this->load->database($config,TRUE);

	            $query = $placedb->query("SELECT userId FROM teeme_users WHERE workPlaceId = '".$workPlaceId."' AND userId = '".$userId."' AND isPlaceManager='1'");
	        }
			else
			{
				$query = $this->db->query("SELECT userId FROM teeme_users WHERE workPlaceId = '".$workPlaceId."' AND userId = '".$userId."' AND isPlaceManager='1'");
			}
			/*Dashrath- changes end*/

			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
                    if ($row->userId > 0)
						return $row->userId;				
				}			
		
			}		
			return 0;	
		}
                return 0;
	}
	
	public function isDefaultPlaceManagerSpace($workSpaceId=0,$workPlaceId=0)
	{
		
			if ($workSpaceId!=0)
			{		
				$query = $this->db->query("SELECT workSpaceId FROM teeme_work_space WHERE workSpaceId = '".$workSpaceId."' AND workPlaceId='".$workPlaceId."' AND defaultPlaceManagerSpace='1'");
	
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						if ($row->workSpaceId > 0)
							return 1;				
					}			
			
				}		
				return 0;	
			}
        return 0;
	}
	
	public function getPlaceManagerDefaultSpace($workPlaceId=0,$config=0)
	{
			if ($workPlaceId!=0)
			{		
				$query = "SELECT workSpaceId FROM teeme_work_space WHERE workPlaceId = '".$workPlaceId."' AND defaultPlaceManagerSpace='1'";
                if ($config!=0)
                {
                    $placedb = $this->load->database($config,TRUE);
                    $result = $placedb->query($query);
                }

                else
                {
                    $result = $this->db->query($query);	
                }
	
				if($result->num_rows() > 0)
				{
					foreach ($result->result() as $row)
					{	
						$workSpaceId = $row->workSpaceId;			
					}			
			
				}		
				return $workSpaceId;	
			}
        return 0;
	}
	
	/*Changed by Dashrath- Add $config for load db*/
	public function isWorkSpaceMember($workSpaceId=0,$userId='', $config=0)
	{
		if ($workSpaceId!=0)
		{	
			/*Changed by Dashrath- Add if else condition for load db*/
			if ($config!=0)
	        {
	            $placedb = $this->load->database($config,TRUE);

	            $query = $placedb->query("SELECT count(*) AS total FROM teeme_work_space_members WHERE workSpaceId = '".$workSpaceId."' AND workSpaceUserId = '".$userId."'");
	        }
			else
			{
				$query = $this->db->query("SELECT count(*) AS total FROM teeme_work_space_members WHERE workSpaceId = '".$workSpaceId."' AND workSpaceUserId = '".$userId."'");
			}
			/*Dashrath- changes end*/	
			

			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					if ($row->total > 0)
						return 1;				
				}		
			}		
			return 0;	
		}
		else
		{
			return 1;
		}
	}
	
	/*Changed by Dashrath- Add $config for load db*/
	public function isSubWorkSpaceMember($subWorkSpaceId=0,$userId='',$workSpaceType=1, $config=0)
	{
		if ($subWorkSpaceId!=0)
		{	
			/*Changed by Dashrath- Add if else condition for load db*/
			if ($config!=0)
	        {
	            $placedb = $this->load->database($config,TRUE);

	            $query = $placedb->query("SELECT count(*) AS total FROM teeme_sub_work_space_members WHERE subWorkSpaceId = '".$subWorkSpaceId."' AND subWorkSpaceUserId = '".$userId."'");
	        }
			else
			{
				$query = $this->db->query("SELECT count(*) AS total FROM teeme_sub_work_space_members WHERE subWorkSpaceId = '".$subWorkSpaceId."' AND subWorkSpaceUserId = '".$userId."'");
			}
			/*Dashrath- changes end*/	
			

			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					if ($row->total > 0)
						return 1;				
				}		
			}		
		return 0;	
		}
		else
		{
			return 1;
		}
	}
	
	/**
	* This method will be used for update the document name to database.
 	* @param $treeId This is the variable used to hold the tree ID .
	* @param $documentName This is the variable used to hold the document name
	* @update the document name
	*/
	public function updateDocumentName( $treeId, $documentName )
	{	
		$bResult  = $this->db->query('UPDATE teeme_tree SET old_name=name,name=\''.$this->db->escape_str($documentName).'\' WHERE id='.$treeId);			
		if($bResult)
		{									
			return true;
		}	
		else
		{
			return false;
		}				
	}	
	public function checkSuccessors($nodeId){
		$query = $this->db->query( "SELECT * FROM teeme_node where id= ".$nodeId);		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				if(trim($row->successors)){
					return trim($row->successors);
				}else{
					return 0;
				}
			}
		}else{
			return 0;
		}
	}	
	public function getTreeDetailsBySearchOptions($workSpaceId, $workSpaceType, $type=0, $created=0, $modified=0, $list='', $by=0, $start = 0, $totalRecords = 0)
	{
	
		$day 	= date('d');
		$month 	= date('m');
		$year	= date('Y');	

		$today = $year."-".$month."-".$day;				
						
		$type = implode (',',$type);
		$by = implode (',',$by);
		
	
		$treeDetails	= array();	
		$limit	= '';
		if($totalRecords > 0)
		{
			$limit = ' LIMIT '.$start.','.$totalRecords;
		}
		if($workSpaceId != NULL)
		{
			// Get information of particular document
			if($workSpaceId == 0)
			{
				if ($type != 0)
				{
					$where = 'workspaces='.$workSpaceId.' AND userId = '.$_SESSION['userId'].' AND type IN ('.$type.')';				
				}
				else
				{
					$where = 'workspaces='.$workSpaceId.' AND userId = '.$_SESSION['userId'].'';	
				}
			}
			else
			{
				if ($type != 0)
				{
					$where = 'workspaces = \''.$workSpaceId.'\' AND workSpaceType= '.$workSpaceType.' AND type IN ('.$type.')';
				}
				else
				{
					$where = 'workspaces = \''.$workSpaceId.'\' AND workSpaceType= '.$workSpaceType.'';
				}
			}	

			$q = 'SELECT id, name, type, userId, createdDate, editedDate,status FROM teeme_tree WHERE '.$where.' AND latestVersion=1 AND embedded=0 AND name not like(\'untile%\') AND name <>\' \'';
				if ($created != '')
				{
					$daysAgo = "-" .$created ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND createdDate >= '".$daysAgo."'";
				}
				if ($modified != '')
				{
					$daysAgo = "-" .$modified ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND editedDate >= '".$daysAgo."'";
				}	
				if ($by != 0)
				{
					$q .= ' AND userId IN ('.$by.')';
				}					

				if ($list == 'desc')
				{
					$q .= ' ORDER BY name DESC'.$limit;
				}
				else if ($list == 'asc')
				{
					$q .= ' ORDER BY name ASC'.$limit;
				}
				else
				{
					$q .= ' ORDER BY createdDate DESC'.$limit;
				}

			$query = $this->db->query($q);				

			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$treeDetails[$row->id]['id'] 				= $row->id;	
					$treeDetails[$row->id]['name'] 				= $row->name;	
					$treeDetails[$row->id]['type'] 				= $row->type;	
					$treeDetails[$row->id]['userId'] 			= $row->userId;	
					$treeDetails[$row->id]['createdDate'] 		= $row->createdDate;	
					$treeDetails[$row->id]['editedDate'] 		= $row->editedDate;
					$treeDetails[$row->id]['status'] 			= $row->status;
										
				}				
			}
		}
		
		return $treeDetails;				
	}	


	public function getSharedTreeDetailsBySearchOptions($workSpaceId, $workSpaceType, $type=0, $created=0, $modified=0, $list='', $by=0, $start = 0, $totalRecords = 0)
	{

		$day 	= date('d');
		$month 	= date('m');
		$year	= date('Y');	

		$today = $year."-".$month."-".$day;				
						
		$type = implode (',',$type);
		$by = implode (',',$by);
		
					
		$treeDetails	= array();	
		$limit	= '';
		if($totalRecords > 0)
		{
			$limit = ' LIMIT '.$start.','.$totalRecords;
		}
		if($workSpaceId != NULL)
		{
			// Get information of particular document
			if($workSpaceId == 0)
			{
				if ($type != 0)
				{
					$where = 'workspaces='.$workSpaceId.' AND (userId = '.$_SESSION['userId'].' OR isShared=1) AND type IN ('.$type.')';				
				}
				else
				{
					$where = 'workspaces='.$workSpaceId.' AND (userId = '.$_SESSION['userId'].' OR isShared=1)';	
				}
			}
			else
			{
				if ($type != 0)
				{
					$where = 'workspaces = \''.$workSpaceId.'\' AND workSpaceType= '.$workSpaceType.' AND type IN ('.$type.')';
				}
				else
				{
					$where = 'workspaces = \''.$workSpaceId.'\' AND workSpaceType= '.$workSpaceType.'';
				}
			}	
			
			$q = 'SELECT id, name, type, userId, createdDate, editedDate,status,isShared FROM teeme_tree WHERE '.$where.' AND latestVersion=1 AND embedded=0 AND name not like(\'untile%\') AND name <>\' \'';
				if ($created != '')
				{
					$daysAgo = "-" .$created ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND createdDate >= '".$daysAgo."'";
				}
				if ($modified != '')
				{
					$daysAgo = "-" .$modified ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND editedDate >= '".$daysAgo."'";
				}	
				if ($by != 0)
				{
					$q .= ' AND userId IN ('.$by.')';
				}					

				if ($list == 'desc')
				{
					$q .= ' ORDER BY name DESC'.$limit;
				}
				else if ($list == 'asc')
				{
					$q .= ' ORDER BY name ASC'.$limit;
				}
				else
				{
					$q .= ' ORDER BY createdDate DESC'.$limit;
				}

			$query = $this->db->query($q);		

			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	

						if ($row->isShared==0 || $row->userId==$_SESSION['userId'])
						{	
							$treeDetails[$row->id]['id'] 				= $row->id;	
							$treeDetails[$row->id]['name'] 				= $row->name;	
							$treeDetails[$row->id]['type'] 				= $row->type;	
							$treeDetails[$row->id]['userId'] 			= $row->userId;	
							$treeDetails[$row->id]['createdDate'] 		= $row->createdDate;	
							$treeDetails[$row->id]['editedDate'] 		= $row->editedDate;
							$treeDetails[$row->id]['status'] 			= $row->status;
						}
					
						else 
						{	
							$sharedMembers	= $this->getSharedMembersByTreeId($row->id);
								if (in_array($_SESSION['userId'],$sharedMembers))
								{
									$treeDetails[$row->id]['id'] 				= $row->id;	
									$treeDetails[$row->id]['name'] 				= $row->name;	
									$treeDetails[$row->id]['type'] 				= $row->type;	
									$treeDetails[$row->id]['userId'] 			= $row->userId;	
									$treeDetails[$row->id]['createdDate'] 		= $row->createdDate;	
									$treeDetails[$row->id]['editedDate'] 		= $row->editedDate;
									$treeDetails[$row->id]['status'] 			= $row->status;
								}
						}
										
				}				
			}
		}
	
		return $treeDetails;				
	}	
	
	public function getTalkDetailsBySearchOptions($workSpaceId, $workSpaceType, $created=0, $modified=0, $list='', $by=0, $start = 0, $totalRecords = 0)
	{
			
		$day 	= date('d');
		$month 	= date('m');
		$year	= date('Y');

		$today = $year."-".$month."-".$day;				

		$by = implode (',',$by);		
					
		$treeDetails	= array();	
		$limit	= '';
		if($totalRecords > 0)
		{
			$limit = ' LIMIT '.$start.','.$totalRecords;
		}
		if($workSpaceId != NULL)
		{
			// Get information of particular document
			if($workSpaceId == 0)
			{
					$where = 'a.workspaces='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].'';	
			}
			else
			{

					$where = 'a.workspaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.'';
			}	
			
			$q = 'SELECT a.id, a.parentTreeId, a.name, a.type, a.userId, a.createdDate, a.editedDate, a.status FROM teeme_tree a, teeme_leaf_tree b WHERE '.$where.' AND a.id=b.tree_id AND latestVersion=1 AND embedded=1 AND name not like(\'untile%\') AND name <>\' \'';
				if ($created != '')
				{
					$daysAgo = "-" .$created ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND a.createdDate >= '".$daysAgo."'";
				}
				if ($modified != '')
				{
					$daysAgo = "-" .$modified ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND a.editedDate >= '".$daysAgo."'";
				}	
				if ($by != 0)
				{
					$q .= ' AND a.userId IN ('.$by.')';
				}					

				if ($list == 'desc')
				{
					$q .= ' ORDER BY name DESC'.$limit;
				}
				else if ($list == 'asc')
				{
					$q .= ' ORDER BY a.name ASC'.$limit;
				}
				else
				{
					$q .= ' ORDER BY a.editedDate DESC'.$limit;
				}
	

		
			$query = $this->db->query($q);	
		


			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$treeDetails[$row->id]['id'] 				= $row->id;	
					$treeDetails[$row->id]['parentTreeId'] 		= $row->parentTreeId;	
					$treeDetails[$row->id]['name'] 				= $row->name;	
					$treeDetails[$row->id]['type'] 				= $row->type;	
					$treeDetails[$row->id]['userId'] 			= $row->userId;	
					$treeDetails[$row->id]['createdDate'] 		= $row->createdDate;	
					$treeDetails[$row->id]['editedDate'] 		= $row->editedDate;
					$treeDetails[$row->id]['status'] 			= $row->status;
										
				}				
			}
		}
		return $treeDetails;				
	}	
	
	
	 /**
	* This method will be used to fetch the tag details from the database.
 	* @return The tag details as an array
	*/
	public function getTagDetailsBySearchOptions( $workSpaceId, $workSpaceType, $tagType=0, $responseTagType=0, $applied=0, $due =0, $list = '', $users =0 )
	{
		$arrTagDetails = array();	
		$responseTagType = implode (',',$responseTagType);	
		$users = implode (',',$users);
		
		$i = 0;	
		
		
		if(in_array(2,$tagType) || $tagType=='')
		{
					
			$q  = 'SELECT a.*, c.tagType as tagName FROM teeme_tag a, teeme_tree b, teeme_tag_types c, teeme_node d WHERE a.tagType = 2 AND a.tag = c.tagTypeId AND a.artifactId = d.id AND b.id = d.treeIds AND c.workPlaceId = '.$_SESSION['workPlaceId'].' AND b.workspaces='.$workSpaceId.' AND b.workSpaceType='.$workSpaceType.'';

				if ($applied != '')
				{
					$daysAgo = "-" .$applied ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND a.createdDate >= '".$daysAgo."'";
				}			
				if ($list != '')
				{
					if ($list == 'desc')
					{
						$q .= ' ORDER BY c.tagType DESC';
					}
					else if ($list == 'asc')
					{
						$q .= ' ORDER BY c.tagType ASC';
					}
					else
					{
						$q .= ' ORDER BY a.createdDate DESC';
					}
				}				
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails['simple'][$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails['simple'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['simple'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['simple'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['simple'][$i]['tagComment'] 		= $tagData->tagName;
							$arrTagDetails['simple'][$i]['artifactId'] 		= $tagData->artifactId;
							$arrTagDetails['simple'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['simple'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['simple'][$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails['simple'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}		
		}

		if(in_array(3,$tagType) || $tagType=='')
		{
					
			$q  = 'SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.tagType = 3 AND a.tagId = b.tagId AND b.status = 1 AND c.id = d.treeIds AND a.artifactId = d.id AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
			
					
				if ($responseTagType != '')
				{
					$q .= ' AND a.tag IN ('.$responseTagType.')';
				}			
				
				
				if ($applied != '')
				{
					$daysAgo = "-" .$applied ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND a.createdDate >= '".$daysAgo."'";
				}	
				
				if ($due != '')
				{
					$daysAgo = "+" .$due ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$day 	= date('d');
					$month 	= date('m');
					$year	= date('Y');	

					$today = $year."-".$month."-".$day;
					
					$today .= " 00:00:00";
					
					$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
				}					
				if ($users != 0)
				{
					$q .= ' AND b.userId IN ('.$users.')';
				}					
						
				if ($list != '')
				{
					if ($list == 'desc')
					{
						$q .= ' ORDER BY a.comments DESC';
					}
					else if ($list == 'asc')
					{
						$q .= ' ORDER BY a.comments ASC';
					}
					else
					{
						$q .= ' ORDER BY a.createdDate DESC';
					}
				}				
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails['response'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['response'][$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['response'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}		
		}

		if(in_array(5,$tagType) || $tagType=='')
		{
		
			if($workSpaceId == 0)
			{
					$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
			}
			else
			{
					$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
			}
					
			$q = 'SELECT a.*, b.name as contactName FROM teeme_tag a, teeme_tree b WHERE '.$where.' AND a.tagType = 5 AND a.tag = b.id';
				if ($applied != '')
				{
					$daysAgo = "-" .$applied ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND a.createdDate >= '".$daysAgo."'";
				}			
				if ($list != '')
				{
					if ($list == 'desc')
					{
						$q .= ' ORDER BY b.name DESC';
					}
					else if ($list == 'asc')
					{
						$q .= ' ORDER BY b.name ASC';
					}
					else
					{
						$q .= ' ORDER BY a.createdDate DESC';
					}
				}				
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails['contact'][$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails['contact'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['contact'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['contact'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['contact'][$i]['tagComment'] 	= $tagData->contactName;
							$arrTagDetails['contact'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['contact'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['contact'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['contact'][$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails['contact'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}		
		}
	
		return $arrTagDetails;
	}


	 /**
	* This method will be used to fetch the tag details from the database.
 	* @return The tag details as an array
	*/
	public function getMyTags( $workSpaceId, $workSpaceType, $tagType=0, $responseTagType=0, $applied=0, $due =0, $list = '', $users =0, $for_by=1 )
	{
		$arrTagDetails = array();	
		$responseTagType = implode (',',$responseTagType);	
		$users = implode (',',$users);
		
		$i = 0;	
		
		
		if(in_array(2,$tagType) || $tagType=='') // Simple Tags
		{ 
					
			$q  = 'SELECT a.*, c.tagType as tagName FROM teeme_tag a, teeme_tree b, teeme_tag_types c, teeme_node d WHERE a.tagType = 2 AND a.tag = c.tagTypeId AND a.artifactId = d.id AND b.id = d.treeIds AND a.ownerId='.$_SESSION['userId'].' AND c.workPlaceId = '.$_SESSION['workPlaceId'].' AND b.workspaces='.$workSpaceId.' AND b.workSpaceType='.$workSpaceType.'';

				if ($applied != '')
				{
					$daysAgo = "-" .$applied ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND a.createdDate >= '".$daysAgo."'";
				}			
				if ($list != '')
				{
					if ($list == 'desc')
					{
						$q .= ' ORDER BY c.tagType DESC';
					}
					else if ($list == 'asc')
					{
						$q .= ' ORDER BY c.tagType ASC';
					}
					else
					{
						$q .= ' ORDER BY a.createdDate DESC';
					}
				}	
				else
				{
					$q .= ' ORDER BY c.tagType ASC';
				}			
			$query = $this->db->query($q);

				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails['simple'][$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails['simple'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['simple'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['simple'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['simple'][$i]['tagComment'] 		= $tagData->tagName;
							$arrTagDetails['simple'][$i]['artifactId'] 		= $tagData->artifactId;
							$arrTagDetails['simple'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['simple'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['simple'][$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails['simple'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}		
		}

		if(in_array(3,$tagType) || $tagType=='') // Response Tags
		{
			// For Leaf Tags
			
			if ($for_by==2) // tags by me
			{		
				$q  = 'SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.artifactType=2 AND a.tagType = 3 AND a.tagId = b.tagId AND b.status = 1 AND c.id = d.treeIds AND a.artifactId = d.id AND a.ownerId='.$_SESSION['userId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
			}
			else // tags for me
			{
				$q  = 'SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.artifactType=2 AND a.tagType = 3 AND a.tagId = b.tagId AND b.status = 1 AND c.id = d.treeIds AND a.artifactId = d.id AND b.userId='.$_SESSION['userId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
	
			}
				
				if ($responseTagType != '')
				{
					$q .= ' AND a.tag IN ('.$responseTagType.')';
				}			

				if ($applied != '')
				{
					$daysAgo = "-" .$applied ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND a.createdDate >= '".$daysAgo."'";
				}	
				
				if ($due != '')
				{
					$daysAgo = "+" .$due ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$day 	= date('d');
					$month 	= date('m');
					$year	= date('Y');	

					$today = $year."-".$month."-".$day;
					
					$today .= " 00:00:00";
					
					$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
				}					
				if ($users != 0)
				{
					$q .= ' AND b.userId IN ('.$users.')';
				}					

				if ($list != '')
				{
					if ($list == 'desc')
					{
						$q .= ' ORDER BY a.comments DESC';
					}
					else if ($list == 'asc')
					{
						$q .= ' ORDER BY a.comments ASC';
					}
					else
					{
						$q .= ' ORDER BY a.createdDate DESC';
					}
				}	
				else
				{
					$q .= ' ORDER BY a.endTime ASC';
				}			
			$query = $this->db->query($q);
			
			
			if($query->num_rows() > 0)
			{
					foreach ($query->result() as $tagData)
					{
						$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;	
						$arrTagDetails['response'][$i]['tagType'] 		= $tagData->tagType;	
						$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;	
						$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;
						$arrTagDetails['response'][$i]['tagComment'] 	= $tagData->comments;
						$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;
						$arrTagDetails['response'][$i]['artifactType'] 	= $tagData->artifactType;	
						$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;	
						$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;	
						$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;	
						$i++;	
					}
			}
				
				
			// For Seed Tags	

			if ($for_by==2) // tags by me
			{		
				$q  = 'SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.artifactType=1 AND a.tagType = 3 AND a.tagId = b.tagId AND b.status = 1 AND c.id = d.treeIds AND a.artifactId = c.id AND a.ownerId='.$_SESSION['userId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
			}
			else // tags for me
			{
				$q  = 'SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.artifactType=1 AND a.tagType = 3 AND a.tagId = b.tagId AND b.status = 1 AND c.id = d.treeIds AND a.artifactId = c.id AND b.userId='.$_SESSION['userId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
	
			}
				
				if ($responseTagType != '')
				{
					$q .= ' AND a.tag IN ('.$responseTagType.')';
				}		

				if ($applied != '')
				{
					$daysAgo = "-" .$applied ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$q .= " AND a.createdDate >= '".$daysAgo."'";
				}	
				
				if ($due != '')
				{
					$daysAgo = "+" .$due ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$day 	= date('d');
					$month 	= date('m');
					$year	= date('Y');	

					$today = $year."-".$month."-".$day;
					
					$today .= " 00:00:00";
					
					$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
				}					
				if ($users != 0)
				{
					$q .= ' AND b.userId IN ('.$users.')';
				}					

				if ($list != '')
				{
					if ($list == 'desc')
					{
						$q .= ' ORDER BY a.comments DESC';
					}
					else if ($list == 'asc')
					{
						$q .= ' ORDER BY a.comments ASC';
					}
					else
					{
						$q .= ' ORDER BY a.createdDate DESC';
					}
				}	
				else
				{
					$q .= ' ORDER BY a.endTime ASC';
				}			
			$query = $this->db->query($q);
			
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $tagData)
				{
					$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;	
					$arrTagDetails['response'][$i]['tagType'] 		= $tagData->tagType;	
					$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;	
					$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;
					$arrTagDetails['response'][$i]['tagComment'] 	= $tagData->comments;
					$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;
					$arrTagDetails['response'][$i]['artifactType'] 	= $tagData->artifactType;	
					$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;	
					$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;	
					$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;	
					$i++;	
				}
			}
					
		}

		if(in_array(5,$tagType) || $tagType=='') // Contact Tags
		{
		
			if($workSpaceId == 0)
			{
				$where = 'b.workspaces='.$workSpaceId.' AND a.ownerId='.$_SESSION['userId'].'';	
			}
			else
			{
				$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.' AND a.ownerId='.$_SESSION['userId'].'';
			}
					
			$q = 'SELECT a.*, b.name as contactName FROM teeme_tag a, teeme_tree b WHERE '.$where.' AND a.tagType = 5 AND a.tag = b.id';
			if ($applied != '')
			{
				$daysAgo = "-" .$applied ." days";
				
				$daysAgo = strtotime ($daysAgo);
			
				$daysAgo = date("Y-m-d",$daysAgo);	
				
				$daysAgo .= " 00:00:00";
				
				$q .= " AND a.createdDate >= '".$daysAgo."'";
			}			
			if ($list != '')
			{
				if ($list == 'desc')
				{
					$q .= ' ORDER BY b.name DESC';
				}
				else if ($list == 'asc')
				{
					$q .= ' ORDER BY b.name ASC';
				}
				else
				{
					$q .= ' ORDER BY a.createdDate DESC';
				}
			}	
			else
			{
				$q .= ' ORDER BY b.name ASC';
			}		
			$query = $this->db->query($q);

				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails['contact'][$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails['contact'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['contact'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['contact'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['contact'][$i]['tagComment'] 	= $tagData->contactName;
							$arrTagDetails['contact'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['contact'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['contact'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['contact'][$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails['contact'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}		
		}
	
		return $arrTagDetails;
	}
	
	public function getNodeCountByTag ( $workSpaceId, $workSpaceType, $tagType=0, $tagComment=0, $applied=0, $due =0, $list = '', $users =0 ,$tag=0,$artifactType=2 )
	{
		$arrTagDetails = array();	
		
		$users = implode (',',$users);
		$i = 0;	

		if($tagType == 2) // Simple Tags
		{	
		 	$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a,teeme_tag_types b WHERE a.tag='".$tag."' AND a.tag = b.tagTypeId AND b.workPlaceId='".$_SESSION['workPlaceId']."'";
			$qry1Result = $this->db->query($qry1);
			
				if($qry1Result->num_rows() > 0)
				{
					$count=0;
					foreach ($qry1Result->result() as $result)
					{
						if ($result->artifactType==2)
						{
							// Leaf Tags
							
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.id as treeId,c.type as treeType, e.contents as leafContents,d.predecessor FROM teeme_tag a, teeme_tag_types b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2 AND c.id = d.treeIds AND a.artifactId = d.id AND d.id = e.nodeId AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND c.workspaces='.$workSpaceId.' AND c.	workSpaceType='.$workSpaceType.'';
						}
						else
						{ 
							// Seed Tags 
			
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tag_types b, teeme_tree c WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2  AND a.artifactId = c.id  AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
						}
						
						if ($applied != 0)
						{
							$daysAgo = "-" .$applied ." days";
						
							$daysAgo = strtotime ($daysAgo);
					
							$daysAgo = date("Y-m-d",$daysAgo);	
						
							$daysAgo .= " 00:00:00";
						
							$q .= " AND a.createdDate >= '".$daysAgo."'";
						}			
						if ($list != 0)
						{
							if ($list == 'desc')
							{
								$q .= ' ORDER BY b.tagType DESC';
							}
							else if ($list == 'asc')
							{
								$q .= ' ORDER BY b.tagType ASC';
							}
							else
							{
								$q .= ' ORDER BY a.createdDate DESC';
							}
						}
							
					$query = $this->db->query($q);
					//echo $q; exit;
						if ($query->num_rows()>0)
						{
							$count++;
						}
					}
				}	
				return $count;
		}

		if($tagType == 3) // Response Tags
		{
				if ($users != '')
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";					
					$qry1Result = $this->db->query($qry1);
					
					if($qry1Result->num_rows() > 0)
					{
						$count=0;
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								// Leaf Tags
								$q  = 'SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, e.contents as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = d.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND c.workspaces='.$workSpaceId.' AND c.	workSpaceType='.$workSpaceType.'';
							}
							else
							{
								// Tree Tags
								$q  = 'SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = c.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND c.workspaces='.$workSpaceId.' AND c.	workSpaceType='.$workSpaceType.'';
							}
				
							if ($responseTagType != '')
							{
								$q .= ' AND a.tag IN ('.$responseTagType.')';
							}			
				
							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}					
							if ($users != '')
							{
								$q .= ' AND b.userId IN ('.$users.')';
							}					
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
							$query = $this->db->query($q);
								if ($query->num_rows()>0)
								{
									$count++;
									//echo "here"; exit;
								}				

						}
						return $count;
					}
				}
				else
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";
					$qry1Result = $this->db->query($qry1);
					//echo $qry1; exit;

					if($qry1Result->num_rows() > 0)
					{
						$count =0;
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								$q  = "SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, e.contents as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = d.id AND d.id = e.nodeId AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."'";
							}
							else
							{
								$q  = "SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = c.id AND d.id = e.nodeId AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."'";
							}

							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}									
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
	
						$query = $this->db->query($q);
								if ($query->num_rows()>0)
								{
									$count++;
									//echo "here"; exit;
								}						
					}
					return $count;
				}
			}	
		}

		if($tagType == 5) // Contact Tags
		{
			
			$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.tag='".$tag."' AND a.tagType=5";
			$qry1Result = $this->db->query($qry1);
			if($qry1Result->num_rows() > 0)
			{
				$count=0;
				foreach ($qry1Result->result() as $result)
				{
					if($workSpaceId == 0)
					{
						$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
					}
					else
					{
						$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
					}
					if ($result->artifactType==2)
					{	
						// Leaf Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId,b.type as treeType, d.contents as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE '.$where.' AND a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND b.id = c.treeIds AND a.artifactId = c.id AND c.leafId = d.id';
					}
					else
					{
						// Tree Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId,b.type as treeType, b.name as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE '.$where.' AND a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND b.id = c.treeIds AND a.artifactId = b.id AND c.leafId = d.id';
			
					}	
					if ($applied != 0)
					{
						$daysAgo = "-" .$applied ." days";
					
						$daysAgo = strtotime ($daysAgo);
				
						$daysAgo = date("Y-m-d",$daysAgo);	
					
						$daysAgo .= " 00:00:00";
					
						$q .= " AND a.createdDate >= '".$daysAgo."'";
					}			
					if ($list != 0)
					{
						if ($list == 'desc')
						{
							$q .= ' ORDER BY b.name DESC';
						}
						else if ($list == 'asc')
						{
							$q .= ' ORDER BY b.name ASC';
						}
						else
						{
							$q .= ' ORDER BY a.createdDate DESC';
						}
					}				
					$query = $this->db->query($q);
								if ($query->num_rows()>0)
								{
									$count++;
									//echo "here"; exit;
								}	
				}
				return $count;
			}
		}
	}

	
	public function getNodesByTagSearchOptions ( $workSpaceId, $workSpaceType, $tagType=0, $tagComment=0, $applied=0, $due =0, $list = '', $users =0 ,$tag=0,$artifactType=2 )
	{
		$arrTagDetails = array();	
		
		$users = implode (',',$users);
		$i = 0;	

		if($tagType == 2) // Simple Tags
		{	
		 	$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a,teeme_tag_types b WHERE a.tag='".$tag."' AND a.tag = b.tagTypeId AND b.workPlaceId='".$_SESSION['workPlaceId']."'";
			$qry1Result = $this->db->query($qry1);
			//echo "<li>".$qry1;
			
				if($qry1Result->num_rows() > 0)
				{
					foreach ($qry1Result->result() as $result)
					{
						if ($result->artifactType==2)
						{
							// Leaf Tags
							
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.id as treeId,c.type as treeType, e.contents as leafContents,d.predecessor FROM teeme_tag a, teeme_tag_types b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2 AND c.id = d.treeIds AND a.artifactId = d.id AND d.id = e.nodeId AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND c.workspaces='.$workSpaceId.' AND c.	workSpaceType='.$workSpaceType.'';
						}
						else
						{ 
							// Seed Tags 
			
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tag_types b, teeme_tree c WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2  AND a.artifactId = c.id  AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
						}
						
						if ($applied != 0)
						{
							$daysAgo = "-" .$applied ." days";
						
							$daysAgo = strtotime ($daysAgo);
					
							$daysAgo = date("Y-m-d",$daysAgo);	
						
							$daysAgo .= " 00:00:00";
						
							$q .= " AND a.createdDate >= '".$daysAgo."'";
						}			
						if ($list != 0)
						{
							if ($list == 'desc')
							{
								$q .= ' ORDER BY b.tagType DESC';
							}
							else if ($list == 'asc')
							{
								$q .= ' ORDER BY b.tagType ASC';
							}
							else
							{
								$q .= ' ORDER BY a.createdDate DESC';
							}
						}
							
					$query = $this->db->query($q);
					
					//echo "<li>" .$query->num_rows() ."<hr>";
					//echo "<li>count= " .$query->num_rows();
						if($query->num_rows() > 0)
						{
							//echo "<li>here1";
							foreach ($query->result() as $tagData)
							{
								$arrTagDetails['simple'][$i]['treeId'] 			= $tagData->treeId;	
								$arrTagDetails['simple'][$i]['treeType'] 		= $tagData->treeType;	
								$arrTagDetails['simple'][$i]['contents'] 		= $tagData->leafContents;	
								$arrTagDetails['simple'][$i]['tagId'] 			= $tagData->tagId;	
								$arrTagDetails['simple'][$i]['tagType'] 		= $tagData->tagType;	
								$arrTagDetails['simple'][$i]['tag'] 			= $tagData->tag;	
								$arrTagDetails['simple'][$i]['ownerId'] 		= $tagData->ownerId;
								$arrTagDetails['simple'][$i]['tagComment'] 		= $tagData->tagName;
								$arrTagDetails['simple'][$i]['predecessor'] 	= $tagData->predecessor;
								$arrTagDetails['simple'][$i]['artifactId'] 		= $tagData->artifactId;
								$arrTagDetails['simple'][$i]['artifactType'] 	= $tagData->artifactType;	
								$arrTagDetails['simple'][$i]['createdDate'] 	= $tagData->createdDate;	
								$arrTagDetails['simple'][$i]['startTime'] 		= $tagData->startTime;	
								$arrTagDetails['simple'][$i]['endTime'] 		= $tagData->endTime;	
								$i++;	
							}
						}	
					}
				}	
		}

		if($tagType == 3) // Response Tags
		{
				if ($users != '')
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";					
					$qry1Result = $this->db->query($qry1);
					
					if($qry1Result->num_rows() > 0)
					{
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								// Leaf Tags
								$q  = 'SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, e.contents as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = d.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND c.workspaces='.$workSpaceId.' AND c.	workSpaceType='.$workSpaceType.'';
							}
							else
							{
								// Tree Tags
								$q  = 'SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = c.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND c.workspaces='.$workSpaceId.' AND c.	workSpaceType='.$workSpaceType.'';
							}
				
							if ($responseTagType != '')
							{
								$q .= ' AND a.tag IN ('.$responseTagType.')';
							}			
				
							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}					
							if ($users != '')
							{
								$q .= ' AND b.userId IN ('.$users.')';
							}					
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
					$query = $this->db->query($q);

					if($query->num_rows() > 0)
						{
							foreach ($query->result() as $tagData)
							{
							$arrTagDetails['response'][$i]['treeId'] 		= $tagData->treeId;	
							$arrTagDetails['response'][$i]['treeType'] 		= $tagData->treeType;	
							$arrTagDetails['response'][$i]['contents'] 		= $tagData->leafContents;							
						
							$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails['response'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['response'][$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['response'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
							}
							}
						}
					}
				}
				else
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";
					$qry1Result = $this->db->query($qry1);

					if($qry1Result->num_rows() > 0)
					{
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								$q  = "SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, e.contents as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = d.id AND d.id = e.nodeId AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."'";
							}
							else
							{
								$q  = "SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = c.id AND d.id = e.nodeId AND c.workspaces='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."'";
							}

							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}									
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
	
						$query = $this->db->query($q);

						if($query->num_rows() > 0)
						{
							foreach ($query->result() as $tagData)
							{
							$arrTagDetails['response'][$i]['treeId'] 		= $tagData->treeId;	
							$arrTagDetails['response'][$i]['treeType'] 		= $tagData->treeType;	
							$arrTagDetails['response'][$i]['contents'] 		= $tagData->leafContents;							
						
							$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails['response'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['response'][$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['response'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
							}
						}	
					}
				}
			}	
		}

		if($tagType == 5) // Contact Tags
		{
			
			$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.tag='".$tag."' AND a.tagType=5";
			$qry1Result = $this->db->query($qry1);
			if($qry1Result->num_rows() > 0)
			{
				foreach ($qry1Result->result() as $result)
				{
					if($workSpaceId == 0)
					{
						$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
					}
					else
					{
						$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
					}
					if ($result->artifactType==2)
					{	
						// Leaf Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId,b.type as treeType, d.contents as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE '.$where.' AND a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND b.id = c.treeIds AND a.artifactId = c.id AND c.leafId = d.id';
					}
					else
					{
						// Tree Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId,b.type as treeType, b.name as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE '.$where.' AND a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND b.id = c.treeIds AND a.artifactId = b.id AND c.leafId = d.id';
			
					}	
					if ($applied != 0)
					{
						$daysAgo = "-" .$applied ." days";
					
						$daysAgo = strtotime ($daysAgo);
				
						$daysAgo = date("Y-m-d",$daysAgo);	
					
						$daysAgo .= " 00:00:00";
					
						$q .= " AND a.createdDate >= '".$daysAgo."'";
					}			
					if ($list != 0)
					{
						if ($list == 'desc')
						{
							$q .= ' ORDER BY b.name DESC';
						}
						else if ($list == 'asc')
						{
							$q .= ' ORDER BY b.name ASC';
						}
						else
						{
							$q .= ' ORDER BY a.createdDate DESC';
						}
					}				
				$query = $this->db->query($q);
					if($query->num_rows() > 0)
					{
						foreach ($query->result() as $tagData)
						{
							
							$arrTagDetails['contact'][$i]['treeId'] 		= $tagData->treeId;	
							$arrTagDetails['contact'][$i]['treeType'] 		= $tagData->treeType;	
							$arrTagDetails['contact'][$i]['contents'] 		= $tagData->leafContents;						
						
							$arrTagDetails['contact'][$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails['contact'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['contact'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['contact'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['contact'][$i]['tagComment'] 	= $tagData->contactName;
							$arrTagDetails['contact'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['contact'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['contact'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['contact'][$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails['contact'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
					}		
				}
			}
		}
		return $arrTagDetails;
	}	
	
	
	
	
		
	function getLinkedTreesBySearchOptions( $workSpaceId, $workSpaceType, $linkType=0, $applied=0, $list = '', $users =0 )
	{
		$treeIds = array();
		
		$day 	= date('d');
		$month 	= date('m');
		$year	= date('Y');	

		$today = $year."-".$month."-".$day;				
						
		$arrLinkType = $linkType;				
		$linkType = implode (',',$linkType);
		$users = implode (',',$users);
		
			if($workSpaceId == 0)
			{
					$where = 'a.workspaces='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].'';	
			}
			else
			{
					$where = 'a.workspaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.'';
			}		
		
		$q = 'SELECT a.id, a.name, a.type, b.artifactId, b.artifactType FROM teeme_tree a, teeme_links b WHERE '.$where.' AND a.id=b.treeId';
		
			if ($linkType != '')
			{
				$q .= ' AND a.type IN ('.$linkType.')';
			}
			if ($applied != '')
			{
				$daysAgo = "-" .$applied ." days";
					
				$daysAgo = strtotime ($daysAgo);
				
				$daysAgo = date("Y-m-d",$daysAgo);	
					
				$daysAgo .= " 00:00:00";
					
				$q .= " AND b.createdDate >= '".$daysAgo."'";
			}	
			if ($users != 0)
			{
				$q .= ' AND a.userId IN ('.$users.')';
			}	

			if ($list == 'desc')
			{
				$q .= ' ORDER BY a.name DESC';
			}
			else if ($list == 'asc')
			{
				$q .= ' ORDER BY a.name ASC';
			}
			else
			{
				$q .= ' ORDER BY b.createdDate DESC';
			}
		
		$query = $this->db->query($q);

		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$treeData->id]['id'] = $treeData->id;
					$treeIds[$treeData->id]['name'] = $treeData->name;
					$treeIds[$treeData->id]['type'] = $treeData->type;
					$treeIds[$treeData->id]['artifactId'] = $treeData->artifactId;
					$treeIds[$treeData->id]['artifactType'] = $treeData->artifactType;
					$treeIds[$treeData->id]['status'] = $treeData->status;
					$i++;
				}
			}
		}
		
		if (in_array(7,$arrLinkType))
		{
		
			if($workSpaceId == 0)
			{
					$where = 'a.workSpaceId='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].'';	
			}
			else
			{
					$where = 'a.workSpaceId = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.'';
			}		
			$q = 'SELECT a.docId, a.docCaption,a.version,b.artifactId,b.artifactType FROM teeme_external_docs a, teeme_links_external b WHERE '.$where.' AND a.docId=b.linkedDocId';
			if ($applied != '')
			{
				$daysAgo = "-" .$applied ." days";
					
				$daysAgo = strtotime ($daysAgo);
				
				$daysAgo = date("Y-m-d",$daysAgo);	
					
				$daysAgo .= " 00:00:00";
					
				$q .= " AND b.createdDate >= '".$daysAgo."'";
			}	
			if ($users != 0)
			{
				$q .= ' AND a.userId IN ('.$users.')';
			}	

			if ($list == 'desc')
			{
				$q .= ' ORDER BY a.docCaption DESC';
			}
			else if ($list == 'asc')
			{
				$q .= ' ORDER BY a.docCaption ASC';
			}
			else
			{
				$q .= ' ORDER BY b.createdDate DESC';
			}
		

			$query = $this->db->query($q);

			if($query)
			{		
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $treeData)
					{										
						$treeIds[$i]['id'] = $treeData->docId;
						$treeIds[$i]['name'] = $treeData->docCaption .'_v' .$treeData->version;
						$treeIds[$i]['type'] = 7;
						$treeIds[$i]['artifactId'] = $treeData->artifactId;
						$treeIds[$i]['artifactType'] = $treeData->artifactType;
						$treeIds[$i]['status'] = 1;
						$i++;
					}
				}
			}
		
			return $treeIds;			
		}

		return $treeIds;
	}
	
	
	public function getTaskDetailsBySearchOptions ($workSpaceId, $workSpaceType, $created=0, $starting=0, $due=0, $list='', $by=0,  $assigned_to = 0)
	{
		$arrNodes	= array();
		
		$by = implode (',',$by);
		$assigned_to_string = implode (',',$assigned_to);
		
			if($workSpaceId == 0)
			{
					$where = 'd.workspaces ='.$workSpaceId.' AND d.userId = '.$_SESSION['userId'].'';	
			}
			else
			{
					$where = 'd.workspaces  = \''.$workSpaceId.'\' AND d.workSpaceType= '.$workSpaceType.'';
			}			
		
		$q = 'SELECT DISTINCT a.id, a.treeIds, b.contents FROM teeme_node a, teeme_leaf b, teeme_notes_users c, teeme_tree d WHERE '.$where.' AND a.treeIds=d.id AND d.type=4 AND a.leafId=b.id AND a.id=c.notesId';
		
			if ($created != '')
			{
				$daysAgo = "-" .$created ." days";
					
				$daysAgo = strtotime ($daysAgo);
				
				$daysAgo = date("Y-m-d",$daysAgo);	
					
				$daysAgo .= " 00:00:00";
					
				$q .= " AND b.createdDate >= '".$daysAgo."'";
			}
			if ($starting != '')
			{
				if ($starting==500) // No End time
				{
					$q .= " AND (a.startTime = '0000-00-00 00:00:00')";
				}
				else
				{
					$daysAgo = "+" .$starting ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$day 	= date('d');
					$month 	= date('m');
					$year	= date('Y');	

					$today = $year."-".$month."-".$day;
					
					$today .= " 00:00:00";
					
					$q .= " AND (a.startTime <= '".$daysAgo."' AND a.startTime >= '".$today."')";
				}
			}			
			if ($due != '')
			{
				if ($due==500) // No End time
				{
					$q .= " AND (a.endTime = '0000-00-00 00:00:00')";
				}
				else
				{
					$daysAgo = "+" .$due ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$day 	= date('d');
					$month 	= date('m');
					$year	= date('Y');	

					$today = $year."-".$month."-".$day;
					
					$today .= " 00:00:00";
					
					$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
				}
			}			
			if ($by != 0)
				$q .= ' AND b.userId IN ('.$by.')';	
				
			if ($assigned_to_string != 0)
				$q .= ' AND c.userId IN ('.$assigned_to_string.')';	
		
			if ($list == 'desc')
			{
				$q .= ' ORDER BY b.contents DESC';
			}
			else if ($list == 'asc')
			{
				$q .= ' ORDER BY b.contents ASC';
			}
			else
			{
				$q .= ' ORDER BY b.createdDate DESC';
			}
	

		$query = $this->db->query($q);
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{										
				$arrNodes[$row->id]['id']	= $row->id;	
				$arrNodes[$row->id]['treeId']	= $row->treeIds;	
				$arrNodes[$row->id]['contents']	= $row->contents;					
			}				
		}
		
		return $arrNodes;				
	}
	
	public function getMyTasks ($workSpaceId, $workSpaceType, $created=0, $starting=0, $due=0, $list='', $by=0,  $assigned_to = 0, $for_by=1)
	{
		$arrNodes	= array();
		
		$by = implode (',',$by);
		$assigned_to_string = implode (',',$assigned_to);
		
			if($workSpaceId == 0)
			{
					/*Commented by Dashrath- comment old code and add new code below with remove AND condition*/
					// $where = 'd.workspaces ='.$workSpaceId.' AND d.userId = '.$_SESSION['userId'].'';

					/*Added by Dashrath- Add new code for show my task on dashboard for shared users*/
					$where = 'd.workspaces ='.$workSpaceId.'';
					/*Dashrath- code end*/	
			}
			else
			{
					$where = 'd.workspaces  = \''.$workSpaceId.'\' AND d.workSpaceType= '.$workSpaceType.'';
			}			
		
		
			if ($for_by==2) // by me
			{
				/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
				// $q = 'SELECT DISTINCT a.id, a.starttime , a.endtime , a.treeIds, b.contents, b.createdDate, b.editedDate, b.userId FROM teeme_node a, teeme_leaf b, teeme_notes_users c, teeme_tree d WHERE '.$where.' AND b.userId='.$_SESSION['userId'].' AND a.treeIds=d.id AND d.type=4 AND a.leafId=b.id AND a.id=c.notesId';

				/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
				$q = 'SELECT DISTINCT a.id, a.starttime , a.endtime , a.treeIds, b.contents, b.createdDate, b.editedDate, b.userId FROM teeme_node a, teeme_leaf b, teeme_notes_users c, teeme_tree d WHERE '.$where.' AND b.userId='.$_SESSION['userId'].' AND a.treeIds=d.id AND d.type=4 AND a.leafId=b.id AND a.id=c.notesId AND b.leafStatus != "discarded" ';
				/*Dashrath- code end*/

			}
			else if ($for_by==1) // for me
			{
				/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
				// $q = 'SELECT DISTINCT a.id, a.starttime , a.endtime , a.treeIds, b.contents, b.createdDate, b.editedDate, b.userId FROM teeme_node a, teeme_leaf b, teeme_notes_users c, teeme_tree d WHERE '.$where.' AND c.userId='.$_SESSION['userId'].' AND a.treeIds=d.id AND d.type=4 AND a.leafId=b.id AND a.id=c.notesId';

				/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
				$q = 'SELECT DISTINCT a.id, a.starttime , a.endtime , a.treeIds, b.contents, b.createdDate, b.editedDate, b.userId FROM teeme_node a, teeme_leaf b, teeme_notes_users c, teeme_tree d WHERE '.$where.' AND c.userId='.$_SESSION['userId'].' AND a.treeIds=d.id AND d.type=4 AND a.leafId=b.id AND a.id=c.notesId AND b.leafStatus != "discarded" ';
				/*Dashrath- code end*/
			}
			else //all
			{
				/*Commented by Dashrath- comment old query and add new query below for discared task not get*/
				// $q = 'SELECT DISTINCT a.id, a.starttime , a.endtime , a.treeIds, b.contents, b.createdDate, b.editedDate, b.userId FROM teeme_node a, teeme_leaf b, teeme_notes_users c, teeme_tree d WHERE '.$where.' AND a.treeIds=d.id AND d.type=4 AND a.leafId=b.id AND a.id=c.notesId';

				/*Added by Dashrath- add and condition in query leafStatus!=discarded*/
				$q = 'SELECT DISTINCT a.id, a.starttime , a.endtime , a.treeIds, b.contents, b.createdDate, b.editedDate, b.userId FROM teeme_node a, teeme_leaf b, teeme_notes_users c, teeme_tree d WHERE '.$where.' AND a.treeIds=d.id AND d.type=4 AND a.leafId=b.id AND a.id=c.notesId AND b.leafStatus != "discarded" ';
				/*Dashrath- code end*/				
			}
				
			if ($created != '')
			{
				$daysAgo = "-" .$created ." days";
					
				$daysAgo = strtotime ($daysAgo);
				
				$daysAgo = date("Y-m-d",$daysAgo);	
					
				$daysAgo .= " 00:00:00";
					
				$q .= " AND b.createdDate >= '".$daysAgo."'";
			}
			if ($starting != '')
			{
				if ($starting==500) // No End time
				{
					$q .= " AND (a.startTime = '0000-00-00 00:00:00')";
				}
				else
				{
					$daysAgo = "+" .$starting ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$day 	= date('d');
					$month 	= date('m');
					$year	= date('Y');	

					$today = $year."-".$month."-".$day;
					
					$today .= " 00:00:00";
					
					$q .= " AND (a.startTime <= '".$daysAgo."' AND a.startTime >= '".$today."')";
				}
			}			
			if ($due != '')
			{
				if ($due==500) // No End time
				{
					$q .= " AND (a.endTime = '0000-00-00 00:00:00')";
				}
				else
				{
					$daysAgo = "+" .$due ." days";
					
					$daysAgo = strtotime ($daysAgo);
				
					$daysAgo = date("Y-m-d",$daysAgo);	
					
					$daysAgo .= " 00:00:00";
					
					$day 	= date('d');
					$month 	= date('m');
					$year	= date('Y');	

					$today = $year."-".$month."-".$day;
					
					$today .= " 00:00:00";
					
					$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
				}
			}			
			if ($by != 0)
				$q .= ' AND b.userId IN ('.$by.')';	
				
			if ($assigned_to_string != 0)
				$q .= ' AND c.userId IN ('.$assigned_to_string.')';	
		
			if ($list == 'desc')
			{
				$q .= ' ORDER BY b.createdDate DESC';
			}
			else if ($list == 'asc')
			{
				$q .= ' ORDER BY b.createdDate ASC';
			}
			else
			{
				$q .= ' ORDER BY a.endTime ASC';
			}
	
		if($created==0 && $starting==0 && $due==0 && $list='desc' && $by==0 && $assigned_to == 0 && $for_by==0 && $workSpaceId!=0)
		{
			//Memcache code start here
			/*$memc=$this->createMemcacheObject();	
			$memCacheId = 'wp'.$workSpaceId.'tasks'.$workSpaceType.'place'.$_SESSION['workPlaceId'];	
			//$memc->delete($memCacheId);
			$tree = $memc->get($memCacheId);
			
			if(!$tree)
			{*/
				$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}
					
					/*$memc->set($memCacheId, $tree);
					$tree = $memc->get($memCacheId);	*/
				}
			/*}*/
			//return $tree;
			if(count($tree) > 0)
			{
				foreach ($tree as $row)
				{	
					$arrNodes[$row->id]['id']	= $row->id;	
					$arrNodes[$row->id]['starttime']	= $row->starttime;
					$arrNodes[$row->id]['endtime']	= $row->endtime;
					$arrNodes[$row->id]['treeId']	= $row->treeIds;	
					$arrNodes[$row->id]['contents']	= $row->contents;	
					$arrNodes[$row->id]['createdDate']	= $row->createdDate;	
					$arrNodes[$row->id]['editedDate']	= $row->editedDate;	
					$arrNodes[$row->id]['userId']	= $row->userId;						
				}
			}	
		}
		else
		{
			$query = $this->db->query($q);
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{										
					$arrNodes[$row->id]['id']	= $row->id;	
					$arrNodes[$row->id]['starttime']	= $row->starttime;
					$arrNodes[$row->id]['endtime']	= $row->endtime;
					$arrNodes[$row->id]['treeId']	= $row->treeIds;	
					$arrNodes[$row->id]['contents']	= $row->contents;	
					$arrNodes[$row->id]['createdDate']	= $row->createdDate;	
					$arrNodes[$row->id]['editedDate']	= $row->editedDate;	
					$arrNodes[$row->id]['userId']	= $row->userId;			
				}				
			}
		}
		
		return $arrNodes;				
	}

	
	public function getExternalDocsBySearchOptions($workSpaceId, $workSpaceType, $imported=0, $list = '', $by = 0)
	{
		$arrDocDetails = array();		
		$by = implode (',',$by);

		$userId = $_SESSION['userId'];
				
		if($workSpaceId == 0)
		{	
			$q = 'SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId=0 AND a.userId='.$userId;
		}
		else	
		{
			$q = 'SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType;
		}
		
			if ($imported != '')
			{
				$daysAgo = "-" .$imported ." days";
					
				$daysAgo = strtotime ($daysAgo);
				
				$daysAgo = date("Y-m-d",$daysAgo);	
					
				$daysAgo .= " 00:00:00";
					
				$q .= " AND a.createdDate >= '".$daysAgo."'";
			}
			if ($by != 0)
			{
				$q .= ' AND a.userId IN ('.$by.')';				
			}
			if ($list == 'desc')
			{
				$q .= ' ORDER BY a.docCaption DESC';
			}
			else if ($list == 'asc')
			{
				$q .= ' ORDER BY a.docCaption ASC';
			}
			else
			{
				$q .= ' ORDER BY a.createdDate DESC';
			}

	
		$query = $this->db->query ($q);
			
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach ($query->result() as $docData)
			{	
				$arrDocDetails[$i]['docId'] 		= $docData->docId;
				$arrDocDetails[$i]['workSpaceId'] 	= $docData->workSpaceId;
				$arrDocDetails[$i]['workSpaceType'] = $docData->workSpaceType;	
				$arrDocDetails[$i]['userId'] 		= $docData->userId;		
				$arrDocDetails[$i]['docCaption'] 	= $docData->docCaption;	
				$arrDocDetails[$i]['docName']	 	= $docData->docName;	
				$arrDocDetails[$i]['docPath']	 	= $docData->path;
				$arrDocDetails[$i]['docCreatedDate']= $docData->createdDate;	
				$arrDocDetails[$i]['version']		= $docData->version;		
				$i++;					
			}
		}
		return $arrDocDetails;
	}	
	
	
	public function getTreeTypeByTreeId($treeId)
	{	
		$query = $this->db->query('select type from teeme_tree WHERE id='.$treeId);	
									
		foreach($query->result() as $row)
		{
			$treeType = $row->type;
		}		
		return $treeType;
	}	
	
	public function getTreeNameByTreeId($treeId)
	{	
		$query = $this->db->query('select name from teeme_tree WHERE id='.$treeId);	
									
		foreach($query->result() as $row)
		{
			$treeName = $row->name;
		}		
		return $treeName;
	}	
	
	
		
	//Manoj: replace mysql_escape_str function
	public function updateWorkSpaceStatus($workSpaceId, $status)
    {		
		$bResult  = $this->db->query('UPDATE teeme_work_space SET status='.$this->db->escape_str($status).' WHERE workSpaceId=\''.$workSpaceId.'\'');
	}
	//Manoj: replace mysql_escape_str function
	public function updateSubWorkSpaceStatus($subWorkSpaceId, $status)
    {		
		$bResult  = $this->db->query('UPDATE teeme_sub_work_space SET status='.$this->db->escape_str($status).' WHERE subWorkSpaceId=\''.$subWorkSpaceId.'\'');
	}
	
	public function updateWorkPlaceStatus($workPlaceId, $status)
    {		
		$config = array();
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		//Manoj: replace mysql_escape_str function
		$instancedb = $this->load->database($config,TRUE);	
		$bResult  = $instancedb->query('UPDATE teeme_work_place SET status='.$this->db->escape_str($status).' WHERE workPlaceId=\''.$workPlaceId.'\'');
	}
	
	public function getWorkPlaceIdByWorkPlaceName($workPlaceName)
	{
		$config = array();
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
		$qry = "SELECT workPlaceId FROM teeme_work_place WHERE companyName='".$this->db->escape_str($workPlaceName)."'";
		$query = $instancedb->query($qry);

		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{										
				$workPlaceId 	= $row->workPlaceId;
				return $workPlaceId;										
			}				
		}					
					
		return 0;
	}
	
	public function getWorkPlaceNameByWorkPlaceId($workPlaceId)
	{
		$config = array();
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
		$query = $instancedb->query("SELECT companyName FROM teeme_work_place WHERE workPlaceId='".$workPlaceId."'");
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{										
				$workPlaceName 	= $row->companyName;									
			}				
		}					
		return $workPlaceName;				

	}
	
	public function getWorkPlaceStatus($workPlaceId)
	{
		$config = array();
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
		$query = $instancedb->query("SELECT status FROM teeme_work_place WHERE workPlaceId='".$workPlaceId."'");
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{										
				$status 	= $row->status;									
			}				
		}					
		return $status;				

	}
	
	public function insertPlaceManager ($config,$userdetails)
	{
			//Manoj: replace mysql_escape_str function
			$placedb = $this->load->database($config,TRUE);
			
			//transaction begin here
			$placedb->trans_begin();
			
            $query = 'INSERT INTO teeme_users ( workPlaceId, userName, password, tagName, userCommunityId, firstName, lastName, address1, phone, mobile, email, registeredDate, other, isPlaceManager, userTimezone, nickName)
                        VALUES (\''.$this->db->escape_str($userdetails['workPlaceId']).'\',\''.$this->db->escape_str($userdetails['managerEmail']).'\',\''.$this->db->escape_str($userdetails['managerPassword']).'\', \''.$this->db->escape_str($userdetails['managerTagName']).'\', \''.$this->db->escape_str($userdetails['managerCommunityId']).'\',\''.$this->db->escape_str($userdetails['managerFname']).'\',\''.$this->db->escape_str($userdetails['managerLname']).'\', \''.$this->db->escape_str(htmlentities($userdetails['managerAddress'])).'\', \''.$this->db->escape_str($userdetails['managerPhone']).'\', \''.$this->db->escape_str($userdetails['managerMobile']).'\', \''.$this->db->escape_str($userdetails['managerEmail']).'\', \''.$this->db->escape_str($userdetails['registeredDate']).'\', \''.$this->db->escape_str($userdetails['managerOther']).'\', \''.$this->db->escape_str($userdetails['isPlaceManager']).'\', \''.$this->db->escape_str($userdetails['timezone']).'\', \''.$this->db->escape_str($userdetails['nickName']).'\')';
		
            $result = $placedb->query($query);
		
			//Checking transaction status here
			
				if($placedb->trans_status()=== FALSE)
				{
					$placedb->trans_rollback();
					return false;
				}
				else
				{
					$lastId = $placedb->insert_id();
					$placedb->trans_commit();
					return $lastId;
				}			
						
            //return $placedb->insert_id();
			
				
	}
        
	public function getAllPlaceManagersByPlaceId($config,$workPlaceId=0,$string='')
	{
		$placeManagerDetails = array();	
                
        $placedb = $this->load->database($config,TRUE);
				if ($string=='')
				{
                	$query = "SELECT * FROM teeme_users WHERE workPlaceId='".$workPlaceId."' AND isPlaceManager='1' ORDER BY userId ASC";
				}
				else
				{
					$query = "SELECT * FROM teeme_users WHERE workPlaceId='".$workPlaceId."' AND isPlaceManager='1' AND tagName LIKE ('pm_".$string."%') ORDER BY firstName ASC";
				}
			
		$result = $placedb->query($query);
               
		if($result->num_rows() > 0)
		{
			$i = 0;			
			foreach ($result->result() as $placeManagerData)
			{	
				$placeManagerDetails[$i]['userId'] 	= $placeManagerData->userId;
				$placeManagerDetails[$i]['userName'] 	= $placeManagerData->userName;
                                $placeManagerDetails[$i]['firstName'] 	= $placeManagerData->firstName;	
                                $placeManagerDetails[$i]['lastName'] 	= $placeManagerData->lastName;	
                                $placeManagerDetails[$i]['status'] 	= $placeManagerData->status;
								
								if($placeManagerData->nickName!='')
								{
									$placeManagerDetails[$i]['tagName'] 	= $placeManagerData->nickName;
								}
								else
								{
									$placeManagerDetails[$i]['tagName'] 	= $placeManagerData->tagName;
								}
				$i++;								
			}
		}			
		return $placeManagerDetails;
	}
	
	public function updateWorkPlace($placeId=0,$placeTimezone=0,$companyAddress='',$companyPhone='',$companyOther='',$NumOfUsers='',$PlaceExpDate='',$securityQuestion='',$securityAnswer='')
	{
		$config = array();
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		//Manoj: replace mysql_escape_str function
		$instancedb = $this->load->database($config,TRUE);
			$strResultSQL = "UPDATE teeme_work_place 
			SET placeTimezone='".$placeTimezone."', 
			companyAddress1='".$this->db->escape_str($companyAddress)."', 
			companyPhone='".$this->db->escape_str($companyPhone)."', 
			companyOther = '".$this->db->escape_str($companyOther)."', 
			NumOfUsers = '".$this->db->escape_str($NumOfUsers)."', 
			ExpireDate = '".$this->db->escape_str($PlaceExpDate)."'
			WHERE workPlaceId='".$placeId."'";
		
			$bResult = $instancedb->query($strResultSQL);
			
			
				if($bResult)
				{
					return true;
				}		
				else
				{
					return false;
				}
	}
	
	public function updateWorkPlaceManager($placeId,$managerFname,$managerLname,$managerAddress,$managerPhone,$managerMobile,$managerFax,$managerOther,$managerCommunityId,$managerEmail,$managerPassword='')
	{
		//Manoj: replace mysql_escape_str function
		if ($managerPassword != '')
			$strResultSQL = "UPDATE teeme_work_place_managers SET managerFname='".$this->db->escape_str($managerFname)."', managerLname='".$this->db->escape_str($managerLname)."', managerAddress='".$this->db->escape_str($managerAddress)."', managerPhone='".$this->db->escape_str($managerPhone)."', managerMobile = '".$this->db->escape_str($managerMobile)."', managerFax = '".$this->db->escape_str($managerFax)."', managerOther = '".$this->db->escape_str($managerOther)."', managerCommunityId = '".$managerCommunityId."', managerEmail = '".$this->db->escape_str($managerEmail)."', managerPassword = '".$this->db->escape_str($managerPassword)."' WHERE placeId='".$placeId."'";
		else
			$strResultSQL = "UPDATE teeme_work_place_managers SET managerFname='".$this->db->escape_str($managerFname)."', managerLname='".$this->db->escape_str($managerLname)."', managerAddress='".$this->db->escape_str($managerAddress)."', managerPhone='".$this->db->escape_str($managerPhone)."', managerMobile = '".$this->db->escape_str($managerMobile)."', managerFax = '".$this->db->escape_str($managerFax)."', managerOther = '".$this->db->escape_str($managerOther)."', managerCommunityId = '".$managerCommunityId."', managerEmail = '".$this->db->escape_str($managerEmail)."' WHERE placeId='".$placeId."'";
			
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
	
	public function insertBackup ($filename,$filesize,$ftpDetailsArray='',$place_name='')
	{
		
		$this->load->model('dal/time_manager');
		$createdDate = time_manager::getGMTTime();
		
		$query = "INSERT INTO teeme_backups (file_name,file_size,createdDate,remoteServer) VALUES ('".$filename."','".$filesize."','".$createdDate."','".$ftpDetailsArray."')";
		
		//Manoj: assign database name in config start
		if($place_name!='')
		{
			$config = array();
			$placedb = '';
			$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
			
			$placedb = $this->load->database($config, TRUE);
			
			$result = $placedb->query($query);	
		}
		else
		{
			$result = $this->db->query($query);
		}
		//Manoj: assign database name in config  end
		
		if($result)
		{
			return true;
		}		
		else
		{
			return false;
		}
	}
	
	public function getBackupDetails()
    {	
		$backupDetails = array();			
		$query = $this->db->query('SELECT * FROM teeme_backups WHERE status=1 ORDER BY createdDate DESC');	
		if($query->num_rows()> 0)
		{
			$i = 0;	
			foreach($query->result() as $row)
			{
				$backupDetails[$i]['backupId'] 		= $row->id;
				$backupDetails[$i]['filename'] 		= $row->file_name;
				$backupDetails[$i]['filesize'] 		= $row->file_size;
				$backupDetails[$i]['createdDate'] 	= $row->createdDate;
				$backupDetails[$i]['status'] 		= $row->status;
				$backupDetails[$i]['remoteServer'] 	= unserialize($row->remoteServer);
				$i++;
			}	
		}	
		return $backupDetails;	
	}
	
	public function deleteBackup($filename)
	{
		$query = "UPDATE teeme_backups SET status=0 WHERE file_name='".$this->db->escape_str($filename)."' AND status=1";
		$result = $this->db->query($query);
	
	
		if($result)
		{
			return true;
		}		
		else
		{
			return false;
		}
	}
	
	//This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
 	public function getFileExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 	}
	
	public function removeDir($dir) 
	{
		$files = scandir($dir);
		array_shift($files);    // remove '.' from array
		array_shift($files);    // remove '..' from array
			foreach ($files as $file) {
				$file = $dir . '/' . $file;
					if (is_dir($file)) {
						$this->removeDir($file);
						rmdir($file);
					} else {
						unlink($file);
					}
			}
		rmdir($dir);
 	}
	
	public function insertShareTrees ($treeId, $members)
	{
		if ($treeId!='')
		{
			$query = "INSERT INTO teeme_trees_shared (treeId,members) VALUES ('".$treeId."','".$members."')";
			$result = $this->db->query($query);
		
			if($result)
			{
				return true;
			}		
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}	
	}
	
	public function updateShareTrees ($treeId, $members)
	{
		$query = "UPDATE teeme_trees_shared SET members='".$members."' WHERE treeId='".$treeId."'";
		$result = $this->db->query($query);
		
		if($result)
		{
			return true;
		}		
		else
		{
			return false;
		}	
	}
	
	public function getSharedMembersByTreeId ($treeId)
	{
	
		$members = array();			
		$query = $this->db->query("SELECT * FROM teeme_trees_shared WHERE treeId='".$treeId."'");	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$members = explode (",",$row->members);
			}
		}	
		return $members;	
	}
	
	public function getWorkSpaceManagersByWorkSpaceId ($spaceId, $spaceType)
	{
		$managerIds = array();		
		$query = $this->db->query('SELECT managerId FROM teeme_managers WHERE placeId='.$spaceId.' AND placeType='.$spaceType);
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{			
				$managerIds[$i] = $row->managerId;										
				$i++;													
			}
		}					
		return $managerIds;
	}
	
	public function isShared ($treeId)
	{
	
		$members = array();			
		$query = $this->db->query("SELECT * FROM teeme_trees_shared WHERE treeId='".$treeId."'");	

		if($query->num_rows()> 0)
		{
			return true;
		}	
		
		return false;	
	}
	public function updateTreeSharedStatus ($treeId)
	{
		$query = "UPDATE teeme_tree SET isShared=1 WHERE id='".$treeId."'";
		$result = $this->db->query($query);
		
		if($result)
		{
			return true;
		}		
		else
		{
			return false;
		}	
	}
	

	public function updateWorkplaceMemberByMemberId($memberId=0,$status=0,$config=0)
        {
            $query = "UPDATE teeme_users SET status = '".$this->db->escape_str($status)."' WHERE userId ='".$memberId."'";
                if ($config!=0)
                {
                    $placedb = $this->load->database($config,TRUE);
                    $placedb->query($query);
                }

                else
                {
                    $this->db->query($query);	
                }
            return true; 		
	}

	public function updateMemberStatusUpdate($memberId=0,$status=0)
    {		
		$query = $this->db->query("UPDATE teeme_users SET statusUpdate = '".$this->db->escape_str($status)."' WHERE userId ='".$memberId."'");	
		return true; 		
	}
	
	public function getPlaceLogoByPlaceId ($placeId)
	{
		$config = array();
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
		$logo = '';
		$query = $instancedb->query("SELECT companyLogo FROM teeme_work_place WHERE workPlaceId='".$placeId."'");	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$logo = $row->companyLogo;
			}
		}	
		return $logo;
	}
	
	public function getNodeDetailsByNodeId( $nodeId )
	{
		$node = array();		

		$query = $this->db->query('SELECT a.id as nodeId,a.leafId,a.nodeOrder as leafOrder,a.treeIds, b.contents as contents,c.type
		FROM teeme_node	a, teeme_leaf b, teeme_tree c WHERE b.id=a.leafId AND a.treeIds=c.id AND a.id='.$nodeId);
		foreach($query->result() as $row)
		{
			
			$node['nodeId'] = $row->nodeId;
			$node['leafId'] = $row->leafId;
			$node['nodeOrder'] = $row->leafOrder;
			$node['treeType'] = $row->type;
			$node['treeId'] = $row->treeIds;
			$node['contents'] = $row->contents;
		}	
		
		return $node;	
	}
	
	public function getLinkedArtifactDetailsByNodeId( $artifactId, $artifactType=2 )
	{
		$node = array();		
		
			if ($artifactType==2)
			{  
				$query = $this->db->query('SELECT a.id as nodeId,a.leafId,a.nodeOrder as leafOrder,a.treeIds, a.workSpaceType as workSpaceType, b.contents as contents,c.parentTreeId as pid ,c.type FROM teeme_node	a, teeme_leaf b, teeme_tree c WHERE b.id=a.leafId AND a.treeIds=c.id AND a.id='.$artifactId);
				//Manoj: code for timeline post 
				if($query->num_rows()==0)
				{
					$query = $this->db->query('SELECT a.id as nodeId,a.leafId,a.nodeOrder as leafOrder,a.treeIds, a.workSpaceType as workSpaceType, b.contents as contents,c.parentTreeId as pid FROM teeme_node	a, teeme_leaf b, teeme_tree c WHERE b.id=a.leafId AND a.treeIds=0 AND a.id='.$artifactId);
				}
				//Manoj: code end
				foreach($query->result() as $row)
				{
				    
					
					$node['nodeId'] = $row->nodeId;
					$node['leafId'] = $row->leafId;
					$node['nodeOrder'] = $row->nodeOrder;
					$node['treeType'] = $row->type;
					$node['treeId'] = $row->treeIds;
					$node['contents'] = $row->contents;
					$node['workSpaceType'] = $row->workSpaceType;
				}	
				
			}
			else
			{ 
				$query = $this->db->query('SELECT id, type,parentTreeId as pid, name FROM teeme_tree WHERE id='.$artifactId);
			
			
				foreach($query->result() as $row)
				{
					
					
					$node['treeType'] = $row->type;
					$node['treeId'] = $row->id;
					$node['contents'] = $row->name;
				}
			
			}	
		
		return $node;	
	}
	
	public function getUserPasswordByUserId ($userId)
	{
		$password = 0;
		$query = $this->db->query("SELECT password FROM teeme_users WHERE userId='".$userId."'");	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$password = $row->password;
			}
		}	
		return $password;	
	}
	
	public function updateTreeAutonumbering($treeId,$autonumbering=0)
    {		
		$query = $this->db->query("UPDATE teeme_tree SET autonumbering = '".$autonumbering."' WHERE id ='".$treeId."'");	
		return true; 		
	}
	
	public function updateNeedPasswordReset($userId,$resetStatus=0,$config=0) // 1-> Reset Required 0-> Reset Not Required
	{
		$qry = "UPDATE teeme_users SET needPasswordReset = '".$resetStatus."' WHERE userId ='".$userId."'";
	
		if ($config!=0)
		{
			$placedb = $this->load->database($config,TRUE);	
			
			$placedb->trans_begin();	
			
			$query = $placedb->query($qry);
			
			//Checking transaction status here
			if($placedb->trans_status()=== FALSE)
			{
				$placedb->trans_rollback();
				return false;
			}
			else
			{
				$placedb->trans_commit();
				return true;
			}	
		}
		else
		{
			$this->db->trans_begin();
			
			$query = $this->db->query($qry);	
			
			//Checking transaction status here
			if($this->db->trans_status()=== FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return true;
			}
			
		}
			/*if ($query)
				return true; 
			else
				return false;*/
	}
	
	public function resetUserPassword($userId,$password,$config=0) // 1-> Reset Required 0-> Reset Not Required
	{
		$qry = "UPDATE teeme_users SET password = '".$password."' WHERE userId ='".$userId."'";
		
		if ($config!=0)
		{
			$placedb = $this->load->database($config,TRUE);	
			$query = $placedb->query($qry);
		}
		else
		{
			$query = $this->db->query($qry);	
		}
			if ($query)
				return true; 
			else
				return false;
	}
	
	public function deleteTreeByTreeId($treeId)
    {	
		if($treeId != '')
		{
			$query = $this->db->query('DELETE FROM teeme_tree WHERE id ='.$treeId);	
		}			
		return true; 		
	}
	
	public function getTreeOwnerIdByTreeId ($treeId)
	{
		$ownerId = 0;
		$query = $this->db->query("SELECT userId FROM teeme_tree WHERE id='".$treeId."'");	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$ownerId = $row->userId;
			}
		}	
		return $ownerId;	
	}
	
	public function formatContent ($content,$limit=0,$strip_tags=0)
	{
		$content = stripslashes($content);
	
			
			$pos=strpos($content,"<img");
			$cond=0;
			if($pos >= 0){
				if(strlen(trim(strip_tags(substr($content,0,$pos+1))))!=0){
					$cond=1;//show image first then content
				}
				else{
					$cond=2;
				}
			}
			
			$str="";
			$img='';$s=0;
			if($pos){
				$pos2 = strpos($content,">",$pos);
				$img  = substr($content,$pos,$pos2-4);
		
			}
			
			if ($strip_tags!=0)
			{
				$content = strip_tags($content);
			}
			//Manoj: IF only media found then showing image/audio/video
				if($content=='')
				{
					$content = $this->lang->line('content_contains_only_image');
				}
			//Manoj: code end
			
			if ($limit!=0 && strlen($content)!=0)
			{
				$content = substr($content,0,$limit);
				if (strlen($content)>($limit-1))
				{
					$content .= '..........';		
				}
			}
		
		if($cond==1){
			return $content;
		}
		else{
			return $img.$content;	
		}
		
	}
	
	public function encodeURLString ($string)
	{
      	$data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
	}
	
	public function decodeURLString ($string)
	{
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
	}
	
	/*Changed by Dashrath- Add $config for load db*/
	public function getUserGroupByMemberId ($userId, $config=0)
	{
		$userGroup = 1;

		/*Changed by Dashrath- Add if else condition for load db*/
		if ($config!=0)
        {
            $placedb = $this->load->database($config,TRUE);

            $query = $placedb->query("SELECT userGroup FROM teeme_users WHERE userId='".$userId."'");
        }
		else
		{
			$query = $this->db->query("SELECT userGroup FROM teeme_users WHERE userId='".$userId."'");
		}
		/*Dashrath- changes end*/	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$userGroup = $row->userGroup;
			}
		}	
		return $userGroup;	
	}
	
	public function getNodePositionByNodeId ($nodeId)
	{
		$position = 1;
		$query = $this->db->query("SELECT nodeOrder FROM teeme_node WHERE id='".$nodeId."'");	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$position = $row->nodeOrder;
			}
		}	
		return $position;	
	}
	
	/*Changed by Dashrath- Add $config for load db*/
	public function hasWorkspace ($userId, $config=0)
	{
		/*Changed by Dashrath- Add if else condition for load db*/
		if ($config!=0)
        {
            $placedb = $this->load->database($config,TRUE);

            $query = $placedb->query("SELECT count(*) as total, workSpaceId FROM teeme_work_space_members WHERE workSpaceUserId='".$userId."'");
        }
		else
		{
			$query = $this->db->query("SELECT count(*) as total, workSpaceId FROM teeme_work_space_members WHERE workSpaceUserId='".$userId."'");
		}
		/*Dashrath- changes end*/
			

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$total = $row->total;
					if ($total>0)
					{
						return $row->workSpaceId;
					}
			}
		}	
	
		$query2 = $this->db->query("SELECT count(*) as total, subWorkSpaceId FROM teeme_sub_work_space_members WHERE subWorkSpaceUserId='".$userId."'");	

		if($query2->num_rows()> 0)
		{
			foreach($query2->result() as $row)
			{
				$total = $row->total;
					if ($total>0)
					{
						return $row->subWorkSpaceId;
					}
			}
		}	
		
		return false;	
	}
	
	public function removeWhiteSpaces ($name)
	{
		$sPattern = '/\s*/m';
		$sReplace = '';
		
		$formattedName = preg_replace( $sPattern, $sReplace, $name );
		
		return $formattedName;
	}
	
function remove_comments(&$output)
{
   $lines = explode("\n", $output);
   $output = "";

   // try to keep mem. use down
   $linecount = count($lines);

   $in_comment = false;
   for($i = 0; $i < $linecount; $i++)
   {
      if( preg_match("/^\/\*/", preg_quote($lines[$i])) )
      {
         $in_comment = true;
      }

      if( !$in_comment )
      {
         $output .= $lines[$i] . "\n";
      }

      if( preg_match("/\*\/$/", preg_quote($lines[$i])) )
      {
         $in_comment = false;
      }
   }

   unset($lines);
   return $output;
}

function remove_remarks($sql)
{
   $lines = explode("\n", $sql);

   // try to keep mem. use down
   $sql = "";

   $linecount = count($lines);
   $output = "";

   for ($i = 0; $i < $linecount; $i++)
   {
      if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
      {
         if (isset($lines[$i][0]) && $lines[$i][0] != "#")
         {
            $output .= $lines[$i] . "\n";
         }
         else
         {
            $output .= "\n";
         }
         // Trading a bit of speed for lower mem. use here.
         $lines[$i] = "";
      }
   }

   return $output;

}

function split_sql_file($sql, $delimiter)
{
   // Split up our string into "possible" SQL statements.
   $tokens = explode($delimiter, $sql);

   // try to save mem.
   $sql = "";
   $output = array();

   // we don't actually care about the matches preg gives us.
   $matches = array();

   // this is faster than calling count($oktens) every time thru the loop.
   $token_count = count($tokens);
   for ($i = 0; $i < $token_count; $i++)
   {
      // Don't wanna add an empty string as the last thing in the array.
      if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
      {
         // This is the total number of single quotes in the token.
         $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
         // Counts single quotes that are preceded by an odd number of backslashes,
         // which means they're escaped quotes.
         $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

         $unescaped_quotes = $total_quotes - $escaped_quotes;

         // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
         if (($unescaped_quotes % 2) == 0)
         {
            // It's a complete sql statement.
            $output[] = $tokens[$i];
            // save memory.
            $tokens[$i] = "";
         }
         else
         {
            // incomplete sql statement. keep adding tokens until we have a complete one.
            // $temp will hold what we have so far.
            $temp = $tokens[$i] . $delimiter;
            // save memory..
            $tokens[$i] = "";

            // Do we have a complete statement yet?
            $complete_stmt = false;

            for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
            {
               // This is the total number of single quotes in the token.
               $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
               // Counts single quotes that are preceded by an odd number of backslashes,
               // which means they're escaped quotes.
               $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

               $unescaped_quotes = $total_quotes - $escaped_quotes;

               if (($unescaped_quotes % 2) == 1)
               {
                  // odd number of unescaped quotes. In combination with the previous incomplete
                  // statement(s), we now have a complete statement. (2 odds always make an even)
                  $output[] = $temp . $tokens[$j];

                  // save memory.
                  $tokens[$j] = "";
                  $temp = "";

                  // exit the loop.
                  $complete_stmt = true;
                  // make sure the outer loop continues at the right point.
                  $i = $j;
               }
               else
               {
                  // even number of unescaped quotes. We still don't have a complete statement.
                  // (1 odd and 1 even always make an odd)
                  $temp .= $tokens[$j] . $delimiter;
                  // save memory.
                  $tokens[$j] = "";
               }

            } // for..
         } // else
      }
   }

   return $output;
}
	
	public function createPlaceDB ($place_db_name,$server,$server_username,$server_password,$place_db,$workPlaceId,$placeManagerId,$migrate=0)
	{     
		//echo "yesmigrate= " .$migrate; exit;
                // echo "username= " .$userdetails['managerEmail']; exit;
		$workPlaceDetails = $this->getWorkPlaceDetails($workPlaceId);
		//$placeManagerDetails = $this->getPlaceManagerDetailsByPlaceManagerId ($placeManagerId);
		
		//Checking mysqli connection 
		$link = mysqli_connect($server, $server_username, $server_password);
		//return $link;
    	if (!$link) 
		{
        	return false;
    	}
		else
		{
			
			//Manoj: replace code of mysql connection 
				$config = array();
				
				$config['hostname'] = $server;
				$config['username'] = $server_username;
				$config['password'] = $server_password;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;

				$db = $this->load->database($config,TRUE);
				
				$q = $db->query("DROP DATABASE IF EXISTS ".strtolower($place_db_name)."");
				
		//$db = mysql_connect ( $server, $server_username, $server_password);
		//$q = mysql_query("DROP DATABASE IF EXISTS ".strtolower($place_db_name)."");
	
		if($q && $db){
			$query = $db->query("CREATE DATABASE $place_db_name") or die($this->db->error());
			
			if ($query)
			{ 
			
				$config = array();
				
				$config['hostname'] = $server;
				$config['username'] = $server_username;
				$config['password'] = $server_password;
				$config['database'] = $place_db_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;

				//mysql_select_db( $place_db_name, $db );
				$placedb = $this->load->database($config,TRUE);
				
				//transaction begin here
				$placedb->trans_begin();
				
				//mysql_select_db( $place_db_name, $db );
				/*
				$FP = fopen ( $place_db, 'r' );
				$READ = fread ( $FP, filesize ( $place_db) );
				 
				if ($migrate==1)
				{ 
					$READ = explode ( "||", $READ );
				}
				else
				{
					$READ = explode ( ";", $READ );
				}
	
				foreach ( $READ AS $RED )
				{
					if($RED){
						$result = $placedb->query( $RED )  or die($this->db->error());
						
						if ($result == false)
						{
							return false;
						}
					}
				}
				*/
				$command='mysql -h' .$server .' -u' .$server_username .' -p' .$server_password .' ' .$place_db_name .' < ' .$place_db;
				
					if (exec($command)==0){
						$placedb->query("UPDATE `teeme_tag_types` SET workPlaceId = '".$workPlaceId."'") or die($this->db->error());
					
						if ($migrate==1)
						{
							$placedb->query ("UPDATE teeme_users SET workPlaceId= '".$workPlaceId."'") or die($this->db->error());
							$placedb->query ("UPDATE teeme_work_space SET workPlaceId= '".$workPlaceId."'") or die($this->db->error());
							$placedb->query ("UPDATE teeme_contact_info SET workplaceId= '".$workPlaceId."'") or die($this->db->error());
						}
					}
					else{
						$placedb->query("DROP DATABASE IF EXISTS ".strtolower($place_db_name)."");
					}

				
/*                $query1 = 'INSERT INTO 
									teeme_work_place
									( 
										workPlaceId, companyName, companyAddress1, companyAddress2, companyCity, companyState, companyCountry, companyZip, companyPhone, companyFax, companyStatus, companyCreatedDate, status, securityQuestion, securityAnswer, companyLogo, server, server_username, server_password, instanceName 
									)
								VALUES
									(
										\''.$this->db->escape_str($workPlaceId).'\',\''.$this->db->escape_str($workPlaceDetails['companyName']).'\',\''.$this->db->escape_str($workPlaceDetails['companyAddress1']).'\',\''.$this->db->escape_str($workPlaceDetails['companyAddress2']).'\',\''.$this->db->escape_str($workPlaceDetails['companyCity']).'\',\''.$this->db->escape_str($workPlaceDetails['companyState']).'\',\''.$this->db->escape_str($workPlaceDetails['companyCountry']).'\',\''.$this->db->escape_str($workPlaceDetails['companyZip']).'\',\''.$this->db->escape_str($workPlaceDetails['companyPhone']).'\',\''.$this->db->escape_str($workPlaceDetails['companyFax']).'\',\''.$this->db->escape_str($workPlaceDetails['companyStatus']).'\',\''.$this->db->escape_str($workPlaceDetails['companyCreatedDate']).'\',\''.$this->db->escape_str($workPlaceDetails['status']).'\',\''.$this->db->escape_str($workPlaceDetails['securityQuestion']).'\',\''.$this->db->escape_str($workPlaceDetails['securityAnswer']).'\',\''.$this->db->escape_str($workPlaceDetails['companyLogo']).'\',\''.$this->db->escape_str($workPlaceDetails['server']).'\',\''.$this->db->escape_str($workPlaceDetails['server_username']).'\',\''.$this->db->escape_str($workPlaceDetails['server_password']).'\',\''.$this->db->escape_str($workPlaceDetails['instanceName']).'\'
									)';
			
				$result1 = mysql_query ($query1)  or die($this->db->error());*/
				
/* Start Andy - teeme_work_place_managers table no longer being used
 				if ($result1 == false)
				{ 
                                    return false;
				}
				else
				{					
						$query2 = "INSERT INTO teeme_work_place_managers(id, placeId, managerFname, managerLname, managerAddress, managerPhone, managerMobile, managerFax, managerOther, managerEmail, managerPassword, managerCommunityId) 
						VALUES ('".$this->db->escape_str($placeManagerId)."','".$this->db->escape_str($workPlaceId)."', '".$this->db->escape_str($placeManagerDetails['firstName'])."', '".$this->db->escape_str($placeManagerDetails['lastName'])."', '".$this->db->escape_str($placeManagerDetails['address1'])."', '".$this->db->escape_str($placeManagerDetails['phone'])."', '".$this->db->escape_str($placeManagerDetails['mobile'])."', '".$this->db->escape_str($placeManagerDetails['fax'])."', '".$this->db->escape_str($placeManagerDetails['managerOther'])."', '".$this->db->escape_str($placeManagerDetails['email'])."', '".$this->db->escape_str($placeManagerDetails['password'])."', '".$placeManagerDetails['userCommunityId']."' )";
						$result2 = mysql_query ($query2);	
						if ($result2 == false)
						{
							return false;
						}
				}
 End Andy */
	
/*                                  if ($result1 == false)
                                    {
										return false;
                                    }*/
									
				//Checking transaction status here
		
				if($placedb->trans_status()=== FALSE)
				{
					$placedb->trans_rollback();
					return false;
				}
				else
				{
					$placedb->trans_commit();
					return true;
				}							
				//return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
		}

}

	public function createFreshInstance ($instance_db_name,$server,$server_username,$server_password,$instance_db)
	{    
			//Manoj: replace code of mysql connection 
				$config = array();
				
				$config['hostname'] = $server;
				$config['username'] = $server_username;
				$config['password'] = $server_password;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;

				$db = $this->load->database($config,TRUE);
				$q = $db->query("DROP DATABASE IF EXISTS ".strtolower($instance_db_name)."") or die ("cannot drop");
				
		
		//$db = mysql_connect ( $server, $server_username, $server_password) or die ("cannot connect");
		//$q = mysql_query("DROP DATABASE IF EXISTS ".strtolower($instance_db_name)."") or die ("cannot drop");
		
		if($q && $db){
			$query = $db->query("CREATE DATABASE $instance_db_name") or die("cannot create database");
			if ($query)
			{ 
				$config = array();
				
				$config['hostname'] = $server;
				$config['username'] = $server_username;
				$config['password'] = $server_password;
				$config['database'] = $instance_db_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;

				//mysql_select_db( $place_db_name, $db );
				$instancedb = $this->load->database($config,TRUE);
	
				$FP = fopen ( $instance_db, 'r' );
				$READ = fread ( $FP, filesize ( $instance_db) );
				 
				$READ = explode ( ";", $READ );

				foreach ( $READ AS $RED )
				{
					if(!empty($RED)){
						//$result = mysql_query ( $RED )  or die($this->db->error());
						//echo "<li>" .$RED;
						$result = $instancedb->query($RED);		
						//$result = mysql_query ( $RED );
						if ($result == false)
						{
							echo "failed"; exit;
							$q = $instancedb->query("DROP DATABASE IF EXISTS ".strtolower($instance_db_name)."") or die ("second drop error");
							return false;
						}
					}
				}
								
			$out = '';
			$pattern1 = '$config[\'memcache_host\']';
			$newValue1 = $server;
			
			$pattern2 = '$config[\'hostname\']';
			$newValue2 = 'base64_encode(\''.$server.'\')';		
			
			$pattern3 = '$config[\'username\']';
			$newValue3 = 'base64_encode(\''.$server_username.'\')';		
			
			$pattern4 = '$config[\'password\']';
			$newValue4 = 'base64_encode(\''.$server_password.'\')';	
			
			$pattern5 = '$config[\'instanceDb\']';
			$newValue5 = $instance_db_name;		
			
			$pattern6 = '$config[\'instanceName\']';
			$newValue6 = $instance_db_name;
			
			//Manoj: add pattern for auto update path
			//$pattern7 = '$config[\'auto_update_client_path\']';
			//$newValue7 = $autoupdate_path;
			//Manoj: code end							
	
			$fileName = $this->config->item('absolute_path').'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php'; 
			//chmod($fileName,0777) or die("cannot set permission");
					if(file_exists($fileName)) {
						$file = fopen($fileName,'r+') or die("can't open file r");
						
						while(!feof($file)) { 
							$line = fgets($file) or die("can't gets");
							if(strpos($line, $pattern1) !== false){
								$out .= $pattern1 . " = '". $newValue1 . "';\n";
							}
							elseif(strpos($line, $pattern2) !== false){
								$out .= $pattern2 . " = ". $newValue2 . ";\n";
							}
							elseif(strpos($line, $pattern3) !== false){
								$out .= $pattern3 . " = ". $newValue3 . ";\n";
							}
							elseif(strpos($line, $pattern4) !== false){
								$out .= $pattern4 . " = ". $newValue4 . ";\n";
							}
							elseif(strpos($line, $pattern5) !== false){
								$out .= $pattern5 . " = '". $newValue5 . "';\n";
							}
							elseif(strpos($line, $pattern6) !== false){
								$out .= $pattern6 . " = '". $newValue6 . "';\n";
							}
							else{
								$out .= $line;
							}
							
						}
						file_put_contents($fileName, $out) or die ("cannot write");
						fclose($file);
					}				
				
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
}

public function printMemCachedDetails($status){

echo "<table border='1'>";

	echo "<tr><td>Memcached Server version:</td><td> ".$status ["version"]."</td></tr>";
	echo "<tr><td>Process id of this server process </td><td>".$status ["pid"]."</td></tr>";
	echo "<tr><td>Number of seconds this server has been running </td><td>".$status ["uptime"]."</td></tr>";
	echo "<tr><td>Accumulated user time for this process </td><td>".$status ["rusage_user"]." seconds</td></tr>";
	echo "<tr><td>Accumulated system time for this process </td><td>".$status ["rusage_system"]." seconds</td></tr>";
	echo "<tr><td>Total number of items stored by this server ever since it started </td><td>".$status ["total_items"]."</td></tr>";
	echo "<tr><td>Number of open connections </td><td>".$status ["curr_connections"]."</td></tr>";
	echo "<tr><td>Total number of connections opened since the server started running </td><td>".$status ["total_connections"]."</td></tr>";
	echo "<tr><td>Number of connection structures allocated by the server </td><td>".$status ["connection_structures"]."</td></tr>";
	echo "<tr><td>Cumulative number of retrieval requests </td><td>".$status ["cmd_get"]."</td></tr>";
	echo "<tr><td> Cumulative number of storage requests </td><td>".$status ["cmd_set"]."</td></tr>";

	$percCacheHit=((real)$status ["get_hits"]/ (real)$status ["cmd_get"] *100);
	$percCacheHit=round($percCacheHit,3);
	$percCacheMiss=100-$percCacheHit;

	echo "<tr><td>Number of keys that have been requested and found present </td><td>".$status ["get_hits"]." ($percCacheHit%)</td></tr>";
	echo "<tr><td>Number of items that have been requested and not found </td><td>".$status ["get_misses"]."($percCacheMiss%)</td></tr>";

	$MBRead= (real)$status["bytes_read"]/(1024*1024);

	echo "<tr><td>Total number of bytes read by this server from network </td><td>".$MBRead." Mega Bytes</td></tr>";
	$MBWrite=(real) $status["bytes_written"]/(1024*1024) ;
	echo "<tr><td>Total number of bytes sent by this server to network </td><td>".$MBWrite." Mega Bytes</td></tr>";
	$MBSize=(real) $status["limit_maxbytes"]/(1024*1024) ;
	echo "<tr><td>Number of bytes this server is allowed to use for storage.</td><td>".$MBSize." Mega Bytes</td></tr>";
	echo "<tr><td>Number of valid items removed from cache to free memory for new items.</td><td>".$status ["evictions"]."</td></tr>";

echo "</table>";

    } 
	
	function getTreeCountByTreeType($workSpaceId, $workSpaceType, $type=1)
	{
		$userGroup= $this->getUserGroupByMemberId($_SESSION['userId']);
		//echo "wspaceid= " .$workSpaceId; exit;
		if($workSpaceId >= 0)
		{
			//echo "here"; exit;
			if($workSpaceId == 0)
			{
				$where = 'a.userId = b.userId AND a.workspaces='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].' AND a.type='.$type;	
				$where1 = 'a.userId = b.userId AND a.workspaces='.$workSpaceId.' AND a.type='.$type;				
			}
			else
			{
				$where = 'a.userId = b.userId AND a.workSpaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.' AND a.type='.$type;	
			}
		
			if($workSpaceId == 0)
			{  
/*					if ($type==5)
					{
						$result_count = $this->db->query("SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_contact_info b WHERE a.id = b.treeId AND a.workspaces=0 AND b.workplaceId = '".$_SESSION['workPlaceId']."' AND a.type=5 AND (a.userId = '".$_SESSION['userId']."' OR a.isShared=1)");
					}
					else
					{
						$qry1="SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b WHERE ".$where." AND latestVersion = 1";
						$result_count = $this->db->query($qry1);
						$qry2="SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b, teeme_trees_shared c WHERE c.treeId=a.id AND c.members like ('%".$_SESSION['userId'].",%') AND ".$where1." AND latestVersion = 1";
						$result_count1 =  $this->db->query($qry2);	
					}*/
						$qry1="SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b WHERE ".$where." AND latestVersion = 1";
						$result_count = $this->db->query($qry1);

						/*Commented by Dashrath- Comment old query and add new query below*/
						//$qry2="SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b, teeme_trees_shared c WHERE c.treeId=a.id AND c.members like ('%".$_SESSION['userId'].",%') AND ".$where1." AND latestVersion = 1";

						/*Added by Dashrath- Add new query for shared tree count issue in left menu bar old query comment above*/
						$qry2="SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b, teeme_trees_shared c WHERE c.treeId=a.id AND FIND_IN_SET(".$_SESSION['userId'].",c.members) AND a.userId != ".$_SESSION['userId']." AND ".$where1." AND latestVersion = 1";
						/*Dashrath- code end*/

						$result_count1 =  $this->db->query($qry2);	

				if($result_count->num_rows()> 0)
				{
					foreach($result_count->result() as $row)
					{
						$total = $row->total;
/*							if ($type!=5)
							{
								if($result_count1->num_rows()> 0)
								{
									foreach($result_count1->result() as $row1)
									{
										$total = $total+$row1->total;
									}
								}
							}*/
								if($result_count1->num_rows()> 0)
								{
									foreach($result_count1->result() as $row1)
									{
										$total = $total+$row1->total;
									}
								}
							if ($total>0)
							{
								return $total;
							}
					}
				}	
			}
			else
			{
					if ($workSpaceType==2)
					{
						$workSpaceDetails=$this->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
					}
					else
					{
						$workSpaceDetails=$this->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
					}
					if ($type==5)
					{
						if ($workSpaceDetails['workSpaceName']=='Try Teeme' || $userGroup==0)
						{
							$result_count = $this->db->query( "SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users u, teeme_contact_info b WHERE a.userId=u.userId AND a.id = b.treeId AND (a.workSpaces = '".$workSpaceId."' AND a.workSpaceType= '".$workSpaceType."') AND b.workplaceId = '".$_SESSION['workPlaceId']."' AND a.type=5");
						
						}
						else
						{
							$result_count = $this->db->query( "SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users u, teeme_contact_info b WHERE a.userId=u.userId AND a.id = b.treeId AND (b.sharedStatus=1 OR (a.workSpaces = '".$workSpaceId."' AND a.workSpaceType= '".$workSpaceType."')) AND b.workplaceId = '".$_SESSION['workPlaceId']."' AND a.type=5");
							
						}
					}
					else
					{
						$result_count = $this->db->query('SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b WHERE '.$where.' AND latestVersion = 1');
					}
					if($result_count->num_rows()> 0)
					{
						foreach($result_count->result() as $row)
						{
							$total = $row->total;
								if ($total>0)
								{
									return $total;
								}
						}
					}	
			}	
		}
			
			return 0;	
			
		
					
	}
	
	public function getTreeCountByTreeTask($workSpaceId,$workSpaceType,$userId, $type=4, $option = 1)
	{
		
		if($workSpaceId >= 0)
		{
			// Get information of particular Discussion
			if($option == 1)
			{
				
		
				if($workSpaceId)
				{
					$query = $this->db->query("SELECT COUNT(a.id) as total FROM teeme_tree a , teeme_node b, teeme_leaf c, teeme_users d where b.treeIds=a.id and c.id = b.leafId AND a.userId = d.userId AND a.name like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type);
				}
				else
				{
					$query = $this->db->query("SELECT COUNT(a.id) as total FROM teeme_tree a , teeme_node b, teeme_leaf c, teeme_users d where b.treeIds=a.id and c.id = b.leafId AND a.userId = d.userId AND a.name like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and (a.userId='".$userId."' OR a.isShared=1) and a.type=".$type);
				}

				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						return $row->total;				
					}				
				}
			}
			else if($option == 2)
			{	
				
				

				if($workSpaceId>0)
				{								
					$query = $this->db->query("SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b  where a.userId = b.userId AND a.name not like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);
					if($query->num_rows() > 0)
				    {
					foreach ($query->result() as $row)
					{	
						$total=$row->total;
						return $total;					
					}				
				}
				}
				else
				{ 
				
					$query = $this->db->query("SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b where a.userId = b.userId AND a.nodes='0' and a.name not like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and (a.userId='".$userId."') and a.type=".$type.$orderBy);

					/*Commented by Dashrath- Comment old query and add new query below*/
					// $query1 =  $this->db->query("SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b, teeme_trees_shared c WHERE c.treeId=a.id AND c.members like ('%".$_SESSION['userId'].",%') AND a.userId = b.userId AND a.nodes='0' and a.name not like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);

					/*Added by Dashrath- Add new query for shared tree count issue in left menu bar old query comment above*/
					$query1 =  $this->db->query("SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b, teeme_trees_shared c WHERE c.treeId=a.id AND FIND_IN_SET(".$_SESSION['userId'].",c.members) AND a.userId != ".$_SESSION['userId']." AND a.userId = b.userId AND a.nodes='0' and a.name not like('untitle%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);
					/*Dashrath- code end*/

					if($query->num_rows() > 0)
				    {
					foreach ($query->result() as $row)
					{	
						$total=$row->total;
						if($query1->num_rows() > 0)
						{
							foreach ($query1->result() as $row1)
							{	
								$total=$total+$row1->total;					
							}				
						}
						return $total;					
					}				
				}
				}

				
			}			
		}
	
		return 0;				
	}


public function getTreeCountByTreeDiscussion($workSpaceId,$workSpaceType,$userId, $type=2)
	{
		
		if($workSpaceId >= 0)
		{
			// Get information of particular Discussion
			if($workSpaceId)
			{
			$query = $this->db->query("SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b where a.userId = b.userId AND a.embedded=0 AND a.nodes='0' and a.name not like('untile%') and a.name <>' ' and a.workspaces='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);
			}else{
			$query = $this->db->query("SELECT COUNT(a.id) as total FROM teeme_tree a, teeme_users b where a.userId = b.userId AND a.embedded=0 AND a.nodes='0' and a.name not like('untile%') and a.name <>' ' and a.workspaces='".$workSpaceId."'  and (a.userId='".$userId."' OR a.isShared=1) and a.workSpaceType='".$workSpaceType."' and a.type=".$type.$orderBy);
			}
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					return $row->total;
				}				
			}
		}
 			
		return 0;				
	}
	
	
	public function getTreeCountByTreeMembers($workSpaceId,$workSpaceType,$workPlaceId)
	{
		if($workSpaceId==0)
		{
		$query = $this->db->query('SELECT COUNT(userId) AS total FROM teeme_users WHERE workPlaceId='.$workPlaceId);
		}
		else
		{
		  if($workSpaceType==2)
		  {	
		  $query = $this->db->query('SELECT COUNT(b.userId) AS total FROM teeme_sub_work_space_members a, teeme_users b WHERE a.subWorkSpaceUserId = b.userId AND a.subWorkSpaceId='.$workSpaceId);
		  }
		  else
		  {
		  	
				$query = $this->db->query('SELECT COUNT(b.userId) AS total FROM teeme_work_space_members a, teeme_users b WHERE a.workSpaceUserId = b.userId AND a.workSpaceId='.$workSpaceId);
			
		  }
		  
		}
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				
				return $row->total;
														
			}				
		}					
		return 0;			
	}
	
	
	//function returns latest updated all trees
	public function getTreesByWorkSpaceId($workSpaceId, $workSpaceType, $count=false,$offset=FALSE,$limit=10,$treeType=0)
	{
		$arrTree	= array();	

		if($workSpaceId != NULL)
		{
			// Get information of particular document
			
			// Making limit query based on parameters
		    $limit_query = $offset!==FALSE ? "LIMIT $offset, $limit" : "";
			
			if($workSpaceId == 0)
			{
				$where = 'a.userId = b.userId AND a.workspaces='.$workSpaceId.' AND (a.userId = '.$_SESSION['userId'].' OR a.isShared=1) ';				
			}
			else
			{
				$where = 'a.userId = b.userId AND a.workSpaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType ;	
			}
			if ($treeType>0)
			{
				$where .= ' AND a.type = '.$treeType;
			}
			
			if($count==true)
			{
				$result_count = $this->db->query('SELECT a.*,date_format(a.createdDate,\'%Y-%m-%d %H:%i:%s\') as treeCreatedDate, date_format(a.editedDate,\'%Y-%m-%d %H:%i:%s\')  as treeEditedDate, a.status FROM teeme_tree a, teeme_users b WHERE '.$where.' AND latestVersion = 1 and a.name not like("untile%") and a.name not like("untitle%") AND (a.parentTreeId=0 OR embedded=0) ORDER BY a.editedDate DESC');
				
	
				if($result_count->num_rows()> 0)
				{
				
						$total = $result_count->num_rows;
						if ($total>0)
						{
						return $total;
						}
				
				}	
		
				return 0;	
			
			}
			
			//Memcache code start here
			/*$memc=$this->createMemcacheObject();

			$memCacheId = 'wp'.$workSpaceId.'trees'.$workSpaceType.'place'.$_SESSION['workPlaceId'];	
			if($workSpaceId != 0)
			{
				$tree = $memc->get($memCacheId);	
			}
			if(!$tree)
			{*/
			
				 $q = 'SELECT a.*,date_format(a.createdDate,\'%Y-%m-%d %H:%i:%s\') as treeCreatedDate, date_format(a.editedDate,\'%Y-%m-%d %H:%i:%s\')  as treeEditedDate, a.status FROM teeme_tree a, teeme_users b WHERE '.$where.' AND a.latestVersion = 1 and a.name not like("untile%") and a.name not like("untitle%") AND (a.parentTreeId=0 OR embedded=0) ORDER BY a.editedDate DESC '.$limit_query;
				$query = $this->db->query($q);
				
				//echo $q; exit;
			
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}	
					
					/*if($workSpaceId != 0)
					{
						$memc->set($memCacheId, $tree);	
						$tree = $memc->get($memCacheId);
					}	*/		
				}
			/*}*/

			if(count($tree) > 0)
			{

				foreach ($tree as $row)
				{
	
					$treeId		= $row->id;		
										
					$arrTree[$treeId]['name'] = $row->name;	
					$arrTree[$treeId]['old_name'] = $row->old_name;	
					$arrTree[$treeId]['type'] = $row->type;	
					$arrTree[$treeId]['userId'] = $row->userId;
					$arrTree[$treeId]['createdDate'] = $row->treeCreatedDate;
					$arrTree[$treeId]['editedDate'] = $row->treeEditedDate;
					$arrTree[$treeId]['workSpaces'] = $row->workspaces;
					$arrTree[$treeId]['nodes'] = $row->nodes;
					$arrTree[$treeId]['isShared'] = $row->isShared;	
					$arrTree[$treeId]['embedded'] = $row->embedded;	
					$arrTree[$treeId]['status'] = $row->status;	
	
				}
			}
		}
		return $arrTree;				
	}
	
	
	//function returns latest updated all trees
	public function getTalkTreesByWorkSpaceId($workSpaceId, $workSpaceType, $count=false,$offset=FALSE,$limit=25)
	{
		$arrTree	= array();	
		
		
		
		if($workSpaceId != NULL)
		{
			// Get information of particular document
			
			// Making limit query based on parameters
		    $limit_query = $offset!==FALSE ? "LIMIT $offset, $limit" : "";
			
			if($workSpaceId == 0)
			{
				$where = '`teeme_tree`.userId = `teeme_users`.userId AND `teeme_tree`.workspaces='.$workSpaceId.' AND (`teeme_tree`.userId = '.$_SESSION['userId'].' OR `teeme_tree`.isShared=1) ';				
			}
			else
			{
				$where = '`teeme_tree`.`userId` = `teeme_users`.`userId` AND `teeme_tree`.`workSpaces` = \''.$workSpaceId.'\' AND `teeme_tree`.`workSpaceType`= '.$workSpaceType ;	
			}
			$q = 'SELECT `teeme_tree`.`id`,`teeme_tree`.`name`,`teeme_tree`.`old_name`,`teeme_tree`.`type` as treeType,`teeme_tree`.`userId`,`teeme_tree`.`createdDate`,`teeme_tree`.`editedDate`,`teeme_tree`.`workSpaces`,`teeme_tree`.`nodes`,`teeme_tree`.`isShared`,`teeme_tree`.`embedded`,`teeme_leaf_tree`.`leaf_id`, date_format(editedDate, \'%Y-%m-%d %H:%i:%s\') as editedDate,`teeme_leaf_tree`.`type` FROM `teeme_tree` LEFT JOIN `teeme_leaf_tree` ON `teeme_tree`.`id`=`teeme_leaf_tree`.`tree_id` LEFT JOIN `teeme_users` ON `teeme_tree`.`userId`=`teeme_users`.`userId`   WHERE '.$where.' AND `teeme_tree`.`embedded`=1 AND `teeme_leaf_tree`.`updates` >0 '.$limit_query;
			
			$query = $this->db->query($q);
			if($count==true)
			{
				$result_count = $this->db->query('SELECT count(`teeme_leaf_tree`.`id`) as total  FROM `teeme_tree` LEFT JOIN `teeme_leaf_tree` ON `teeme_tree`.`id`=`teeme_leaf_tree`.`tree_id` WHERE `teeme_tree`.`embedded`=1 AND `teeme_leaf_tree`.`updates` >0 ');
				
	
				if($result_count->num_rows()> 0)
				{
					foreach($result_count->result() as $row)
					{
						$total = $row->total;
						if ($total>0)
						{
						return $total;
						}
					}
				}	
		
				return 0;	
			
			}
			
			
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$treeId		= $row->id;		
										
					$arrTree[$treeId]['name'] = $row->name;	
					$arrTree[$treeId]['old_name'] = $row->old_name;	
					$arrTree[$treeId]['type'] = $row->type;	
					$arrTree[$treeId]['treeType'] = $row->treeType;	
					$arrTree[$treeId]['userId'] = $row->userId;
					$arrTree[$treeId]['createdDate'] = $row->treeCreatedDate;
					$arrTree[$treeId]['editedDate'] = $row->treeEditedDate;
					$arrTree[$treeId]['workSpaces'] = $row->workspaces;
					$arrTree[$treeId]['nodes'] = $row->nodes;
					$arrTree[$treeId]['isShared'] = $row->isShared;	
					$arrTree[$treeId]['embedded'] = $row->embedded;	
							
				}				
			}
		}
		return $arrTree;				
	}
	
	
	
	//function check unique tag name for users list
	public function checkUserTagName($tagName,$config=0)
    {	
		$tagName1 = $tagName;
		if (strpos($tagName1, 'pm_') === false)
		{
			$tagName2 = 'pm_'.$tagName;
		}
		else
		{
			$tagName2 = str_replace('pm_','',$tagName1);
		}
			
		$qry = 'SELECT userId FROM teeme_users WHERE tagName = \''.$this->db->escape_str($tagName1).'\' OR tagName = \''.$this->db->escape_str($tagName2).'\'';	
		
			if($config!=0){
				$placedb = $this->load->database($config,TRUE);		
				$query = $placedb->query($qry);	
			}
			else
			{
				$query = $this->db->query($qry);
			}
		if($query->num_rows()> 0)
		{
			return false;
		}
		else
		{
			return true;
		}		
	}
	
	//Fucntion to get  user tage name 
	function randomUserTagName($firstname,$lastname)
	{
		$tagName=$firstname."_".$lastname."_".rand(1,10000);
		if($this->checkUserTagName($tagName))
			return $tagName;
		else
		  randomUserTagName($firstname,$lastname);	 
	}
	
	//fucntion returns unique tag name
	function generateaUniqueTagName($firstname,$lastname,$isPlaceManager=0, $placeId=0, $tagNamePreference='f_l')
	{
		if($firstname!='')
		{
			$firstname = str_replace(' ','_',trim($firstname));
		}
		if($lastname!='')
		{
			$lastname = str_replace(' ','_',trim($lastname));
		}
/*		if($this->checkUserTagName($lastname."_".$firstname))
		{
			return $lastname."_".$firstname;
		}
		elseif($this->checkUserTagName($firstname."_".$lastname))
		{
			return $firstname."_".$lastname;
		}
		elseif($this->checkUserTagName($lastname."".$firstname))
		{
			return $lastname."".$firstname;
		}
		elseif($this->checkUserTagName($firstname."".$lastname))
		{
			return $firstname."".$lastname;
		}
		elseif($this->checkUserTagName("_".$lastname."".$firstname))
		{
			return "_".$lastname."".$firstname;
		}
		else
		   return $this->randomUserTagName($firstname,$lastname);*/
		   
		if ($placeId>0)
		{
			$workPlaceData = $this->getWorkPlaceDetails($placeId);
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
		}   

		if ($isPlaceManager==1)
		{
			if ($tagNamePreference=='l_f')
				$tagname = "pm_".$lastname."_".$firstname;
			else
				$tagname = "pm_".$firstname."_".$lastname;
		}
		else
		{
			if ($tagNamePreference=='l_f')
				$tagname = $lastname."_".$firstname;
			else
				$tagname = $firstname."_".$lastname;
			$config = 0;
		}

		if($this->checkUserTagName($tagname,$config))
		{
			return $tagname;
		} 
		else
		{
			$gotit = '';
			for ($i=1;$i<10000;$i++)
			{
				if ($isPlaceManager==1)
				{
					if ($tagNamePreference=='l_f')
						$tagname_sequence = "pm_".$lastname."_".$firstname."_".$i;
					else
						$tagname_sequence = "pm_".$firstname."_".$lastname."_".$i;
				}
				else
				{
					if ($tagNamePreference=='l_f')
						$tagname_sequence = $lastname."_".$firstname."_".$i;
					else
						$tagname_sequence = $firstname."_".$lastname."_".$i;
				}
				
				if($this->checkUserTagName($tagname_sequence,$config))
				{
					$gotit = $tagname_sequence;
					break;
				}
			}
			if ($gotit!='')
			{
				return $gotit;	
			}
			else
			{
				$random_tagname = $this->randomUserTagName($firstname,$lastname);
				if ($isPlaceManager==1)
				{
					$random_tagname = "pm_".$random_tagname;
				}
				return $random_tagname;
			}
		}	 	
	}
	
	//returns all talk tree by parent tree
	public function getTalkTreesByParentTreeIdDoc($treeId)
	{
		
			$treeData	= array();
		
		
			$query = $this->db->query( "SELECT `teeme_tree`.`id`,`teeme_tree`.userId,`teeme_leaf_tree`.`leaf_id`, date_format(editedDate, '%Y-%m-%d %H:%i:%s') as editedDate,`teeme_leaf_tree`.`type`	FROM `teeme_tree` LEFT JOIN	`teeme_leaf_tree` ON `teeme_tree`.`id`=`teeme_leaf_tree`.`tree_id` WHERE `teeme_tree`.`embedded`=1 AND `teeme_tree`.`parentTreeId` = ".$treeId);
			if($query->num_rows() > 0)
			{
				 $i=1;
				 $row=$query->result();
		
				foreach ($query->result() as $row)
				{
					
					$q = $this->db->query("SELECT `leafId` FROM `teeme_node` WHERE `treeIds`= ".$row->id);
					if($q->num_rows()){
							
						
						if($row->type==1)
						{
						    $parentTreeId=$this->getParentTreeIdByTreeId($row->id); 
						    $content=$this->getTreeNameByTreeId($parentTreeId);
						   
							$treeData[0]['id'] = $row->id;	
							$treeData[0]['name']       = $content;
							$treeData[0]['leaf_id']    = $row->leaf_id;
							$treeData[0]['userId']    = $row->userId;		 
							$treeData[0]['editedDate'] = $row->editedDate;	
							$treeData[0]['type']       = $row->type;
							$treeData[$i]['nodeId']    = '';
						}
						else
						{
							$query= $this->db->query("SELECT `contents`, `nodeId` FROM `teeme_leaf` WHERE `id`=".$row->leaf_id);
							$data = $query->row();
							$content   = $data->contents;
							$nodeId   = $data->nodeId;
							$treeData[$i]['id'] = $row->id;	
							$treeData[$i]['name']       = $content;
							$treeData[$i]['leaf_id']    = $row->leaf_id;	
							$treeData[$i]['userId']    = $row->userId;		 	 
							$treeData[$i]['editedDate'] = $row->editedDate;	
							$treeData[$i]['type']       = $row->type;	
							$treeData[$i]['nodeId']     = $nodeId;
							$i++;
						}
						
					}
				}
			}	
				
			sort($treeData);
		
			return $treeData;	
		
	}
	
	function getTalkTreesByParentTreeId($treeId){
		
		
			$treeData	= array();
		
			//$query = $this->db->query( "SELECT `teeme_tree`.`id`,`teeme_tree`.`name`,`teeme_leaf_tree`.`leaf_id`, date_format(editedDate, '%Y-%m-%d %H:%i:%s') as editedDate,`teeme_leaf_tree`.`type`	FROM `teeme_tree` LEFT JOIN	`teeme_leaf_tree` ON `teeme_tree`.`id`=`teeme_leaf_tree`.`tree_id` WHERE `teeme_tree`.`embedded`=1 AND `teeme_tree`.`parentTreeId` = ".$treeId  );
			$query = $this->db->query( "SELECT `teeme_tree`.`id`,`teeme_tree`.userId,`teeme_leaf_tree`.`leaf_id`, editedDate,`teeme_leaf_tree`.`type`	FROM `teeme_tree` LEFT JOIN	`teeme_leaf_tree` ON `teeme_tree`.`id`=`teeme_leaf_tree`.`tree_id` WHERE `teeme_tree`.`embedded`=1 AND `teeme_tree`.`parentTreeId` = ".$treeId." ORDER BY editedDate desc");
			if($query->num_rows() > 0)
			{
				 $i=0;
				 $row=$query->result();
		
				foreach ($query->result() as $row)
				{
					$treeData[$i]['id'] = $row->id;	
					$q = $this->db->query("SELECT `leafId` FROM `teeme_node` WHERE `treeIds`= ".$row->id);
					if($q->num_rows()){
						if($row->type==1)
						{
						   $parentTreeId=$this->getParentTreeIdByTreeId($row->id); 
						   
						   $content=$this->getTreeNameByTreeId($parentTreeId);
						   $nodeId   = '';
						}
						else
						{
							$query= $this->db->query("SELECT teeme_leaf.`contents`,teeme_leaf.`nodeId` FROM `teeme_leaf`,`teeme_node` WHERE `teeme_node`.`leafId`=`teeme_leaf`.id AND  `teeme_node`.`id`=".$row->leaf_id);
							$data = $query->row();
							$content   = $data->contents;
							$nodeId   = $data->nodeId;
						}
						$treeData[$i]['name']       = strip_tags($content);
						$treeData[$i]['leaf_id']    = $row->leaf_id;		
						$treeData[$i]['userId']    	= $row->userId;		  
						$treeData[$i]['editedDate'] = $row->editedDate;	
						$treeData[$i]['type']       = $row->type;	
						$treeData[$i]['nodeId']     = $nodeId;
						$i++;
					}
				}
			}	
				
		
			return $treeData;	
		
	
	}
		
		
	//function returns parent tree Id	
	function getParentTreeIdByTreeId($treeId)
	{
		$query=$this->db->query('SELECT `parentTreeId` FROM `teeme_tree` WHERE `id`= "'.$treeId.'"');
		if($query->num_rows()>0)
		{
		  $result=$query->row();
		  
		  return $result->parentTreeId;
		}
		return false;
	}
		

	public function getUpdatedTalkTree($workSpaceId, $workSpaceType,$count=false,$start=0,$limit=25 )
	{
			
		$limit = ' LIMIT '.$start.','.$limit;
		
		
		if($workSpaceId != NULL)
		{
			// Get information of particular document
			if($workSpaceId == 0)
			{
				//$where = 'a.workspaces='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].'';	
				$where = 'a.workspaces='.$workSpaceId;		
			}
			else
			{

					$where = 'a.workspaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.'';
			}
			
			if($count==true)
			{ 
			
			 
			    $countResult=$this->db->query('SELECT count(b.id) as total  FROM teeme_tree a, teeme_leaf_tree b WHERE '.$where.' AND a.id=b.tree_id AND latestVersion=1 AND embedded=1 AND name not like(\'untile%\') AND name <>\' \'  and b.updates>0 ');
				
				if($countResult->num_rows()>0)
				{
				    $countResult=$countResult->row();
					
					return $countResult->total;
				}
				 else
				    return 0;
			  
			}	
								
			//Memcache code start here
			/*$memc=$this->createMemcacheObject();

			$memCacheId = 'wp'.$workSpaceId.'talks'.$workSpaceType.'place'.$_SESSION['workPlaceId'];	
			
			if($workSpaceId != 0)
			{
				$tree = $memc->get($memCacheId);	
			}
			
			if(!$tree)
			{*/			
				$q = 'SELECT a.id,  a.parentTreeId,b.leaf_id, a.name, a.type,b.type as treeType, a.userId, a.createdDate, a.editedDate, a.status FROM teeme_tree a, teeme_leaf_tree b WHERE '.$where.' AND a.id=b.tree_id AND latestVersion=1 AND embedded=1 AND name not like(\'untile%\') AND name <>\' \' and b.updates>0 ORDER BY editedDate desc   '.$limit;
					
				$query = $this->db->query($q);	
				
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}
					/*if($workSpaceId != 0)
					{
						$memc->set($memCacheId, $tree);
						$tree = $memc->get($memCacheId);				
					}*/
				}
			/*}*/
			
			if(count($tree) > 0)
			{

				foreach ($tree as $row)
				{
	
					$treeDetails[$row->id]['id'] 				= $row->id;	
					$treeDetails[$row->id]['parentTreeId'] 		= $row->parentTreeId;
					$treeDetails[$row->id]['leaf_id'] 			= $row->leaf_id;	
					$treeDetails[$row->id]['name'] 				= $row->name;	
					$treeDetails[$row->id]['type'] 				= $row->type;	
					$treeDetails[$row->id]['treeType'] 			= $row->treeType;	
					$treeDetails[$row->id]['userId'] 			= $row->userId;	
					$treeDetails[$row->id]['createdDate'] 		= $row->createdDate;	
					$treeDetails[$row->id]['editedDate'] 		= $row->editedDate;
					$treeDetails[$row->id]['status'] 			= $row->status;
	
				}
			}
			
		}
		return $treeDetails;				
	}
	
	
	function getRecentLinks( $workSpaceId, $workSpaceType, $count=false,$start=0,$limit=25  )
	{
		 
		 	$limit = ' LIMIT '.$start.','.$limit;
		
			if($workSpaceId == 0)
			{
					$where = 'a.workspaces='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].'';	
			}
			else
			{
					$where = 'a.workspaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.'';
			}	
			
			if($count==true)
			{ 
			    $countResult=$this->db->query('SELECT COUNT(b.linkId) as total FROM teeme_tree a, teeme_links b WHERE '.$where.' AND a.id=b.treeId ORDER BY b.createdDate desc');
				
				if($countResult->num_rows()>0)
				{
				    $countResult=$countResult->row();
					
					return $countResult->total;
				}
				 else
				    return 0;
			  
			}		
		
	$q = 'SELECT a.id, a.name, a.type, b.artifactId, b.artifactType ,b.createdDate FROM teeme_tree a, teeme_links b WHERE '.$where.' AND a.id=b.treeId ORDER BY b.createdDate desc'.$limit;
		
			
		
		$query = $this->db->query($q);

		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$treeData->id]['id'] = $treeData->id;
					$treeIds[$treeData->id]['name'] = $treeData->name;
					$treeIds[$treeData->id]['type'] = $treeData->type;
					$treeIds[$treeData->id]['artifactId'] = $treeData->artifactId;
					$treeIds[$treeData->id]['createdDate'] = $treeData->createdDate;
					$treeIds[$treeData->id]['artifactType'] = $treeData->artifactType;
					$treeIds[$treeData->id]['status'] = $treeData->status;
					$i++;
				}
			}
		}
		
		

		return $treeIds;
	}
	
	
	public function getRecentTags( $workSpaceId, $workSpaceType,$count=false,$start=0,$limit=25 )
	{
		$arrTagDetails=array();
	
					
		
		$i = 0;	

		 //response tag for leaf
			$q  = 'select * from (SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.artifactType=2 AND a.tagType = 3 AND a.tagId = b.tagId AND b.status = 1 AND c.id = d.treeIds AND a.artifactId = d.id AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.' order by createdDate desc ) t group by comments';
	
								
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails[$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}		
		
		
		//response tag for seed
		  $q  = 'select * from(SELECT a.* FROM teeme_tag as a LEFT JOIN teeme_tree as t ON a.artifactId=t.id  where a.artifactType=1 AND a.tagType = 3 AND  t.workspaces='.$workSpaceId.'  AND workSpaceType='.$workSpaceType.' order by createdDate desc ) t group by comments  ';
			
				
							
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;
							
							$arrTagDetails[$i]['tagComment'] 	= $tagData->comments;
								
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}	
		
				//for simple tag 
				//  $q  = 'select * from (SELECT y.tagType as tagComment,a.* FROM teeme_tag as a LEFT JOIN teeme_tree as t  ON a.artifactId=t.id LEFT JOIN teeme_tag_types as y ON a.tag=y.tagTypeId  where (a.artifactType=1 OR a.artifactType=2)  AND (a.tagType = 2 AND t.workspaces='.$workSpaceId.'  AND t.workSpaceType='.$workSpaceType.') order by a.createdDate desc ) t group by tagComment ';
				$q  = 'SELECT * from (SELECT y.tagType as tagComment,a.* FROM teeme_tree as t, teeme_tag as a LEFT JOIN teeme_tag_types as y ON a.tag=y.tagTypeId WHERE (a.artifactType=1 OR a.artifactType=2) AND (a.tagType = 2 AND t.workspaces='.$workSpaceId.'  AND t.workSpaceType='.$workSpaceType.') ORDER BY a.createdDate desc ) t GROUP BY tagComment ';
	
				
							
			    $query = $this->db->query($q);
				//echo $q; exit;
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;
							
							$arrTagDetails[$i]['tagComment'] 	= $tagData->tagComment;
								
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}	
		
			// for contact tags
			if($workSpaceId == 0)
			{
					$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
			}
			else
			{
					$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
			}
		
			 
			  $q = 'select * from(SELECT a.*, b.name as contactName FROM teeme_tag a, teeme_tree b WHERE '.$where.' AND a.tagType = 5 AND a.tag = b.id order by createdDate desc ) t group by contactName';
						
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails[$i]['tagComment'] 	= $tagData->contactName;
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}		
		
		if($count==true)
			{ 
			    $countResult=count($arrTagDetails);
				
				if($countResult)
				{
				   
					
					return $countResult;
				}
				 else
				    return 0;
			  
			}
		
		//Sorting array by diffrence 
			foreach ($arrTagDetails as $key => $row)
			{
				$diff[$key]  = $row['createdDate'];
            }

			
	     	array_multisort($diff,SORT_DESC,$arrTagDetails);
		
			$main_array=array();
			
		
			for($i=$start;$i<$start+25;$i++)
			{ 
			    if($arrTagDetails[$i])
				{
			   	 array_push($main_array,$arrTagDetails[$i]);
				} 
			}	
			
			
	
		return $main_array;
	}
	
	//////////////////arun/////////
	function getUpdatedLinks( $workSpaceId, $workSpaceType, $count=false,$start=0,$limit=25  )
	{
		 
		 	$limit = ' LIMIT '.$start.','.$limit;
		
			if($workSpaceId == 0)
			{
					$where = 'a.workspaces='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].'';
					
					//condition for external doc	
					$whereExternal = 'a.workSpaceId='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].'';
					
					//condition for applied url	
					$whereUrl = 'c.workspaces='.$workSpaceId.' AND l.userId = '.$_SESSION['userId'].'';
			}
			else
			{
					$where = 'a.workspaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.'';
					
					//condition for external doc	
					$whereExternal = 'a.workSpaceId='.$workSpaceId.' AND a.workSpaceType= '.$workSpaceType.'';
					
					//condition for applied url	
					$whereUrl = 'c.workspaces='.$workSpaceId.' AND c.workSpaceType= '.$workSpaceType.'';
			}	
			
			if($count==true)
			{ 
			    $countResult=$this->db->query('select * from(SELECT a.id, a.name, a.type, b.artifactId, b.artifactType ,b.createdDate FROM teeme_tree a, teeme_links b WHERE '.$where.' AND a.id=b.treeId ORDER BY b.createdDate desc) t group by name');
				
				if($countResult->num_rows()>0)
				{
		
					return $countResult->num_rows();
				}
				 else
				    return 0;
			  
			}		
		
$q = 'select * from(SELECT a.id, a.name, a.type, b.artifactId, b.artifactType ,b.createdDate FROM teeme_tree a, teeme_links b WHERE '.$where.' AND a.id=b.treeId ORDER BY b.createdDate desc) t group by name';
		
		$i = 0;	
		
		$query = $this->db->query($q);

		if($query)
		{		
			if($query->num_rows() > 0)
			{
				//$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['id'] = $treeData->id;
					$treeIds[$i]['name'] = $treeData->name;
					$treeIds[$i]['type'] = $treeData->type;
					$treeIds[$i]['artifactId'] = $treeData->artifactId;
					$treeIds[$i]['createdDate'] = $treeData->createdDate;
					$treeIds[$i]['artifactType'] = $treeData->artifactType;
					$treeIds[$i]['status'] = $treeData->status;
					$treeIds[$i]['linkType'] ='';
					$treeIds[$i]['path'] ='';
					$i++;
				}
			}
		}
		
			
	$q = 'select * from (SELECT a.docId, a.docName,a.path,  l.artifactId, l.artifactType ,l.createdDate FROM teeme_links_external l, teeme_external_docs a WHERE '.$whereExternal.' AND l.linkedDocId =a.docId ORDER BY l.createdDate desc) t group by docName ';	
	
	  
	  
	  $query = $this->db->query($q);

		if($query)
		{		
			if($query->num_rows() > 0)
			{
				//$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['id'] = $treeData->docId;
					$treeIds[$i]['name'] = $treeData->docName;
					$treeIds[$i]['type'] = '';
					$treeIds[$i]['artifactId'] = $treeData->artifactId;
					$treeIds[$i]['createdDate'] = $treeData->createdDate;
					$treeIds[$i]['artifactType'] = $treeData->artifactType;
					$treeIds[$i]['status'] = '';
					$treeIds[$i]['linkType'] ='external';
					$treeIds[$i]['path'] =$treeData->path;
					$i++;
				}
			}
		}
		
		//for applied url
		
		$q = 'select * from (SELECT a.id, a.title, a.url, l.artifactId, l.artifactType ,l.appliedDate FROM teeme_applied_url l, teeme_links_url a, teeme_node b, teeme_tree c WHERE l.urlId =a.id AND l.artifactId=b.id AND b.treeIds=c.id AND '.$whereUrl.' ORDER BY l.appliedDate desc) t group by title';	
	
	  
	  //return $q;
	  $query = $this->db->query($q);

		if($query)
		{		
			if($query->num_rows() > 0)
			{
				//$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['id'] = $treeData->id;
					$treeIds[$i]['name'] = $treeData->title;
					$treeIds[$i]['type'] = '';
					$treeIds[$i]['artifactId'] = $treeData->artifactId;
					$treeIds[$i]['createdDate'] = $treeData->appliedDate;
					$treeIds[$i]['artifactType'] = $treeData->artifactType;
					$treeIds[$i]['status'] = '';
					$treeIds[$i]['linkType'] ='url';
					$treeIds[$i]['url'] =$treeData->url;
					$i++;
				}
			}
		} 
		
		
			//Sorting array by cratedDate 
			foreach ($treeIds as $key => $row)
			{
				$diff[$key]  = $row['createdDate'];
            }

			
	     	array_multisort($diff,SORT_DESC,$treeIds);
	
			$main_array=array();
			
			for($i=$start;$i<$start+25;$i++)
			{ 
			    if($treeIds[$i])
				{
			   	 array_push($main_array,$treeIds[$i]);
				} 
			}	
			
		return $main_array;

	}
	
	//function returns sub space manager id by subWorkSpaceId
	function getWorkSpaceBySubWorkSpaceId($subWorkSpaceId)
	{
			
		$query = $this->db->query('SELECT workSpaceId FROM teeme_sub_work_space WHERE subWorkSpaceId='.$subWorkSpaceId);
		if($query->num_rows() > 0)
		{
			$query=$query->row();
			return $query->workSpaceId;
			
		}					
		else
		{
			return false;
		}		
	
	}
	

	
	
	function getLinkedTreesByWorkSpaceId( $workSpaceId, $workSpaceType,$count=false,$start,$limit=25 )
	{
		$treeIds = array();
		
		$limit = ' LIMIT '.$start.','.$limit;
		
		if($count==true)
			{ 
			    $countResult=$this->db->query('SELECT count(b.linkId) as total FROM teeme_tree a, teeme_links b WHERE a.id=b.treeId AND a.workspaces = "'.$workSpaceId.' " AND a.workSpaceType="'.$workSpaceType.'" AND a.name NOT LIKE (\'untitle%\') group by(b.treeId) ORDER BY b.createdDate DESC');
				
				if($countResult->num_rows()>0)
				{
				    $countResult=$countResult->row();
					
					return $countResult->total;
				}
				 else
				    return 0;
			  
			}		
		
		
				 $q = 'SELECT a.id,a.type, a.name,b.linkId,b.createdDate FROM teeme_tree a, teeme_links b WHERE a.id=b.treeId AND a.workspaces = "'.$workSpaceId.' " AND a.workSpaceType="'.$workSpaceType.'" AND a.name NOT LIKE (\'untitle%\') group by(b.treeId)  ORDER BY b.createdDate DESC'.$limit;
			
		
		$query = $this->db->query ($q);
	

		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{	
					$treeIds[$i]['linkId'] = $treeData->linkId;									
					$treeIds[$i]['treeId'] = $treeData->id;
					$treeIds[$i]['type'] = $treeData->type;
					$treeIds[$i]['createdDate'] = $treeData->createdDate;
					$treeIds[$i]['name'] = $treeData->name;
					$i++;
				}
			}
		}

		return $treeIds;
	}
	
	
	//arun
	//function to maintain history and keeps past Detail
	function insert_history()
	{
	
	   $query = $this->db->query('INSERT INTO `teeme_task_history`(treeId,treeType,nodeId,contents,starttime,endtime,assignedTime) values() ');
	
	}
		
		
		
	//arun- get all messages by space id and spaceType
	public function getMessageCountBySpaceIdAndType($ownerId,$count=false,$spaceType=0,$spaceId=0)
	{
		
		$check=$this->db->query("select * from information_schema.tables where table_name = 'teeme_wall_recipients'  ");
	   if($check->num_rows()>0)
	   {
			$query=$this->db->query("SELECT COUNT(*) AS total_count FROM (SELECT COUNT(*) FROM teeme_wall_recipients AS r LEFT JOIN  teeme_wall_comments AS c ON  r.commentId=c.Id   WHERE (( recipientId= '".$_SESSION['userId']."' ) || (commenterId='".$_SESSION['userId']." ' && recipientId = '".$ownerId."')) AND c.parentCommentId=0 AND r.recipientStatus =1 AND c.commentWorkSpaceId ='".$spaceId."' AND c.commentWorkSpaceType='".$spaceType."'	 GROUP BY commentId,recipientId) AS T  ");
				
			if($query->num_rows() > 0)
			{
				$query=$query->row();
				
			}		
			
			return $query->total_count;
		}
		
	}
	
	function insertUrl($txtUrl,$title,$ownerId,$workSpaceId,$workSpaceType)
	{
	   
	   if($this->db->query("INSERT INTO `teeme_links_url`(workSpaceId,workSpaceType,title,url,ownerId) VALUES($workSpaceId,$workSpaceType,'$title','$txtUrl',$ownerId)"))
	   {
	      return true;
		  
	   }
	   else
	   {
	      return false;
	   }
	   
	}
	
	function getImportedUrls($artifactId,$artifactType='')
	{
	
	        if($artifactType)
			{
			  $query="SELECT * FROM `teeme_links_url`  	";
			}
			else
			{
			   $query="SELECT * FROM `teeme_links_url`   ";
			}
	       
			$query=$this->db->query($query);
			
			$data = array();
			if($query)
			{		
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $treeData)
					{	
						$data[$i]['id'] = $treeData->id;									
						$data[$i]['url'] = $treeData->url;
						$data[$i]['createdDate'] = $treeData->createdDate;
						$i++;
					}
				}
			}
		
			return $data;	
			
			
	
	}
	
	
	function getImportedUrlsByartifactAndArtifactType($artifactId,$artifactType='')
	{
	 
			if($artifactType)
			{
			  $query="SELECT a.urlId,a.artifactId,a.artifactType,a.userId as appliedUserId,b.*  FROM `teeme_applied_url` AS a LEFT JOIN `teeme_links_url` as b ON  a.urlId=b.id WHERE a.artifactId=$artifactId and a.artifactType=$artifactType 	"; 
			}
			else
			{
			
			$query="SELECT a.urlId,a.artifactId,a.artifactType,a.userId as appliedUserId,b.*  FROM `teeme_applied_url` AS a LEFT JOIN `teeme_links_url` as b ON  a.urlId=b.id WHERE a.artifactId=$artifactId 	"; 
			
			}
	       
			$query=$this->db->query($query);
			
			$data = array();
			if($query)
			{		
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $treeData)
					{	
						$data[$i]['id'] = $treeData->id;
						$data[$i]['urlId'] = $treeData->urlId;	
						$data[$i]['artifactId'] = $treeData->artifactId;	
						$data[$i]['artifactType'] = $treeData->artifactType;	
						$data[$i]['title'] = $treeData->title;									
						$data[$i]['url'] = $treeData->url;
						$data[$i]['createdDate'] = $treeData->createdDate;
						$i++;
					}
				}
			}
		
			return $data;	
	
	}
	
	
	function getAllImportUrls($search='')
	{
	      
	        if(!empty($search))
			{
			   
				 $query="SELECT * FROM `teeme_links_url` WHERE `title` LIKE  '%$search%' ORDER BY title ASC "; 
			}
			else
			{
			
				$query="SELECT * FROM `teeme_links_url` ORDER BY title ASC ";
			}
			
			
			$query=$this->db->query($query);
			
			$data = array();
			if($query)
			{		
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $treeData)
					{	
						$data[$i]['id'] = $treeData->id;									
						$data[$i]['url'] = $treeData->url;
						$data[$i]['title'] = $treeData->title;
						$data[$i]['createdDate'] = $treeData->createdDate;
						$i++;
					}
				}
			}
		
			return $data;	
	}
	
	
	function getAppliedUrl($artifactId,$artifactType)
	{
	
		$query="SELECT * FROM `teeme_applied_url` WHERE 	artifactId=$artifactId and artifactType=$artifactType   ";
			
			$query=$this->db->query($query);
			
			$data = array();
			if($query)
			{		
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $treeData)
					{	
						$data[$i]['id'] 			= $treeData->id;									
						$data[$i]['urlId']			= $treeData->urlId;
						$data[$i]['artifactId'] 	= $treeData->artifactId;
						$data[$i]['artifactType'] 	= $treeData->artifactType;
						$data[$i]['userId'] 		= $treeData->userId;
						$i++;
					}
				}
			}
		
			return $data;
	
		
	
	}
	
	public function getTreeOriginatorByTreeId($treeId)
	{
				
		$query = $this->db->query( "SELECT a.userId FROM teeme_tree a WHERE a.id=".$treeId);		
		if($query->num_rows() > 0)
		{
			 $row=$query->row();
			return $row->userId;	
 			
		}					
		return false;		
	}
	
	public function getTreeAccessByWorkSpaceId($workSpaceId)
	{
			
		$query = $this->db->query( "SELECT a.treeAccess FROM teeme_work_space a WHERE a.workSpaceId=".$workSpaceId);
		
		if($query->num_rows() > 0)
		{
			 $row=$query->row();
			return $row->treeAccess;	
			
		}					
		return false;	
		
	}
	
	function validatePlace($place){
		$config = array();
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
		$q = $instancedb->query("select * from teeme_work_place where companyName='".$place."'");
		if($q->num_rows()){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	/*Changed by Dashrath- Add $config for load db*/
	function getUserConfigSettings($config=0){
		$userId = $_SESSION['userId'];

		/*Changed by Dashrath- Add if else condition for load db*/
		if ($config!=0)
        {
            $placedb = $this->load->database($config,TRUE);

            $q = $placedb->query("SELECT * FROM teeme_user_configuration  WHERE userId='$userId'");
        }
		else
		{
			$q = $this->db->query("SELECT * FROM teeme_user_configuration  WHERE userId='$userId'");
		}
		/*Dashrath- changes end*/

		if($q->num_rows()){
	
			return $q->row_array();
		}
		else{
			return 0;
		}
	}
	
	function saveUserConfigSettings($editorOption,$defaultSpace){
		$userId = $_SESSION['userId'];
		
		$query = $this->db->query("SELECT * FROM teeme_user_configuration WHERE userId='$userId'");
		if($query->num_rows()){
			$q = $this->db->query("UPDATE teeme_user_configuration SET `editorOption`='".$editorOption."', `defaultSpace`='".$defaultSpace."' WHERE userId='$userId'");
		}
		else{
			$q = $this->db->query("INSERT INTO teeme_user_configuration(`userId`, `editorOption`, `defaultSpace`) VALUES('$userId','".$editorOption."', '".$defaultSpace."') ");
		}
		if($q){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	function deletePlaceDb($dbName){
		$query = $this->db->query("DROP DATABASE IF EXISTS ".$dbName);
		if($query){
			return true;	
		}
	}
	
	function getNotificationOptions(){
		$query = $this->db->query("SELECT * FROM teeme_configuration_options WHERE is_notification='1'");
		if($query->num_rows()){
			return $query->result_array();
		}
		else{
			return 0;
		}
	}

    function hasPlaceManagerPrefix ($prefix='',$str='')
        {
                if (substr($str, 0, strlen($prefix)) == $prefix) {
                    return 1;
                } 
            return 0;
    }
        
    function removePlaceManagerPrefix ($prefix='',$str='')
    {
                if (substr($str, 0, strlen($prefix)) == $prefix) {
                    $str = substr($str, strlen($prefix));
                } 
            return $str;
    }
	
	function ifTreeExists ($tree_title='',$tree_type_value=0,$workSpaceId=0)
	{
		$q = 'SELECT name FROM teeme_tree WHERE name = \''.$this->db->escape_str($tree_title).'\' AND workspaces = \''.$workSpaceId.'\' AND type=\''.$tree_type_value.'\'';
		$query = $this->db->query($q);

		if($query->num_rows()> 0)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	function getTotalTreeCount ($workSpaceId, $workSpaceType)
	{
		$query = $this->db->query("SELECT count(id) AS total FROM teeme_tree WHERE workspaces = '".$workSpaceId."' AND workSpaceType = '".$workSpaceType."'");

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				return $row->total;				
			}		
		}		
		return 'null';
	}
	function securePassword ($password='')
	{
		if ($password!='')
		{
			$securePassword = password_hash($password, PASSWORD_BCRYPT);
			return $securePassword;
		}
		return 0;
	}	
	function verifySecurePassword ($password='',$hash='')
	{
		if ($password!='' && $hash!='')
		{
			$isVerified = password_verify($password, $hash);
				if ($isVerified)
				{
					return 1;
				}
				else
				{
					return 0;
				}
		}
		return 0;
	}
	function send_forgot_password_email($place_name=0,$user_type='',$email='',$code='')
	{
		
/*                    $this->model('mailer/mailer');
                    $objMailer	= $this->mailer;
                    $this->model('dal/mailer_manager');
                    $objMailerManager	= $this->mailer_manager;
	
					$objMailer->setMailTo($email);
					$objMailer->setMailSubject( 'Teeme - Forgot Password');
					$url = base_url().$place_id.'/'.$user_type.'/'.$email.'/'.$code;	
					$mailContent = '';
					$mailContent.= 'Hi,<br><br>';
					$mailContent.= 'Please click the link below to reset your password'."<br>";		
					$mailContent.= 'Link: '.$url."<br>";		
					$objMailer->setMailContents( $mailContent );*/
								$email_encoded = $this->encodeURLString($email);
								$code_encoded = $this->encodeURLString($code);
								$to      = $email;
								$subject = 'Teeme - Forgot Password';
								//$url = base_url().'forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$email.'/'.$code;
								$url = '<a href="'.base_url().'forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$email_encoded.'/'.$code_encoded.'">'.base_url().'forgot_password/password_reset/'.$place_name.'/'.$user_type.'/'.$email_encoded.'/'.$code_encoded.'</a>';
								$mailContent = '';
								$mailContent.= 'Hi,'."<br><br>";
								$mailContent.= 'Please click the link below to reset your password:'."<br>";		
								$mailContent.= 'Link: '.$url."<br><br>";
								$mailContent.= 'Thanks,'."<br>";
								$mailContent.= 'Teeme admin';
								$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
								$headers .= 'From: no-reply@teeme.net' . "\r\n" .'Reply-To: no-reply@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
					
                    /*if($objMailerManager->sendMail($objMailer))*/
					if (mail($to, $subject, $mailContent, $headers))
					{						
                    	return 1;
					}
					else
					{
                    	return 0;
					}	
	}
	//Manoj: Delete old backup from database
	public function removeBackup ($file='',$place_name='')
	{
		
		$this->load->model('dal/time_manager');
		$createdDate = time_manager::getGMTTime();
		
		//$query = "delete from teeme_backups WHERE file_name='".$file."'";	
		$query = "UPDATE teeme_backups SET `status`='0' WHERE file_name='".$file."'";	
		
		//Manoj: assign database name in config start
		if($place_name!='')
		{
			$config = array();
			$placedb = '';
			$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
			
			$placedb = $this->load->database($config, TRUE);
			
			$result = $placedb->query($query);	
		}
		else
		{
			$result = $this->db->query($query);
		}
		//Manoj: assign database name in config  end
		
		if($result)
		{
			return true;
		}		
		else
		{
			return false;
		}
	}
	//Manoj: code end
	
	//Manoj: Get number of users from place database for instance
	public function getInstanceWorkPlaceMembersByWorkPlaceId ($workPlaceId,$place_name)
	{
		$userData = array();
		$query = 'SELECT * FROM teeme_users WHERE workPlaceId='.$workPlaceId.' AND status = 0 ORDER BY firstName ASC';
		if($place_name!='')
		{
			$config = array();
			$placedb = '';
			$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
			
			$placedb = $this->load->database($config, TRUE);
			
			$query = $placedb->query($query);	
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach($query->result() as $row)
				{
					$userData[$i]['userId'] 		= $row->userId;	
					$i++;										
				}				
			}					
			return $userData;	
		}
		
		
	}
	//Manoj: code end
	
	//Manoj: code start for alter instance and place database table
	
	public function editAdminDB($instance_db)
	{    
				//Get database details
				$instance_db_name = $this->config->item('instanceDb');
				$server = base64_decode(trim($this->config->item('hostname')));
				$server_username = base64_decode(trim($this->config->item('username')));
				$server_password = base64_decode(trim($this->config->item('password')));
		
				$config = array();
				
				$config['hostname'] = $server;
				$config['username'] = $server_username;
				$config['password'] = $server_password;
				$config['database'] = $instance_db_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;

				//mysql_select_db( $place_db_name, $db );
				$instancedb = $this->load->database($config,TRUE);
				
		if($instancedb)
		{
		
				$FP = fopen ( $instance_db, 'r' );
				$READ = fread ( $FP, filesize ( $instance_db) );
				 
				$READ = explode ( ";", $READ );
				
				$instancedb->trans_begin();
				
				foreach ( $READ AS $RED )
				{
					if(!empty($RED)){
						//$result = mysql_query ( $RED )  or die($this->db->error());
						//echo "<li>" .$RED;
						$result = $instancedb->query($RED);		
						//$result = mysql_query ( $RED );
						
					}
				}
					
				if($instancedb->trans_status()=== FALSE)
				{
					$instancedb->trans_rollback();
					return false;
				}
				else
				{
					$instancedb->trans_commit();
					return true;
				}			
				
		
		}
		else{
			return false;
		}
	}
	
	public function editPlaceDB($placeId=0,$place_db)
	{    
				//Get database details
			if ($placeId>0)
			{	
				$instance_db_name = $this->config->item('instanceDb');
				$server = base64_decode(trim($this->config->item('hostname')));
				$server_username = base64_decode(trim($this->config->item('username')));
				$server_password = base64_decode(trim($this->config->item('password')));
		
				$workPlaceData = $this->getWorkPlaceDetails($placeId);
				$place_name = mb_strtolower($workPlaceData['companyName']);
				
				$config = array();
				
				$config['hostname'] = $server;
				$config['username'] = $server_username;
				$config['password'] = $server_password;
				$config['database'] = $instance_db_name.'_'.$place_name;;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;

				//mysql_select_db( $place_db_name, $db );
				$placedb = $this->load->database($config,TRUE);
			}
				
		if($placedb)
		{
	
				$FP = fopen ( $place_db, 'r' );
				$READ = fread ( $FP, filesize ( $place_db) );
				 
				$READ = explode ( ";", $READ );
				
				$placedb->trans_begin();

				foreach ( $READ AS $RED )
				{
					if(!empty($RED)){
						//$result = mysql_query ( $RED )  or die($this->db->error());
						//echo "<li>" .$RED;
						$result = $placedb->query($RED);		
						//$result = mysql_query ( $RED );
						
					}
				}
								
				if($placedb->trans_status()=== FALSE)
				{
					$placedb->trans_rollback();
					return false;
				}
				else
				{
					$placedb->trans_commit();
					return true;
				}		
			
		}
		else
		{
			return false;
		}
	}
	
	function insertVersionDetails($versionNumber,$updateResult='')
	{
		if($updateResult=='')
		{
			$updateResult='fail';
		}
		
		$this->load->model('dal/time_manager');
		$objTime		= $this->time_manager;	
		$updateDate = $objTime->getGMTTime();
		
		//Checking if version already exist or not
		$query = $this->db->query("SELECT * FROM teeme_system_update WHERE versionNumber='".$versionNumber."'");
		//Checking end
		if($query->num_rows()==0){
		
			$strResultSQL = 'INSERT INTO 
										teeme_system_update
										( 
											versionNumber, updateDate, updateResult , notify
										)
									VALUES
										(
											"'.$versionNumber.'","'.$updateDate.'","'.$updateResult.'","0"
										)';
								
			$updateResult = $this->db->query($strResultSQL);
			 
		}
		else
		{
			$updateResult = $this->db->query("UPDATE teeme_system_update SET `updateDate`='".$updateDate."',`updateResult`='".$updateResult."',`notify`='0' WHERE versionNumber='".$versionNumber."'");
		}
		
		if($updateResult)
		{    
			return true;
		}		
		else
		{
			return false;
		}
	}
	
	//Manoj: when user select No install update for instance
	
	function insertNoVersionDetails($versionNumber,$updateResult='')
	{
		$this->load->model('dal/time_manager');
		$objTime		= $this->time_manager;	
		$updateDate = $objTime->getGMTTime();
		
		//Checking if version already exist or not
		$query = $this->db->query("SELECT versionNumber FROM teeme_system_update WHERE versionNumber='".$versionNumber."'");
		
		if($query->num_rows()==0){
			$strResultSQL = 'INSERT INTO 
									teeme_system_update
									( 
										versionNumber, updateDate, updateResult
									)
								VALUES
									(
										"'.$versionNumber.'","'.$updateDate.'","'.$updateResult.'"
									)';
							
		$updateResult = $this->db->query($strResultSQL);
		 
		if($updateResult)
		{    
			return true;
		}		
		else
		{
			return false;
		}
		}
		
		
	}
	
	function getVersionHistory()
	{
		$getVersionDetails = 'SELECT versionNumber, updateDate, updateResult, notify_date, notify FROM teeme_system_update ORDER BY id DESC';
		$query = $this->db->query($getVersionDetails);
		
		if($query->num_rows()> 0)
		{
			$i = 0;	
		
			foreach($query->result() as $row)
			{
				
				$versionDetails[$i]['versionNumber'] 	= $row->versionNumber;
				$versionDetails[$i]['updateDate'] 	= $row->updateDate;
				$versionDetails[$i]['updateResult'] = $row->updateResult;
				$versionDetails[$i]['notify_date'] = $row->notify_date;
				$versionDetails[$i]['notify'] = $row->notify;
				$i++;
			}	
		}	
	
		
		if($query)
		{
			return $versionDetails;
		}
		else
		{
			return false;
		}
	}
	
	//Manoj: code end for update version  
	
	//Manoj: code for user notification of install update
	
	function insertUpdateNotification($versionNumber,$updateResult,$notify_datetime,$notifyResult)
	{
		
		$this->load->model('dal/time_manager');
		$objTime		= $this->time_manager;	
		$updateDate = $objTime->getGMTTime();
		
		$query = $this->db->query("SELECT id FROM teeme_system_update WHERE versionNumber='".$versionNumber."'");
		
		if($query->num_rows()> 0){
			
			$notifyResultSQL = 'UPDATE teeme_system_update SET `updateDate`= "'.$updateDate.'",`notify_date`="'.$notify_datetime.'",`notify`="'.$notifyResult.'" WHERE versionNumber="'.$versionNumber.'"';
		
		}
		else
		{
			$notifyResultSQL = 'INSERT INTO 
									teeme_system_update
									( 
										versionNumber, updateDate, updateResult, notify_date , notify
									)
								VALUES
									(
										"'.$versionNumber.'","'.$updateDate.'","'.$updateResult.'","'.$notify_datetime.'","'.$notifyResult.'"
									)';
							
			
		}
		$updateResult = $this->db->query($notifyResultSQL);
		
		if($updateResult)
		{    
			return true;
		}		
		else
		{
			return false;
		}
	}
	//Manoj: code end for update notify
	
	//Manoj: get install update status for notify users 	
	function getUpdateStatus()
	{
		$this->load->model('dal/time_manager');
		$currentDate = $this->time_manager->getGMTtime();
			
		//Get database details
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
			
		//return $instancedb;	
		if($instancedb)
		{
				$getUpdateDetails = 'SELECT notify_date, notify FROM teeme_system_update WHERE notify="1" AND updateResult="downloaded" AND notify_date > "'.$currentDate.'" ORDER BY id DESC LIMIT 1';
				//return $getUpdateDetails;
				$query = $instancedb->query($getUpdateDetails);
				if($query)
				{
					if($query->num_rows()> 0)
					{
						foreach($query->result() as $row)
						{
							$updateDetail['notify_date'] 	= $row->notify_date;
							$updateDetail['notify'] 	= $row->notify;
						}	
						return $updateDetail;
					}
				}
				else
				{
					return false;
				}
		}
		else
		{
			return false;
		}
		
	}
	//Manoj: code end
	
	//Manoj: For cancel notification of install update
	function cancelUpdateNotification($versionNumber)
	{
		$strResultSQL = 'UPDATE teeme_system_update SET `notify`="0" WHERE versionNumber="'.$versionNumber.'"';
							
		$updateCancelResult = $this->db->query($strResultSQL);
		 
		if($updateCancelResult)
		{    
			return true;
		}		
		else
		{
			return false;
		}
	}
	//Manoj: code end
	
	//Manoj: code for add maintenance mode
	function add_maintenance_mode($mode_val)
	{
		$query = $this->db->query('SELECT id FROM teeme_config WHERE config_option="offline"');
		if($query->num_rows()> 0){
			$q = $this->db->query("UPDATE teeme_config SET `config_option`='offline',`config_value`='".$mode_val."' WHERE config_option='offline'");
		}
		else{
			$q = $this->db->query("INSERT INTO teeme_config(`config_option`,`config_value`) VALUES('offline','".$mode_val."')");
		}
		if($q){
			return 1;
		}
		else{
			return 0;
		}
	}
	//Manoj: code end for add mode
	
	//Manoj: code for get maintenance mode
	
	function get_maintenance_mode()
	{
		//Get database details
		$config['hostname'] = base64_decode($this->config->item('hostname'));
		$config['username'] = base64_decode($this->config->item('username'));
		$config['password'] = base64_decode($this->config->item('password'));
		$config['database'] = $this->config->item('instanceDb');
		$config['dbdriver'] = $this->db->dbdriver;
		$config['dbprefix'] = $this->db->dbprefix;
		$config['pconnect'] = FALSE;
		$config['db_debug'] = $this->db->db_debug;
		$config['cache_on'] = $this->db->cache_on;
		$config['cachedir'] = $this->db->cachedir;
		$config['char_set'] = $this->db->char_set;
		$config['dbcollat'] = $this->db->dbcollat;
		
		$instancedb = $this->load->database($config,TRUE);
	
		$getModeDetails = 'SELECT config_value FROM teeme_config WHERE config_option="offline"';
		
		$query = $instancedb->query($getModeDetails);
		
		if($query)
		{
			if($query->num_rows()== 1)
			{
				foreach($query->result() as $row)
				{
					$modeDetail	= $row->config_value;
				}	
				return $modeDetail;
			}
			else
			{
				return 'false';
			}	
			
		}
		else
		{
			return false;
		}
	}
	//Manoj: code end for get mode
	
	//Manoj: code for adding ftp details for instance backup
	
	function AddRemoteServerDetails($ftpDetailsArray)
	{
		
		$query = $this->db->query('SELECT id FROM teeme_config WHERE config_option="remoteServer"');
		if($query->num_rows()> 0){
			$q = $this->db->query("UPDATE teeme_config SET `config_option`='remoteServer',`config_value`='".$ftpDetailsArray."' WHERE config_option='remoteServer'");
		}
		else{
			$q = $this->db->query("INSERT INTO teeme_config(`config_option`,`config_value`) VALUES('remoteServer','".$ftpDetailsArray."')");
		}
		if($q){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	//Manoj: code end
	
	//Manoj: code for getting ftp details for instance backup
	
	function GetRemoteServerDetails($place='')
	{
		if($place=='place')
		{
			$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb');
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
		
			$instancedb = $this->load->database($config,TRUE);
			$query = $instancedb->query('SELECT config_value FROM teeme_config WHERE config_option="remoteServer"');	
		}
		else
		{
			$query = $this->db->query('SELECT config_value FROM teeme_config WHERE config_option="remoteServer"');	
		}
		$remoteFtpDetails = array();			
		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$remoteFtpDetails['config_value'] 	= unserialize($row->config_value);
			}	
		}	
		return $remoteFtpDetails;
	}
	
	//Manoj: code end
	
	//Manoj: code for adding ftp details for instance backup
	
	function AddBackupChecksDetails($backupChecksDetailsArray)
	{
		
		$query = $this->db->query('SELECT id FROM teeme_config WHERE config_option="backupChecksStatus"');
		if($query->num_rows()> 0){
			$q = $this->db->query("UPDATE teeme_config SET `config_option`='backupChecksStatus',`config_value`='".$backupChecksDetailsArray."' WHERE config_option='backupChecksStatus'");
		}
		else{
			$q = $this->db->query("INSERT INTO teeme_config(`config_option`,`config_value`) VALUES('backupChecksStatus','".$backupChecksDetailsArray."')");
		}
		if($q){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	//Manoj: code end
	
	//Manoj: code for getting ftp details for instance backup
	
	function GetBackupChecksDetails($place='')
	{
		if($place=='place')
		{
			$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb');
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
		
			$instancedb = $this->load->database($config,TRUE);
			$query = $instancedb->query('SELECT config_value FROM teeme_config WHERE config_option="backupChecksStatus"');	
		}
		else
		{
			$query = $this->db->query('SELECT config_value FROM teeme_config WHERE config_option="backupChecksStatus"');	
		}
		$remoteFtpDetails = array();			
		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$remoteFtpDetails['config_value'] 	= unserialize($row->config_value);
			}	
		}	
		return $remoteFtpDetails;
	}
	
	//Manoj: code end
	
	//Manoj: get all active users for place
	public function getWorkPlaceUsersByWorkPlaceId($workPlaceId)
    { 
		$userData = array();
		$query = $this->db->query('SELECT * FROM teeme_users WHERE workPlaceId='.$workPlaceId.' AND status = 0 ORDER BY firstName ASC');
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				$userData[$i]['userId'] = $row->userId;	
				$i++;										
			}				
		}					
		return $userData;				
	}
	//Manoj: code end 
	
	//Manoj: code for create memcache object
	function createMemcacheObject()
	{
		$objMemCache = new Memcached;
		$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));
		//echo count($objMemCache->getServerList()).'test'; exit;
		return $objMemCache;
	}
	//Manoj: code end
	
	
	/*Timeline post start*/
	
	public function getRecentTagsTimeline( $workSpaceId, $workSpaceType,$count=false,$start=0,$limit=25 )
	{
		$arrTagDetails=array();
	
					
		
		$i = 0;	

		 
				//for simple tag 
				
				$q  = 'SELECT * from (SELECT y.tagType as tagComment,a.* FROM teeme_node as t, teeme_tag as a LEFT JOIN teeme_tag_types as y ON a.tag=y.tagTypeId WHERE (a.artifactType=1 OR a.artifactType=2) AND (a.tagType = 2 AND t.workSpaceId='.$workSpaceId.'  AND t.workSpaceType='.$workSpaceType.')  AND t.treeIds=0 ORDER BY a.createdDate desc ) t GROUP BY tagComment ';
	
				//echo $q; exit;
							
			    $query = $this->db->query($q);
				//echo $q; exit;
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;
							
							$arrTagDetails[$i]['tagComment'] 	= $tagData->tagComment;
								
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}	
				
				 //response tag for leaf
			$q  = 'select * from (SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.artifactType=2 AND a.tagType = 3 AND a.tagId = b.tagId AND b.status = 1 AND d.treeIds=0 AND a.artifactId = d.id AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.' order by createdDate desc ) t group by comments';
	
								
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails[$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}		
		
		
		//response tag for seed
		  $q  = 'select * from(SELECT a.* FROM teeme_tag as a LEFT JOIN teeme_tree as t ON a.artifactId=t.id  where a.artifactType=1 AND a.tagType = 3 AND  t.workspaces='.$workSpaceId.'  AND workSpaceType='.$workSpaceType.' order by createdDate desc ) t group by comments  ';
			
				
							
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;
							
							$arrTagDetails[$i]['tagComment'] 	= $tagData->comments;
								
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}	
		
			// for contact tags
			if($workSpaceId == 0)
			{
					$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
			}
			else
			{
					$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
			}
		
			 
			  $q = 'select * from(SELECT a.*, b.name as contactName FROM teeme_tag a, teeme_tree b WHERE '.$where.' AND a.tagType = 5 AND a.tag = b.id order by createdDate desc ) t group by contactName';
						//echo $q; exit;
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails[$i]['tagComment'] 	= $tagData->contactName;
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}
		
				
		
		if($count==true)
			{ 
			    $countResult=count($arrTagDetails);
				
				if($countResult)
				{   
					return $countResult;
				}
				 else
				    return 0;
			  
			}
		
		//Sorting array by diffrence 
			foreach ($arrTagDetails as $key => $row)
			{
				$diff[$key]  = $row['createdDate'];
            }

			
	     	array_multisort($diff,SORT_DESC,$arrTagDetails);
		
			$main_array=array();
			
		
			for($i=$start;$i<$start+25;$i++)
			{ 
			    if($arrTagDetails[$i])
				{
			   	 array_push($main_array,$arrTagDetails[$i]);
				} 
			}	
			
			return $main_array;
	}
	
	/*Timeline post end*/
	
	
	
	
	//Timeline post code start 
	
	
	public function getNodeCountByTagTimeline ( $workSpaceId, $workSpaceType, $tagType=0, $tagComment=0, $applied=0, $due =0, $list = '', $users =0 ,$tag=0,$artifactType=2 )
	{
		$arrTagDetails = array();	
		
		$users = implode (',',$users);
		$i = 0;	

		if($tagType == 2) // Simple Tags
		{	
		 	$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a,teeme_tag_types b WHERE a.tag='".$tag."' AND a.tag = b.tagTypeId AND b.workPlaceId='".$_SESSION['workPlaceId']."'";
			$qry1Result = $this->db->query($qry1);
			
				if($qry1Result->num_rows() > 0)
				{
					$count=0;
					foreach ($qry1Result->result() as $result)
					{
						if ($result->artifactType==2)
						{
							// Leaf Tags
							
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.id as treeId,c.type as treeType, e.contents as leafContents,d.predecessor FROM teeme_tag a, teeme_tag_types b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
						}
						else
						{ 
							// Seed Tags 
			
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.name as leafContents FROM teeme_tag a, teeme_tag_types b, teeme_tree c WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2  AND a.artifactId = c.id  AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
						}
						
						if ($applied != 0)
						{
							$daysAgo = "-" .$applied ." days";
						
							$daysAgo = strtotime ($daysAgo);
					
							$daysAgo = date("Y-m-d",$daysAgo);	
						
							$daysAgo .= " 00:00:00";
						
							$q .= " AND a.createdDate >= '".$daysAgo."'";
						}			
						if ($list != 0)
						{
							if ($list == 'desc')
							{
								$q .= ' ORDER BY b.tagType DESC';
							}
							else if ($list == 'asc')
							{
								$q .= ' ORDER BY b.tagType ASC';
							}
							else
							{
								$q .= ' ORDER BY a.createdDate DESC';
							}
						}
							
					$query = $this->db->query($q);
					//echo $q; exit;
						if ($query->num_rows()>0)
						{
							$count++;
						}
					}
				}	
				return $count;
		}
		
		if($tagType == 3) // Response Tags
		{
				if ($users != '')
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";					
					$qry1Result = $this->db->query($qry1);
					
					if($qry1Result->num_rows() > 0)
					{
						$count=0;
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								// Leaf Tags
								$q  = 'SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, e.contents as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
							}
							else
							{
								// Tree Tags
								$q  = 'SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = c.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND d.workSpaceId='.$workSpaceId.' AND d.	workSpaceType='.$workSpaceType.'';
							}
				
							if ($responseTagType != '')
							{
								$q .= ' AND a.tag IN ('.$responseTagType.')';
							}			
				
							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}					
							if ($users != '')
							{
								$q .= ' AND b.userId IN ('.$users.')';
							}					
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
							$query = $this->db->query($q);
								if ($query->num_rows()>0)
								{
									$count++;
									//echo "here"; exit;
								}				

						}
						return $count;
					}
				}
				else
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";
					$qry1Result = $this->db->query($qry1);
					//echo $qry1; exit;

					if($qry1Result->num_rows() > 0)
					{
						$count =0;
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								$q  = "SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, e.contents as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND d.workSpaceId='".$workSpaceId."' AND d.workSpaceType='".$workSpaceType."'";
							}
							else
							{
								$q  = "SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = c.id AND d.id = e.nodeId AND d.workSpaceId='".$workSpaceId."' AND d.workSpaceType='".$workSpaceType."'";
							}

							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}									
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
	
						$query = $this->db->query($q);
								if ($query->num_rows()>0)
								{
									$count++;
									//echo "here"; exit;
								}						
					}
					return $count;
				}
			}	
		}

		if($tagType == 5) // Contact Tags
		{
			
			$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.tag='".$tag."' AND a.tagType=5";
			$qry1Result = $this->db->query($qry1);
			if($qry1Result->num_rows() > 0)
			{
				$count=0;
				foreach ($qry1Result->result() as $result)
				{
					if($workSpaceId == 0)
					{
						$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
					}
					else
					{
						$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
					}
					if ($result->artifactType==2)
					{	
						// Leaf Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId, d.contents as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE '.$where.' AND a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND a.artifactId = c.id AND c.leafId = d.id';
					}
					else
					{
						// Tree Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId, b.name as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE '.$where.' AND a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND b.id = c.treeIds AND a.artifactId = b.id AND c.leafId = d.id';
			
					}	
					if ($applied != 0)
					{
						$daysAgo = "-" .$applied ." days";
					
						$daysAgo = strtotime ($daysAgo);
				
						$daysAgo = date("Y-m-d",$daysAgo);	
					
						$daysAgo .= " 00:00:00";
					
						$q .= " AND a.createdDate >= '".$daysAgo."'";
					}			
					if ($list != 0)
					{
						if ($list == 'desc')
						{
							$q .= ' ORDER BY b.name DESC';
						}
						else if ($list == 'asc')
						{
							$q .= ' ORDER BY b.name ASC';
						}
						else
						{
							$q .= ' ORDER BY a.createdDate DESC';
						}
					}				
					$query = $this->db->query($q);
								if ($query->num_rows()>0)
								{
									$count++;
									//echo "here"; exit;
								}	
				}
				return $count;
			}
		}

		
		
	}
	
	//Timeline post code end
	
	//Timeline post start
	public function getNodesByTagSearchOptionsTimeline ( $workSpaceId, $workSpaceType, $tagType=0, $tagComment=0, $applied=0, $due =0, $list = '', $users =0 ,$tag=0,$artifactType=2 )
	{
		$arrTagDetails = array();	
		
		$users = implode (',',$users);
		$i = 0;	

		if($tagType == 2) // Simple Tags
		{	
		 	$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a,teeme_tag_types b WHERE a.tag='".$tag."' AND a.tag = b.tagTypeId AND b.workPlaceId='".$_SESSION['workPlaceId']."'";
			$qry1Result = $this->db->query($qry1);
			//echo "<li>".$qry1;
			
				if($qry1Result->num_rows() > 0)
				{
					foreach ($qry1Result->result() as $result)
					{
						if ($result->artifactType==2)
						{
							// Leaf Tags
							
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, e.contents as leafContents,d.predecessor FROM teeme_tag a, teeme_tag_types b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
						}
						else
						{ 
							// Seed Tags 
			
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tag_types b, teeme_tree c WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2  AND a.artifactId = c.id  AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
						}
						
						if ($applied != 0)
						{
							$daysAgo = "-" .$applied ." days";
						
							$daysAgo = strtotime ($daysAgo);
					
							$daysAgo = date("Y-m-d",$daysAgo);	
						
							$daysAgo .= " 00:00:00";
						
							$q .= " AND a.createdDate >= '".$daysAgo."'";
						}			
						if ($list != 0)
						{
							if ($list == 'desc')
							{
								$q .= ' ORDER BY b.tagType DESC';
							}
							else if ($list == 'asc')
							{
								$q .= ' ORDER BY b.tagType ASC';
							}
							else
							{
								$q .= ' ORDER BY a.createdDate DESC';
							}
						}
							
					$query = $this->db->query($q);
					
					//echo "<li>" .$query->num_rows() ."<hr>";
					//echo "<li>count= " .$query->num_rows();
						if($query->num_rows() > 0)
						{
							//echo "<li>here1";
							foreach ($query->result() as $tagData)
							{
								$arrTagDetails['simple'][$i]['treeId'] 			= $tagData->treeId;	
								$arrTagDetails['simple'][$i]['treeType'] 		= $tagData->treeType;	
								$arrTagDetails['simple'][$i]['contents'] 		= $tagData->leafContents;	
								$arrTagDetails['simple'][$i]['tagId'] 			= $tagData->tagId;	
								$arrTagDetails['simple'][$i]['tagType'] 		= $tagData->tagType;	
								$arrTagDetails['simple'][$i]['tag'] 			= $tagData->tag;	
								$arrTagDetails['simple'][$i]['ownerId'] 		= $tagData->ownerId;
								$arrTagDetails['simple'][$i]['tagComment'] 		= $tagData->tagName;
								$arrTagDetails['simple'][$i]['predecessor'] 	= $tagData->predecessor;
								$arrTagDetails['simple'][$i]['artifactId'] 		= $tagData->artifactId;
								$arrTagDetails['simple'][$i]['artifactType'] 	= $tagData->artifactType;	
								$arrTagDetails['simple'][$i]['createdDate'] 	= $tagData->createdDate;	
								$arrTagDetails['simple'][$i]['startTime'] 		= $tagData->startTime;	
								$arrTagDetails['simple'][$i]['endTime'] 		= $tagData->endTime;	
								$i++;	
							}
						}	
					}
				}	
		}

		if($tagType == 3) // Response Tags
		{
				if ($users != '')
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";					
					$qry1Result = $this->db->query($qry1);
					
					if($qry1Result->num_rows() > 0)
					{
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								// Leaf Tags
								$q  = 'SELECT DISTINCT a.*, e.contents as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
							}
							else
							{
								// Tree Tags
								$q  = 'SELECT DISTINCT a.*, c.name as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = c.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
							}
				
							if ($responseTagType != '')
							{
								$q .= ' AND a.tag IN ('.$responseTagType.')';
							}			
				
							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}					
							if ($users != '')
							{
								$q .= ' AND b.userId IN ('.$users.')';
							}					
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
					$query = $this->db->query($q);

					if($query->num_rows() > 0)
						{
							foreach ($query->result() as $tagData)
							{
							$arrTagDetails['response'][$i]['treeId'] 		= $tagData->treeId;	
							$arrTagDetails['response'][$i]['treeType'] 		= $tagData->treeType;	
							$arrTagDetails['response'][$i]['contents'] 		= $tagData->leafContents;							
						
							$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails['response'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['response'][$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['response'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
							}
							}
						}
					}
				}
				else
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";
					$qry1Result = $this->db->query($qry1);

					if($qry1Result->num_rows() > 0)
					{
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								$q  = "SELECT DISTINCT a.*, e.contents as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND d.workSpaceId='".$workSpaceId."' AND d.workSpaceType='".$workSpaceType."'";
							}
							else
							{
								$q  = "SELECT DISTINCT a.*, c.name as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = c.id AND d.id = e.nodeId AND d.workSpaceId='".$workSpaceId."' AND d.workSpaceType='".$workSpaceType."'";
							}

							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}									
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
	
						$query = $this->db->query($q);

						if($query->num_rows() > 0)
						{
							foreach ($query->result() as $tagData)
							{
							$arrTagDetails['response'][$i]['treeId'] 		= $tagData->treeId;	
							$arrTagDetails['response'][$i]['treeType'] 		= $tagData->treeType;	
							$arrTagDetails['response'][$i]['contents'] 		= $tagData->leafContents;							
						
							$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails['response'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['response'][$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['response'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
							}
						}	
					}
				}
			}	
		}

		if($tagType == 5) // Contact Tags
		{
			
			$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.tag='".$tag."' AND a.tagType=5";
			$qry1Result = $this->db->query($qry1);
			if($qry1Result->num_rows() > 0)
			{
				foreach ($qry1Result->result() as $result)
				{
					if($workSpaceId == 0)
					{
						$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
					}
					else
					{
						$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
					}
					if ($result->artifactType==2)
					{	
						// Leaf Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId, d.contents as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tag =b.id AND a.tagType = 5 AND c.treeIds = 0 AND a.artifactId = c.id AND c.leafId = d.id';
					}
					else
					{
						// Tree Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId, b.name as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND a.artifactId = b.id AND c.leafId = d.id';
			
					}	
					//echo $q; exit;
					if ($applied != 0)
					{
						$daysAgo = "-" .$applied ." days";
					
						$daysAgo = strtotime ($daysAgo);
				
						$daysAgo = date("Y-m-d",$daysAgo);	
					
						$daysAgo .= " 00:00:00";
					
						$q .= " AND a.createdDate >= '".$daysAgo."'";
					}			
					if ($list != 0)
					{
						if ($list == 'desc')
						{
							$q .= ' ORDER BY b.name DESC';
						}
						else if ($list == 'asc')
						{
							$q .= ' ORDER BY b.name ASC';
						}
						else
						{
							$q .= ' ORDER BY a.createdDate DESC';
						}
					}				
				$query = $this->db->query($q);
					if($query->num_rows() > 0)
					{
						foreach ($query->result() as $tagData)
						{
							
							$arrTagDetails['contact'][$i]['treeId'] 		= $tagData->treeId;	
							$arrTagDetails['contact'][$i]['treeType'] 		= $tagData->treeType;	
							$arrTagDetails['contact'][$i]['contents'] 		= $tagData->leafContents;						
						
							$arrTagDetails['contact'][$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails['contact'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['contact'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['contact'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['contact'][$i]['tagComment'] 	= $tagData->contactName;
							$arrTagDetails['contact'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['contact'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['contact'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['contact'][$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails['contact'][$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
					}		
				}
			}
		}
		
		return $arrTagDetails;
	}	
	
	//Timeline post end
	
	//Timeline post PUBLIC start here
	
	/*Timeline post start*/
	
	public function getRecentTagsTimelinePublic( $workSpaceId, $workSpaceType,$count=false,$start=0,$limit=25 )
	{
		$arrTagDetails=array();
	
					
		
		$i = 0;	

		 
				//for simple tag 
				
				$q  = 'SELECT * from (SELECT y.tagType as tagComment,a.* FROM teeme_node as t, teeme_tag as a LEFT JOIN teeme_tag_types as y ON a.tag=y.tagTypeId WHERE (a.artifactType=1 OR a.artifactType=2) AND (a.tagType = 2 AND t.workSpaceId='.$workSpaceId.'  AND t.workSpaceType='.$workSpaceType.')  AND t.treeIds=0 ORDER BY a.createdDate desc ) t GROUP BY tagComment ';
	
				//echo $q; exit;
							
			    $query = $this->db->query($q);
				//echo $q; exit;
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;
							
							$arrTagDetails[$i]['tagComment'] 	= $tagData->tagComment;
								
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}	
				
				 //response tag for leaf
			$q  = 'select * from (SELECT a.* FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.artifactType=2 AND a.tagType = 3 AND a.tagId = b.tagId AND b.status = 1 AND d.treeIds=0 AND a.artifactId = d.id AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.' order by createdDate desc ) t group by comments';
	
								
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails[$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}		
		
		
		//response tag for seed
		  $q  = 'select * from(SELECT a.* FROM teeme_tag as a LEFT JOIN teeme_tree as t ON a.artifactId=t.id  where a.artifactType=1 AND a.tagType = 3 AND  t.workspaces='.$workSpaceId.'  AND workSpaceType='.$workSpaceType.' order by createdDate desc ) t group by comments  ';
			
				
							
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;
							
							$arrTagDetails[$i]['tagComment'] 	= $tagData->comments;
								
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;	
							$i++;	
						}
				}	
		
			// for contact tags
			if($workSpaceId == 0)
			{
					$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
			}
			else
			{
					$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
			}
		
			 
			  $q = 'select * from(SELECT a.*, b.name as contactName, d.workSpaceType as workSpaceType, d.workSpaceId as workSpaceId FROM teeme_tag a, teeme_tree b, teeme_node d WHERE '.$where.' AND a.tagType = 5 AND d.treeIds=0 AND a.artifactId = d.id AND a.tag = b.id order by createdDate desc ) t group by contactName';
						//echo $q; exit;
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails[$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails[$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails[$i]['tagComment'] 	= $tagData->contactName;
							$arrTagDetails[$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails[$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails[$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails[$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails[$i]['endTime'] 		= $tagData->endTime;
							$arrTagDetails[$i]['workSpaceType'] 		= $tagData->workSpaceType;
							$arrTagDetails[$i]['workSpaceId'] 		= $tagData->workSpaceId;	
							$i++;	
						}
				}
		
				
		
		if($count==true)
			{ 
			    $countResult=count($arrTagDetails);
				
				if($countResult)
				{   
					return $countResult;
				}
				 else
				    return 0;
			  
			}
		
		//Sorting array by diffrence 
			foreach ($arrTagDetails as $key => $row)
			{
				$diff[$key]  = $row['createdDate'];
            }

			
	     	array_multisort($diff,SORT_DESC,$arrTagDetails);
		
			$main_array=array();
			
		
			for($i=$start;$i<$start+25;$i++)
			{ 
			    if($arrTagDetails[$i])
				{
			   	 array_push($main_array,$arrTagDetails[$i]);
				} 
			}	
			
			return $main_array;
	}
	
	/*Timeline post end*/
	
	
	
	
	//Timeline post code start 
	
	
	public function getNodeCountByTagTimelinePublic ( $workSpaceId, $workSpaceType, $tagType=0, $tagComment=0, $applied=0, $due =0, $list = '', $users =0 ,$tag=0,$artifactType=2 )
	{
		$arrTagDetails = array();	
		
		$users = implode (',',$users);
		$i = 0;	

		if($tagType == 2) // Simple Tags
		{	
		 	$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a,teeme_tag_types b WHERE a.tag='".$tag."' AND a.tag = b.tagTypeId AND b.workPlaceId='".$_SESSION['workPlaceId']."'";
			$qry1Result = $this->db->query($qry1);
			
				if($qry1Result->num_rows() > 0)
				{
					$count=0;
					foreach ($qry1Result->result() as $result)
					{
						if ($result->artifactType==2)
						{
							// Leaf Tags
							
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.id as treeId,c.type as treeType, e.contents as leafContents,d.predecessor FROM teeme_tag a, teeme_tag_types b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
						}
						else
						{ 
							// Seed Tags 
			
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.name as leafContents FROM teeme_tag a, teeme_tag_types b, teeme_tree c WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2  AND a.artifactId = c.id  AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
						}
						
						if ($applied != 0)
						{
							$daysAgo = "-" .$applied ." days";
						
							$daysAgo = strtotime ($daysAgo);
					
							$daysAgo = date("Y-m-d",$daysAgo);	
						
							$daysAgo .= " 00:00:00";
						
							$q .= " AND a.createdDate >= '".$daysAgo."'";
						}			
						if ($list != 0)
						{
							if ($list == 'desc')
							{
								$q .= ' ORDER BY b.tagType DESC';
							}
							else if ($list == 'asc')
							{
								$q .= ' ORDER BY b.tagType ASC';
							}
							else
							{
								$q .= ' ORDER BY a.createdDate DESC';
							}
						}
							
					$query = $this->db->query($q);
					//echo $q; exit;
						if ($query->num_rows()>0)
						{
							$count++;
						}
					}
				}	
				return $count;
		}
		
		if($tagType == 3) // Response Tags
		{
				if ($users != '')
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";					
					$qry1Result = $this->db->query($qry1);
					
					if($qry1Result->num_rows() > 0)
					{
						$count=0;
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								// Leaf Tags
								$q  = 'SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, e.contents as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
							}
							else
							{
								// Tree Tags
								$q  = 'SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND c.id = d.treeIds AND a.artifactId = c.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND d.workSpaceId='.$workSpaceId.' AND d.	workSpaceType='.$workSpaceType.'';
							}
				
							if ($responseTagType != '')
							{
								$q .= ' AND a.tag IN ('.$responseTagType.')';
							}			
				
							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}					
							if ($users != '')
							{
								$q .= ' AND b.userId IN ('.$users.')';
							}					
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
							$query = $this->db->query($q);
								if ($query->num_rows()>0)
								{
									$count++;
									//echo "here"; exit;
								}				

						}
						return $count;
					}
				}
				else
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";
					$qry1Result = $this->db->query($qry1);
					//echo $qry1; exit;

					if($qry1Result->num_rows() > 0)
					{
						$count =0;
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								$q  = "SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, e.contents as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND d.workSpaceId='".$workSpaceId."' AND d.workSpaceType='".$workSpaceType."'";
							}
							else
							{
								$q  = "SELECT DISTINCT a.*, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = c.id AND d.id = e.nodeId AND d.workSpaceId='".$workSpaceId."' AND d.workSpaceType='".$workSpaceType."'";
							}

							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}									
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
	
						$query = $this->db->query($q);
								if ($query->num_rows()>0)
								{
									$count++;
									//echo "here"; exit;
								}						
					}
					return $count;
				}
			}	
		}

		if($tagType == 5) // Contact Tags
		{
			
			$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.tag='".$tag."' AND a.tagType=5";
			$qry1Result = $this->db->query($qry1);
			if($qry1Result->num_rows() > 0)
			{
				$count=0;
				foreach ($qry1Result->result() as $result)
				{
					if($workSpaceId == 0)
					{
						$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
					}
					else
					{
						$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
					}
					if ($result->artifactType==2)
					{	
						// Leaf Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId, d.contents as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE '.$where.' AND a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND a.artifactId = c.id AND c.leafId = d.id';
					}
					else
					{
						// Tree Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, b.id as treeId, b.name as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE '.$where.' AND a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND b.id = c.treeIds AND a.artifactId = b.id AND c.leafId = d.id';
			
					}	
					if ($applied != 0)
					{
						$daysAgo = "-" .$applied ." days";
					
						$daysAgo = strtotime ($daysAgo);
				
						$daysAgo = date("Y-m-d",$daysAgo);	
					
						$daysAgo .= " 00:00:00";
					
						$q .= " AND a.createdDate >= '".$daysAgo."'";
					}			
					if ($list != 0)
					{
						if ($list == 'desc')
						{
							$q .= ' ORDER BY b.name DESC';
						}
						else if ($list == 'asc')
						{
							$q .= ' ORDER BY b.name ASC';
						}
						else
						{
							$q .= ' ORDER BY a.createdDate DESC';
						}
					}				
					$query = $this->db->query($q);
								if ($query->num_rows()>0)
								{
									$count++;
									//echo "here"; exit;
								}	
				}
				return $count;
			}
		}

		
		
	}
	
	//Timeline post code end
	
	//Timeline post start
	public function getNodesByTagSearchOptionsTimelinePublic ( $workSpaceId, $workSpaceType, $tagType=0, $tagComment=0, $applied=0, $due =0, $list = '', $users =0 ,$tag=0,$artifactType=2 )
	{
		$arrTagDetails = array();	
		
		$users = implode (',',$users);
		$i = 0;	

		if($tagType == 2) // Simple Tags
		{	
		 	$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a,teeme_tag_types b WHERE a.tag='".$tag."' AND a.tag = b.tagTypeId AND b.workPlaceId='".$_SESSION['workPlaceId']."'";
			$qry1Result = $this->db->query($qry1);
			//echo "<li>".$qry1;
			
				if($qry1Result->num_rows() > 0)
				{
					foreach ($qry1Result->result() as $result)
					{
						if ($result->artifactType==2)
						{
							// Leaf Tags
							
							$q  = 'SELECT DISTINCT a.*,d.workSpaceType as workSpaceType, b.tagType as tagName, e.contents as leafContents,d.predecessor FROM teeme_tag a, teeme_tag_types b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
						}
						else
						{ 
							// Seed Tags 
			
							$q  = 'SELECT DISTINCT a.*, b.tagType as tagName, c.id as treeId,c.type as treeType, c.name as leafContents FROM teeme_tag a, teeme_tag_types b, teeme_tree c WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag='.$tag.' AND a.tagType = 2  AND a.artifactId = c.id  AND a.tag = b.tagTypeId AND b.workPlaceId = '.$_SESSION['workPlaceId'].' AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.'';
						}
						
						if ($applied != 0)
						{
							$daysAgo = "-" .$applied ." days";
						
							$daysAgo = strtotime ($daysAgo);
					
							$daysAgo = date("Y-m-d",$daysAgo);	
						
							$daysAgo .= " 00:00:00";
						
							$q .= " AND a.createdDate >= '".$daysAgo."'";
						}			
						if ($list != 0)
						{
							if ($list == 'desc')
							{
								$q .= ' ORDER BY b.tagType DESC';
							}
							else if ($list == 'asc')
							{
								$q .= ' ORDER BY b.tagType ASC';
							}
							else
							{
								$q .= ' ORDER BY a.createdDate DESC';
							}
						}
							
					$query = $this->db->query($q);
					
					//echo "<li>" .$query->num_rows() ."<hr>";
					//echo "<li>count= " .$query->num_rows();
						if($query->num_rows() > 0)
						{
							//echo "<li>here1";
							foreach ($query->result() as $tagData)
							{
								$arrTagDetails['simple'][$i]['treeId'] 			= $tagData->treeId;	
								$arrTagDetails['simple'][$i]['treeType'] 		= $tagData->treeType;	
								$arrTagDetails['simple'][$i]['contents'] 		= $tagData->leafContents;	
								$arrTagDetails['simple'][$i]['tagId'] 			= $tagData->tagId;	
								$arrTagDetails['simple'][$i]['tagType'] 		= $tagData->tagType;	
								$arrTagDetails['simple'][$i]['tag'] 			= $tagData->tag;	
								$arrTagDetails['simple'][$i]['ownerId'] 		= $tagData->ownerId;
								$arrTagDetails['simple'][$i]['tagComment'] 		= $tagData->tagName;
								$arrTagDetails['simple'][$i]['predecessor'] 	= $tagData->predecessor;
								$arrTagDetails['simple'][$i]['artifactId'] 		= $tagData->artifactId;
								$arrTagDetails['simple'][$i]['artifactType'] 	= $tagData->artifactType;	
								$arrTagDetails['simple'][$i]['createdDate'] 	= $tagData->createdDate;	
								$arrTagDetails['simple'][$i]['startTime'] 		= $tagData->startTime;	
								$arrTagDetails['simple'][$i]['endTime'] 		= $tagData->endTime;	
								$arrTagDetails['simple'][$i]['workSpaceType'] 		= $tagData->workSpaceType;
								$i++;	
							}
						}	
					}
				}	
		}

		if($tagType == 3) // Response Tags
		{
				if ($users != '')
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";					
					$qry1Result = $this->db->query($qry1);
					
					if($qry1Result->num_rows() > 0)
					{
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								// Leaf Tags
								$q  = 'SELECT DISTINCT a.*,d.workSpaceType as workSpaceType, e.contents as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
							}
							else
							{
								// Tree Tags
								$q  = 'SELECT DISTINCT a.*,d.workSpaceType as workSpaceType, c.name as leafContents FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.comments='.$tagComment.' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = c.id AND d.id = e.nodeId AND a.tagId = b.tagId AND b.status = 1 AND d.workSpaceId='.$workSpaceId.' AND d.workSpaceType='.$workSpaceType.'';
							}
				
							if ($responseTagType != '')
							{
								$q .= ' AND a.tag IN ('.$responseTagType.')';
							}			
				
							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}					
							if ($users != '')
							{
								$q .= ' AND b.userId IN ('.$users.')';
							}					
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
					$query = $this->db->query($q);

					if($query->num_rows() > 0)
						{
							foreach ($query->result() as $tagData)
							{
							$arrTagDetails['response'][$i]['treeId'] 		= $tagData->treeId;	
							$arrTagDetails['response'][$i]['treeType'] 		= $tagData->treeType;	
							$arrTagDetails['response'][$i]['contents'] 		= $tagData->leafContents;							
						
							$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails['response'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['response'][$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['response'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;	
							$arrTagDetails['response'][$i]['workSpaceType'] 		= $tagData->workSpaceType;	
							$i++;	
							}
							}
						}
					}
				}
				else
				{
					$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.comments='".$tagComment."'";
					$qry1Result = $this->db->query($qry1);

					if($qry1Result->num_rows() > 0)
					{
						foreach ($qry1Result->result() as $result)
						{
							if ($result->artifactType==2)
							{
								$q  = "SELECT DISTINCT a.*,d.workSpaceType as workSpaceType, e.contents as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=2 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = d.id AND d.id = e.nodeId AND d.workSpaceId='".$workSpaceId."' AND d.workSpaceType='".$workSpaceType."'";
							}
							else
							{
								$q  = "SELECT DISTINCT a.*,d.workSpaceType as workSpaceType, c.name as leafContents FROM teeme_tag a, teeme_tree c, teeme_node d, teeme_leaf e WHERE a.artifactType=1 AND a.tagId='".$result->tagId."' AND a.comments='".$tagComment."' AND a.tagType = 3 AND d.treeIds=0 AND a.artifactId = c.id AND d.id = e.nodeId AND d.workSpaceId='".$workSpaceId."' AND d.workSpaceType='".$workSpaceType."'";
							}

							if ($applied != 0)
							{
								$daysAgo = "-" .$applied ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$q .= " AND a.createdDate >= '".$daysAgo."'";
							}	
				
							if ($due != 0)
							{
								$daysAgo = "+" .$due ." days";
					
								$daysAgo = strtotime ($daysAgo);
				
								$daysAgo = date("Y-m-d",$daysAgo);	
					
								$daysAgo .= " 00:00:00";
					
								$day 	= date('d');
								$month 	= date('m');
								$year	= date('Y');	

								$today = $year."-".$month."-".$day;
					
								$today .= " 00:00:00";
					
								$q .= " AND (a.endTime <= '".$daysAgo."' AND a.endTime >= '".$today."')";
							}									
						
							if ($list != 0)
							{
								if ($list == 'desc')
								{
									$q .= ' ORDER BY a.comments DESC';
								}
								else if ($list == 'asc')
								{
									$q .= ' ORDER BY a.comments ASC';
								}
								else
								{
									$q .= ' ORDER BY a.createdDate DESC';
								}
							}
	
						$query = $this->db->query($q);

						if($query->num_rows() > 0)
						{
							foreach ($query->result() as $tagData)
							{
							$arrTagDetails['response'][$i]['treeId'] 		= $tagData->treeId;	
							$arrTagDetails['response'][$i]['treeType'] 		= $tagData->treeType;	
							$arrTagDetails['response'][$i]['contents'] 		= $tagData->leafContents;							
						
							$arrTagDetails['response'][$i]['tagId'] 		= $tagData->tagId;	
							$arrTagDetails['response'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['response'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['response'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['response'][$i]['tagComment'] 	= $tagData->comments;
							$arrTagDetails['response'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['response'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['response'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['response'][$i]['startTime'] 	= $tagData->startTime;	
							$arrTagDetails['response'][$i]['endTime'] 		= $tagData->endTime;	
							$arrTagDetails['response'][$i]['workSpaceType'] 		= $tagData->workSpaceType;	
							$i++;	
							}
						}	
					}
				}
			}	
		}

		if($tagType == 5) // Contact Tags
		{
			
			$qry1 = "SELECT a.tagId,a.tag,a.artifactType FROM teeme_tag a WHERE a.tag='".$tag."' AND a.tagType=5";
			$qry1Result = $this->db->query($qry1);
			if($qry1Result->num_rows() > 0)
			{
				foreach ($qry1Result->result() as $result)
				{
					if($workSpaceId == 0)
					{
						$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
					}
					else
					{
						$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
					}
					if ($result->artifactType==2)
					{	
						// Leaf Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, c.workSpaceType as workSpaceType, b.id as treeId, d.contents as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE a.artifactType=2 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tag =b.id AND a.tagType = 5 AND c.treeIds = 0 AND a.artifactId = c.id AND c.leafId = d.id';
					}
					else
					{
						// Tree Tags
						$q = 'SELECT DISTINCT a.*, b.name as contactName, c.workSpaceType as workSpaceType, b.id as treeId, b.name as leafContents FROM teeme_tag a, teeme_tree b, teeme_node c, teeme_leaf d WHERE a.artifactType=1 AND a.tagId='.$result->tagId.' AND a.tag ='.$tag.' AND a.tagType = 5 AND a.artifactId = b.id AND c.leafId = d.id';
			
					}	
					//echo $q; exit;
					if ($applied != 0)
					{
						$daysAgo = "-" .$applied ." days";
					
						$daysAgo = strtotime ($daysAgo);
				
						$daysAgo = date("Y-m-d",$daysAgo);	
					
						$daysAgo .= " 00:00:00";
					
						$q .= " AND a.createdDate >= '".$daysAgo."'";
					}			
					if ($list != 0)
					{
						if ($list == 'desc')
						{
							$q .= ' ORDER BY b.name DESC';
						}
						else if ($list == 'asc')
						{
							$q .= ' ORDER BY b.name ASC';
						}
						else
						{
							$q .= ' ORDER BY a.createdDate DESC';
						}
					}				
				$query = $this->db->query($q);
					if($query->num_rows() > 0)
					{
						foreach ($query->result() as $tagData)
						{
							
							$arrTagDetails['contact'][$i]['treeId'] 		= $tagData->treeId;	
							$arrTagDetails['contact'][$i]['treeType'] 		= $tagData->treeType;	
							$arrTagDetails['contact'][$i]['contents'] 		= $tagData->leafContents;						
						
							$arrTagDetails['contact'][$i]['tagId'] 			= $tagData->tagId;	
							$arrTagDetails['contact'][$i]['tagType'] 		= $tagData->tagType;	
							$arrTagDetails['contact'][$i]['tag'] 			= $tagData->tag;	
							$arrTagDetails['contact'][$i]['ownerId'] 		= $tagData->ownerId;
							$arrTagDetails['contact'][$i]['tagComment'] 	= $tagData->contactName;
							$arrTagDetails['contact'][$i]['artifactId'] 	= $tagData->artifactId;
							$arrTagDetails['contact'][$i]['artifactType'] 	= $tagData->artifactType;	
							$arrTagDetails['contact'][$i]['createdDate'] 	= $tagData->createdDate;	
							$arrTagDetails['contact'][$i]['startTime'] 		= $tagData->startTime;	
							$arrTagDetails['contact'][$i]['endTime'] 		= $tagData->endTime;	
							$arrTagDetails['contact'][$i]['workSpaceType'] 		= $tagData->workSpaceType;	
							$i++;	
						}
					}		
				}
			}
		}
		
		return $arrTagDetails;
	}	
	
	//Manoj: code for add post count start
	
	function getTreeCountByTreePost($workSpaceId, $workSpaceType, $treeId=0, $postType='')
	{
		$mergePostArray=array();
		
		if($workSpaceId >= 0)
		{
		
			//Fetch space post count
			
			$result_count1 = $this->db->query("SELECT a.id FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' ORDER BY b.editedDate DESC");
			
			if($postType=='all')
			{
				$result_count1 = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.editedDate DESC");
			}
			
			
			//Fetch public post count
			
			$result_count2 = $this->db->query("SELECT COUNT(a.id) as total FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='0' and a.workSpaceType='0' ORDER BY b.editedDate DESC");
			
			$mergePostArray=array_merge($result_count1->result(),$result_count2->result());
			
			//return $mergePostArray;
					if($postType=='')
					{
						/*if(count($mergePostArray)> 0)
						{
							$total=0;
							foreach($mergePostArray as $row)
							{
								$total+= $row->total;
							}
							if ($total>0)
							{
								return $total;
							}
						}*/	
						$total=0;
						if($result_count1)
						{
							if($result_count1->num_rows() > 0)
							{	
								$spacePostsTotal=0;
								//print_r($result_count1->result());
								foreach($result_count1->result() as $row)
								{
									$members = array();			
									$postQuery = $this->db->query("SELECT members FROM teeme_posts_shared WHERE postId='".$row->id."'");	
										
									if($postQuery->num_rows()> 0)
									{
										foreach($postQuery->result() as $rowData)
										{
											$members = explode (",",$rowData->members);
										}
										
										$groupUsers = array();	
										$groupPostQuery = $this->db->query("SELECT groupUsers FROM teeme_group_shared WHERE postId='".$row->id."'");	
								
										if($groupPostQuery->num_rows()> 0)
										{
											foreach($groupPostQuery->result() as $groupRowData)
											{
												$groupUsers = explode (",",$groupRowData->groupUsers);
											}
										}
										
										$members = array_filter(array_unique(array_merge($members,$groupUsers)));
										
										if(in_array($_SESSION['userId'],$members))
										{
											$spacePostsTotal+= count($row->id);
										}
									}
								}
							}
						}
						if($result_count2)
						{
							if($result_count2->num_rows() > 0)
							{	
								$publicPostsTotal=0;
								foreach($result_count2->result() as $row)
								{	
									$publicPostsTotal+= $row->total;									
								}
							}					
						}
						$total=$spacePostsTotal+$publicPostsTotal;
						if ($total>0)
						{
							return $total;
						}	
						
					}
					else if($postType=='space' || $postType=='all')
					{
						if($result_count1)
						{
							if($result_count1->num_rows() > 0)
							{	
								$total=0;
								//print_r($result_count1->result());
								foreach($result_count1->result() as $row)
								{	
									
									$members = array();			
									$postQuery = $this->db->query("SELECT members FROM teeme_posts_shared WHERE postId='".$row->id."'");	
							
									if($postQuery->num_rows()> 0)
									{
										foreach($postQuery->result() as $rowData)
										{
											$members = explode (",",$rowData->members);
										}
										
										$groupUsers = array();	
										$groupPostQuery = $this->db->query("SELECT groupUsers FROM teeme_group_shared WHERE postId='".$row->id."'");	
								
										if($groupPostQuery->num_rows()> 0)
										{
											foreach($groupPostQuery->result() as $groupRowData)
											{
												$groupUsers = explode (",",$groupRowData->groupUsers);
											}
										}
										
										$members = array_filter(array_unique(array_merge($members,$groupUsers)));
										
										if(in_array($_SESSION['userId'],$members))
										{
											//echo 'test==';
											$total+= count($row->id);
										}
									}
									
																		
								}
								if ($total>0)
								{
									return $total;
								}				
							}					
						}
						else
						{
							return false;
						}
					}
					else if($postType=='public')
					{
						if($result_count2)
						{
							if($result_count2->num_rows() > 0)
							{	
								$total=0;
								foreach($result_count2->result() as $row)
								{	
									$total+= $row->total;									
								}
								if ($total>0)
								{
									return $total;
								}				
							}					
						}
						else
						{
							return false;
						}
					}
				
		}	
		
		return 0;	
			
		
					
	}
	 
	//Manoj: code for add post count end
	
	//Manoj: Search feature start
	
	public function checkPublicPostComment($nodeId){
		$query = $this->db->query( "SELECT a.workSpaceId AS workSpaceId, a.workSpaceType AS workSpaceType FROM teeme_node a where id= ".$nodeId);		
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$tree['workSpaceId'] = $row->workSpaceId;
				$tree['workSpaceType'] = $row->workSpaceType;
			}
			return $tree;	
		}
		else
		{
			return 0;
		}
	}	
	
	
	function getSearchResultCount($workSpaceId, $workSpaceType, $type, $searchQuery)
	{
			$mergeArray=array();
			
			$condition = "a.workspaces='".$workSpaceId."' AND a.workSpaceType='".$workSpaceType."'";
			
			//$postCondition = "c.workSpaceId='".$workSpaceId."' AND c.workSpaceType='".$workSpaceType."'";
			//$postCondition = "(c.workSpaceId='".$workSpaceId."' OR c.workSpaceId='0') AND (c.workSpaceType='".$workSpaceType."' OR c.workSpaceType='0') ";
			if($workSpaceId==0)
			{
				$postSpaceCondition = "c.workSpaceId='".$workSpaceId."'  AND c.workSpaceType='".$workSpaceType."' AND b.userId='".$_SESSION['userId']."'";
			}
			else
			{
				$postSpaceCondition = "c.workSpaceId='".$workSpaceId."'  AND c.workSpaceType='".$workSpaceType."'";
			}
			$postPublicCondition = "c.workSpaceId=0 AND c.workSpaceType=0";
			
			if($type=='tree')
			{
				$query = "SELECT a.name AS seed, a.id AS treeId, a.createdDate as seedCreatedDate, a.userId as seedUserId, a.type AS seedType FROM teeme_tree a WHERE ".$condition." AND a.parentTreeId='0' AND MATCH(name) AGAINST ('+".$this->db->escape_str($searchQuery)."*' IN BOOLEAN MODE) ORDER BY a.createdDate DESC";
			}
			else if($type=='leaf')
			{
				$query = "SELECT a.name AS seed, b.contents AS leaf, b.nodeId AS nodeId, a.id AS treeId, b.createdDate as leafCreatedDate, a.createdDate as seedCreatedDate, a.userId as seedUserId, b.userId as leafUserId, a.type AS seedType, c.predecessor AS predecessor FROM teeme_tree a, teeme_leaf b, teeme_node c WHERE c.id=b.nodeId AND a.id=c.treeIds AND ".$condition." AND MATCH(contents) AGAINST ('+".$this->db->escape_str($searchQuery)."*' IN BOOLEAN MODE) ORDER BY b.createdDate DESC";
			}
			else if($type=='post')
			{
				//$query = "SELECT b.contents AS leaf, b.nodeId AS nodeId, b.createdDate as leafCreatedDate, b.userId as leafUserId, c.predecessor AS predecessor FROM teeme_leaf b, teeme_node c WHERE c.id=b.nodeId AND c.treeIds=0 AND ".$postCondition." AND MATCH(contents) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE) ORDER BY b.createdDate DESC";
				$query = "(SELECT b.contents AS leaf, b.nodeId AS nodeId, b.createdDate as leafCreatedDate, b.userId as leafUserId, c.predecessor AS predecessor, c.workSpaceId AS workSpaceId, c.workSpaceType AS workSpaceType FROM teeme_leaf b, teeme_node c WHERE c.id=b.nodeId AND c.treeIds=0 AND ".$postSpaceCondition." AND MATCH(contents) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)ORDER BY b.createdDate DESC) UNION (SELECT b.contents AS leaf, b.nodeId AS nodeId, b.createdDate as leafCreatedDate, b.userId as leafUserId, c.predecessor AS predecessor, c.workSpaceId AS workSpaceId, c.workSpaceType AS workSpaceType FROM teeme_leaf b, teeme_node c WHERE c.id=b.nodeId AND c.treeIds=0 AND ".$postPublicCondition." AND MATCH(contents) AGAINST ('+".$this->db->escape_str($searchQuery)."*' IN BOOLEAN MODE)ORDER BY b.createdDate DESC )";
				
			}
			else if($type=='user')
			{
				$query = "SELECT userId FROM teeme_users WHERE MATCH(userName,tagName,firstName,lastName,department,address1,address2,city,state,country,other,statusUpdate) AGAINST ('+".$this->db->escape_str($searchQuery)."*' IN BOOLEAN MODE) ";
				//$query = "SELECT userId FROM teeme_users WHERE MATCH(userName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE) ";
				//echo $query; exit;
				//$query = "SELECT userId FROM teeme_users WHERE MATCH(userName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE) OR MATCH(tagName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(firstName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(lastName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(department) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(address1) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(address2) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(city) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(state) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(country) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(statusUpdate) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(other) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)";
			}
			
			
			$searchCountQuery = $this->db->query($query);
			
			$totalSearchCount=$searchCountQuery->result();
			
			return count($totalSearchCount);		
			
	}
	
	
	function getSearchResult($workSpaceId, $workSpaceType, $type, $searchQuery,$limit,$start)
	{
			$calc  = $limit * $start;
			$start = $calc - $limit;
	
			$mergeArray=array();
			
			$condition = "a.workspaces='".$workSpaceId."' AND a.workSpaceType='".$workSpaceType."'";
			
			if($workSpaceId==0)
			{
				$postSpaceCondition = "c.workSpaceId='".$workSpaceId."'  AND c.workSpaceType='".$workSpaceType."' AND b.userId='".$_SESSION['userId']."'";
			}
			else
			{
				$postSpaceCondition = "c.workSpaceId='".$workSpaceId."'  AND c.workSpaceType='".$workSpaceType."'";
			}
			$postPublicCondition = "c.workSpaceId='0' AND c.workSpaceType='0'";
			
			if($type=='tree')
			{
				$query = "SELECT a.name AS seed, a.id AS treeId, a.createdDate as seedCreatedDate, a.userId as seedUserId, a.type AS seedType FROM teeme_tree a WHERE ".$condition." AND a.parentTreeId='0' AND MATCH(name) AGAINST ('+".$this->db->escape_str($searchQuery)."*' IN BOOLEAN MODE) ORDER BY a.createdDate DESC LIMIT ".$start.",".$limit;
			}
			else if($type=='leaf')
			{
				$query = "SELECT a.name AS seed, b.contents AS leaf, b.nodeId AS nodeId, a.id AS treeId, b.createdDate as leafCreatedDate, a.createdDate as seedCreatedDate, a.userId as seedUserId, b.userId as leafUserId, a.type AS seedType, c.predecessor AS predecessor, b.id as leafId, c.nodeOrder as nodeOrder FROM teeme_tree a, teeme_leaf b, teeme_node c WHERE c.id=b.nodeId AND a.id=c.treeIds AND ".$condition." AND MATCH(contents) AGAINST ('+".$this->db->escape_str($searchQuery)."*' IN BOOLEAN MODE) ORDER BY b.createdDate DESC LIMIT ".$start.",".$limit;
			}
			else if($type=='post')
			{
				$query = "(SELECT b.contents AS leaf, b.nodeId AS nodeId, b.createdDate as leafCreatedDate, b.userId as leafUserId, c.predecessor AS predecessor, c.workSpaceId AS workSpaceId, c.workSpaceType AS workSpaceType FROM teeme_leaf b, teeme_node c WHERE c.id=b.nodeId AND c.treeIds=0 AND ".$postSpaceCondition." AND MATCH(contents) AGAINST ('+".$this->db->escape_str($searchQuery)."*' IN BOOLEAN MODE)ORDER BY b.createdDate DESC LIMIT ".$start.",".$limit.") UNION (SELECT b.contents AS leaf, b.nodeId AS nodeId, b.createdDate as leafCreatedDate, b.userId as leafUserId, c.predecessor AS predecessor, c.workSpaceId AS workSpaceId, c.workSpaceType AS workSpaceType FROM teeme_leaf b, teeme_node c WHERE c.id=b.nodeId AND c.treeIds=0 AND ".$postPublicCondition." AND MATCH(contents) AGAINST ('+".$this->db->escape_str($searchQuery)."*' IN BOOLEAN MODE)ORDER BY b.createdDate DESC LIMIT ".$start.",".$limit.")";
				
			}
			else if($type=='user')
			{
				$query = "SELECT * FROM teeme_users WHERE MATCH(userName,tagName,firstName,lastName,department,address1,address2,city,state,country,other,statusUpdate) AGAINST ('+".$this->db->escape_str($searchQuery)."*' IN BOOLEAN MODE) LIMIT ".$start.",".$limit;
				
				//$query = "SELECT * FROM teeme_users WHERE MATCH(userName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE) LIMIT ".$start.",".$limit;
				
				//$query = "SELECT * FROM teeme_users WHERE MATCH(userName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE) OR MATCH(tagName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(firstName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(lastName) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(department) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(address1) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(address2) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(city) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(state) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(country) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(statusUpdate) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE)OR MATCH(other) AGAINST ('+".$searchQuery."*' IN BOOLEAN MODE) LIMIT ".$start.",".$limit;
				
			}
			
			$searchQuery = $this->db->query($query);
			
			$i=0;
			if($type=='tree')
			{
				foreach($searchQuery->result() as $searchData)
				{ 
						
					$tree[$i]['seed'] = $searchData->seed;
					$tree[$i]['treeId'] = $searchData->treeId;
					$tree[$i]['seedCreatedDate'] = $searchData->seedCreatedDate;
					$tree[$i]['seedUserId'] = $searchData->seedUserId;
					$tree[$i]['seedType'] = $searchData->seedType;
					$i++;
				}
			}
			if($type=='leaf')
			{
				foreach($searchQuery->result() as $searchData)
				{ 
						
					$tree[$i]['seed'] = $searchData->seed;
					$tree[$i]['leaf'] = $searchData->leaf;
					$tree[$i]['nodeId'] = $searchData->nodeId;
					$tree[$i]['treeId'] = $searchData->treeId;
					$tree[$i]['seedCreatedDate'] = $searchData->seedCreatedDate;
					$tree[$i]['leafCreatedDate'] = $searchData->leafCreatedDate;
					$tree[$i]['seedUserId'] = $searchData->seedUserId;
					$tree[$i]['leafUserId'] = $searchData->leafUserId;
					$tree[$i]['seedType'] = $searchData->seedType;
					$tree[$i]['predecessor'] = $searchData->predecessor;
					$tree[$i]['leafType'] = $searchData->leafType;
					$tree[$i]['leafId'] = $searchData->leafId;
					$tree[$i]['nodeOrder'] = $searchData->nodeOrder;
					$i++;
				}
			}	
			
			if($type=='post')
			{
				foreach($searchQuery->result() as $searchData)
				{ 
					$tree[$i]['leaf'] = $searchData->leaf;
					$tree[$i]['nodeId'] = $searchData->nodeId;
					$tree[$i]['leafCreatedDate'] = $searchData->leafCreatedDate;
					$tree[$i]['leafUserId'] = $searchData->leafUserId;
					$tree[$i]['predecessor'] = $searchData->predecessor;
					$tree[$i]['workSpaceId'] = $searchData->workSpaceId;
					$tree[$i]['workSpaceType'] = $searchData->workSpaceType;
					$i++;
				}
			}	
			
			if($type=='user')
			{
				foreach($searchQuery->result() as $searchData)
				{ 
					$tree[$i]['userId'] 		= $searchData->userId;	
					$tree[$i]['workPlaceId'] 	= $searchData->workPlaceId;
					$tree[$i]['userName']	 	= $searchData->userName;	
					$tree[$i]['password'] 		= $searchData->password;
					$tree[$i]['userCommunityId'] = $searchData->userCommunityId;	
					$tree[$i]['userTitle'] 		= $searchData->userTitle;
					$tree[$i]['firstName'] 		= $searchData->firstName;
					$tree[$i]['lastName'] 		= $searchData->lastName;		
					$tree[$i]['address1'] 		= $searchData->address1;
					$tree[$i]['address2'] 		= $searchData->address2;	
					$tree[$i]['city'] 			= $searchData->city;		
					$tree[$i]['state'] 			= $row->state;			
					$tree[$i]['country'] 		= $searchData->country;	
					$tree[$i]['zip'] 			= $searchData->zip;		
					$tree[$i]['phone'] 			= $searchData->phone;	
					$tree[$i]['mobile'] 		= $searchData->mobile;		
					$tree[$i]['email'] 			= $searchData->email;
					$tree[$i]['status'] 		= $searchData->status;			
					$tree[$i]['emailSent'] 		= $searchData->emailSent;	
					$tree[$i]['registeredDate']	= $searchData->registeredDate;	
					$tree[$i]['lastLoginTime']	= $searchData->lastLoginTime;
					$tree[$i]['activation'] 	= $searchData->activation;
					$tree[$i]['photo'] 			= $searchData->photo;	
					$tree[$i]['statusUpdate'] 	= $searchData->statusUpdate;
					$tree[$i]['other'] 			= $searchData->other;
					$tree[$i]['role'] 			= $searchData->role;
					$tree[$i]['skills'] 			= $searchData->skills;
					$tree[$i]['department'] 	= $searchData->department;
					$tree[$i]['userGroup'] 	= $searchData->userGroup;
					$tree[$i]['isPlaceManager'] 	= $searchData->isPlaceManager;
					if($searchData->nickName!='')
					{
						$tree[$i]['tagName'] 		= $searchData->nickName;
						$tree[$i]['userTagName']	= $searchData->nickName;	
					}
					else
					{
						$tree[$i]['tagName'] 		= $searchData->tagName;
						$tree[$i]['userTagName']	= $searchData->tagName;	
					}		
					
					$i++;
				}
			}	
				
			
			return $tree;		
			
	}
	
	//Manoj: Search feature end
	
	//Manoj: get workplace manager start
	
	function getWorkPlaceManagersIdByWorkPlaceId($workPlaceId)
	{
		$userData = array();
		$userId = $_SESSION['userId'];
		
		$query = "SELECT * FROM teeme_users WHERE workPlaceId='".$workPlaceId."' AND isPlaceManager='1' ORDER BY userId ASC";
		//echo $query;
		$userDataQuery = $this->db->query($query);
		
		if($userDataQuery->num_rows() > 0)
		{
			$i = 0;
			foreach($userDataQuery->result() as $row)
			{
				$userData[$i]['userId'] 	= $row->userId;
				$userData[$i]['userName'] 	= $row->userName;
                $userData[$i]['firstName'] 	= $row->firstName;	
                $userData[$i]['lastName'] 	= $row->lastName;	
                $userData[$i]['tagName'] 	= $row->tagName;
                $userData[$i]['status'] 	= $row->status;
				$i++;										
			}				
		}	
					
		return $userData;	
	}
	
	//Manoj: get workplace manager end
	
	//Get object follow status
	
	public function get_follow_status($user_id,$object_instance_id,$place_name='')
	{
		if($user_id!='' && $object_instance_id!='')
		{
			$objectFollowDetails	= array();
			
			$get_object_follow_status = "SELECT preference FROM teeme_notification_follow WHERE user_id ='".$user_id."' AND object_instance_id='".$object_instance_id."'";
			
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				$get_object_follow_status = $placedb->query($get_object_follow_status);	
			}
			else
			{
				$get_object_follow_status = $this->db->query($get_object_follow_status);
			}
	
			if($get_object_follow_status->num_rows() > 0)
	
			{
				$i=0;
	
				foreach ($get_object_follow_status->result() as $row)
				{
	
					$objectFollowDetails['preference'] = $row->preference;	
						
				}
	
			}					
	
			return $objectFollowDetails;
		}
	}
	//Manoj: code end
	
	//Manoj: Get timezone name for dropdown list
	
	function getTimezoneNames($place_name='')
	{
		$timezoneData = array();
		$query = "SELECT timezoneid,timezone_name FROM teeme_timezones";
		
		if($place_name!='')
		{
			$config = array();
			$placedb = '';
			$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
					
			$placedb = $this->load->database($config, TRUE);
			$query = $placedb->query($query);	
		}
		else
		{
			$query = $this->db->query($query);
		}		
		
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $row)
			{
				$timezoneData[$i]['timezoneid'] 	= $row->timezoneid;
				$timezoneData[$i]['timezone_name'] 	= $row->timezone_name;
                $i++;										
			}				
		}	
					
		return $timezoneData;	
	}
	
	//Manoj: Update user time zone
	
	function updateUserTimeZone($userId,$timezoneid)
	{
		if($userId!='' && $timezoneid!='')
		{
			$query = "UPDATE teeme_users SET userTimezone='".$timezoneid."' WHERE userId='".$userId."'";
			
			$queryResult = $this->db->query($query);
	
			if($queryResult)
			{
				return true;
			}		
			else
			{
				return false;
			}
		}
	}
	
	//Manoj: Update user time zone
	
	function getUserTimeZone($userId)
	{
		if($userId!='')
		{
				$query = "SELECT userTimezone FROM teeme_users where userId=".$userId."";
				
				$query = $this->db->query($query);
				
				if($query)
				{
					if($query->num_rows() == 1)
					{
						foreach ($query->result() as $timezone_details)
						{	
							$timezone = $timezone_details->userTimezone;
						}
						return $timezone;
					}
				}
				else
				{
					return false;
				}
		}
	}
	
	public function getNodeworkSpaceDetails($nodeId)
	{
		if($nodeId!='')
		{
				$query = "SELECT treeIds, workSpaceId, workSpaceType FROM teeme_node where id=".$nodeId." AND treeIds='0'";
				
				$query = $this->db->query($query);
				
				if($query)
				{
					if($query->num_rows() > 0)
					{	
						$i=0;
						foreach($query->result() as $row)
						{	
							$nodeData['treeIds']	 = $row->treeIds;
							$nodeData['workSpaceId']	 = $row->workSpaceId;
							$nodeData['workSpaceType']	 = $row->workSpaceType;
							$i++;										
						}
						return $nodeData;				
					}					
						
				}
				else
				{
					return false;
				}
		}
	}
	
	function get_tree_originator_id($object_id,$object_instance_id)
	{
		if($object_id!='' && $object_instance_id!='')
		{
			$getObjectOriginatorId =  "SELECT user_id FROM teeme_notification_object_meta where object_id= ".$object_id." AND object_instance_id= ".$object_instance_id."";
				
			$getObjectOriginatorId = $this->db->query($getObjectOriginatorId);
			
			if($getObjectOriginatorId)
			{
				if($getObjectOriginatorId->num_rows() == 1)
				{
					foreach ($getObjectOriginatorId->result() as $originatorId)
					{	
						$originatorUserId = $originatorId->user_id;
					}
					return $originatorUserId;
				}
			}
			else
			{
				return false;
			}
		}
	}
	
	public function getPostSharedMembersByNodeId($nodeId)
	{
	
		$members = array();			
		$query = $this->db->query("SELECT members FROM teeme_posts_shared WHERE postId='".$nodeId."'");	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$members = explode (",",$row->members);
			}
		}	
		return $members;	
	}
	
	//get place timezone offset
	
	public function get_timezone_offset($timezoneId,$place_name='')
	{
		if($timezoneId!='')
		{
				$query = "SELECT gmt_offset FROM teeme_timezones where timezoneid=".$timezoneId."";
				
				if($place_name!='')
				{
					$config = array();
					$placedb = '';
					$config['hostname'] = base64_decode($this->config->item('hostname'));
					$config['username'] = base64_decode($this->config->item('username'));
					$config['password'] = base64_decode($this->config->item('password'));
					$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
					$config['dbdriver'] = $this->db->dbdriver;
					$config['dbprefix'] = $this->db->dbprefix;
					$config['pconnect'] = FALSE;
					$config['db_debug'] = $this->db->db_debug;
					$config['cache_on'] = $this->db->cache_on;
					$config['cachedir'] = $this->db->cachedir;
					$config['char_set'] = $this->db->char_set;
					$config['dbcollat'] = $this->db->dbcollat;
					
					$placedb = $this->load->database($config, TRUE);
					$query = $placedb->query($query);
				}
				else
				{
					$query = $this->db->query($query);
				}	
				
				
				if($query)
				{
					if($query->num_rows() == 1)
					{
						foreach ($query->result() as $timezone_details)
						{	
							$timezone_offset = $timezone_details->gmt_offset;
						}
						return $timezone_offset;
					}
				}
				else
				{
					return false;
				}
		}
	}
	
	//Manoj: Code end
	
	//Get tree following list on dashboard
	public function getFollowingTreesByWorkSpaceId($workSpaceId, $workSpaceType, $userId)
	{
	
		if($workSpaceId!='' && $workSpaceType!='' && $userId!='')
		{
			$arrTree	= array();	
				
		if($workSpaceId != NULL)
		{
			
			if($workSpaceId == 0)
			{
				$where = 'a.id=b.object_instance_id AND b.user_id = '.$userId.' AND b.preference = 1 AND a.workspaces='.$workSpaceId.'';				
			}
			else
			{
				$where = 'a.id=b.object_instance_id AND b.user_id = '.$userId.' AND b.preference = 1 AND a.workSpaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType ;	
			}
			
			$q = 'SELECT a.name as treeName, a.type as treeType, a.workspaces as workSpaceId, a.workSpaceType as workSpaceType, b.object_instance_id as treeId, b.subscribed_date as treeFollowingDate FROM teeme_tree a, teeme_notification_follow b WHERE '.$where.' AND a.latestVersion = 1 and a.name not like("untile%") and a.name not like("untitle%") AND (a.parentTreeId=0 OR embedded=0) ORDER BY b.subscribed_date DESC ';
			$query = $this->db->query($q);
			
			//echo $q; exit;
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $row)
				{	
					$arrTree[$i]['id']  = $row->treeId;		
					$arrTree[$i]['name'] = $row->treeName;	
					$arrTree[$i]['type'] = $row->treeType;
					$arrTree[$i]['followDate'] = $row->treeFollowingDate;
					$arrTree[$i]['workSpaceId'] = $row->workSpaceId;
					$arrTree[$i]['workSpaceType'] = $row->workSpaceType;	
					$i++;
				}				
			}
		}
			return $arrTree;
		}				
	}
		
	//Get post following list on dashboard
	public function getFollowingPosts($workSpaceId, $workSpaceType, $userId)
	{
	
		if($workSpaceId!='' && $workSpaceType!='' && $userId!='')
		{
			$arrTree	= array();	
				
		if($workSpaceId != NULL)
		{
			$q = "SELECT a.id as nodeId, a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, b.contents as leafName, c.bookmark_date as followingDate FROM teeme_node a, teeme_leaf b, teeme_bookmark c WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=0 and c.node_id=a.id and c.bookmarked=1 and c.user_id='".$userId."' ORDER BY c.bookmark_date DESC LIMIT 0,5";
			
			$query = $this->db->query($q);
			
			//echo $q; exit;
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $row)
				{	
					$arrTree[$i]['id']  = $row->nodeId;		
					$arrTree[$i]['name'] = $row->leafName;	
					$arrTree[$i]['type'] = '';
					$arrTree[$i]['followDate'] = $row->followingDate;	
					$arrTree[$i]['workSpaceId'] = $row->workSpaceId;
					$arrTree[$i]['workSpaceType'] = $row->workSpaceType;	
					$i++;
				}				
			}
			
		}
			return $arrTree;
		}				
	}
	//Get tree following list end
	
	//Check user unique nickname start
	public function checkUniqueNickName($nickName,$userId=0,$place_name='')
	{
		if($nickName!='')
		{
			$query = "SELECT userId FROM teeme_users where nickName='".$nickName."' AND userId!='".$userId."'";
			
			if($place_name!='')
			{
				$config = array();
				$placedb = '';
				$config['hostname'] = base64_decode($this->config->item('hostname'));
				$config['username'] = base64_decode($this->config->item('username'));
				$config['password'] = base64_decode($this->config->item('password'));
				$config['database'] = $this->config->item('instanceDb').'_'.$place_name;
				$config['dbdriver'] = $this->db->dbdriver;
				$config['dbprefix'] = $this->db->dbprefix;
				$config['pconnect'] = FALSE;
				$config['db_debug'] = $this->db->db_debug;
				$config['cache_on'] = $this->db->cache_on;
				$config['cachedir'] = $this->db->cachedir;
				$config['char_set'] = $this->db->char_set;
				$config['dbcollat'] = $this->db->dbcollat;
				
				$placedb = $this->load->database($config, TRUE);
				
				$query = $placedb->query($query);
			}
			else
			{
				$query = $this->db->query($query);
			}
				
				if($query)
				{
					if($query->num_rows() == 1)
					{
						return true;
					}
				}
				else
				{
					return false;
				}
		}
	}
	//Check user unique nick name end
	
	public function setUserTermsStatus($userId)
    {		
		$query = $this->db->query('UPDATE teeme_users SET terms = 1 WHERE userId ='.$userId);	
		if($query)
		{
			return true; 		
		}
		else
		{
			return false;
		}
	}
	
	public function writeLogs($logMsg)
	{	
		//$logMsg='test';
		$log_file_path = $this->config->item('application_log_file_path');
		$myFile = $log_file_path.'adminLog.txt';
		if (file_exists($myFile)) {
		  $fh = fopen($myFile, 'a');
		} else {
		  $fh = fopen($myFile, 'w');
		} 
		fwrite($fh, $logMsg."\r\n");
		fclose($fh);
	}
	
	public function getLeafIdByNodeId ($nodeId)
	{
		$query = $this->db->query("SELECT id, userId FROM teeme_leaf WHERE nodeId = '".$nodeId."'");

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				$arrLeaf['id']  = $row->id;	
				$arrLeaf['userId']  = $row->userId;	
			}				
		}		
		return $arrLeaf;	
	}
	
	//Get links by nodeId for post update
	function getLinkedPostsByNodeId($nodeId, $linkType='')
	{
		if($nodeId!='')
		{
			if($linkType=='tree')
			{
				$countResult=$this->db->query('SELECT COUNT(a.linkId) as total FROM teeme_links a WHERE a.artifactId="'.$nodeId.'" AND a.ownerId!="'.$_SESSION['userId'].'" AND a.ownerId!=0');
			}
			else if($linkType=='file')	
			{
				$countResult=$this->db->query('SELECT COUNT(a.linkId) as total FROM teeme_links_external a WHERE a.artifactId="'.$nodeId.'" AND a.ownerId!="'.$_SESSION['userId'].'" AND a.ownerId!=0');
			}	
			else if($linkType=='url')	
			{
				$countResult=$this->db->query('SELECT COUNT(a.id) as total FROM teeme_applied_url a WHERE a.artifactId="'.$nodeId.'" AND a.userId!="'.$_SESSION['userId'].'" AND a.userId!=0');
			}
			//Added by Dashrath- for folder linked count
			else if($linkType=='folder')	
			{
				$countResult=$this->db->query('SELECT COUNT(a.linkId) as total FROM teeme_links_folder a WHERE a.artifactId="'.$nodeId.'" AND a.ownerId!="'.$_SESSION['userId'].'" AND a.ownerId!=0');
			}

			if($countResult->num_rows()>0)
			{
			   $countResult=$countResult->row();
			   return $countResult->total;
			}
			else
			{
			   return 0;
			}
		}
	}
	//get tagged nodes by post id
	function getTaggedPostByNodeId($nodeId)
	{
		if($nodeId!='')
		{
			$countResult=$this->db->query('SELECT COUNT(a.tagId) as total FROM teeme_tag a WHERE a.artifactId="'.$nodeId.'" AND a.ownerId!="'.$_SESSION['userId'].'" AND a.tag!=0');
			if($countResult->num_rows()>0)
			{
			   $countResult=$countResult->row();
			   return $countResult->total;
			}
			else
			{
			   return 0;
			}
		}
	}
	
	
	public function getPlaceAndSpaceManagersDetailsByWorkSpaceId($spaceId,$spaceType=3,$workPlaceId)
	{
	
		$managerIds = array();		
		$space_query = $this->db->query('SELECT managerId FROM teeme_managers WHERE placeId='.$spaceId.' AND placeType='.$spaceType);
		if($space_query->num_rows() > 0)
		{
			$i = 0;
			foreach($space_query->result() as $row)
			{			
				$managerIds[$i] = $row->managerId;										
				$i++;													
			}
		}					
		
		//space manager end
	
		$placeManagerDetails = array();	
        $place_query = $this->db->query("SELECT userId FROM teeme_users WHERE workPlaceId='".$workPlaceId."' AND isPlaceManager='1' ORDER BY userId ASC");
		if($place_query->num_rows() > 0)
		{
			$i = 0;			
			foreach ($place_query->result() as $placeManagerData)
			{	
				$placeManagerDetails[$i] = $placeManagerData->userId;
				$i++;								
			}
		}	
		
		$resultArray = array_unique(array_merge($managerIds,$placeManagerDetails));
		
		return $resultArray;
		
		//place manager end		
		
	}
	
	/*Changed by Dashrath- Add $config for load db*/
	public function countWorkspace ($userId, $config=0)
	{
		/*Changed by Dashrath- Add if else condition for load db*/
		if ($config!=0)
        {
            $placedb = $this->load->database($config,TRUE);

            $query = $placedb->query("SELECT count(*) as total, workSpaceId FROM teeme_work_space_members WHERE workSpaceUserId='".$userId."'");
        }
		else
		{
			$query = $this->db->query("SELECT count(*) as total, workSpaceId FROM teeme_work_space_members WHERE workSpaceUserId='".$userId."'");
		}
		/*Dashrath- changes end*/		

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$total = $row->total;
					if ($total>0)
					{
						return $total;
					}
			}
		}	
	
		$query2 = $this->db->query("SELECT count(*) as total, subWorkSpaceId FROM teeme_sub_work_space_members WHERE subWorkSpaceUserId='".$userId."'");	

		if($query2->num_rows()> 0)
		{
			foreach($query2->result() as $row)
			{
				$total = $row->total;
					if ($total>0)
					{
						return $total;
					}
			}
		}	
		
		return false;	
	}
	
	function getUserTagNameByUserId ($userId)
	{
		if($userId!='')
		{
			$query = $this->db->query("SELECT tagName, nickName FROM teeme_users WHERE userId='".$userId."'");
			
				if($query->num_rows() > 0)
				{
					foreach($query->result() as $row)
					{
						if($row->nickName!='')
						{
							$userData['tagName'] 		= $row->nickName;	
						}
						else
						{
							$userData['tagName'] 		= $row->tagName;
						}
					}
				}
			return $userData;
		}
	}
	
	//Manoj: code for adding selected language for place 
	
	function AddSelectedLanguageDetails($SelectedLanguageArray)
	{
		
		$query = $this->db->query('SELECT id FROM teeme_language_config WHERE config_option="language"');
		if($query->num_rows()> 0){
			$q = $this->db->query("UPDATE teeme_language_config SET `config_option`='language',`config_value`='".$SelectedLanguageArray."' WHERE config_option='language'");
		}
		else{
			$q = $this->db->query("INSERT INTO teeme_language_config(`config_option`,`config_value`) VALUES('language','".$SelectedLanguageArray."')");
		}
		if($q){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	function GetSelectedLanguageDetails($place='')
	{
		
		$query = $this->db->query('SELECT config_value FROM teeme_language_config WHERE config_option="language"');	
		
		$selectedLanguageDetails = array();			
		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$selectedLanguageDetails['config_value'] 	= unserialize($row->config_value);
			}	
		}	
		return $selectedLanguageDetails;
	}
	
	//Trial place code start
	
	public function checkTrialPlaceUserName($email,$ip)
    {		
		if($email!='')
		{
			//OR ip = '".$ip."'
		
			$qry = "SELECT id FROM teeme_users_trial WHERE email = '".$email."' OR ip = '".$ip."' ";	
			
			$query = $this->db->query($qry);
			
			if($query->num_rows()> 0)
			{
				return false;
			}
			else
			{
				return true;
			}	
		}	
	}
	
	function addTrialUserEmail($email,$trial_request_time,$ip,$random_string)
	{
		if($email!='')
		{
			$qry = 'INSERT INTO teeme_users_trial(email,trial_request_time,ip,random_string) VALUES("'.$email.'","'.$trial_request_time.'","'.$ip.'","'.$random_string.'")';	
			
			$query = $this->db->query($qry);
			
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
	
	function send_trial_place_email($email='',$random_string='')
	{
					
					$to      = $email;
					$subject = 'Teeme - Trial';
					$url = '<a href="'.base_url().'trial/new_trial/'.$random_string.'">'.base_url().'trial/new_trial/'.$random_string.'</a>';
					$mailContent = '';
					$mailContent.= 'Hello,'."<br><br>";
					$mailContent.= 'You initiated a trial request on teeme. Please click link below to start your trial process.'."<br>";		
					$mailContent.=  $url."<br><br>";
					$mailContent.= 'Teeme admin';
					$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= 'From: admin@teeme.net' . "\r\n" .'Reply-To: admin@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
					
                    if (mail($to, $subject, $mailContent, $headers))
					{						
                    	return 1;
					}
					else
					{
                    	return 0;
					}	
	}	
	
	function send_trial_place_create_email($place_name=0,$email='',$password='',$number_of_users='',$place_expiry_date='',$firstName='',$lastName='')
	{
				$to      = $email;
				$subject = 'Teeme - Trial Place Details';
				$url = '<a href="'.base_url().''.$place_name.'">'.base_url().''.$place_name.'</a>';
				$mailContent = '';
				$mailContent.= 'Hello,'."<br><br>";
				$mailContent.= 'Place Details'."<br>";
				$mailContent.= 'Place Url: '.$url."<br>";
				$mailContent.= 'Place Name: '.$place_name."<br>";
				$mailContent.= 'Expiry Date: '.$place_expiry_date."<br>";
				$mailContent.= 'Number Of Users: '.$number_of_users."<br><br>";
				$mailContent.= 'Place Manager Details'."<br>";
				$mailContent.= 'First Name: '.$firstName."<br>";
				$mailContent.= 'Last Name:'.$lastName."<br>";		
				$mailContent.= 'Email: '.$email."<br><br>";
				$mailContent.= 'Teeme admin';
				$headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: admin@teeme.net' . "\r\n" .'Reply-To: admin@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();
					
                   if (mail($to, $subject, $mailContent, $headers))
					{						
                    	return 1;
					}
					else
					{
                    	return 0;
					}	
	}	
	
	function get_user_trial_place($email='',$random_string='')
	{
		if($email!='' && $random_string!='')
		{
			$qry = "SELECT random_string_expire,trial_request_time FROM teeme_users_trial WHERE email = '".$email."' AND random_string = '".$random_string."'";	
			
			$query = $this->db->query($qry);
			
			if($query)
			{
				foreach($query->result() as $row)
				{
					$trialPlaceDetails['random_string_expire'] = $row->random_string_expire;	
					$trialPlaceDetails['trial_request_time'] = $row->trial_request_time;	
				}		
				return $trialPlaceDetails;
			}
			else
			{
				return false;
			}	
		}	
	}	
	
	function update_trial_place_details ($placeExpDate,$placeCreatedTime,$email)
	{
		if($email!='')
		{
			$this->db->trans_begin();
		
			$strResultSQL = "UPDATE teeme_users_trial SET place_expire_date='".$placeExpDate."', place_created_date='".$placeCreatedTime."', random_string_expire='1' WHERE email='".$email."'";
			
			$bResult = $this->db->query($strResultSQL);
			
			//Checking transaction status here
			if($this->db->trans_status()=== FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return true;
			}
	
			/*if($bResult)
			{
				return true;
			}		
			else
			{
				return false;
			}*/
		}
	}
	
	//Trial place code end
	
	//User group code start
	
	function insertGroupDetails($groupDetails)
	{
		if(count($groupDetails)!=0)
		{
			$qry = 'INSERT INTO teeme_usergroups(placeId, placemanagerId, createdDate, lastEditedDate, groupName) VALUES("'.$groupDetails['placeId'].'","'.$groupDetails['placemanagerId'].'","'.$groupDetails['createdDate'].'","'.$groupDetails['createdDate'].'","'.$groupDetails['groupName'].'")';	
			
			$query = $this->db->query($qry);
			
			if($query)
			{
				$lastId = $this->db->insert_id();
				return $lastId;
			}	
			else
			{
				return false;
			}	
		}		
	}
	
	public function checkGroupName($groupName,$placeId)
    {		
		$query = $this->db->query('SELECT id FROM teeme_usergroups WHERE groupName = \''.$this->db->escape_str($groupName).'\' AND placeId = \''.$placeId.'\'');	
		if($query->num_rows()> 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	public function insertUserGroupDetails($groupUserDetails)
	{
		if(count($groupUserDetails)!=0)
		{
			$qry = 'INSERT INTO teeme_usergroups_as_user(userGroupId, userId) VALUES("'.$groupUserDetails['userGroupId'].'","'.$groupUserDetails['userId'].'")';	
			
			$query = $this->db->query($qry);
			
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
	
	public function getUserGroupDetails()
	{
		$groupData = array();
		$query = $this->db->query('SELECT id, placemanagerId, createdDate, lastEditedDate, groupName FROM teeme_usergroups ORDER BY createdDate DESC');
		if($query->num_rows() > 0)
		{
			$i = 0;	
			foreach($query->result() as $row)
			{
				$groupData[$i]['groupId']        = $row->id;	
				$groupData[$i]['placemanagerId'] = $row->placemanagerId;	
				$groupData[$i]['createdDate'] 	 = $row->createdDate;
				$groupData[$i]['lastEditedDate'] = $row->lastEditedDate;	
				$groupData[$i]['groupName'] 	 = $row->groupName;
				$i++;
			}				
		}					
		return $groupData;			
	}	
	
	public function deleteGroup($groupId)
	{
		if($groupId!='')
		{
			$query = $this->db->query('DELETE FROM teeme_usergroups WHERE id='.$groupId.'');
			if($query > 0)
			{
				return true;
			}					
			else
			{
				return false;
			}	
		}	
	}
	
	public function deleteGroupUsers($groupId)
	{
		if($groupId!='')
		{
			$query = $this->db->query('DELETE FROM teeme_usergroups_as_user WHERE userGroupId='.$groupId.'');
			if($query > 0)
			{
				return true;
			}					
			else
			{
				return false;
			}	
		}	
	}
	
	public function getUsersByGroupId($groupId)
	{
		if($groupId!='')
		{
			$groupData = array();
			$query = $this->db->query('SELECT userId FROM teeme_usergroups_as_user WHERE userGroupId='.$groupId.'');
			if($query->num_rows() > 0)
			{
				$i = 0;	
				foreach($query->result() as $row)
				{
					$groupData[$i]['userId']  = $row->userId;	
					$i++;
				}				
			}					
			return $groupData;	
		}		
	}	
	
	public function getGroupDetailsByGroupId($groupId)
	{
		if($groupId!='')
		{
			$groupData = array();
			$query = $this->db->query('SELECT id, placemanagerId, createdDate, lastEditedDate, groupName FROM teeme_usergroups WHERE id='.$groupId.'');
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					$groupData['groupId']        = $row->id;	
					$groupData['placemanagerId'] = $row->placemanagerId;	
					$groupData['createdDate'] 	 = $row->createdDate;
					$groupData['lastEditedDate'] = $row->lastEditedDate;	
					$groupData['groupName'] 	 = $row->groupName;
				}				
			}					
			return $groupData;	
		}				
	}	
	
	public function getGroupUsersByGroupId($groupId)
	{
		if($groupId!='')
		{
			$groupUsersData = array();		
			$query = $this->db->query('SELECT userGroupId, userId FROM teeme_usergroups_as_user WHERE userGroupId='.$groupId.'');
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach($query->result() as $row)
				{										
					$groupUsersData[$i]['groupId']	= $row->userGroupId;	
					$groupUsersData[$i]['userId']	= $row->userId;		
					$i++;													
				}				
			}					
			return $groupUsersData;
		}				
	}	
	
	public function updateGroupDetails($groupDetails)
	{
		if(!empty($groupDetails))
		{
			$qry = "UPDATE teeme_usergroups SET groupName='".$groupDetails['groupName']."', lastEditedDate='".$groupDetails['editedDate']."', lastPlaceManagerId='".$groupDetails['lastPlaceManagerId']."' WHERE id='".$groupDetails['groupId']."'";
			
			$query = $this->db->query($qry);
			
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
	
	public function checkGroupNameUpdate($groupName,$groupId)
    {		
		$query = $this->db->query('SELECT id FROM teeme_usergroups WHERE groupName = \''.$this->db->escape_str($groupName).'\' AND id != '.$groupId.'');	
		if($query->num_rows()> 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	public function getUserGroupList()
	{
		$groupData = array();
		$query = $this->db->query('SELECT id, groupName FROM teeme_usergroups ORDER BY groupName ASC');
		if($query->num_rows() > 0)
		{
			$i = 0;	
			foreach($query->result() as $row)
			{
				$groupData[$i]['groupId']        = $row->id;	
				$groupData[$i]['groupName'] 	 = $row->groupName;
				$i++;
			}				
		}					
		return $groupData;			
	}	
	
	public function getGroupSharedIdsByNodeId($nodeId)
	{
	
		$groupIdArr = array();			
		$query = $this->db->query("SELECT groupIds FROM teeme_group_shared WHERE postId='".$nodeId."'");	

		if($query->num_rows()> 0)
		{
			foreach($query->result() as $row)
			{
				$groupIdArr = explode (",",$row->groupIds);
			}
		}	
		return $groupIdArr;	
	}
	
	public function isGroupShared($nodeId)
	{
		$query = $this->db->query("SELECT * FROM teeme_group_shared WHERE postId='".$nodeId."'");	

		if($query->num_rows()> 0)
		{
			return true;
		}
		else
		{	
			return false;	
		}
	}
	
	public function add_group_recipients($nodeId,$workSpaceId,$groupRecipients,$groupUserRecipients)
	{
		if($nodeId!='')
		{
			if($workSpaceId==0)
			{
				$query = $this->db->query("INSERT INTO teeme_group_shared (postId,groupIds,groupUsers) VALUES ('".$nodeId."','".$groupRecipients."','".$groupUserRecipients."')");
			}
		}
	}
	
	public function update_group_recipients($nodeId,$workSpaceId,$groupRecipients,$groupUserRecipients)
	{
		if($nodeId!='')
		{
			if($workSpaceId==0)
			{
				$query = "UPDATE teeme_group_shared SET groupIds='".$groupRecipients."', groupUsers='".$groupUserRecipients."' WHERE postId='".$nodeId."'";
				$result = $this->db->query($query);
				if($result)
				{
					return true;
				}		
				else
				{
					return false;
				}	
			}
		}
	}
	
	public function getPostSharedMembersByPostId($nodeId)
	{
	
		$members = array();			
		$postQuery = $this->db->query("SELECT members FROM teeme_posts_shared WHERE postId='".$nodeId."'");	
			
		if($postQuery->num_rows()> 0)
		{
			foreach($postQuery->result() as $rowData)
			{
				$members = explode (",",$rowData->members);
			}
		}
					
		$groupUsers = array();	
		$groupPostQuery = $this->db->query("SELECT groupUsers FROM teeme_group_shared WHERE postId='".$nodeId."'");	
			
		if($groupPostQuery->num_rows()> 0)
		{
			foreach($groupPostQuery->result() as $groupRowData)
			{
				$groupUsers = explode (",",$groupRowData->groupUsers);
			}
		}
					
		$members = array_filter(array_unique(array_merge($members,$groupUsers)));
		
		return $members;
	}
	
	public function getGroupUsersListByGroupId($groupId)
	{
		if($groupId!='')
		{
			$groupUsersData = array();		
			$query = $this->db->query('SELECT userId FROM teeme_usergroups_as_user WHERE userGroupId='.$groupId.'');
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach($query->result() as $row)
				{										
					//$groupUsersData[$i]['userId']	= $row->userId;		
					//$groupUsersData[$i] = $this->getUserTagNameByUserId($row->userId);
					$qry = $this->db->query("SELECT tagName, nickName FROM teeme_users WHERE userId='".$row->userId."'");
			
					if($qry->num_rows() > 0)
					{
						foreach($qry->result() as $rowData)
						{
							if($row->nickName!='')
							{
								$userData[$i] 		= $rowData->nickName;	
							}
							else
							{
								$userData[$i] 		= $rowData->tagName;
							}
						}
					}
					
					$i++;													
				}				
			}		
							
			return implode(', ',$userData);
		}	
	}
	
	//User group code end		
	//Trial place code end	
	function validatePlaceMember($placeMemberData)
	{
		if(preg_match('{^[A-Za-z0-9 ]+$}',$placeMemberData['fname'])&& preg_match('{^[A-Za-z0-9 ]+$}',$placeMemberData['lname'])  )
		{
			if(preg_match("(^[A-Za-z0-9_\+-]+(\.[A-Za-z0-9_\+-]+)*@[a-z0-9-]+)", $placeMemberData['email']))
			{
				return '1';
			}
			else
			{
				return 'invalid_email';
			}
		}
		else
		{
			return 'invalid_name';
		}
	}	
	//Space tree configuration start here
	function space_tree_config($spaceTreeData)
	{
		if(!empty($spaceTreeData))
		{
			$qry = "INSERT INTO teeme_tree_enabled(`space_id`,`space_type`,`tree_type_id`) VALUES('".$spaceTreeData['workSpaceId']."','".$spaceTreeData['workSpaceType']."','".$spaceTreeData['treeTypeId']."')";	
			
			$query = $this->db->query($qry);
			
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
	function delete_space_tree_config($workSpaceId,$workSpaceType)
	{
		$query  = $this->db->query("DELETE FROM teeme_tree_enabled WHERE space_id='".$workSpaceId."' AND space_type='".$workSpaceType."'");
		if($query)
		{									
			return true;
		}	
		else
		{
			return false;
		}	
	}
	function get_space_tree_config($spaceId,$spaceType)
	{
		if($spaceId!='')
		{
			$qry = "SELECT tree_type_id,space_id FROM teeme_tree_enabled WHERE space_id = '".$spaceId."' AND space_type = '".$spaceType."'";	
			
			$query = $this->db->query($qry);
			
			if($query)
			{
				foreach($query->result() as $row)
				{
					$spaceTreeDetails[]['tree_type_id'] = $row->tree_type_id;	
					//$spaceTreeDetails[]['space_id'] = $row->space_id;	
				}		
				return $spaceTreeDetails;
			}
			else
			{
				return false;
			}	
		}	
	}
	function get_space_tree_type_id($spaceId,$spaceType=0,$treeCreate='')
	{
		if($treeCreate==1)
		{
				$qry = "SELECT tree_type_id FROM teeme_tree_enabled WHERE space_id = '".$spaceId."' AND space_type = '".$spaceType."'";	
				
				$query = $this->db->query($qry);
				
				if($query)
				{
					foreach($query->result() as $row)
					{
						$spaceTreeDetails[] = $row->tree_type_id;	
					}		
					return array_filter($spaceTreeDetails);
				}
				else
				{
					return false;
				}
		}
		else
		{
			$spaceTreeDetails = array(1,3,4,6,5);
			return $spaceTreeDetails;
		}
		/*if($spaceId!='')
		{
			//space tree content show 
			$spaceQuery = $this->db->query('SELECT showDisabledTreeContent FROM teeme_work_space WHERE workSpaceId='.$spaceId);
			if($spaceQuery->num_rows() > 0)
			{
				foreach($spaceQuery->result() as $spaceRow)
				{										
					$showDisabledTreeContent = $spaceRow->showDisabledTreeContent;
				}				
			}				
			if(($showDisabledTreeContent!='' && $showDisabledTreeContent=='0') || $treeCreate==1)
			{
			
				//allowed trees 
			
				$qry = "SELECT tree_type_id FROM teeme_tree_enabled WHERE space_id = '".$spaceId."'";	
				
				$query = $this->db->query($qry);
				
				if($query)
				{
					foreach($query->result() as $row)
					{
						$spaceTreeDetails[] = $row->tree_type_id;	
					}		
					return array_filter($spaceTreeDetails);
				}
				else
				{
					return false;
				}
			}
			else if($showDisabledTreeContent==1)
			{
				$spaceTreeDetails = array(1,3,4,6,5);
				return $spaceTreeDetails;
			}	
		}*/	
	}
	function if_is_tree_enabled($treeTypeId,$spaceId,$spaceType=0,$treeCreate='')
	{
		if($treeCreate==1)
		{
			$qry = "SELECT tree_type_id FROM teeme_tree_enabled WHERE space_id = '".$spaceId."' AND space_type = '".$spaceType."' AND tree_type_id = '".$treeTypeId."'";	
			
			$query = $this->db->query($qry);
			
			if($query->num_rows()> 0)
			{
				return false;
			}
			else
			{
				return true;
			}	
		}
		else
		{
			return false;
		}
		/*if($treeTypeId!='' && $spaceId!='')
		{
			//space tree content show 
			$spaceQuery = $this->db->query('SELECT showDisabledTreeContent FROM teeme_work_space WHERE workSpaceId='.$spaceId);
			if($spaceQuery->num_rows() > 0)
			{
				foreach($spaceQuery->result() as $spaceRow)
				{										
					$showDisabledTreeContent = $spaceRow->showDisabledTreeContent;
				}				
			}
			if($showDisabledTreeContent==1 && $treeCreate!=1)
			{
				return false;
			}
			
			//check tree enabled
			$qry = "SELECT tree_type_id FROM teeme_tree_enabled WHERE space_id = '".$spaceId."' AND tree_type_id = '".$treeTypeId."'";	
			
			$query = $this->db->query($qry);
			
			if($query->num_rows()> 0)
			{
				return false;
			}
			else
			{
				return true;
			}	
		}*/	
	}
	//Space tree configuration end here 
	
	public function getSpaceManagersDetailsByWorkSpaceId($spaceId, $spaceType)
	{
		$userData = array();
		if($spaceId != 0)
		{
			$query = $this->db->query('SELECT b.* FROM teeme_managers a, teeme_users b WHERE a.managerId = b.userId AND a.placeId='.$spaceId.' AND a.placeType='.$spaceType.' ORDER BY firstName ASC');
			if($query->num_rows() > 0)
			{
			$i = 0;
				foreach($query->result() as $row)
				{
				$userData[$i]['userId'] 		= $row->userId;	
				$userData[$i]['firstName'] 		= $row->firstName;	
				$userData[$i]['lastName'] 		= $row->lastName;
				if($row->nickName!='')
				{
					$userData[$i]['tagName']	= $row->nickName;	
				}
				else
				{
					$userData[$i]['tagName']	= $row->tagName;	
				}			
				$i++;										
				}	
			}			
		}					
		return $userData;				
	}
	
	//get tags count start
	function getAllTagsCount($workSpaceId, $workSpaceType,$count=false,$start=0,$limit=25)
	{
		
		$arrTagDetails=array();
	
					
		
		$i = 0;	

		 //response tag for leaf
			$q  = 'select tagId from (SELECT a.tagId, a.createdDate, a.comments FROM teeme_tag a, teeme_tagged_users b, teeme_tree c, teeme_node d WHERE a.artifactType=2 AND a.tagType = 3 AND a.tagId = b.tagId AND b.status = 1 AND c.id = d.treeIds AND a.artifactId = d.id AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.' order by createdDate desc ) t group by comments';
	
								
				$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$i++;	
						}
				}		
		
		
		//response tag for seed
		  /*$q  = 'select tagId from(SELECT a.tagId, a.createdDate, a.comments FROM teeme_tag as a LEFT JOIN teeme_tree as t ON a.artifactId=t.id  where a.artifactType=1 AND a.tagType = 3 AND  t.workspaces='.$workSpaceId.'  AND workSpaceType='.$workSpaceType.' order by createdDate desc ) t group by comments  ';
			
				
							
				$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$i++;	
						}
				}*/	
		
				//for simple tag tree
				  $q  = 'select tagId from (SELECT y.tagType as tagComment,a.tagId, a.createdDate FROM teeme_tag as a LEFT JOIN teeme_tree as t  ON a.artifactId=t.id LEFT JOIN teeme_tag_types as y ON a.tag=y.tagTypeId  where a.artifactType=1  AND a.tagType = 2 AND t.workspaces='.$workSpaceId.'  AND t.workSpaceType='.$workSpaceType.' order by a.createdDate desc ) t group by tagComment ';
								
							
			    $query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$i++;	
						}
				}
				
				//for simple tag leaf
			$q  = 'select tagId from (SELECT y.tagType as tagComment,a.tagId, a.createdDate FROM teeme_tag a, teeme_tree c, teeme_tag_types as y, teeme_node d WHERE a.artifactType=2 AND a.tagType = 2 AND c.id = d.treeIds AND a.artifactId = d.id AND a.tag=y.tagTypeId AND c.workspaces='.$workSpaceId.' AND c.workSpaceType='.$workSpaceType.' order by createdDate desc) t group by tagComment';
	
								
				$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 		= $tagData->tagId;	
							$i++;	
						}
				}		
		
			// for contact tags
			if($workSpaceId == 0)
			{
					$where = 'b.workspaces='.$workSpaceId.' AND b.userId = '.$_SESSION['userId'].'';	
			}
			else
			{
					$where = 'b.workspaces = \''.$workSpaceId.'\' AND b.workSpaceType= '.$workSpaceType.'';
			}
		
			 
			  $q = 'select tagId from(SELECT a.tagId, a.createdDate, b.name as contactName FROM teeme_tag a, teeme_tree b WHERE '.$where.' AND a.tagType = 5 AND a.tag = b.id order by createdDate desc ) t group by contactName';
						
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
						foreach ($query->result() as $tagData)
						{
							$arrTagDetails[$i]['tagId'] 			= $tagData->tagId;	
							$i++;	
						}
				}		
		
			if($count==true)
			{ 
			    $countResult=count($arrTagDetails);
				
				if($countResult)
				{
				   
					
					return $countResult;
				}
				 else
				    return 0;
			  
			}
		
	}
	//get tags count end
	//Assigned move tree originator code start
	
	function assignedMoveTreeOriginator($workSpaceId,$workSpaceType,$userId,$originatorId)
	{
		if($workSpaceType==1)
		{
			$workSpaceUser=$this->getWorkSpaceMembersByWorkSpaceId($workSpaceId);
		}
		elseif($workSpaceType==2)
		{
			$workSpaceUser=$this->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
		}
		foreach($workSpaceUser as $user)
		{
			$workspaceMembers[] = $user['userId'];
		}
		if(in_array($originatorId, $workspaceMembers))
		{
			return $originatorId;
		}
		else if(in_array($userId, $workspaceMembers))
		{
			return $userId;
		}
		else 
		{
			if($workSpaceType==1)
			{
				$workSpaceManagersIds = $this->getTeemeManagers($workSpaceId,'3');
				if(count($workSpaceManagersIds)==1)
				{
					$workSpaceUser=$this->getSpaceManagersDetailsByWorkSpaceId($workSpaceId,'3');
					foreach($workSpaceUser as $user)
					{
						$workspaceMemberId = $user['userId'];
					}
					return $workspaceMemberId;
				}
				else
				{
					$workSpaceUser=$this->getSpaceManagersDetailsByWorkSpaceId($workSpaceId,'3');
					return $workSpaceUser;
				}
			}
			elseif($workSpaceType==2)
			{
				$workSubSpaceMembers=$this->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
				if(count($workSubSpaceMembers)==1)
				{
					$workSpaceUser=$this->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
					foreach($workSpaceUser as $user)
					{
						$workSubspaceMemberId = $user['userId'];
					}
					return $workSubspaceMemberId;
				}
				else
				{
					$workSpaceUser=$this->getSubWorkSpaceMembersBySubWorkSpaceId($workSpaceId);
					return $workSpaceUser;
				}
			}
			
		}
	}
	
	//Assigned move tree originator code end 
	
	public function getPostsByWorkSpaceId($treeId,$workSpaceId,$workSpaceType)
	{
		$treeId = '0';
	
		$treeData	= array();

		$tree = array();	
		
		if($user_id!='' && $user_id !=0)
		{
			$profileUserId = $user_id;
		}	
		else
		{
			$profileUserId = $_SESSION['userId'];
		}
		
		//Memcache code start here
		/*$memc=$this->createMemcacheObject();

		$memCacheId = 'wp'.$workSpaceId.'posts'.$workSpaceType.'place'.$_SESSION['workPlaceId'];	
		if($workSpaceId!=0)
		{	
			$tree = $memc->get($memCacheId);
		}
		if(!$tree)
		{*/
		
		/*Changed by Dashrath- Add b.leafStatus in query*/
		$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' ORDER BY b.editedDate DESC");
			
			foreach($query->result() as $disData)
			{

				$tree[] = $disData;

			}	
			/*if($workSpaceId!=0)
			{	
				$memc->set($memCacheId, $tree);
				$tree = $memc->get($memCacheId);	
			}*/
		/*}*/		

		if(count($tree) > 0)
		{

			$i=0;

			

			foreach ($tree as $row)

			{
			
				if($row->workSpaceType!=0)
				{
				
					$members = array();			
					$postQuery = $this->db->query("SELECT members FROM teeme_posts_shared WHERE postId='".$row->id."'");	
			
					if($postQuery->num_rows()> 0)
					{
						foreach($postQuery->result() as $rowData)
						{
							$members = explode (",",$rowData->members);
						}
						
						$groupUsers = array();	
						$groupPostQuery = $this->db->query("SELECT groupUsers FROM teeme_group_shared WHERE postId='".$row->id."'");	
				
						if($groupPostQuery->num_rows()> 0)
						{
							foreach($groupPostQuery->result() as $groupRowData)
							{
								$groupUsers = explode (",",$groupRowData->groupUsers);
							}
						}
						
						$members = array_filter(array_unique(array_merge($members,$groupUsers)));	
						
						if(in_array($profileUserId,$members))
						{
							$treeData[$i]['nodeId'] = $row->id;	
	
							$treeData[$i]['successors']  = $row->successors;	
			
							$treeData[$i]['predecessor'] = $row->predecessor;
			
							$treeData[$i]['nodeOrder'] = $row->nodeOrder;		
			
							$treeData[$i]['authors'] = $row->authors;	
			
							$treeData[$i]['userId']  = $row->userId;	
			
							$treeData[$i]['leafId']  = $row->leafId;	
			
							$treeData[$i]['contents'] = $row->contents;	
			
							$treeData[$i]['TimelineCreatedDate']  = $row->TimelineCreatedDate;	
							
							$treeData[$i]['commentWorkSpaceId']  		= $row->workSpaceId;
			
							$treeData[$i]['commentWorkSpaceType']  		= $row->workSpaceType;

							/*Added by Dashrath- Add leafStatus in array */
							$treeData[$i]['leafStatus']  		= $row->leafStatus;
			
							$i++;
						}
					}	
				}
			}

		}

		return $treeData;	

	}
	
	//Update memcache data code start
	
	public function updateTreeMemCache($workSpaceId, $workSpaceType, $treeId)
	{

		if($workSpaceId != NULL && $workSpaceId!=0)
		{
			if($workSpaceId == 0)
			{
				$where = 'a.userId = b.userId AND a.workspaces='.$workSpaceId.' AND (a.userId = '.$_SESSION['userId'].' OR a.isShared=1) AND a.id = '.$treeId;				
			}
			else
			{
				$where = 'a.userId = b.userId AND a.workSpaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.' AND a.id = '.$treeId;	
			}
			
			//Memcache code start here
			$memc=$this->createMemcacheObject();

			$memCacheId = 'wp'.$workSpaceId.'trees'.$workSpaceType.'place'.$_SESSION['workPlaceId'];
			
			$value = $memc->get($memCacheId);	
			
			foreach ($value as $key=>$row)
			{
				if($row->id == $treeId)
				{
					unset($value[$key]);
				}
			}
			
			$q = 'SELECT a.*,date_format(a.createdDate,\'%Y-%m-%d %H:%i:%s\') as treeCreatedDate, date_format(a.editedDate,\'%Y-%m-%d %H:%i:%s\')  as treeEditedDate, a.status FROM teeme_tree a, teeme_users b WHERE '.$where.' AND a.latestVersion = 1 and a.name not like("untile%") and a.name not like("untitle%") AND (a.parentTreeId=0 OR embedded=0) ORDER BY a.editedDate DESC ';
			
			$query = $this->db->query($q);
				
			
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$tree[] = $row;	
				}	
			}
			
			$tree = array_merge($tree,$value);
			
			/*foreach ($tree as $key => $node) {
				$timestamps[$key]=strtotime($node->treeEditedDate) ;
			}
			array_multisort($timestamps, SORT_DESC, $tree);*/
			
			$memc->set($memCacheId, $tree);
			
		}

	}
	
	public function updateTalksMemCache($workSpaceId, $workSpaceType, $treeId)
	{

		if($workSpaceId != NULL && $workSpaceId!=0)
		{
			
			if($workSpaceId == 0)
			{
				$where = 'a.workspaces='.$workSpaceId.' AND a.id = '.$treeId;		
			}
			else
			{
				$where = 'a.workspaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.' AND a.id = '.$treeId;
			}
			
			//Memcache code start here
			$memc=$this->createMemcacheObject();

			$memCacheId = 'wp'.$workSpaceId.'talks'.$workSpaceType.'place'.$_SESSION['workPlaceId'];
			
			$value = $memc->get($memCacheId);							
			
			$q = 'SELECT a.id,  a.parentTreeId,b.leaf_id, a.name, a.type,b.type as treeType, a.userId, a.createdDate, a.editedDate, a.status FROM teeme_tree a, teeme_leaf_tree b WHERE '.$where.' AND a.id=b.tree_id AND latestVersion=1 AND embedded=1 AND name not like(\'untile%\') AND name <>\' \' and b.updates>0 ORDER BY editedDate desc   '.$limit;
				
			$query = $this->db->query($q);	
			
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$tree[] = $row;	
				}				
			}
			
			$tree = array_merge($tree,$value);
			
			$memc->set($memCacheId, $tree);
		}

	}
	
	public function updatePostsMemCache($workSpaceId, $workSpaceType, $nodeId)
	{
		$treeId = '0';
			
		if($workSpaceId != NULL && $workSpaceId!=0)
		{
			//Memcache code start here
			$memc=$this->createMemcacheObject();

			$memCacheId = 'wp'.$workSpaceId.'posts'.$workSpaceType.'place'.$_SESSION['workPlaceId'];
			
			$value = $memc->get($memCacheId);							
			
			$q = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' and a.id='".$nodeId."' ORDER BY b.editedDate DESC";
				
			$query = $this->db->query($q);	
			
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$tree[] = $row;	
				}				
			}
			
			$tree = array_merge($tree,$value);
			
			$memc->set($memCacheId, $tree);
		}

	}
	
	public function updateFilesMemCache($workSpaceId, $workSpaceType, $docId)
	{
		if($workSpaceId != NULL && $workSpaceId!=0)
		{
			$search = '';	
			//Memcache code start here
			$memc=$this->createMemcacheObject();

			$memCacheId = 'wp'.$workSpaceId.'files'.$workSpaceType.'place'.$_SESSION['workPlaceId'];
			
			$value = $memc->get($memCacheId);							
			
			$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND '.$search.' a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.docId='.$docId.' ORDER BY a.createdDate DESC');
				
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$tree[] = $row;	
				}				
			}
			
			$tree = array_merge($tree,$value);
			
			$memc->set($memCacheId, $tree);
			
		}

	}
	
	public function updateFollowingMemCache($workSpaceId, $workSpaceType, $userId, $seedId)
	{
	
		if($workSpaceId!='' && $workSpaceType!='' && $userId!='')
		{
			$arrTree	= array();	
				
		if($workSpaceId != NULL)
		{
			
			if($workSpaceId == 0)
			{
				$where = 'a.id=b.object_instance_id AND b.user_id = '.$userId.' AND b.preference = 1 AND a.workspaces='.$workSpaceId.' AND b.object_instance_id='.$seedId;				
			}
			else
			{
				$where = 'a.id=b.object_instance_id AND b.user_id = '.$userId.' AND b.preference = 1 AND a.workSpaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.' AND b.object_instance_id='.$seedId;	
			}
			
			//Memcache code start here
			$memc=$this->createMemcacheObject();

			$memCacheId = 'wp'.$workSpaceId.'follow'.$workSpaceType.'tree'.$userId.'place'.$_SESSION['workPlaceId'];	
			
			$value = $memc->get($memCacheId);	
			
			$q = 'SELECT a.name as treeName, a.type as treeType, a.workspaces as workSpaceId, a.workSpaceType as workSpaceType, b.object_instance_id as treeId, b.subscribed_date as treeFollowingDate FROM teeme_tree a, teeme_notification_follow b WHERE '.$where.' AND a.latestVersion = 1 and a.name not like("untile%") and a.name not like("untitle%") AND (a.parentTreeId=0 OR embedded=0) ORDER BY b.subscribed_date DESC ';
			$query = $this->db->query($q);
			
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}	
				}
			
			$tree = array_merge($tree,$value);
			
			$memc->set($memCacheId, $tree);
		}
		}	
	}
	
	public function updateTreeLinksMemCache($workSpaceId, $workSpaceType)
	{
		if($workSpaceId != NULL)
		{
			if($workSpaceId == 0)
			{
					$where = 'a.workspaces='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].'';
			}
			else
			{
					$where = 'a.workspaces = \''.$workSpaceId.'\' AND a.workSpaceType= '.$workSpaceType.'';
			}	
			
			//Memcache code start here
			$memc=$this->createMemcacheObject();
			if($workSpaceId==0)
			{
				$memCacheId = 'wp'.$workSpaceId.'links'.$workSpaceType.'my'.$_SESSION['userId'].'trees'.'place'.$_SESSION['workPlaceId'];	
			}
			else
			{
				$memCacheId = 'wp'.$workSpaceId.'links'.$workSpaceType.'trees'.'place'.$_SESSION['workPlaceId'];	
			}
			//$tree = $memc->get($memCacheId);	
			
			$q = 'select * from(SELECT a.id, a.name, a.type, b.artifactId, b.artifactType ,b.createdDate FROM teeme_tree a, teeme_links b WHERE '.$where.' AND a.id=b.treeId ORDER BY b.createdDate desc) t group by name';
			
				$query = $this->db->query($q);
				
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}	
				}
				
				$memc->set($memCacheId, $tree);
			}
	}
	
	public function updateFileLinksMemCache($workSpaceId, $workSpaceType)
	{
		if($workSpaceId != NULL)
		{
			if($workSpaceId == 0)
			{
					$whereExternal = 'a.workSpaceId='.$workSpaceId.' AND a.userId = '.$_SESSION['userId'].'';
			}
			else
			{
					$whereExternal = 'a.workSpaceId='.$workSpaceId.' AND a.workSpaceType= '.$workSpaceType.'';
			}	
						
			//Memcache code start here
			$memc=$this->createMemcacheObject();
			if($workSpaceId==0)
			{
				$memCacheId = 'wp'.$workSpaceId.'links'.$workSpaceType.'my'.$_SESSION['userId'].'files'.'place'.$_SESSION['workPlaceId'];	
			}
			else
			{
				$memCacheId = 'wp'.$workSpaceId.'links'.$workSpaceType.'files'.'place'.$_SESSION['workPlaceId'];
			}
			//$tree = $memc->get($memCacheId);	
					
			$q = 'select * from (SELECT a.docId, a.docName,a.path,  l.artifactId, l.artifactType ,l.createdDate FROM teeme_links_external l, teeme_external_docs a WHERE '.$whereExternal.' AND l.linkedDocId =a.docId ORDER BY l.createdDate desc) t group by docName ';	
			
				$query = $this->db->query($q);
				
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}	
				}
			
			$memc->set($memCacheId, $tree);	
			
		}
	}
	
	public function updateSpaceMembersMemCache($workSpaceId, $workSpaceType)
	{
		if($workSpaceId != NULL && $workSpaceId!=0)
		{
		
			//Memcache code start here
			$memc=$this->createMemcacheObject();
		
			if($workSpaceType == 1)
			{
					$memCacheId = 'wp'.$workSpaceId.'users1'.'place'.$_SESSION['workPlaceId'];
					
					$q = 'SELECT DISTINCT b.* FROM teeme_work_space_members a, teeme_users b WHERE a.workSpaceUserId = b.userId AND a.workSpaceId='.$workSpaceId.' ORDER BY firstName ASC';
			}
			else if($workSpaceType == 2)
			{
					$memCacheId = 'wp'.$workSpaceId.'users2'.'place'.$_SESSION['workPlaceId'];	
					
					$q = 'SELECT a.*,b.* FROM teeme_sub_work_space_members a, teeme_users b WHERE a.subWorkSpaceUserId = b.userId AND a.subWorkSpaceId='.$workSpaceId.' ORDER BY b.firstName ASC';
			}	
						
				$query = $this->db->query($q);
				
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}	
				}
			
				$memc->set($memCacheId, $tree);	
			
		}
	}
	
	public function updateTasksMemCache($workSpaceId, $workSpaceType, $treeId)
	{
		if($workSpaceId != NULL && $workSpaceId!=0)
		{
				//Memcache code start here
				$memc=$this->createMemcacheObject();
			
				$memCacheId = 'wp'.$workSpaceId.'tasks'.$workSpaceType.'place'.$_SESSION['workPlaceId'];
					
				$tree = $memc->get($memCacheId);

					foreach ($tree as $key=>$row)
					{
						if($row->treeIds == $treeId)
						{
							unset($tree[$key]);
						}
					}
					
					$where = 'd.workspaces  = \''.$workSpaceId.'\' AND d.workSpaceType= '.$workSpaceType.'';						
		
					$q = 'SELECT DISTINCT a.id, a.starttime , a.endtime , a.treeIds, b.contents, b.createdDate, b.editedDate, b.userId FROM teeme_node a, teeme_leaf b, teeme_notes_users c, teeme_tree d WHERE '.$where.' AND a.treeIds=d.id AND d.type=4 AND a.leafId=b.id AND a.id=c.notesId AND a.treeIds='.$treeId;				
						
					$q .= ' ORDER BY b.createdDate DESC';
					
					$query = $this->db->query($q);
						
					if($query->num_rows() > 0)
					{
						foreach ($query->result() as $row)
						{	
							$treeVal[] = $row;
						}	
					}
					
					$tree = array_merge($treeVal,$tree);
					
					foreach ($tree as $key => $node) {
						$timestamps[$key]=strtotime($node->editedDate) ;
					}
					array_multisort($timestamps, SORT_DESC, $tree);
					
					$memc->set($memCacheId, $tree);	
			
		}
	}
	
	public function updateAllMemCacheOnMoveTree($currentWorkSpaceId, $currentWorkSpaceType, $treeId, $workSpaceId, $workSpaceType, $userId)
	{
		//return $workSpaceId.'=='.$workSpaceType.'==='.$treeId;
		//Memcache Tree code start here
		$memc=$this->createMemcacheObject();
	
		if($currentWorkSpaceId != NULL && $currentWorkSpaceId!=0)
		{
				$memCacheId = 'wp'.$currentWorkSpaceId.'trees'.$currentWorkSpaceType.'place'.$_SESSION['workPlaceId'];
					
				$tree = $memc->get($memCacheId);

					foreach ($tree as $key=>$row)
					{
						if($row->id == $treeId)
						{
							unset($tree[$key]);
						}
					}
				
				$memc->set($memCacheId, $tree);	
		}
		
		if($workSpaceId!=0)
		{		
			$this->updateTreeMemCache($workSpaceId, $workSpaceType, $treeId);
		}
		//Memcache Tree code end here
		if($currentWorkSpaceId != NULL && $currentWorkSpaceId!=0)
		{		
				//Memcache Task code start here
				$memCacheId = 'wp'.$currentWorkSpaceId.'tasks'.$currentWorkSpaceType.'place'.$_SESSION['workPlaceId'];
					
				$tree = $memc->get($memCacheId);

					foreach ($tree as $key=>$row)
					{
						if($row->treeIds == $treeId)
						{
							unset($tree[$key]);
						}
					}
				
				$memc->set($memCacheId, $tree);
		}	
		
		if($workSpaceId!=0)
		{		
			$this->updateTasksMemCache($workSpaceId, $workSpaceType, $treeId);
		}
		
		//Memcache Task code end here
		if($currentWorkSpaceId != NULL && $currentWorkSpaceId!=0)
		{			
				//Memcache Talks code start here
				$memCacheId = 'wp'.$currentWorkSpaceId.'talks'.$currentWorkSpaceType.'place'.$_SESSION['workPlaceId'];
					
				$tree = $memc->get($memCacheId);

					foreach ($tree as $key=>$row)
					{
						if($row->parentTreeId == $treeId)
						{
							unset($tree[$key]);
						}
					}
				
				$memc->set($memCacheId, $tree);	
		}
				
		if($workSpaceId!=0)
		{
			$this->updateTalksMemCache($workSpaceId, $workSpaceType, $treeId);
		}
		//Memcache Talks code end here			
		
	}
	
	public function removeFilesMemCache($workSpaceId, $workSpaceType, $docId)
	{
		if($workSpaceId != NULL && $workSpaceId!=0)
		{
			$search = '';	
			//Memcache code start here
			$memc=$this->createMemcacheObject();

			$memCacheId = 'wp'.$workSpaceId.'files'.$workSpaceType.'place'.$_SESSION['workPlaceId'];
			
			$tree = $memc->get($memCacheId);							
			
			foreach ($tree as $key=>$row)
			{
				if($row->docId == $docId)
				{
					unset($tree[$key]);
				}
			}
				
			$memc->set($memCacheId, $tree);	
			
		}

	}
	//Update memcache data code end
	//Get all tree followers
	
	function getTreeFollowers($treeId)
	{		
	
		$userData 	= array();		
		$i = 0;
		if ($treeId>0 && $treeId!='')
		{
			$query 		= $this->db->query('SELECT user_id, object_id, object_instance_id, preference FROM teeme_notification_follow WHERE preference = 1 AND object_instance_id = '.$treeId.' AND object_id = 1');
			if($query->num_rows() > 0)
			{			
				foreach ($query->result() as $row)
				{						
					$userData[$i]['userId'] 		= $row->user_id;	
					$userData[$i]['object_id'] 		= $row->object_id;
					$userData[$i]['object_instance_id'] = $row->object_instance_id;	
					$userData[$i]['preference'] 	= $row->preference;
					$i++;					
				}				
			}			
			return $userData;	
		}	
	}
	
	
	function update_object_follow_details($objectFollowData)
	{	
		if($objectFollowData['user_id']!='' && $objectFollowData['object_id']!='' && $objectFollowData['preference']!='' && $objectFollowData['subscribed_date']!='' && $objectFollowData['object_instance_id']!='' && $objectFollowData['object_parent_instance_id']!='')
		{
		
				$setObjectFollowDetails = $this->db->query("UPDATE teeme_notification_follow SET `preference`='".$objectFollowData['preference']."', subscribed_date='".$objectFollowData['subscribed_date']."', object_instance_id='".$objectFollowData['object_instance_id']."' WHERE user_id ='".$objectFollowData['user_id']."' AND object_id ='".$objectFollowData['object_id']."' AND object_instance_id ='".$objectFollowData['object_parent_instance_id']."' AND preference ='1'");
				
				if($setObjectFollowDetails)
				{
					return true;
				}
				else
				{
					return false;
				}
			
		}
	}
	//Code end
	
	public function getWorkSpaceCreatorId($spaceId)
	{
		if($spaceId!=0 && $spaceId != '')
		{		
			$query = $this->db->query( "SELECT workSpaceCreatorId FROM teeme_work_space WHERE workSpaceId=".$spaceId);		
			if($query->num_rows() > 0)
			{
				$row=$query->row();
				return $row->workSpaceCreatorId;	
			}	
		}				
		return false;		
	}
	
	//Set document previous leaf tag(s)
		
	function addPreviousLeafTags($leafData)
	{
		$this->db->trans_begin();
	
		//Get tree tag details by parent leaf id start
		if($leafData['parent_leaf_id']!='' && $leafData['node_type']!='')
		{
		$query = 'SELECT a.tagId, a.tagType, a.tag, a.comments, a.ownerId, a.artifactId, a.artifactType, a.createdDate, a.startTime, a.endTime, a.sequenceTagId, a.sequenceOrder FROM teeme_tag a WHERE a.artifactId = '.$leafData['parent_leaf_id'].' AND a.artifactType = '.$leafData['node_type'].' AND a.tagType != 3';
		
		$query = $this->db->query($query);
		
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $prevTagData)
			{
			
				$tagData[] = "('{$prevTagData->tagType}', '{$prevTagData->tag}', '{$prevTagData->comments}', '{$prevTagData->ownerId}', '{$leafData['inserted_leaf_id']}', '{$prevTagData->artifactType}', '{$prevTagData->createdDate}', '{$prevTagData->startTime}', '{$prevTagData->endTime}', '{$prevTagData->sequenceTagId}', '{$prevTagData->sequenceOrder}')";
									
				$oldTagsData[] = array('tagId'=>$prevTagData->tagId,'tagType'=>$prevTagData->tagType);
				
				$i++;	
			}
		}
		
		//insert all type tag details
				
		$tagData = implode(", ", $tagData);
		
		if(!empty($tagData) && $tagData!='')
		{
		
			$query = "INSERT INTO teeme_tag(tagType, tag, comments, ownerId, artifactId, artifactType, createdDate, startTime, endtime, sequenceTagId, sequenceOrder ) VALUES
	{$tagData}";
			
			$query = $this->db->query($query);
			
			$row_inserted_count = $this->db->affected_rows();
			
			//Get all inserted tagids
			
			if($row_inserted_count>0)
			{
				$lastTagId = $this->db->insert_id();
				$lastTagIds[] = $this->db->insert_id();
				for($i=1; $i<$row_inserted_count; $i++)
				{
					$lastTagIds[] = $lastTagId+$i;
				}
			}
			//add tag details in leaf objects table for clear feature
			if(!empty($lastTagIds))
			{
				foreach($lastTagIds as $newTagIds)
				{
					$newTagData[] = "('{$leafData['inserted_leaf_id']}', 'tag', '{$newTagIds}')";
				}
				
				$newTagData = implode(", ", $newTagData);
				
				if(!empty($newTagData) && $newTagData!='')
				{
					$query = "INSERT INTO teeme_leaf_objects(leaf_id, object_type, object_id) VALUES {$newTagData}";
					
					$query = $this->db->query($query);
				}
			}
			//return $lastTagIds;
			
			//Get tagged details by tagid and insert start
			$arrTagDetails = array();
			/*foreach ($oldTagsData as $key => $oldTagData)
			{
				//Get simple action (todo) tag response and insert
				
				$query = 'SELECT a.tagId, a.comments, a.userId, a.status, a.selectedOption, a.createdDate FROM teeme_simple_tag a WHERE a.tagId = '.$oldTagData['tagId'].'';
	
				$query = $this->db->query($query);
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $tagData)
					{
						$todoSimpleTagValues[] = "('{$lastTagIds[$key]}', '{$tagData->comments}', '{$tagData->userId}', '{$tagData->status}', '{$tagData->selectedOption}', '{$tagData->createdDate}')";
						$i++;	
					}
				}
				
				//Get tagged users by tagid and insert start
				$query = 'SELECT a.tagId, a.userId, a.status FROM teeme_tagged_users a WHERE a.tagId = '.$oldTagData['tagId'].'';
	
				$query = $this->db->query($query);
				if($query->num_rows() > 0)
				{
					$i = 0;
					//$keys[] = $key;
					foreach ($query->result() as $tagData)
					{
						$taggedUsersValues[] = "('{$lastTagIds[$key]}', '{$tagData->userId}', '{$tagData->status}')";
						$i++;	
					}
				}
				
				//Get vote action tag details and insert
				$query = 'SELECT a.votingTopicId, a.tagId, a.votingTopic FROM teeme_vote_tag a WHERE a.tagId = '.$oldTagData['tagId'].'';
	
				$query = $this->db->query($query);
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $tagData)
					{
						$voteTagValues[] = "('{$lastTagIds[$key]}', '{$tagData->votingTopic}')";
						$i++;	
					}
				}
				
				//Get select action tag details and insert
				$query = 'SELECT a.selectionId, a.tagId, a.selectionOptions FROM teeme_selection_tag a WHERE a.tagId = '.$oldTagData['tagId'].'';
	
				$query = $this->db->query($query);
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $tagData)
					{
						$selectTagValues[] = "('{$lastTagIds[$key]}', '{$tagData->selectionOptions}')";
						$i++;	
					}
				}
				
				
			}
			
			//insert simple action todo tag details
			$todoSimpleTagValues = implode(", ", $todoSimpleTagValues);
			if(!empty($todoSimpleTagValues) && $todoSimpleTagValues!='')
			{
				$query = "INSERT INTO teeme_simple_tag(tagId, comments, userId, status, selectedOption, createdDate) VALUES {$todoSimpleTagValues}";
				$query = $this->db->query($query);
			}
			
			//insert tagged details with inserted tag id
			$taggedUsersValues = implode(", ", $taggedUsersValues);
			if(!empty($taggedUsersValues) && $taggedUsersValues!='')
			{
				$query = "INSERT INTO teeme_tagged_users(tagId, userId, status) VALUES {$taggedUsersValues}";
				$query = $this->db->query($query);
			}			
			//insert vote action tag details
			$voteTagValues = implode(", ", $voteTagValues);
			if(!empty($voteTagValues) && $voteTagValues!='')
			{
				$query = "INSERT INTO teeme_vote_tag(tagId, votingTopic) VALUES {$voteTagValues}";
				$query = $this->db->query($query);
			}
			//insert select action tag details
			$selectTagValues = implode(", ", $selectTagValues);
			if(!empty($selectTagValues) && $selectTagValues!='')
			{
				$query = "INSERT INTO teeme_selection_tag(tagId, selectionOptions) VALUES {$selectTagValues}";
				$query = $this->db->query($query);
			}*/			
			
			//Get tagged details by tagid and insert end		
		}
		
				if($tagData!='')
				{
					$query = "INSERT INTO teeme_leaf_objects(leaf_id, object_type, object_id) VALUES ('".$leafData['inserted_leaf_id']."', 'clear_tag', '0')";
					
					$query = $this->db->query($query);
				}
		
		}
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
	
	
	//Set document previous leaf link(s)
		
	function addPreviousLeafLinks($leafData)
	{
		$this->db->trans_begin();
		
		//Get tree link details by parent leaf id start
		if($leafData['parent_leaf_id']!='' && $leafData['node_type']!='')
		{
		$query = 'SELECT a.linkId, a.treeId, a.artifactId, a.artifactType, a.createdDate, a.ownerId FROM teeme_links a WHERE a.artifactId = '.$leafData['parent_leaf_id'].' AND a.artifactType = '.$leafData['node_type'].'';
		
		$query = $this->db->query($query);
		
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $linkData)
			{
			
				$linksData[] = "('{$linkData->treeId}', '{$leafData['inserted_leaf_id']}', '{$linkData->artifactType}', '{$linkData->createdDate}', '{$linkData->ownerId}')";
									
				$oldLinkData[] = array('linkId'=>$linkData->linkId);
				
				$i++;	
			}
		}
		
		$linksData = implode(", ", $linksData);
		
		if(!empty($linksData) && $linksData!='')
		{
			$query = "INSERT INTO teeme_links(treeId, artifactId, artifactType, createdDate, ownerId) VALUES {$linksData}";
			
			$query = $this->db->query($query);
			
			$link_row_inserted_count = $this->db->affected_rows();
			
			//Get all inserted tree link ids
			
			if($link_row_inserted_count>0)
			{
				$lastlinkId = $this->db->insert_id();
				$lastlinkIds[] = $this->db->insert_id();
				for($i=1; $i<$link_row_inserted_count; $i++)
				{
					$lastlinkIds[] = $lastlinkId+$i;
				}
			}
			if(!empty($lastlinkIds))
			{
				foreach($lastlinkIds as $treeLinkIds)
				{
					$treeLinksData[] = "('{$leafData['inserted_leaf_id']}', 'tree_link', '{$treeLinkIds}')";
				}
				
				$treeLinksData = implode(", ", $treeLinksData);
				
				if(!empty($treeLinksData) && $treeLinksData!='')
				{
					$query = "INSERT INTO teeme_leaf_objects(leaf_id, object_type, object_id) VALUES {$treeLinksData}";
					
					$query = $this->db->query($query);
				}
			}
		}
		//Get tree link details by parent leaf id end
		
		//Get external link details by parent leaf id start
		
		$query = 'SELECT a.linkId, a.linkedDocId, a.artifactId, a.artifactType, a.createdDate, a.ownerId FROM teeme_links_external a WHERE a.artifactId = '.$leafData['parent_leaf_id'].' AND a.artifactType = '.$leafData['node_type'].'';
		
		$query = $this->db->query($query);
		
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $extLinkData)
			{
			
				$extLinksData[] = "('{$extLinkData->linkedDocId}', '{$leafData['inserted_leaf_id']}', '{$extLinkData->artifactType}', '{$extLinkData->createdDate}', '{$extLinkData->ownerId}')";
									
				$oldExtLinkData[] = array('linkId'=>$extLinkData->linkId);
				
				$i++;	
			}
		}
		
		$extLinksData = implode(", ", $extLinksData);
		
		if(!empty($extLinksData) && $extLinksData!='')
		{
			$query = "INSERT INTO teeme_links_external(linkedDocId, artifactId, artifactType, createdDate, ownerId) VALUES {$extLinksData}";
			
			$query = $this->db->query($query);
			
			$link_row_inserted_count = $this->db->affected_rows();
			
			//Get all inserted tree link ids
			
			if($link_row_inserted_count>0)
			{
				$lastextlinkId = $this->db->insert_id();
				$lastextlinkIds[] = $this->db->insert_id();
				for($i=1; $i<$link_row_inserted_count; $i++)
				{
					$lastextlinkIds[] = $lastextlinkId+$i;
				}
			}
			if(!empty($lastextlinkIds))
			{
				foreach($lastextlinkIds as $docLinkIds)
				{
					$docLinksData[] = "('{$leafData['inserted_leaf_id']}', 'external_link', '{$docLinkIds}')";
				}
				
				$docLinksData = implode(", ", $docLinksData);
				
				if(!empty($docLinksData) && $docLinksData!='')
				{
					$query = "INSERT INTO teeme_leaf_objects(leaf_id, object_type, object_id) VALUES {$docLinksData}";
					
					$query = $this->db->query($query);
				}
			}
		}
		//Get external link details by parent leaf id end

		//Get external folder link details by parent leaf id start
		$query = 'SELECT a.linkId, a.linkedFolderId, a.artifactId, a.artifactType, a.createdDate, a.ownerId FROM teeme_links_folder a WHERE a.artifactId = '.$leafData['parent_leaf_id'].' AND a.artifactType = '.$leafData['node_type'].'';
		
		$query = $this->db->query($query);
		
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $extFolLinkData)
			{
			
				$extFolLinksData[] = "('{$extFolLinkData->linkedFolderId}', '{$leafData['inserted_leaf_id']}', '{$extFolLinkData->artifactType}', '{$extFolLinkData->createdDate}', '{$extFolLinkData->ownerId}')";
									
				$oldExtFolLinkData[] = array('linkId'=>$extFolLinkData->linkId);
				
				$i++;	
			}
		}
		
		$extFolLinksData = implode(", ", $extFolLinksData);
		
		if(!empty($extFolLinksData) && $extFolLinksData!='')
		{
			$query = "INSERT INTO teeme_links_folder(linkedFolderId, artifactId, artifactType, createdDate, ownerId) VALUES {$extFolLinksData}";
			
			$query = $this->db->query($query);
			
			$fol_link_row_inserted_count = $this->db->affected_rows();
			
			//Get all inserted tree link ids
			
			if($fol_link_row_inserted_count>0)
			{
				$lastextfollinkId = $this->db->insert_id();
				$lastextfollinkIds[] = $this->db->insert_id();
				for($i=1; $i<$fol_link_row_inserted_count; $i++)
				{
					$lastextfollinkIds[] = $lastextfollinkId+$i;
				}
			}
			if(!empty($lastextfollinkIds))
			{
				foreach($lastextfollinkIds as $docFolLinkIds)
				{
					$docFolLinksData[] = "('{$leafData['inserted_leaf_id']}', 'external_folder_link', '{$docFolLinkIds}')";
				}
				
				$docFolLinksData = implode(", ", $docFolLinksData);
				
				if(!empty($docFolLinksData) && $docFolLinksData!='')
				{
					$query = "INSERT INTO teeme_leaf_objects(leaf_id, object_type, object_id) VALUES {$docFolLinksData}";
					
					$query = $this->db->query($query);
				}
			}
		}
		//Get external folder link details by parent leaf id end
		
		//Get url link details by parent leaf id start
		
		$query = 'SELECT a.id, a.urlId, a.artifactId, a.artifactType, a.userId, a.appliedDate FROM teeme_applied_url a WHERE a.artifactId = '.$leafData['parent_leaf_id'].' AND a.artifactType = '.$leafData['node_type'].'';
		
		$query = $this->db->query($query);
		
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $urlLinkData)
			{
			
				$urlLinksData[] = "('{$urlLinkData->urlId}', '{$leafData['inserted_leaf_id']}', '{$urlLinkData->artifactType}', '{$urlLinkData->userId}', '{$urlLinkData->appliedDate}')";
									
				$oldUrlLinkData[] = array('id'=>$urlLinkData->id);
				
				$i++;	
			}
		}
		
		$urlLinksData = implode(", ", $urlLinksData);
		
		if(!empty($urlLinksData) && $urlLinksData!='')
		{
			$query = "INSERT INTO teeme_applied_url(urlId, artifactId, artifactType, userId, appliedDate) VALUES {$urlLinksData}";
			
			$query = $this->db->query($query);
			
			$link_row_inserted_count = $this->db->affected_rows();
			
			//Get all inserted tree link ids
			
			if($link_row_inserted_count>0)
			{
				$lasturllinkId = $this->db->insert_id();
				$lasturllinkIds[] = $this->db->insert_id();
				for($i=1; $i<$link_row_inserted_count; $i++)
				{
					$lasturllinkIds[] = $lasturllinkId+$i;
				}
			}
			if(!empty($lasturllinkIds))
			{
				foreach($lasturllinkIds as $urlLinkIds)
				{
					$linksUrlData[] = "('{$leafData['inserted_leaf_id']}', 'url_link', '{$urlLinkIds}')";
				}
				
				$linksUrlData = implode(", ", $linksUrlData);
				
				if(!empty($linksUrlData) && $linksUrlData!='')
				{
					$query = "INSERT INTO teeme_leaf_objects(leaf_id, object_type, object_id) VALUES {$linksUrlData}";
					
					$query = $this->db->query($query);
				}
			}
		}
				/*Changed by Dashrath- Add $extFolLinksData in if condition*/
				if($linksData!='' || $extLinksData!='' || $urlLinksData!='' || $extFolLinksData!='')
				{
					$query = "INSERT INTO teeme_leaf_objects(leaf_id, object_type, object_id) VALUES ('".$leafData['inserted_leaf_id']."', 'clear_link', '0')";
					
					$query = $this->db->query($query);
				}
		
		}
		//Get url link details by parent leaf id end
		
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
		
	}
	
	//Set document previous leaf talk(s)
		
	function addPreviousLeafTalks($leafData)
	{
		//Get tree talk details by parent leaf id start
		
		$this->db->trans_begin();
		
		if($leafData['oldTalkLeafTreeId']!='' && $leafData['currentTalkLeafTreeId']!='')
		{
		if($leafData['prevTalkActive']==1)
		{
			$query = $this->db->query("update teeme_leaf_tree set updates=updates+1 where tree_id=".$leafData['currentTalkLeafTreeId']);	
		}
		$query = 'SELECT a.id, a.predecessor, a.successors, a.leafId, a.tag, a.treeIds, a.nodeOrder, a.starttime, a.endtime, a.version, a.nodeTitle, a.viewCalendar, a.userId, a.workSpaceId, a.workSpaceType, a.chatSession FROM teeme_node a WHERE a.treeIds = '.$leafData['oldTalkLeafTreeId'].'';
		
		$query = $this->db->query($query);
		
		if($query->num_rows() > 0)
		{
			$i = 0;
			foreach($query->result() as $prevTalkNodeData)
			{
				$talkNodesData[] = "('{$prevTalkNodeData->predecessor}', '{$prevTalkNodeData->successors}', '{$prevTalkNodeData->leafId}', '{$prevTalkNodeData->tag}', '{$leafData['currentTalkLeafTreeId']}', '{$prevTalkNodeData->nodeOrder}', '{$prevTalkNodeData->starttime}', '{$prevTalkNodeData->endtime}', '{$prevTalkNodeData->version}', '{$prevTalkNodeData->nodeTitle}', '{$prevTalkNodeData->viewCalendar}', '{$prevTalkNodeData->userId}', '{$prevTalkNodeData->workSpaceId}', '{$prevTalkNodeData->workSpaceType}', '{$prevTalkNodeData->chatSession}')";
									
				$oldTalksNodeData[] = array('nodeId'=>$prevTalkNodeData->id);
				
				$i++;	
			}
		}
		//return $talkNodesData;
		//insert all type node talk details
				
		$talkNodesData = implode(", ", $talkNodesData);
		
		if(!empty($talkNodesData) && $talkNodesData!='')
		{
		
			$query = "INSERT INTO teeme_node(predecessor, successors, leafId, tag, treeIds, nodeOrder, starttime, endtime, version, nodeTitle, viewCalendar, userId, workSpaceId, workSpaceType, chatSession) VALUES {$talkNodesData}";
			
			$query = $this->db->query($query);
			
			$row_inserted_count = $this->db->affected_rows();
			
			//Get all inserted node Ids
			
			if($row_inserted_count>0)
			{
				$lastNodeTalkId = $this->db->insert_id();
				$lastNodeTalkIds[] = $this->db->insert_id();
				for($i=1; $i<$row_inserted_count; $i++)
				{
					$lastNodeTalkIds[] = $lastNodeTalkId+$i;
				}
			}
			//add talk leaf node object details for clear feature
			if(!empty($lastNodeTalkIds))
			{
				foreach($lastNodeTalkIds as $newTalkIds)
				{
					$newTalkData[] = "('{$leafData['currentTalkLeafTreeId']}', 'talk', '{$newTalkIds}')";
				}
				
				$newTalkData = implode(", ", $newTalkData);
				
				if(!empty($newTalkData) && $newTalkData!='')
				{
					$query = "INSERT INTO teeme_leaf_objects(leaf_id, object_type, object_id) VALUES {$newTalkData}";
					
					$query = $this->db->query($query);
				}
			}
			
			//Get leaf talk details by nodeid and insert start
			$arrNodeTalkDetails = array();
			foreach ($oldTalksNodeData as $key => $oldTalkNodeData)
			{
				$query = 'SELECT a.id, a.leafParentId, a.type, a.authors, a.status, a.userId, a.createdDate, a.editedDate, a.contents, a.latestContent, a.version, a.lockedStatus, a.userLocked, a.nodeId, a.newVersionLeafId FROM teeme_leaf a WHERE a.nodeId = '.$oldTalkNodeData['nodeId'].'';
	
				$query = $this->db->query($query);
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $leafTalkData)
					{
						$leafTalkValues[] = "('{$leafTalkData->leafParentId}', '{$leafTalkData->type}', '{$leafTalkData->authors}', '{$leafTalkData->status}', '{$leafTalkData->userId}', '{$leafTalkData->createdDate}', '{$leafTalkData->editedDate}', '{$leafTalkData->contents}', '{$leafTalkData->latestContent}', '{$leafTalkData->version}', '{$leafTalkData->lockedStatus}', '{$leafTalkData->userLocked}', '{$lastNodeTalkIds[$key]}', '{$leafTalkData->newVersionLeafId}')";
						$i++;	
					}
				}
			 }
			 
			 //insert talk leaf details with inserted node id
			$leafTalkValues = implode(", ", $leafTalkValues);
			if(!empty($leafTalkValues) && $leafTalkValues!='')
			{
				$query = "INSERT INTO teeme_leaf(leafParentId, type, authors, status, userId, createdDate, editedDate, contents, latestContent, version, lockedStatus, userLocked, nodeId, newVersionLeafId) VALUES {$leafTalkValues}";
				$query = $this->db->query($query);
				
				$leaf_row_inserted_count = $this->db->affected_rows();
			
				//Get all inserted leaf talk ids
				
				if($leaf_row_inserted_count>0)
				{
					$lastLeafTalkId = $this->db->insert_id();
					$lastLeafTalkIds[] = $this->db->insert_id();
					for($i=1; $i<$leaf_row_inserted_count; $i++)
					{
						$lastLeafTalkIds[] = $lastLeafTalkId+$i;
					}
				}
				
			}
			
			//update node table for leaf id
			if(!empty($lastNodeTalkIds))
			{
				foreach ($lastNodeTalkIds as $key => $lastNodeTalkId)
				{
					//$test[] = $key.'==='.$lastNodeTalkId;
					$nodeTalkUpdateQry .= ' when id = "'.$lastNodeTalkId.'" then "'.$lastLeafTalkIds[$key].'"';
				}
				if(!empty($nodeTalkUpdateQry) && $nodeTalkUpdateQry!='' && $leafData['currentTalkLeafTreeId']!='')
				{
					$query = 'UPDATE teeme_node SET leafId = (case '.$nodeTalkUpdateQry.' end) WHERE treeIds = "'.$leafData['currentTalkLeafTreeId'].'"';
					$query = $this->db->query($query);
				}
			}
		}
		
				if($talkNodesData!='')
				{
					$query = "INSERT INTO teeme_leaf_objects(leaf_id, object_type, object_id) VALUES ('".$leafData['currentTalkLeafTreeId']."', 'clear_talk', '0')";
					
					$query = $this->db->query($query);
				}
				if($leafData['workSpaceId']!='' && $leafData['workSpaceType']!='' && $leafData['currentTalkLeafTreeId']!='' && $talkNodesData!='')
				{
					$this->updateTalksMemCache($leafData['workSpaceId'],$leafData['workSpaceType'],$leafData['currentTalkLeafTreeId']);
				}
		}
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
	
	//Clear link leaf objects start
	function clearLinkLeafObjects($linkObjectData)
	{
		$this->db->trans_begin();
		if($linkObjectData['objectType']!='' && $linkObjectData['leafId']!='')
		{
			//Tree link clear code
			$query = 'SELECT leaf_id, object_type, object_id FROM teeme_leaf_objects WHERE leaf_id = '.$linkObjectData['leafId'].' And object_type="tree_link"';
			
			$query = $this->db->query($query);
			
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeLinkObjectData)
				{
					$treeLeafObjectIds[] = $treeLinkObjectData->object_id;
					$i++;	
				}
				$treeLeafObjectIds = implode(", ", $treeLeafObjectIds);
				//return $treeLeafObjectIds;
				if(!empty($treeLeafObjectIds) && $treeLeafObjectIds!='')
				{
					$query = "DELETE FROM teeme_links WHERE linkId in($treeLeafObjectIds)";
					$query = $this->db->query($query);
				}
			}
			
			//External link clear code
			$query = 'SELECT leaf_id, object_type, object_id FROM teeme_leaf_objects WHERE leaf_id = '.$linkObjectData['leafId'].' And object_type="external_link"';
			
			$query = $this->db->query($query);
			
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $extLinkObjectData)
				{
					$extLeafObjectIds[] = $extLinkObjectData->object_id;
					$i++;	
				}
				$extLeafObjectIds = implode(", ", $extLeafObjectIds);
				//return $treeLeafObjectIds;
				if(!empty($extLeafObjectIds) && $extLeafObjectIds!='')
				{
					$query = "DELETE FROM teeme_links_external WHERE linkId in($extLeafObjectIds)";
					$query = $this->db->query($query);
				}
			}

			//External folder link clear code start
			$query = 'SELECT leaf_id, object_type, object_id FROM teeme_leaf_objects WHERE leaf_id = '.$linkObjectData['leafId'].' And object_type="external_folder_link"';
			
			$query = $this->db->query($query);
			
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $extLinkObjectData1)
				{
					$extLeafObjectIds1[] = $extLinkObjectData1->object_id;
					$i++;	
				}
				$extLeafObjectIds1 = implode(", ", $extLeafObjectIds1);
				//return $treeLeafObjectIds;
				if(!empty($extLeafObjectIds1) && $extLeafObjectIds1!='')
				{
					$query = "DELETE FROM teeme_links_folder WHERE linkId in($extLeafObjectIds1)";
					$query = $this->db->query($query);
				}
			}
			//External folder link clear code end
			
			//Url link clear code
			$query = 'SELECT leaf_id, object_type, object_id FROM teeme_leaf_objects WHERE leaf_id = '.$linkObjectData['leafId'].' And object_type="url_link"';
			
			$query = $this->db->query($query);
			
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $urlLinkObjectData)
				{
					$urlLeafObjectIds[] = $urlLinkObjectData->object_id;
					$i++;	
				}
				$urlLeafObjectIds = implode(", ", $urlLeafObjectIds);
				//return $treeLeafObjectIds;
				if(!empty($urlLeafObjectIds) && $urlLeafObjectIds!='')
				{
					$query = "DELETE FROM teeme_applied_url WHERE id in($urlLeafObjectIds)";
					$query = $this->db->query($query);
				}
			}
			
			
			$query = "UPDATE teeme_leaf_objects SET object_id = '1' WHERE leaf_id = '".$linkObjectData['leafId']."' AND object_type = 'clear_link'";
			$query = $this->db->query($query);
			
			
		}
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
	
	//Clear tag leaf objects start
	function clearTagLeafObjects($tagObjectData)
	{
		$this->db->trans_begin();
		if($tagObjectData['objectType']!='' && $tagObjectData['leafId']!='')
		{
			//Tree link clear code
			$query = 'SELECT leaf_id, object_type, object_id FROM teeme_leaf_objects WHERE leaf_id = '.$tagObjectData['leafId'].' And object_type="tag"';
			
			$query = $this->db->query($query);
			
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeTagObjectData)
				{
					$treeLeafObjectIds[] = $treeTagObjectData->object_id;
					$i++;	
				}
				$treeLeafObjectIds = implode(", ", $treeLeafObjectIds);
				//return $treeLeafObjectIds;
				if(!empty($treeLeafObjectIds) && $treeLeafObjectIds!='')
				{
					$query = "DELETE FROM teeme_tag WHERE tagId in($treeLeafObjectIds)";
					$query = $this->db->query($query);
				}
			}
			
			$query = "UPDATE teeme_leaf_objects SET object_id = '1' WHERE leaf_id = '".$tagObjectData['leafId']."' AND object_type = 'clear_tag'";
			$query = $this->db->query($query);
			
			
		}
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
	
	//Clear talk leaf objects start
	function clearTalkLeafObjects($talkObjectData)
	{
		$this->db->trans_begin();
		if($talkObjectData['objectType']!='' && $talkObjectData['leafId']!='')
		{
			//Tree talk clear code
			$query = 'SELECT leaf_id, object_type, object_id FROM teeme_leaf_objects WHERE leaf_id = '.$talkObjectData['leafId'].' And object_type="talk"';
			
			$query = $this->db->query($query);
			
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeTalkObjectData)
				{
					$treeLeafObjectIds[] = $treeTalkObjectData->object_id;
					$i++;	
				}
				$treeLeafObjectIds = implode(", ", $treeLeafObjectIds);
				//return $treeLeafObjectIds;
				if(!empty($treeLeafObjectIds) && $treeLeafObjectIds!='')
				{
					$query = "DELETE FROM teeme_node WHERE id in($treeLeafObjectIds)";
					$query = $this->db->query($query);
					if($query)
					{
						$query = "DELETE FROM teeme_leaf WHERE nodeId in($treeLeafObjectIds)";
						$query = $this->db->query($query);
					}
				}
			}
			
			$query = "UPDATE teeme_leaf_objects SET object_id = '1' WHERE leaf_id = '".$talkObjectData['leafId']."' AND object_type = 'clear_talk'";
			$query = $this->db->query($query);
			
			
		}
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}

	function getLeafClearStatus($leafId,$objectType)
	{
		$object_id = '';
		if($leafId!='' && $objectType != '')
		{
			$query = '';
			if($objectType == 'clear_link')
			{
				$query = "SELECT object_id FROM teeme_leaf_objects WHERE leaf_id='".$leafId."' AND object_type = 'clear_link'";	
			}
			else if($objectType == 'clear_tag')
			{
				$query = "SELECT object_id FROM teeme_leaf_objects WHERE leaf_id='".$leafId."' AND object_type = 'clear_tag'";	
			}
			else if($objectType == 'clear_talk')
			{
				$query = "SELECT object_id FROM teeme_leaf_objects WHERE leaf_id='".$leafId."' AND object_type = 'clear_talk'";	
			}
			$query = $this->db->query($query);
			if($query->num_rows()> 0)
			{
				foreach($query->result() as $row)
				{
					$object_id = $row->object_id;
				}
			}	
			return $object_id;	
		}
	}
	//Clear draft tag(s), link(s) and talk(s)
	function clearAllLeafObjects($objectData)
	{
		$this->db->trans_begin();
		if($objectData['nodeId']!='')
		{
				$query1 = "DELETE FROM teeme_links WHERE artifactId = '".$objectData['nodeId']."' AND artifactType=2";
				$query1 = $this->db->query($query1);
			
				$query2 = "DELETE FROM teeme_links_external WHERE artifactId = '".$objectData['nodeId']."' AND artifactType=2";
				$query2 = $this->db->query($query2);
				
				$query3 = "DELETE FROM teeme_applied_url WHERE artifactId = '".$objectData['nodeId']."' AND artifactType=2";
				$query3 = $this->db->query($query3);
				
				$query4 = "DELETE FROM teeme_tag WHERE artifactId = '".$objectData['nodeId']."' AND artifactType=2";
				$query4 = $this->db->query($query4);
		}
		if($objectData['leafTreeId']!='')
		{				
				//Talk clear leaf object(s)
				$query = 'SELECT id FROM teeme_node WHERE treeIds = '.$objectData['leafTreeId'].'';
			
				$query = $this->db->query($query);
				
				if($query->num_rows() > 0)
				{
					$i = 0;
					foreach ($query->result() as $treeTalkObjectData)
					{
						$treeLeafObjectIds[] = $treeTalkObjectData->id;
						$i++;	
					}
					$treeLeafObjectIds = implode(", ", $treeLeafObjectIds);
					//return $treeLeafObjectIds;
					if(!empty($treeLeafObjectIds) && $treeLeafObjectIds!='')
					{
						$query = "DELETE FROM teeme_node WHERE id in($treeLeafObjectIds)";
						$query = $this->db->query($query);
						if($query)
						{
							$query = "DELETE FROM teeme_leaf WHERE nodeId in($treeLeafObjectIds)";
							$query = $this->db->query($query);
						}
					}
				}	
				//Talk code end
		}
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
	
	//Get all leaf id(s) by tree id
	public function getAllLeafIdsByTreeId($treeId)
	{
		if($treeId != '')
		{
			$arrIdDetails = array();
			if($treeId != NULL)
			{
				$query = 'SELECT a.id as leafId, a.userId as userId FROM teeme_leaf a, teeme_node b WHERE b.treeIds='.$treeId.' AND b.id = a.nodeId';
				$query = $this->db->query($query);
				if($query->num_rows() > 0)
				{		
					$i=0;		
					foreach ($query->result() as $leafData)
					{	
						$arrIdDetails[$i]['leafId'] = $leafData->leafId;	
						$arrIdDetails[$i]['userId'] = $leafData->userId;
						$i++;							
					}
				}
			}
	
			return $arrIdDetails;
		}
	}
	//Changed leaf originator for reservation icon
	public function changeLeafOriginatorId($leafId,$userId)
	{
		if($leafId!='' && $userId!='')
		{
			$this->db->trans_begin();
			
			$query = 'UPDATE teeme_leaf SET userId='.$userId.' WHERE id='.$leafId.'';
			
			$query = $this->db->query($query);
			
			if($this->db->trans_status()=== FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return true;
			}
		}
	}
	
		//Add Notes Tree Type Configuration
	function addTreeTypeConfiguration($treeTypeDetails)
	{
		if($treeTypeDetails['allowStatus']!='' && $treeTypeDetails['treeType']!='')
		{
			$query = $this->db->query('SELECT id FROM teeme_configuration WHERE treeTypeId="'.$treeTypeDetails['treeType'].'"');
			if($query->num_rows()> 0)
			{
				$q = $this->db->query("UPDATE teeme_configuration SET `allowStatus`='".$treeTypeDetails['allowStatus']."' WHERE treeTypeId='".$treeTypeDetails['treeType']."'");
			}
			if($q){
				return 1;
			}
			else{
				return 0;
			}
		}
	}
	
	function getTreeTypeConfiguration($treeType)
	{
		if($treeType!='')
		{
			$query = $this->db->query('SELECT allowStatus, treeTypeId FROM teeme_configuration WHERE treeTypeId="'.$treeType.'"');	
			
			$arrDetails = array();	
			if($query->num_rows()> 0)
			{
				foreach($query->result() as $row)
				{
					$arrDetails['allowStatus'] 	= $row->allowStatus;
					$arrDetails['treeTypeId'] 	= $row->treeTypeId;
				}	
			}	
			return $arrDetails;
		}	
	}
	//Delete contributors if removed from tree shared
	public function deleteNotesUsersFromShared($notesId,$userId)
	{
		if($notesId!='' && $userId!='')
		{
			$strResultSQL = "DELETE FROM teeme_notes_users WHERE notesId='".$notesId."' AND userId='".$userId."'";
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
	
	//Check tree move status
	public function getWorkspaceIdByTreeId($treeId)
	{
		if($treeId!='')
		{
			$query = $this->db->query('select workspaces from teeme_tree WHERE id='.$treeId);	
									
			foreach($query->result() as $row)
			{
				$spaceId = $row->workspaces;
			}		
			return $spaceId;
		}
	}
	
	function getLeafReservedUsers($leafId)
	{		
		$userData 	= array();		
		$i = 0;
		if ($leafId>0 && $leafId!='')
		{
			$query 		= $this->db->query('SELECT b.tagName, b.nickName, a.userId, b.userGroup FROM teeme_leaf_reservation a, teeme_users b WHERE a.userId = b.userId AND a.leafId = '.$leafId.' AND a.status = 1 ORDER BY b.tagName');
			if($query->num_rows() > 0)
			{			
				foreach ($query->result() as $row)
				{						
					$userData[$i]['userId'] 		= $row->userId;	
					$userData[$i]['userGroup'] 	= $row->userGroup;
					if($row->nickName!='')
					{
						$userData[$i]['userTagName'] 	= $row->nickName;	
					}
					else
					{
						$userData[$i]['userTagName'] 	= $row->tagName;
					}		
					$i++;					
				}				
			}			
			return $userData;	
		}	
		return 0;
	}
	
	public function getReservedUsersListByParentId($treeId,$nodeId)
	{
		if($treeId!='' && $nodeId!='')
		{
			$nodeOrder = $this->getNodePositionByNodeId($nodeId);
			$leafData  =  $this->getLeafIdByNodeId($nodeId);
			$leafId = $leafData['id'];
			if($leafId!='')
			{
				$query1 = 'SELECT leafStatus FROM teeme_leaf WHERE id = "'.$leafId.'"';	
					
				$query1 = $this->db->query($query1);							
					
				foreach($query1->result() as $row1)
				{
					$leafStatus = $row1->leafStatus;
				}
			}
			
			//
				if($nodeOrder != '' && $leafStatus=='draft')
				{
		
					$query = 'SELECT a.leafStatus, a.userId, b.leafId, b.id FROM teeme_leaf a, teeme_node b WHERE b.treeIds='.$treeId .' AND b.nodeOrder='.$nodeOrder.' AND b.leafId = a.id AND b.predecessor=0 LIMIT 0,1';	
					
					$query = $this->db->query($query);							
					
					foreach($query->result() as $row)
					{
						$parentLeafId = $row->leafId;
					}
					$resUserIds = array();
					$reservedUsers 	= $this->getLeafReservedUsers($parentLeafId);
					if(count($reservedUsers)>0)
					{
						
						foreach($reservedUsers  as $resUserData)
						{
							$resUserIds[] = $resUserData['userId']; 
						}
						
					}
					return $resUserIds;
				}
			//
			
		}
	}
	
	public function checkLeafNewVersion($nodeId)
	{

		$query = $this->db->query( "SELECT successors FROM teeme_node where id= ".$nodeId);		

		if($query->num_rows() > 0)
		{

			foreach ($query->result() as $row)

			{

				if(trim($row->successors))
				{
					return trim($row->successors);
				}
				else
				{
					return 0;
				}

			}

		}
		else
		{
			return 0;
		}

	}
	
	//Remove tree shared status
	
	public function removeTreeSharedStatus($treeId)
	{
		$query = "UPDATE teeme_tree SET isShared=0 WHERE id='".$treeId."'";
		$result = $this->db->query($query);
		
		if($result)
		{
			return true;
		}		
		else
		{
			return false;
		}	
	}
	
	//Code end

	//Added by Dashrath : code start
	public function copyLeaf($leafId, $type='copy')
	{
		$leafData = array('leaf_id' => $leafId, 'type' => $type);
		$copyKey = 'leafBy_'.$_SESSION['userId'];
        $_SESSION[$copyKey] = $leafData;
		return true;	

	}
	// Dashrath : code end

	//Added by Dashrath : code start
	public function moveLeaf($leafId, $type='move')
	{
		$leafData = array('leaf_id' => $leafId, 'type' => $type);
		$copyKey = 'leafBy_'.$_SESSION['userId'];
        $_SESSION[$copyKey] = $leafData;
		return true;	

	}
	// Dashrath : code end

	//Added by Dashrath : code start
	public function getLeafData()
	{
		$copyKey = 'leafBy_'.$_SESSION['userId'];
		$copyLeafId = $_SESSION[$copyKey];
		return $copyLeafId;	

	}
	// Dashrath : code end

    //Added by Dashrath : code start
	public function clearLeafData()
	{
		$leafData = array();
		$copyKey = 'leafBy_'.$_SESSION['userId'];
        $_SESSION[$copyKey] = $leafData;
	}
	// Dashrath : code end

	//Added by Dashrath : code start
	public function updateNodeOrder($leafId, $treeId, $currentNodeOrder, $moveNodeOrder)

	{		
		$increment = 1;
		$decrement = 1;

		$nodeArrayDetails = array();

		if($currentNodeOrder > $moveNodeOrder)
		{
			$moveNodeOrder = $moveNodeOrder + 1;
			// $updateResult1  = $this->db->query('UPDATE teeme_node SET nodeOrder=nodeOrder+'.$increment.' WHERE treeIds='.$treeId.' AND nodeOrder>='.$moveNodeOrder.' AND nodeOrder<'.$currentNodeOrder);

			//get node ids for used in update query
			$query = $this->db->query('SELECT id, predecessor, leafId FROM teeme_node WHERE treeIds='.$treeId.' AND nodeOrder>='.$moveNodeOrder.' AND nodeOrder<'.$currentNodeOrder.' AND successors=0');

			$updateResult1  = $this->db->query('UPDATE teeme_node SET nodeOrder=nodeOrder+'.$increment.' WHERE treeIds='.$treeId.' AND nodeOrder>='.$moveNodeOrder.' AND nodeOrder<'.$currentNodeOrder.' AND successors=0');

		}else{
			// $updateResult1  = $this->db->query('UPDATE teeme_node SET nodeOrder=nodeOrder-'.$decrement.' WHERE treeIds='.$treeId.' AND nodeOrder<='.$moveNodeOrder.' AND nodeOrder>'.$currentNodeOrder);

			//get node ids for used in update query
			$query = $this->db->query('SELECT id, predecessor, leafId FROM teeme_node WHERE treeIds='.$treeId.' AND nodeOrder<='.$moveNodeOrder.' AND nodeOrder>'.$currentNodeOrder.' AND successors=0');

			$updateResult1  = $this->db->query('UPDATE teeme_node SET nodeOrder=nodeOrder-'.$decrement.' WHERE treeIds='.$treeId.' AND nodeOrder<='.$moveNodeOrder.' AND nodeOrder>'.$currentNodeOrder.' AND successors=0');
		}

		foreach($query->result() as $row)
		{
			$node['id'] = $row->id;
			$node['predecessor'] = $row->predecessor;
			$node['leafId'] = $row->leafId;

			$nodeArrayDetails[] = $node;
		}

		
		$updateResult2  = $this->db->query('UPDATE teeme_node SET nodeOrder='.$moveNodeOrder.' WHERE treeIds='.$treeId.' AND leafId='.$leafId);

		$query1 = $this->db->query('SELECT id, predecessor, leafId FROM teeme_node WHERE treeIds='.$treeId.' AND leafId='.$leafId);

		$node1 = array();
		foreach($query1->result() as $row)
		{
			$node1['id'] = $row->id;
			$node1['predecessor'] = $row->predecessor;
			$node1['leafId'] = $row->leafId;

			if($node1['predecessor']>0)
			{
				$count = count($nodeArrayDetails);
				if($count>0)
				{
					$nodeArrayDetails[$count] = $node1;
				}
				else
				{
					$nodeArrayDetails[] = $node1;
				}
			}
		}

		//this query used for get node count according leaf
		$query2 = $this->db->query('SELECT COUNT(id) AS totalNode FROM teeme_node WHERE treeIds='.$treeId);
		if($query2->num_rows() > 0)
		{
			foreach($query2->result() as $row)
			{
				
				$totalNode = $row->totalNode;
														
			}				
		}
		else{
			$totalNode = 0;
		}	

		//this loop used for update predecessor
		foreach ($nodeArrayDetails as $value) {
			
			if($value['predecessor']>0)
			{

				$this->updatePredecssorLeafNodeOrder($value['id'], $value['predecessor'], $value['leafId'], $treeId);
				// $_SESSION['id_val_node_order'.$treeId] = $value['id'];
				// $_SESSION['predecessor_val_node_order'.$treeId] = $value['predecessor'];
				// $_SESSION['leafId_val_node_order'.$treeId] = $value['leafId'];

				// for($i=0; $i<$totalNode; $i++)
				// {
				// 	if($_SESSION['predecessor_val_node_order'.$treeId]>0)
				// 	{
				// 		$this->updatePredecssorLeafNodeOrder($_SESSION['id_val_node_order'.$treeId], $_SESSION['predecessor_val_node_order'.$treeId], $_SESSION['leafId_val_node_order'.$treeId], $treeId);
				// 	}
				// 	else
				// 	{
				// 		break;
				// 	}
				// }
			}
		}



		//update memcache value
		$this->load->model('dal/identity_db_manager');
		$memc=$this->identity_db_manager->createMemcacheObject();
		$this->load->model('dal/document_db_manager');
		$memCacheId = 'wp'.$_SESSION['workPlaceId'].'doc'.$treeId;
		$tree = $this->document_db_manager->getDocumentFromDB($treeId);
		$memc->set($memCacheId, $tree, MEMCACHE_COMPRESSED);


		if($updateResult1 && $updateResult2)
		{									
			return true;
		}	
		else
		{
			return false;
		}				

	}
	// Dashrath : code end

	//Added by Dashrath : code start
	function updatePredecssorLeafNodeOrder($id, $predecessor, $leafId, $treeId)
	{
		$updateNodeOrder = $this->getNodeOrderByLeafId($leafId);
		$updateNodeOrder = $updateNodeOrder['nodeOrder'];

		$updateResult  = $this->db->query('UPDATE teeme_node SET nodeOrder='.$updateNodeOrder.' WHERE treeIds='.$treeId.' AND id='.$predecessor);


		$query = $this->db->query('SELECT id, predecessor, leafId FROM teeme_node WHERE treeIds='.$treeId.' AND id='.$predecessor);

		$node = array();
		foreach($query->result() as $row)
		{
			$node['id'] = $row->id;
			$node['predecessor'] = $row->predecessor;
			$node['leafId'] = $row->leafId;
		}

		if($node['predecessor']>0)
		{

			$this->updatePredecssorLeafNodeOrder($node['id'], $node['predecessor'],$node['leafId'],$treeId);
			// $_SESSION['id_val_node_order'.$treeId] = $node['id'];
			// $_SESSION['predecessor_val_node_order'.$treeId] = $node['predecessor'];
			// $_SESSION['leafId_val_node_order'.$treeId] = $node['leafId'];
		}
		else
		{
			// $_SESSION['id_val_node_order'.$treeId] = '';
			// $_SESSION['predecessor_val_node_order'.$treeId] = '';
			// $_SESSION['leafId_val_node_order'.$treeId] = '';
			return $predecessor;
		}

		
	}
	// Dashrath : code end

	//Added by Dashrath : code start
	public function getNodeOrderByLeafId($leafId)
	{
		$node = array();		

		$query = $this->db->query('SELECT nodeOrder FROM teeme_node	 WHERE leafId='.$leafId);

		foreach($query->result() as $row)
		{
			$node['nodeOrder'] = $row->nodeOrder;
		}	
		return $node;	
	}
	// Dashrath : code end

	// Dashrath: start code
	public function deleteLeaf($leafId)
	{	
		$dResult  = $this->db->query('UPDATE teeme_leaf SET leafStatus="deleted" WHERE id='.$leafId);			
		if($dResult)
		{									
			return true;
		}	
		else
		{
			return false;
		}				

	}
	// Dashrath : code end

	// Dashrath: start code
	public function getWorkspaceIdAndTypeByTreeId($treeId)
	{
		if($treeId!='')
		{
			$query = $this->db->query('select workspaces, workSpaceType from teeme_tree WHERE id='.$treeId);	
			
			$treeData = array();

			foreach($query->result() as $row)
			{
				$treeData['workSpaceId'] = $row->workspaces;
				$treeData['workSpaceType'] = $row->workSpaceType;
			}		
			return $treeData;
		}
	}
	// Dashrath : code end

	//Added by Dashrath : code start
	public function getFilesByFolderId($folderId, $workSpaceId, $workSpaceType, $orderType, $addCaption=0)
	{
		$arrDocDetails = array();		

		$userId 	   = $_SESSION['userId'];
		
			if ($orderType=='alphabetical')
			{
				$orderBy = ' ORDER BY a.docCaption ASC';
			}
			else if ($orderType=='reverse_alphabetical')
			{
				$orderBy = ' ORDER BY a.docCaption DESC';
			}
			else if ($orderType=='chronological')
			{
				$orderBy = ' ORDER BY a.createdDate ASC';
			}
			else if ($orderType=='order_ascending')
			{
				$orderBy = ' ORDER BY a.file_order ASC';
			}
			else if ($orderType=='order_descending')
			{
				$orderBy = ' ORDER BY a.file_order DESC';
			}
			else
			{			
				$orderBy = ' ORDER BY a.createdDate DESC';
			}
		$baseUrl 	   = base_url();
		$baseUrlArray  = explode("/", $baseUrl);
	
		if($workSpaceId == 0)
		{	
			$q = 'SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND  a.workSpaceId=0 AND a.userId='.$userId.' AND a.folderId='.$folderId.$orderBy;
			$query = $this->db->query($q);
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$tree[] = $row;
					}
				}
		}
		else	
		{
			$tree=array();
			$q = 'SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.folderId='.$folderId.$orderBy;
			$query = $this->db->query($q);
			
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$tree[] = $row;
				}
			}
		}

		//echo "query= " .$q; exit;
		if(count($tree) > 0)
		{
			$i = 0;
			foreach ($tree as $docData)
			{	
				
				$fileName 	 = $docData->docName;

				// Generate new random name.
		  		// $name = sha1(microtime()) . "_" .$fileName;
		  		$fileNameArray = explode('.', $fileName);

		  		$currentDate = date("Y-m-d",time());
		  		$currentTime = date("H:i:s");
		  		$currentDateTime = str_replace('-', '', $currentDate).str_replace(':', '', $currentTime);

		  		$name = $fileNameArray[0]."_".$currentDateTime.'.'.$fileNameArray[count($fileNameArray)-1];

				//file current path
				$currentPath = "workplaces/".$_COOKIE['place']."/".$docData->path."/";
				//file copy path
				$copyPath    = "workplaces/".$_COOKIE['place']."/editor_uploads/";

				//file copy
				copy($currentPath.$fileName, $copyPath.$name);

				//get file extension
				$extension = $this->getFileExtension($fileName);
				$extension = strtolower($extension);

				//image file extension
				$imageAllowedExts = array("gif", "jpeg", "jpg", "png");

				//video file extension
				$videoAllowedExts = array("mp4", "avi","flv","wmv","mov");

				//audio file extension
				$audioAllowedExts = array("mp3", "m4a", "aac", "oga");

				//file extension
				$fileAllowedExts = array("txt", "pdf", "csv", "doc", "docx", "xls", "xlsx", "ppt", "odt", "pptx", "xps", "docm", "dotm", "dotx", "dot", "xlsm", "xlsb", "xlw", "pot", "pptm", "pub", "rtf");


				$fileTypeImagePath = '';

				$basePath1 = '/images/default-file-icons/';

				if($extension == "txt")
				{
					$fileTypeImagePath = $basePath1.'txt_default.png';
				}
				else if($extension == "pdf")
				{
					$fileTypeImagePath = $basePath1.'pdf_default.png';
				}
				else if($extension == "csv")
				{
					$fileTypeImagePath = $basePath1.'csv_default.png';
				}
				else if($extension == "doc" || $extension == "docx")
				{
					$fileTypeImagePath = $basePath1.'doc_default.png';
				}
				else if($extension == "xls" || $extension == "xlsx")
				{
					$fileTypeImagePath = $basePath1.'xls_default.png';
				}
				else if($extension == "ppt" || $extension == "pptx")
				{
					$fileTypeImagePath = $basePath1.'ppt_default.png';
				}
				else if($extension == "pub")
				{
					$fileTypeImagePath = $basePath1.'pub_default.png';
				}
				else if($extension == "rtf")
				{
					$fileTypeImagePath = $basePath1.'rtf_default.png';
				}
				else if(in_array($extension, $fileAllowedExts))
				{
					$fileTypeImagePath = $basePath1.'default_file.png';
				}
				else if($extension == "mp3")
				{
					$fileTypeImagePath = $basePath1.'mp3_default.png';
				}
				else if(in_array($extension, $audioAllowedExts))
				{
					$fileTypeImagePath = $basePath1.'audio_default.png';
				}
				
				
				if($addCaption==1)
				{
					$caption = '<p><strong>'.$docData->docCaption.'</strong></p><br>';
					//$fileName = '';
				}
				else
				{
					$caption = '';
					//$fileName = '<br><p>'.$docData->docCaption.'</p>';
				}
				
				// $fileName = '<br><p>'.$docData->docName.'</p>';
				$fileName = '<br><p>'.$name.'</p>';

				if(in_array($extension, $imageAllowedExts))
				{
					$filePathForLeaf = $caption.'<p><img src="/workplaces/'.$_COOKIE["place"].'/editor_uploads/'.$name.'" style="width: 100%;" class="fr-fil fr-dib"></p>'.$fileName;
					// $filePathForLeaf = '<p>'.$docData->docCaption.'<img src="/'.$baseUrlArray[3].'/workplaces/'.$_COOKIE["place"].'/editor_uploads//'.$name.'" style="width: 100%;" class="fr-fil fr-dib"></p>';
				}
				else if(in_array($extension, $videoAllowedExts))
				{
					$filePathForLeaf = $caption.'<p><span class="fr-video fr-dvb fr-draggable" contenteditable="false" draggable="true"><video "="" class="fr-draggable" controls="" src="/workplaces/'.$_COOKIE["place"].'/editor_uploads/'.$name.'" style="width: 600px;">Your browser does not support HTML5 video.</video></span></p>'.$fileName;
					// $filePathForLeaf = '<p>'.$docData->docCaption.'<span class="fr-video fr-dvb fr-draggable" contenteditable="false" draggable="true"><video "="" class="fr-draggable" controls="" src="/'.$baseUrlArray[3].'/workplaces/'.$_COOKIE["place"].'/editor_uploads//'.$name.'" style="width: 600px;">Your browser does not support HTML5 video.</video></span></p>';
				}
				else if(in_array($extension, $fileAllowedExts)) 
				{
					if($fileTypeImagePath != '')
					{
						$filePathForLeaf = '<p><span class="defaultFileIconInLeaf"><img src="'.$fileTypeImagePath.'"></span><a class="fr-file" href="/workplaces/'.$_COOKIE["place"].'/editor_uploads/'.$name.'" target="_blank">'.$name.'</a></p>';
					}
					else
					{
						$filePathForLeaf = '<p><a class="fr-file" href="/workplaces/'.$_COOKIE["place"].'/editor_uploads/'.$name.'" target="_blank">'.$name.'</a></p>';
					}
					
					// $filePathForLeaf = '<p><a class="fr-file" href="/'.$baseUrlArray[3].'/workplaces/'.$_COOKIE["place"].'/editor_uploads//'.$name.'" target="_blank">'.$name.'</a></p>';
				}
				else if(in_array($extension, $audioAllowedExts))
				{
					if($fileTypeImagePath != '')
					{
						$filePathForLeaf = '<p><span class="defaultFileIconInLeaf"><img src="'.$fileTypeImagePath.'"></span><a class="fr-file" href="/workplaces/'.$_COOKIE["place"].'/editor_uploads/'.$name.'" target="_blank">'.$name.'</a></p>';
					}
					else
					{
						$filePathForLeaf = '<p><a class="fr-file" href="/workplaces/'.$_COOKIE["place"].'/editor_uploads/'.$name.'" target="_blank">'.$name.'</a></p>';
					}
					
					// $filePathForLeaf = '<p><a class="fr-file" href="/'.$baseUrlArray[3].'/workplaces/'.$_COOKIE["place"].'/editor_uploads//'.$name.'" target="_blank">'.$name.'</a></p>';
				}

				// $arrDocDetails[$i]['docId'] 		= $docData->docId;
				// $arrDocDetails[$i]['workSpaceId'] 	= $docData->workSpaceId;
				// $arrDocDetails[$i]['workSpaceType'] = $docData->workSpaceType;	
				// $arrDocDetails[$i]['userId'] 		= $docData->userId;		
				// $arrDocDetails[$i]['docCaption'] 	= $docData->docCaption;	
				// $arrDocDetails[$i]['docName']	 	= $docData->docName;	
				// $arrDocDetails[$i]['docPath']	 	= $docData->path;
				// $arrDocDetails[$i]['docCreatedDate']= $docData->createdDate;	
				// $arrDocDetails[$i]['version']		= $docData->version;

				//make path after copy
				$arrDocDetails[$i]['leafContent']	= $filePathForLeaf;
						
				$i++;
									
			}
		}			
		return $arrDocDetails;

	}

	//Added by Dashrath : code start
	public function createNewEmptyFolder($folderName, $workSpaceId, $workSpaceType, $workPlaceName, $userId=0)
	{

		if($userId==0)
		{
			$userId = $_SESSION['userId'];
		}

		if (PHP_OS=='Linux')
		{
			$workPlaceRootDir   = $this->config->item('absolute_path').'workplaces';			
			$workPlaceDir		= $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$workPlaceName;
			$workSpaceMainDir	= $workPlaceDir.DIRECTORY_SEPARATOR.'workspaces';

			if($workSpaceId > 0)
			{
				if($workSpaceType==2)
				{
					$workSpaceSubDir	= $workSpaceMainDir.DIRECTORY_SEPARATOR.'sws'.$workSpaceId;
				}
				else
				{
					$workSpaceSubDir	= $workSpaceMainDir.DIRECTORY_SEPARATOR.'ws'.$workSpaceId;
				}
			}
			else
			{
				$workSpaceSubDir	= $workSpaceMainDir.DIRECTORY_SEPARATOR.'wsuser'.$userId;
			}

			if($workSpaceId > 0)
			{
				if($workSpaceType==2)
				{
					$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
				}
				else
				{
					$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
				}	
			}
			else
			{
				// $docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
				$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."wsuser$userId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;	
			}
		
		}
		else
		{
			$workPlaceRootDir   = $this->config->item('absolute_path').'\workplaces';			
			$workPlaceDir		= $this->config->item('absolute_path').'\workplaces\\'.$workPlaceName;
			$workSpaceMainDir	= $workPlaceDir.'\\workspaces';

			if($workSpaceId > 0)
			{
				if($workSpaceType==2)
				{
					$workSpaceSubDir	= $workSpaceMainDir.'\\sws'.$workSpaceId;
				}
				else
				{
					$workSpaceSubDir	= $workSpaceMainDir.'\\ws'.$workSpaceId;
				}
			}
			else
			{
				$workSpaceSubDir	= $workSpaceMainDir.'\\wsuser'.$userId;
			}

			if($workSpaceId > 0)
			{
				if($workSpaceType==2)
				{
					$docPath		= "workplaces/".$workPlaceName."/workspaces/sws$workSpaceId/".$folderName."/";
				}
				else
				{
					$docPath		= "workplaces/".$workPlaceName."/workspaces/ws$workSpaceId/".$folderName."/";
				}
			}
			else
			{
				// $docPath		= "workplaces/".$workPlaceName."/workspaces/wsuser$_SESSION[userId]/".$folderName."/";

				$docPath = "workplaces/".$workPlaceName."/workspaces/wsuser$userId/".$folderName."/";
			}
		}
		
		$desRoot	= $this->config->item('absolute_path').$docPath;

		if (!is_dir($workPlaceRootDir))
		{
			mkdir($workPlaceRootDir);
		}
		if(!is_dir($workPlaceDir))
		{
			mkdir($workPlaceDir);
		}
		if(!is_dir($workSpaceMainDir))
		{
			mkdir($workSpaceMainDir);
		}
		if(!is_dir($workSpaceSubDir))
		{
			mkdir($workSpaceSubDir);
		}		
		if(!is_dir($desRoot))
		{
			$res = mkdir($desRoot);

			if($res)
			{
				return "true";
			}
			else
			{
				return "false";
			}
		}
		else
		{
			return "false";
		}

		//return "true";

	}

	
	public function insertFolder($name, $workSpaceId, $workSpaceType, $userId, $parentId=0, $config=0)
	{

		// $qry = "INSERT INTO teeme_folders(`parentId`,`name`,`workSpaceId`,`workSpaceType`,`userId`) VALUES('".$parentId."','".$name."','".$workSpaceId."','".$workSpaceType."','".$userId."')";	

		//$query = $this->db->query($qry);

		/*Changed by Dashrath- Add if else condition for load db*/
		if ($config!=0)
        {
            $placedb = $this->load->database($config,TRUE);

            $query = $placedb->query("INSERT INTO teeme_folders(`parentId`,`name`,`workSpaceId`,`workSpaceType`,`userId`) VALUES('".$parentId."','".$name."','".$workSpaceId."','".$workSpaceType."','".$userId."')");
        }
		else
		{
			$query = $this->db->query("INSERT INTO teeme_folders(`parentId`,`name`,`workSpaceId`,`workSpaceType`,`userId`) VALUES('".$parentId."','".$name."','".$workSpaceId."','".$workSpaceType."','".$userId."')");
		}
		/*Dashrath- changes end*/	
		
		

		if($query)
		{
			// return $this->db->insert_id();

			if ($config!=0)
        	{
        		return $placedb->insert_id();
			}
			else
			{
				return $this->db->insert_id();
			}
		}	
		else
		{
			return false;
		}		
	}

	public function checkFolderNameById($name, $workSpaceId, $workSpaceType, $userId)
	{
		$folderId = 0;

		if($workSpaceId > 0)
		{
			$query = $this->db->query('SELECT id FROM teeme_folders WHERE name="'.$name.'" AND workSpaceId ="'.$workSpaceId.'" AND workSpaceType ="'.$workSpaceType. '"');
		}
		else
		{
			$query = $this->db->query('SELECT id FROM teeme_folders WHERE name="'.$name.'" AND workSpaceId =0 AND workSpaceType ="'.$workSpaceType. '" AND userId ="'.$userId.'"');
		}
				
		foreach($query->result() as $row)
		{
			$folderId	= $row->id;

		}	
		return $folderId; 
	}

	public function getFolders($workSpaceId, $workSpaceType)
	{
		$arrDocDetails = array();		
		
		$orderBy = ' ORDER BY a.name ASC';
	
		$userId = $_SESSION['userId'];

		$folder=array();
						
		if($workSpaceId == 0)
		{	
			$query = $this->db->query('SELECT a.* FROM teeme_folders a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId=0 AND a.userId='.$userId.$orderBy);
				if($query->num_rows() > 0)
				{
					foreach ($query->result() as $row)
					{	
						$folder[] = $row;
					}
				}
		}
		else	
		{
			$query = $this->db->query('SELECT a.* FROM teeme_folders a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.$orderBy);
			
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$folder[] = $row;
				}
			}
		}
		
		//return $tree;
		if(count($folder) > 0)
		{
			$i = 0;
			foreach ($folder as $docData)
			{	
				$arrDocDetails[$i]['folderId'] 		= $docData->id;
				$arrDocDetails[$i]['parentId'] 		= $docData->parentId;	
				$arrDocDetails[$i]['name']	 		= $docData->name;	
				$arrDocDetails[$i]['workSpaceId'] 	= $docData->workSpaceId;
				$arrDocDetails[$i]['workSpaceType'] = $docData->workSpaceType;	
				$arrDocDetails[$i]['userId'] 		= $docData->userId;		
				$arrDocDetails[$i]['createdDate']	= $docData->createdDate;

				//get editFolderName
				$arrDocDetails[$i]['editFolderName'] = $this->identity_db_manager->characterLimiter($docData->name, 16);

				$i++;					
			}
		}			
		return $arrDocDetails;
	}
	//Dashrath : code end

	//Added by Dashrath : code start
	public function removeFolder($folderName, $workSpaceId, $workSpaceType, $workPlaceName)
	{
		if (PHP_OS=='Linux')
		{
			if($workSpaceId > 0)
			{
				$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;
				
			}
			else
			{
				$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR.$folderName.DIRECTORY_SEPARATOR;	
			}
		
		}
		else
		{
			if($workSpaceId > 0)
			{
				$docPath		= "workplaces/".$workPlaceName."/workspaces/ws$workSpaceId/".$folderName."/";
			}
			else
			{
				$docPath		= "workplaces/".$workPlaceName."/workspaces/wsuser$_SESSION[userId]/".$folderName."/";
			}
		}
		
		$desRoot	= $this->config->item('absolute_path').$docPath;

			
		if(is_dir($desRoot))
		{
			rmdir($desRoot);
		}
		
		return "true";
		
	}

	public function getFolderNameByFolderId($folderId)
	{
		$folderName = '';
		if($folderId > 0)
		{
			$query = $this->db->query('SELECT name FROM teeme_folders WHERE id ="'.$folderId.'"');
			
			foreach($query->result() as $row)
			{
				$folderName	= $row->name;

			}	
		} 
		return $folderName;
	}
	//Dashrath : code end

	//Added by Dashrath : code start
	public function getFilesData($externalDocs, $companyName)
	{
		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$i = 0;
		foreach ($externalDocs as $extDoc) {
			$userDetails	= $this->identity_db_manager->getUserDetailsByUserId($extDoc['userId']);
			$externalDocs[$i]['userTagName'] = $userDetails['userTagName'];
			$externalDocs[$i]['docCreatedDate'] = $this->time_manager->getUserTimeFromGMTTime($extDoc['docCreatedDate'], 'm-d-Y h:i A');

			$externalDocs[$i]['orig_modified_date'] = $this->time_manager->getUserTimeFromGMTTime($extDoc['orig_modified_date'], 'm-d-Y h:i A');

			//get thumbnail url
			$externalDocs[$i]['thumbnailUrl'] = $this->identity_db_manager->getThumbnailUrl($companyName,$extDoc['docPath'],$extDoc['docName']);

			$fileInfo = $this->identity_db_manager->getFileInformation($companyName,$extDoc['docPath'],$extDoc['docName']);

			if($fileInfo['is_image'] == 1)
			{
				$externalDocs[$i]['size']      = $fileInfo['size'];
				$externalDocs[$i]['size_type'] = $fileInfo['size_type'];
				$externalDocs[$i]['extension'] = $fileInfo['extension'];
				$externalDocs[$i]['is_image']  = $fileInfo['is_image'];
				$externalDocs[$i]['width']     = $fileInfo['width'];
				$externalDocs[$i]['height']    = $fileInfo['height'];
			}
			else
			{
				$externalDocs[$i]['size']      = $fileInfo['size'];
				$externalDocs[$i]['size_type'] = $fileInfo['size_type'];
				$externalDocs[$i]['extension'] = $fileInfo['extension'];
				$externalDocs[$i]['is_image']  = $fileInfo['is_image'];
			}
			

			$i++;
		}
		return $externalDocs;
	}
	//Dashrath : code end

	//Added by Dashrath : code start
	public function generateThumbnail($path, $fileGeneratedName, $type="", $fileNameWithoutExt="")
	{
		if($type == "image")
		{
			$this->load->library('image_lib');

			$source_path = $path.$fileGeneratedName;
			$target_path = $path."thumbnail".DIRECTORY_SEPARATOR;

			if(!is_dir($target_path))
			{
				mkdir($target_path);
			}

		    $config_manip = array(
		        'image_library' => 'gd2',
		        'source_image' => $source_path,
		        'new_image' => $target_path,
		        'maintain_ratio' => FALSE,
		        'create_thumb' => FALSE,
		        //'thumb_marker' => '_thumb',
		        'width' => 75,
		        'height' => 45
		    );

		    $this->image_lib->initialize($config_manip);
		    //$this->load->library('image_lib', $config_manip);
		    if (!$this->image_lib->resize()) {
		        echo $this->image_lib->display_errors();
		    }
		    // clear
		    $this->image_lib->clear();
		}
		else if($type == "video")
		{
			//used for server
			$ffmpeg = DIRECTORY_SEPARATOR."usr".DIRECTORY_SEPARATOR."bin".DIRECTORY_SEPARATOR."ffmpeg";
			//used for local
			//$ffmpeg = "C:\\ffmpeg\\bin\\ffmpeg";
			$source_path = $path.$fileGeneratedName;
			$target_path = $path."thumbnail".DIRECTORY_SEPARATOR.$fileNameWithoutExt.".jpg";

			$interval = 5;

			$size = '75x45';

			//ffmpeg command
			$cmd = "$ffmpeg -i $source_path -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y -s $size $target_path 2>&1";

			$return = `$cmd`;
		}
	}

	public function getThumbnailUrl($companyName, $docPath, $docName)
	{
		$extension = $this->getFileExtension($docName);
		$extension = strtolower($extension);

		$imageAllowedExts = ["gif", "jpeg", "jpg", "png"];
		$fileAllowedExts  = ["txt", "pdf", "csv", "doc", "docx", "xls", "xlsx", "ppt", "odt", "pptx", "xps", "docm", "dotm", "dotx", "dot", "xlsm", "xlsb", "xlw", "pot", "pptm", "pub", "rtf"];
		$videoAllowedExts = ["mp4", "avi","flv","wmv","mov"];
		$audioAllowedExts = ["mp3", "m4a", "aac", "oga"];

		if(in_array($extension, $imageAllowedExts))
		{
			$thumbnailUrlExists = $this->config->item('absolute_path').'workplaces/'.$companyName.'/'.$docPath.'thumbnail/'.$docName;

			$thumbImageName = $docName;
		}
		else if(in_array($extension, $videoAllowedExts))
		{
			$arrFileName		= explode('.',$docName);
			$thumbnailUrlExists = $this->config->item('absolute_path').'workplaces/'.$companyName.'/'.$docPath.'thumbnail/'.$arrFileName[0].'.jpg';

			$thumbImageName = $arrFileName[0].'.jpg';
		}
		else
		{
			$thumbnailUrlExists = $this->config->item('absolute_path').'workplaces/'.$companyName.'/'.$docPath.'thumbnail/'.$docName;

			$thumbImageName = $docName;
		}

		

		if(file_exists($thumbnailUrlExists))
		{
			$thumbnailUrl = base_url().'workplaces/'.$companyName.'/'.$docPath.'thumbnail/'.$thumbImageName;
		}
		else
		{

			if(in_array($extension, $imageAllowedExts))
			{
				$thumbnailUrl = base_url().'images/thumbnail/default_image.png';
			}
			else if($extension == "txt")
			{
				$thumbnailUrl = base_url().'images/thumbnail/txt_default.png';
			}
			else if($extension == "pdf")
			{
				$thumbnailUrl = base_url().'images/thumbnail/pdf_default.png';
			}
			else if($extension == "csv")
			{
				$thumbnailUrl = base_url().'images/thumbnail/csv_default.png';
			}
			else if($extension == "doc" || $extension == "docx")
			{
				$thumbnailUrl = base_url().'images/thumbnail/doc_default.png';
			}
			else if($extension == "xls" || $extension == "xlsx")
			{
				$thumbnailUrl = base_url().'images/thumbnail/xls_default.png';
			}
			else if($extension == "ppt" || $extension == "pptx")
			{
				$thumbnailUrl = base_url().'images/thumbnail/ppt_default.png';
			}
			else if($extension == "pub")
			{
				$thumbnailUrl = base_url().'images/thumbnail/pub_default.png';
			}
			else if($extension == "rtf")
			{
				$thumbnailUrl = base_url().'images/thumbnail/rtf_default.png';
			}
			else if(in_array($extension, $fileAllowedExts))
			{
				$thumbnailUrl = base_url().'images/thumbnail/default_file.png';
			}
			else if(in_array($extension, $videoAllowedExts))
			{
				$thumbnailUrl = base_url().'images/thumbnail/default_video.png';
			}
			else if($extension == "mp3")
			{
				$thumbnailUrl = base_url().'images/thumbnail/mp3_default.png';
			}
			else if(in_array($extension, $audioAllowedExts))
			{
				$thumbnailUrl = base_url().'images/thumbnail/audio_default.png';
			}
			else
			{
				$thumbnailUrl = base_url().'images/thumbnail/default_image.png';
			}
		}
		return $thumbnailUrl;
	}
	//Dashrath : code end
	public function getFileInformation($companyName,$docPath,$docName)
	{
		$fileInfo = array();
		//get file size in byte
		$sizeInByte = $this->getFileSize($companyName,$docPath,$docName);

		$sizeInMb = round(($sizeInByte/1024)/1024,2);
		$sizeInKb = round(($size/1024),2);

		if($sizeInMb > 0 )
		{
			$fileInfo['size'] = $sizeInMb;
			$fileInfo['size_type'] = "MB";
		}
		else if($sizeInKb > 0)
		{
			$fileInfo['size'] = $sizeInKb;
			$fileInfo['size_type'] = "KB";
		}
		else
		{
			$fileInfo['size'] = $sizeInByte;
			$fileInfo['size_type'] = "Byte";
		}
		
		//get file extension
		$extension = $this->getFileExtension($docName);
		$extension = strtolower($extension);

		$fileInfo['extension'] = $extension;

		$imageExtension = ["gif", "jpeg", "jpg", "png"];

		if(in_array($extension, $imageExtension))
		{
			$fileInfo['is_image'] = 1;

			$imageInfo = $this->getImageInfo($companyName,$docPath,$docName);

			$fileInfo['width']  = $imageInfo[0];

			$fileInfo['height'] = $imageInfo[1];
		}
		else
		{
			$fileInfo['is_image'] = 0;
		}
		
		return $fileInfo;
		
	}

	public function getFileSize($companyName,$docPath,$docName)
	{
		$path = $this->config->item('absolute_path').'workplaces/'.$companyName.'/'.$docPath.$docName;
		//size in byte
		$size = filesize($path);
		return $size;
	}

	public function getImageInfo($companyName,$docPath,$docName)
	{
		$path = $this->config->item('absolute_path').'workplaces/'.$companyName.'/'.$docPath.$docName;
		$imageInfo = getimagesize($path);
		return $imageInfo;
	}

	public function getMaxValueOfNodeOrderByTreeId($treeId)
	{
		$nodeOrder = 0;

		if($treeId > 0)
		{
			$query = $this->db->query('SELECT MAX(nodeOrder) As `nodeOrder` FROM teeme_node WHERE treeIds ="'.$treeId.'"');
			
			foreach($query->result() as $row)
			{
				$nodeOrder	= $row->nodeOrder;

			}	
		} 
		return $nodeOrder;

	}

	/**
	 * Character Limiter
	 *
	 * Limits the string based on the character count.  Preserves complete words
	 * so the character count may not be exactly as specified.
	 *
	 * @param	string
	 * @param	int
	 * @param	string	the end character. Usually an ellipsis
	 * @return	string
	 */
	function characterLimiter($str, $n = 16, $type='folder', $end_char = '&#8230;')
	{
		if(strlen($str)<=$n)
		{

		   return $str;
		}
		else
		{
		   $y=substr($str,0,$n) . '...';
		   return $y;
		}
		// if (mb_strlen($str) < $n)
		// {
		// 	return $str;
		// }

		// // a bit complicated, but faster than preg_replace with \s+
		// $str = preg_replace('/ {2,}/', ' ', str_replace(array("\r", "\n", "\t", "\x0B", "\x0C"), ' ', $str));

		// if (mb_strlen($str) <= $n)
		// {
		// 	return $str;
		// }

		// $out = '';
		// if($type=='folder')
		// {
		// 	$replaceType = '_';
		// }
		// else
		// {
		// 	$replaceType = ' ';
		// }
		
		// foreach (explode($replaceType, trim($str)) as $val)
		// {
		// 	$out .= $val.' ';

		// 	if (mb_strlen($out) >= $n)
		// 	{
		// 		$out = trim($out);

		// 		if($type=='folder')
		// 		{
		// 			$newOut = str_replace(' ','_',$out);
		// 		}
		// 		else
		// 		{
		// 			$newOut = $out;
		// 		}
				
		// 		return (mb_strlen($out) === mb_strlen($str)) ? $newOut : $newOut.$end_char;
		// 	}
		// }
	}

	//Added by Dashrath : getTreeTimeline function start
	//This function is used for get tree timeline data
	function getTreeTimeline($currentTreeId, $workSpaceId, $workSpaceType, $userId)
	{
		// echo 'currentTreeId';
		// echo $currentTreeId;
		// echo 'workSpaceId';
		// echo $workSpaceId;
		// echo 'workSpaceType';
		// echo $workSpaceType;die;

		$this->load->model('dal/notification_db_manager');   
   		$this->load->model('dal/identity_db_manager');  
        $this->load->model('dal/time_manager'); 
        $objIdentity    = $this->identity_db_manager;   
        $objTime    = $this->time_manager;
        $modeId = '1';

        //Comment code by : Dashrath
        // $workSpaceId    = '15';
        // $workSpaceType  = '1';
        // $userId = '1';

        // $config['hostname'] = base64_decode($this->config->item('hostname'));
        // $config['username'] = base64_decode($this->config->item('username'));
        // $config['password'] = base64_decode($this->config->item('password'));
        // $config['database'] = $this->config->item('instanceDb').'_test';
        // $config['dbdriver'] = $this->db->dbdriver;
        // $config['dbprefix'] = $this->db->dbprefix;
        // $config['pconnect'] = FALSE;
        // $config['db_debug'] = $this->db->db_debug;
        // $config['cache_on'] = $this->db->cache_on;
        // $config['cachedir'] = $this->db->cachedir;
        // $config['char_set'] = $this->db->char_set;
        // $config['dbcollat'] = $this->db->dbcollat;    
        // $this->db = $this->load->database($config, TRUE);   

        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        $successorsId = trim($obj['data']['successors']); 

        /*get treeIds according parentTreeId for get talk content in timeline*/
		$treeIds = $objIdentity->getTreeIdsByParentTreeId($currentTreeId);   
       
        //Notification code start here
        /*Dashrath- send userId 0 for get all user notification */
       // $allNotificationEvents  = $this->notification_db_manager->get_all_app_notification_events($modeId,0, $currentTreeId);
        
        //if(count($allNotificationEvents)>0)
        //{   $i=0;
            //foreach($allNotificationEvents as $notificationEventDetails)
            //{
        		
                $notificationEventData = $this->notification_db_manager->get_notification_events_data(0,'',$workSpaceId);

                foreach($notificationEventData as $notificationEventContent)
                {
                	
	                    $object_instance_id=$notificationEventContent['object_instance_id'];
	                    $object_id=$notificationEventContent['object_id'];
	                    $action_id=$notificationEventContent['action_id'];

	                    /*Dashrath- check condition for get only currentTreeId data*/
	                    if($currentTreeId > 0 )
						{
							$objectIdsArray = array(1,2,3,4,5,6,7,8,14);
							/*check object ids*/
							if(in_array($object_id, $objectIdsArray))
							{
								if($object_id==1 || $object_id==8 || $object_id==14)
								{
									$treeId = $object_instance_id;
								}
								else if($object_id == 3)
								{
									$treeId = 0;
								}
								else if($object_id==4 || $object_id==5 || $object_id==6 || $object_id==7)
								{
									if($notificationEventContent['url']=='')
		                            {
		                            	$treeId = $object_instance_id;
		                            }
		                            else
		                            {
		                            	if($object_instance_id > 0)
										{
											//get tree id
											$treeId = $objIdentity->getTreeIdByNodeId_identity($object_instance_id);	
										}
										else
										{
											$treeId = 0;
										}
		                            }
								}    
								else
								{
									if($object_instance_id > 0)
									{

										//get tree id
										$treeId = $objIdentity->getTreeIdByNodeId_identity($object_instance_id);	
									}
									else
									{
										$treeId = 0;
									}
								}

								/*Changed  by Dashrath- Add in array condition for talk notification*/
								if(($currentTreeId==$treeId || in_array($treeId, $treeIds)) && $treeId>0)
								{
									 $notificationEventsDataArray[$object_instance_id][$object_id][$action_id][] = array(
		                            'object_id' => $notificationEventContent['object_id'],
		                            'action_id' => $notificationEventContent['action_id'],
		                            'object_instance_id' => $notificationEventContent['object_instance_id'],
		                            'action_user_id' => $notificationEventContent['action_user_id'],
		                            'workSpaceId' => $notificationEventContent['workSpaceId'],
		                            'workSpaceType' => $notificationEventContent['workSpaceType'],
		                            'url' => $notificationEventContent['url'],
		                            'created_date' => $notificationEventContent['created_date'],
		                            'notification_data_id' => $notificationEventContent['notification_data_id'],
		                            'parent_object_id' => $notificationEventContent['parent_object_id']
		                    		);
								}

							} //end if condition
						}
						/*Dashrath- check condition for get only currentTreeId data*/
					
                   
                }
               // $i++;
           // }

            // echo "<pre>";
            // print_r($notificationEventsDataArray);die;

            if(count($notificationEventsDataArray)>0)
            {
                foreach($notificationEventsDataArray as $key=>$objectInstanceData)
                {
                    foreach($objectInstanceData as $objectInstanceValue)
                    {
                    	$notification_data_ids = [];
                        foreach($objectInstanceValue as $objectContent)
                        {
                            $objectContent=array_reverse($objectContent);
                            $i=0;
                            /*Changed by Dashrath- Add foreach loop for show all record for timeline and add if condition for check id in array*/
                            foreach($objectContent as $objectValue)
                            {
                            	if(!in_array($objectValue['notification_data_id'], $notification_data_ids) || $objectValue['notification_data_id']==0)
                            	{
                            		if($objectValue['notification_data_id']>0)
                            		{
                            			$notification_data_ids[]=$objectValue['notification_data_id'];
                            		}
                            		
                            		$notification_data_id=$objectValue['notification_data_id'];
                            		$objectInstanceId=$objectValue['object_instance_id'];
	                                $objectId=$objectValue['object_id'];
	                                $actionId=$objectValue['action_id'];
	                                $action_user_ids[]=$objectValue['action_user_id'];
	                                $workSpaceId=$objectValue['workSpaceId'];
	                                $workSpaceType=$objectValue['workSpaceType'];
	                                $url=$objectValue['url'];
	                                $created_date=$objectValue['created_date'];
	                                $i++;
	                                $action_count = $i;
	                                $parent_object_id = $objectValue['parent_object_id'];

                            		// foreach($objectContent as $objectValue)
                            		// {
		                            //     $objectInstanceId=$objectValue['object_instance_id'];
		                            //     $objectId=$objectValue['object_id'];
		                            //     $actionId=$objectValue['action_id'];
		                            //     $action_user_ids[]=$objectValue['action_user_id'];
		                            //     $workSpaceId=$objectValue['workSpaceId'];
		                            //     $workSpaceType=$objectValue['workSpaceType'];
		                            //     $url=$objectValue['url'];
		                            //     $created_date=$objectValue['created_date'];
		                            //     $i++;
		                            //     $action_count = $i;
		                            // }
	                            	
	                            
	                            	//notification start here
	                                //Condition for object and action id start
	                                $treeId='0';
	                                $leafData='';
	                                $treeContent='';
	                                $talkContent='';
	                                $treeName='';
	                                $postFollowStatus='';
	                                $personalize_status='';
	                                if($objectId==1) //1 for tree
	                                {
	                                    $treeId=$objectInstanceId;  
	                                    $treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
	                                }
	                                if($objectId==2) //2 for leaf
	                                {   
	                                    $treeId=$this->identity_db_manager->getTreeIdByNodeId_identity($objectInstanceId);  
	                                    $leafData = $this->identity_db_manager->getNodeDetailsByNodeId($objectInstanceId);
	                                    $treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);

	                                    /*Added by Dashrath: code start */
	                                    if($actionId!=17 && $actionId!=18 && $actionId!=9 && $actionId!=10)
										{
											// $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
											if($notification_data_id>0)
	                                    	{
	                                    		$notificationDataId = $notification_data_id;
	                                    	}
	                                    	else
	                                    	{
	                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
	                                    	}

											if($notificationDataId > 0)
											{
												$leafData['contents'] = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
											}
										}
										/*Dashrath: code end */
	                                }
	                                if($objectId==3) //3 for post
	                                {   
	                                    $treeId=0;
	                                    $leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId);
	                                    if($actionId==13)
	                                    {
	                                        $postFollowStatus = $this->notification_db_manager->getPostFollowStatus($userId,$objectInstanceId);
	                                    }
	                                }
	                                /*4 for simple tag, 5 for action tag, 6 for contact tag, 7 for  	link */
	                                if($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7)
	                                {
	                                    if($actionId==4 || $actionId==13)
	                                    {
	                                        //$leafData = $this->identity_db_manager->getNodeDetailsByNodeId($objectInstanceId);
	                                        // $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
	                                        if($notification_data_id>0)
	                                    	{
	                                    		$notificationDataId = $notification_data_id;
	                                    	}
	                                    	else
	                                    	{
	                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
	                                    	}

	                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
	                                    }
	                                    if($url=='')
	                                    {
	                                        $treeId=$objectInstanceId;
	                                        $treeContent = $this->notification_db_manager->getTreeNameByTreeId($objectInstanceId);
	                                    }
	                                    else
	                                    {
	                                        $treeId=$this->identity_db_manager->getTreeIdByNodeId_identity($objectInstanceId);
	                                        $leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId);
	                                        if($treeId==0)
	                                        {
	                                            $postFollowStatus = $this->notification_db_manager->getPostFollowStatus($userId,$objectInstanceId);
	                                            if($postFollowStatus==1)
	                                            {
	                                                $personalize_status='1';
	                                            }
	                                            $leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,'3');
	                                            $treeType = 'post';  
	                                            $treeName = 'post_tree.png';
	                                        }
	                                    }
	                                    //print_r($leafData);
	                                    //exit;
	                                    /*if(count($leafData)==0 || empty($leafData))
	                                    {
	                                        $treeId = $objectInstanceId;
	                                        $treeContent = $this->notification_db_manager->getTreeNameByTreeId($objectInstanceId);
	                                    }*/
	                                }
	                                //8 for talk
	                                if($objectId==8)
	                                {
	                                	/*Commented by Dashrath- comment old code add new code below*/
	                                    // $treeId=$objectInstanceId;  
	                                    // $talkContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
	                                    // $talkContent=strip_tags($talkContent);
	                                    // if(strlen($talkContent) > 25)
	                                    // {
	                                    //     $talkContent = substr($talkContent, 0, 25) . "..."; 
	                                    // }

	                                    /*Added by Dashrath- change for when only image exists talkContent is blank by strip_tags*/
										if($actionId==13)
										{
											$treeId=$objectInstanceId;	
											$talkContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
											$talkContentNew=strip_tags($talkContent);

											//if content is blank after apply strip_tags
											if($talkContentNew == '')
											{
												$talkContent = $this->lang->line('content_contains_only_image');
											}
											else
											{
												$talkContent = $talkContentNew;
												
												if(strlen($talkContentNew) > 25)
												{
													$talkContent = substr($talkContentNew, 0, 25) . "..."; 
												}
											}
											
										}
										else
										{
											$treeId=$objectInstanceId;	
											$talkContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
											$talkContent=strip_tags($talkContent);
											if(strlen($talkContent) > 25)
											{
												$talkContent = substr($talkContent, 0, 25) . "..."; 
											}
											
										}
										/*Dashrath- code end*/
	                                }
	                                //9 for file
	                                if($objectId==9)
	                                {
	                                    $fileName='';
	                                    $fileDetails = $this->notification_db_manager->getImportedFileNameById($objectInstanceId);
	                                    if($fileDetails['docCaption']!='')
	                                    {
	                                        $fileName = $fileDetails['docCaption'];
	                                    }
	                                }
	                                if($objectId==14 || $objectId==1 || $objectId==2 || $objectId==3)
	                                {
	                                    if($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17)
	                                    {
	                                    	// $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
	                                    	if($notification_data_id>0)
	                                    	{
	                                    		$notificationDataId = $notification_data_id;
	                                    	}
	                                    	else
	                                    	{
	                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
	                                    	}
	                                       
	                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
	                                        $currentUserName='';
	                                        $currentUserDetails = $this->identity_db_manager->getUserDetailsByUserId($userId);
	                                        if($currentUserDetails['firstName']!='' && $currentUserDetails['lastName']!='')
	                                        {
	                                            $currentUserName = $currentUserDetails['firstName'].' '.$currentUserDetails['lastName'];
	                                        }
	                                        $summarizeData = str_replace($currentUserName,"You",$summarizeData);
	                                        //echo $summarizeData; exit;
	                                        if($summarizeData=='' && ($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17))
	                                        {
	                                            $summarizeData='You';
	                                        }
	                                    }

	                                    /*Added by Dashrath- get unassign users data*/
	                                    if($actionId==10)
	                                    {
	                                    	// $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
	                                    	if($notification_data_id>0)
	                                    	{
	                                    		$notificationDataId = $notification_data_id;
	                                    	}
	                                    	else
	                                    	{
	                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
	                                    	}

	                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);

	                                    }

	                                    if($actionId==18)
	                                    {
	                                    	// $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);

	                                    	if($notification_data_id>0)
	                                    	{
	                                    		$notificationDataId = $notification_data_id;
	                                    	}
	                                    	else
	                                    	{
	                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
	                                    	}

	                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);

	                                    }
	                                    /*Dashrath- code end*/

	                                    if($objectId!=2)
	                                    {
	                                        $treeId=$objectInstanceId;  
	                                        $treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
	                                    }
	                                }
	                                if($objectId==15 || $objectId==16)
	                                {
	                                    $memberName='';
	                                    $memberDetails = $this->identity_db_manager->getUserDetailsByUserId($objectInstanceId);
	                                    if($memberDetails['userTagName']!='')
	                                    {
	                                        $memberName = $memberDetails['userTagName'];
	                                    }
	                                }
	                                
	                                if($treeContent!='')
	                                {
	                                    $treeContent=strip_tags($treeContent);
	                                    if(strlen($treeContent) > 25)
	                                    {
	                                        $treeContent = substr($treeContent, 0, 25) . "..."; 
	                                    }
	                                }                                       
	                                if(count($leafData)>0)
	                                {
	                                	/*Commented by Dashrath- Add new code below*/
	                                    // $leafdataContent=strip_tags($leafData['contents']);
	                                    // if (strlen($leafdataContent) > 25) 
	                                    // {
	                                    //     $leafTitle = substr($leafdataContent, 0, 25) . "..."; 
	                                    // }
	                                    // else
	                                    // {
	                                    //     $leafTitle = $leafdataContent;
	                                    // }
	                                    // if($leafTitle=='')
	                                    // {
	                                    //     $leafTitle = $this->lang->line('content_contains_only_image');
	                                    // }

	                                    /*Added by Dashrath- Change condition for image,video,mp3 display in timeline*/
	                                	$isFileContent = 0;
	                                	if($leafData['contents']!='')
	                                	{
	                                		preg_match_all("#<img(.*?)\\/?>#",$leafData['contents'], $imgTags);
	                                		if($imgTags[0])
	                                		{
	                                			
	                                			preg_match( '@src="([^"]+)"@' , $leafData['contents'], $match );
		                                		if($match)
		                                		{
		                                			$imgPathInfo = explode('/', $match[1]);
		                                			$imgName = $imgPathInfo[count($imgPathInfo)-1];

		                                			$finalPath = $this->config->item('absolute_path').'workplaces/'.$_COOKIE['place'].'/editor_uploads//'.$imgName;
													
		                                			$imageInfo = getimagesize($finalPath);

		                                			$imgWidth = '150px;';

		                                			if(count($imageInfo)>0)
		                                			{
		                                				if($imageInfo[0]<=150)
			                                			{
			                                				$imgWidth = $imageInfo[0].'px;';
			                                			}
		                                			}

		                                			if($imgWidth==' px;' || $imgWidth=='px;')
		                                			{
		                                				$imgWidth = '150px;';
		                                			}

		                                			$leafData['contents'] = '<p><img src="'.$match[1].'" style="width: '.$imgWidth.'" class="fr-fil fr-dib"></p>';
		                                			
		          
		                                			// $leafData['contents'] = str_replace("100%",$imgWidth,$leafData['contents']);
		                                			$isFileContent = 1;
		                                		}

	                                		} 
	                                	}
	                                	
	                                    $leafdataContent=strip_tags($leafData['contents']);
	                                    if (strlen($leafdataContent) > 25) 
	                                    {
	                                        $leafTitle = substr($leafdataContent, 0, 25) . "..."; 
	                                    }
	                                    else
	                                    {
	                                        $leafTitle = $leafdataContent;
	                                    }
	                                    if($leafTitle=='')
	                                    {
	                                    	if($isFileContent==1)
	                                    	{
	                                    		$leafTitle = $leafData['contents'];
	                                    	}
	                                    	else
	                                    	{
	                                        	$leafTitle = $this->lang->line('content_contains_only_image');
	                                    	}
	                                    }
	                                    else
	                                    {
	                                    	if($isFileContent==1)
	                                    	{
	                                    		$leafTitle = $leafData['contents'];
	                                    		// $newLeafData = explode('<img', $leafData['contents']);

	                                    		// if(count($newLeafData)>1)
	                                    		// {
	                                    		// 	if (strlen($newLeafData[0]) > 25) 
				                                   //  {
				                                   //      $subContent = substr($newLeafData[0], 0, 25) . "...<br/>";  
				                                   //  }
				                                   //  else
				                                   //  {
				                                   //  	$subContent = $newLeafData[0].'<br/>';
				                                   //  }

				                                   //  $leafData['contents'] = str_replace($newLeafData[0],$subContent,$leafData['contents']);
	                                    		// }
	                                    		
	                                    		// $leafTitle = $leafData['contents'];
	                                    	}
	                                    }
	                                    /*Dashrath- code end*/
	                                }
	                                
	                                //Condition for object and action id end
	                                
	                                if($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7)
	                                {
	                                    if($treeContent!='')
	                                    {
	                                        $leafTitle = $treeContent;
	                                    }
	                                }
	                                
	                                if(count($action_user_ids)>0)
	                                {
	                                    //Set notification dispatch data start
	                                    if($workSpaceId==0)
	                                    {
	                                        //$workSpaceMembers = $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
	                                        if($workSpaceType == 0 || $workSpaceType == '')
	                                        {                   
	                                            $work_space_name = '';
	                                        }
	                                        else
	                                        {
	                                            $work_space_name = $this->lang->line('txt_My_Workspace');
	                                        }
	                                    }
	                                    else
	                                    {
	                                        if($workSpaceType == 1)
	                                        {                   
	                                            $workSpaceDetails   = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
	                                            $work_space_name = $workSpaceDetails['workSpaceName'];
	                                        }
	                                        else if($workSpaceType == 2)
	                                        {               
	                                            $workSpaceDetails   = $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
	                                            $work_space_name = $workSpaceDetails['subWorkSpaceName'];
	                                        }
	                                    }
	                                    
	                                    $getSummarizationUserIds = array_map("unserialize", array_unique(array_map("serialize", array_reverse($action_user_ids))));
	                                    foreach($getSummarizationUserIds as $key =>$user_id)
	                                    {
	                                        if($user_id==$userId || $user_id==0)
	                                        {
	                                            unset($getSummarizationUserIds[$key]);
	                                        }
	                                    }
	                                    $recepientUserName='';
	                                                                    
	                                    $i=0;
	                                    $otherTxt='';
	                                    if(count($getSummarizationUserIds)>2)
	                                    {
	                                        $totalUsersCount = count($getSummarizationUserIds)-2;   
	                                        $otherTxt=str_replace('{userName}', $totalUsersCount ,$this->lang->line('txt_summarize_msg'));
	                                    }
	                                    foreach($getSummarizationUserIds as $user_id)
	                                    {
	                                        if($i<2)
	                                        {
	                                            $getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
	                                            if($getUserName['userTagName']!='')
	                                            {
	                                                //$recepientUserNameArray[] = $getUserName['firstName'].' '.$getUserName['lastName'];
	                                                $recepientUserNameArray[] = $getUserName['userTagName'];
	                                            }
	                                        }
	                                        $i++;
	                                    }   
	                                    $recepientUserName=implode(', ',$recepientUserNameArray).' '.$otherTxt; 
	                                    unset($recepientUserNameArray);
	                                    
	                                    //Summarize data start here
	                                
	                                    /*if($userPreferenceData['notification_type_id']==$notificationDetails['object_id'] && $userPreferenceData['notification_action_type_id']==$notificationDetails['action_id'] && $userPreferenceData['preference']==1)
	                                    {*/
	                                        //get user language preference
	                                        $userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userId);
	                                        if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
	                                        {
	                                            $getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);           
	                                            $this->lang->load($getLanguageName.'_lang', $getLanguageName);
	                                            $this->lang->is_loaded = array();   
	                                            $notification_language_id=$userLanguagePreference['notification_language_id'];
	                                                //$this->lang->language = array();
	                                        }
	                                        else
	                                        {
	                                            $languageName='english';
	                                            $this->lang->load($languageName.'_lang', $languageName);
	                                            $this->lang->is_loaded = array();   
	                                            $notification_language_id='1';
	                                        }
	                                        
	                                        
	                                                                    
	                                        //get notification template using object and action id
	                                        $getNotificationTemplate=$this->notification_db_manager->get_notification_template($objectId, $actionId, '', 'Timeline');
	                                        $getNotificationTemplate=trim($getNotificationTemplate);
	                                        $tagType='';
	                                        $userType='';
	                                        $tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);
	                                        if ($tree_type_val==1){ $treeType = 'document'; $treeName = 'document_tree.png';}
	                                        if ($tree_type_val==3){ $treeType = 'discuss';  $treeName = 'discuss_tree.png'; }
	                                        if ($tree_type_val==4){ $treeType = 'task';    $treeName = 'task_tree.png'; }
	                                        if ($tree_type_val==6) { $treeType = 'notes';      $treeName = 'notes_tree.png';}   
	                                        if ($tree_type_val==5) { $treeType = 'contact';  $treeName = 'contact_tree.png'; }
	                                        if ($objectId==3) { $treeType = 'post';  $treeName = 'post_tree.png';}
	                                        if($treeName!='')
	                                        {
	                                        	if($treeType == 'discuss')
	                                        	{
	                                        		$treeIcon='<img alt="image" title="discussion" src="'.base_url().'images/tab-icon/'.$treeName.'"/>';
	                                        	}
	                                        	else
	                                        	{
	                                        		$treeIcon='<img alt="image" title='.$treeType.' src="'.base_url().'images/tab-icon/'.$treeName.'"/>';	
	                                        	}
	                                            
	                                        }
	                                        $leafIcon='<img title="leaf" src="'.base_url().'images/tab-icon/leaf_icon.png"/>';
	                                        if($objectId==4){ $tagType = 'simple tag'; }
	                                        if($objectId==5){ $tagType = 'action tag'; }
	                                        if($objectId==6){ $tagType = 'contact tag';}
	                                        if($objectId==15 || $objectId==14 || $objectId==1 || $objectId==2){ $userType = 'user'; }
	                                        if($objectId==16){ $userType = 'place manager'; }
	                                        if(tagType!='')
	                                        {
	                                            $tagIcon='<img alt="image" title="'.$tagType.'" src="'.base_url().'images/tab-icon/tag_icon.png"/>';
	                                        }
	                                        $linkIcon='<img alt="image" title="link" src="'.base_url().'images/tab-icon/link_icon.png"/>';
	                                        $talkIcon='<img alt="image" title="talk" src="'.base_url().'images/tab-icon/talk_tree.png"/>';
	                                        $fileIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/file_import.png"/>';
	                                        if($userType!='')
	                                        {
	                                            $userIcon='<img alt="image" title="'.$userType.'" src="'.base_url().'images/tab-icon/user.png"/>';
	                                        }
	                                        $user_template = array("{username}", "{treeType}", "{spacename}", "{subspacename}", "{leafContent}", "{treeContent}", "{memberName}", "{fileName}", "{talkContent}", "{summarizeName}", "{leafIcon}", "{treeIcon}", "{tagIcon}", "{linkIcon}", "{talkIcon}", "{fileIcon}", "{userIcon}", "{content}", "{actionCount}");
	                                        $user_translate_template   = array($recepientUserName, $treeType, $work_space_name, $work_space_name, $leafTitle, $treeContent, $memberName, $fileName, $talkContent, $summarizeData, $leafIcon, $treeIcon, $tagIcon, $linkIcon, $talkIcon, $fileIcon, $userIcon, $leafTitle, $action_count);
	                                                                        
	                                        $notificationContent=array();
	                                        $notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
	                                        
	                                        
	                                        if(($objectId =='2' && $actionId=='1') || $actionId=='4' || $actionId=='14' || $actionId=='5' || $actionId=='6')
	                                        {
	                                            $personalize_status ='';
	                                            if($treeId != '' && $treeId != '0')
	                                            {
	                                                $objectFollowStatus = $this->identity_db_manager->get_follow_status($userId,$treeId);
	                                            }
	                                            if($objectFollowStatus['preference']==1)
	                                            {
	                                                $personalize_status='1';
	                                            }
	                                            
	                                        }                                           
	                                                                                    
	                                        if($actionId=='2' || $actionId=='11' || $actionId=='13')
	                                        {
	                                            $personalize_status ='';
	                                            $originatorUserId=$this->notification_db_manager->get_object_originator_id($objectId,$objectInstanceId);
	                                            if($treeId != '' && $treeId != '0')
	                                            {
	                                                $objectFollowStatus = $this->identity_db_manager->get_follow_status($userId,$treeId);
	                                            }
	                                            if($originatorUserId==$userId || $postFollowStatus==1 || $objectFollowStatus['preference']==1)
	                                            {
	                                                $personalize_status='1';
	                                            }
	                                            
	                                        }
	                                        // if($tree_type_val==1)
	                                        // {    
	                                            $notificationContentArray[] = array(
	                                                'notification_data' => $notificationContent['data'],
	                                                'url' => $url,
	                                                'create_time' => $created_date,
	                                                'objectId' => $objectId,
	                                                'actionId' => $actionId,
	                                                'personalize_status' => $personalize_status,
	                                                'treeType' => $tree_type_val,
	                                                'work_space_name' => $work_space_name,
	                                                'tree_type_space_id' => $workSpaceId,
	                                                'parent_object_id' => $parent_object_id,
	                                                'objectInstanceId' => $objectInstanceId,
	                                            );
	                                        // }
	                                    /*}*/
	                                    //Summarize data end here
	                                }
	                                    unset($action_user_ids);
	                                //notification end here
                                }//if end
                            }//foreach end
                        }
                    }
                }
            }
        //}
        // echo "<pre>";
        // print_r($notificationContentArray);die;
        foreach ($notificationContentArray as $key => $node) {
            $timestamps[$key]=strtotime($node['create_time']) ;
        }
        array_multisort($timestamps, SORT_DESC, $notificationContentArray);

       
        
        //$notificationDataArray['notificationData']=$notificationContentArray;
        return $notificationContentArray;
        //Notification code end here
        
        //Comment code by : Dashrath
        // echo json_encode($notificationDataArray);
        // exit;   
	}
	//Dashrath : getTreeTimeline function end

	//Added by Dashrath- imageOrientationChange function start
	function imageOrientationChange($tmpName, $extension)
	{

		if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" )
		{
			$image = imagecreatefromjpeg($tmpName);

			$exif = exif_read_data($tmpName);

	    	if(isset($exif['Orientation'])) {
	        	$orientation = $exif['Orientation'];
	    	}
		}
		
    	if(isset($orientation)) 
    	{
            switch($orientation) 
            {
                case 3:
                    $image = imagerotate($image, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($image, -90, 0);
                    break;
                case 8:
                    $image = imagerotate($image, 90, 0);
                    break;
            }
        }

	    return $image;
	}
	//Dashrath : imageOrientationChange function end

	//Added by dashrath : checkFolderAndFilesByFolderName function start
	function checkFolderAndFilesByFolderName($workSpaceId, $workSpaceType, $userId, $selFolderName)
	{
		$folderData = array();
		$filesData = array();

		$query = $this->db->query('SELECT a.* FROM teeme_folders a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.userId='.$userId.' AND a.name="'.$selFolderName.'"');
			
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				$folderData['folderId'] = $row->id;
				$folderData['folderName'] = $row->name;
			}
		}

		//get files 
		if(count($folderData)>0)
		{
			$folderId = $folderData["folderId"];
			$query1 = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND  a.workSpaceId='.$workSpaceId.' AND a.userId='.$userId.' AND a.folderId='.$folderId);
			

			if($query1->num_rows() > 0)
			{
				foreach ($query1->result() as $row)
				{	
					$filesData[] = $row;
				}
			}

		}

		$data['folderData'] = $folderData;
		$data['filesData'] = $filesData;

		return $data;
	}
	//Dashrath : checkFolderAndFilesByFolderName function end

	//Added by dashrath- updateAlreadyExistsFile function start
	function updateAlreadyExistsFile($workSpaceId, $workSpaceType, $userId, $folderId, $fileId, $fileName)
	{
		$bResult  = $this->db->query('UPDATE teeme_external_docs SET docName=\''.$this->db->escape_str($fileName).'\' WHERE workSpaceId='.$workSpaceId.' AND workSpaceType='.$workSpaceType.' AND userId='.$userId.' AND folderId='.$folderId.' AND fileId='.$fileId);			
		if($bResult)
		{									
			return true;
		}	
		else
		{
			return false;
		}		
	}
	//Dashrath- updateAlreadyExistsFile function end

	//Added by dashrath- getLatestVersionOfFile function start
	function getLatestVersionOfFile($workSpaceId, $workSpaceType, $folderId, $docCaption)
	{
		$docVersion = 0;
		$query = $this->db->query('SELECT a.version FROM teeme_external_docs a, teeme_users b WHERE a.docCaption = \''.$this->db->escape_str($docCaption).'\' a.userId = b.userId AND a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.folderId='.$folderId.'ORDER BY a.createdDate DESC LIMIT 1');

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				$docVersion = $row->version+1;
			}
		}

		return $docVersion;		
	}
	//Dashrath- getLatestVersionOfFile function end

	/*Added by dashrath- getFileOrder function start */
	public function getFileOrder($workSpaceId, $workSpaceType, $folderId)
	{
		$fileOrder = 1;

		$query = $this->db->query('SELECT MAX(file_order) As `fileOrder` FROM teeme_external_docs WHERE workSpaceId='.$workSpaceId.' AND workSpaceType='.$workSpaceType.' AND folderId='.$folderId);
		
		foreach($query->result() as $row)
		{
			$fileOrder	= $row->fileOrder+1;

		}	
		
		return $fileOrder;
	}
	/*Dashrath- getFileOrder function end*/

	/*Added by dashrath- updateFileOrder function start */
	public function updateFileOrder($fileId)
	{
		if($fileId>0)
		{
			$fileData = array();

			$query = $this->db->query('SELECT a.* FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND a.docId='.$fileId);

			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$fileData['workSpaceId'] = $row->workSpaceId;
					$fileData['workSpaceType'] = $row->workSpaceType;
					$fileData['folderId'] = $row->folderId;
					$fileData['file_order'] = $row->file_order;
				}
			}

			if(count($fileData)>0)
			{
				$workSpaceId = $fileData['workSpaceId'];
				$workSpaceType = $fileData['workSpaceType'];
				$folderId = $fileData['folderId'];
				$fileOrder = $fileData['file_order'];

				if($fileOrder>0)
				{
					$qResult  = $this->db->query('UPDATE teeme_external_docs SET file_order = (file_order-1) WHERE workSpaceId='.$workSpaceId.' AND workSpaceType='.$workSpaceType.' AND folderId='.$folderId.' AND file_order>'.$fileOrder);
	
					if($qResult)
					{									
						return true;
					}	
					else
					{
						return false;
					}	

				}
			}
		}
		
	}
	/*Dashrath- updateFileOrder function end*/


	/*Added by dashrath- updateFileOrderInDb function start */
	public function updateFileOrderInDb($workSpaceId, $workSpaceType, $fileId, $fileIndex)
	{
		$fileOrder = $fileIndex+1;

		$qResult  = $this->db->query('UPDATE teeme_external_docs SET file_order ='.$fileOrder.' WHERE workSpaceId='.$workSpaceId.' AND workSpaceType='.$workSpaceType.' AND docId='.$fileId);
	
		if($qResult)
		{									
			return true;
		}	
		else
		{
			return false;
		}	
	}
	/*Dashrath- updateFileOrderInDb function end*/

	/*Added by Dashrath- getPostNodeIdByLeafId function end*/
	public function getPostNodeIdByLeafId($leafId)
	{
		$postNodeId = 0;
		$query = $this->db->query('SELECT predecessor FROM teeme_node WHERE leafId='.$leafId);								
		foreach($query->result() as $row)
		{
			$postNodeId = $row->predecessor;
		}	
		return $postNodeId; 		
	}
	/*Dashrath- getPostNodeIdByLeafId function end*/

	/*Added by Dashrath- getSpaceIdAndTypeByDefaultSpace function end*/
	public function getSpaceIdAndTypeByDefaultSpace($defaultSpace)
	{
		$data = array();

		$spaceIdDetailArray = explode( ',', $defaultSpace);
		if(count($spaceIdDetailArray)>1)
		{
			$data['defaultWorkSpaceId'] = $spaceIdDetailArray[1];
			$data['defaultWorkSpaceType'] = 2;
		}
		else
		{
		 	$data['defaultWorkSpaceId'] = $spaceIdDetailArray[0];
			$data['defaultWorkSpaceType'] = 1;
		}

		return $data;
				
	}
	/*Dashrath- getSpaceIdAndTypeByDefaultSpace function end*/

	/*Added by Dashrath- getFolderIdByDocId function end*/
	public function getFolderIdByDocId($docId)
	{
		$folderId = 0;

		$query = $this->db->query('SELECT a.folderId FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND a.docId='.$docId);
	
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				$folderId = $row->folderId;
			}
		}

		return $folderId;
				
	}
	/*Dashrath- getFolderIdByDocId function end*/

	/*Added by Dashrath- generateRandomToken function end*/
	public function generateRandomToken()
	{
		$length = 64;
		$token = bin2hex(random_bytes($length)).time();
		return $token;	
	}
	/*Dashrath- generateRandomToken function end*/

	/*Added by Dashrath- updateLoggedInToken function end*/
	public function updateLoggedInToken($userId,$loggedInToken='')
	{
		if($userId!='')
		{
			$query = "UPDATE teeme_users SET loggedInToken='".$loggedInToken."' WHERE userId='".$userId."'";
			
			$queryResult = $this->db->query($query);
	
			if($queryResult)
			{
				return true;
			}		
			else
			{
				return false;
			}
		}	
	}
	/*Dashrath- updateLoggedInToken function end*/

	/*Added by Dashrath- logIn*/
	function logIn($userName, $password, $workPlaceId, $contName, $remember, $timezoneName, $cookieSet='', $loggedInToken='', $config=0)
	{

		//Add if else condition for send config
		if($cookieSet=='cookie_set' && $loggedInToken!='' && $config!=0)
		{
			$config = $config;
		}
		else
		{
			$config='0';
		}

		$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');	
		$objIdentity	= $this->identity_db_manager;

		/* Set time difference between browser and server */
		//$_SESSION['timeDiff'] = $this->input->post('timeDiff');
		
		//echo "Time= " .$this->input->post('timeDiff'); exit;


		// $userName		 	= trim($this->input->post('userName'));
		
		// $password 			= trim($this->input->post('userPassword'));
		
		//Changed by Dashrath- Add $config parameter 
		$userCommunityId = $objIdentity->getUserCommunityIdByUsername($userName, $config);
		// $workPlaceId 		= $this->input->post('workPlaceId');
		// $contName 			= $this->input->post('contName');	
		
		$workPlaceStatus = $objIdentity->getWorkPlaceStatus ($workPlaceId);
		
		//Manoj: Get user information by work place id
		//Changed by Dashrath- replace 0 to  $config parameter 
		$UserInfo = $objIdentity->getUserDetailsByUsername($userName,$config,$workPlaceId);
		

		//echo '<pre>';
		//print_r($UserInfo); exit;		
		//$query = $this->db->query('SELECT userId, userName, password, needPasswordReset, tagName, firstName, lastName,photo,status,isPlaceManager FROM teeme_users WHERE userName=\''.$this->db->escape_str(trim($this->input->post('userName'))).'\' AND workPlaceId =\''.$workPlaceId.'\'');

		
		//$query->num_rows();
		//if($query->num_rows()>0)
		if(count($UserInfo)>0)
		{
			//$row=$query->row();
			//$userGroup = $this->identity_db_manager->getUserGroupByMemberId($row->userId);
			//Changed by Dashrath- Add $config parameter
			$userGroup = $this->identity_db_manager->getUserGroupByMemberId($UserInfo['userId'], $config);

			/*$config['hostname'] = base64_decode($this->config->item('hostname'));
			$config['username'] = base64_decode($this->config->item('username'));
			$config['password'] = base64_decode($this->config->item('password'));
			$config['database'] = $this->config->item('instanceDb');
			$config['dbdriver'] = $this->db->dbdriver;
			$config['dbprefix'] = $this->db->dbprefix;
			$config['pconnect'] = FALSE;
			$config['db_debug'] = $this->db->db_debug;
			$config['cache_on'] = $this->db->cache_on;
			$config['cachedir'] = $this->db->cachedir;
			$config['char_set'] = $this->db->char_set;
			$config['dbcollat'] = $this->db->dbcollat;
			
			$instancedb = $this->load->database($config,TRUE);*/
			
			
			//$statusCheck = $instancedb->query("SELECT * FROM `teeme_work_place` WHERE `workPlaceId`='$workPlaceId'");
			//$workPlaceData = $statusCheck->row();
			
			//Get work place status
			$workPlaceData = $objIdentity->getWorkPlaceDetails($workPlaceId); 
			//echo '<pre>';
			//print_r($workPlaceData); exit;
			//echo $workPlaceData['status'];exit;
			
			if($workPlaceData['status']==0){
				$_SESSION['errorMsg'] = $this->lang->line('place_not_active');
				return 'place_not_active';				
				//redirect('/'.$contName, 'location');
			}
			elseif($UserInfo['status']==1){
				$_SESSION['errorMsg'] = $this->lang->line('user_not_active');
				return 'user_not_active';				
				//redirect('/'.$contName, 'location');
			}
			else
			{
				//Added by Dashrath- check token and password
				if($cookieSet=='cookie_set' && $loggedInToken!='')
				{
					if($loggedInToken==$UserInfo['loggedInToken'])
					{
						$verifyCredential = 1;
					}
					else
					{
						return 'token_invaild';
					}
					
				}
				else
				{
					$verifyCredential = $this->identity_db_manager->verifySecurePassword($password,$UserInfo['password']);
				}
				//Dashrath- code end

				//verify User password
				//Changed by Dashrath- change for check both token or password
				// if ($this->identity_db_manager->verifySecurePassword($password,$UserInfo['password']))	
				// {
				if ($verifyCredential)
				{

					/*Added by Dashrath- Keep me logged in feature*/
					if($remember)
					{
						$loggedInToken = $this->identity_db_manager->generateRandomToken();

						if($loggedInToken)
						{
							$updRes = $this->identity_db_manager->updateLoggedInToken($UserInfo['userId'], $loggedInToken);

							if($updRes)
							{
								$cookieValueArray = array();
								//set cookie for checkbox
								$cookieValueArray['keep_me_logged_in'] = 1;
							
								//set cookie for login details
								$cookieValueArray['user_detail'] = $userName.':'.$workPlaceId.':'.$timezoneName.':'.$loggedInToken;

								//cookie set time 2 year
								setcookie('rememberme', base64_encode(serialize($cookieValueArray)), time()+63072000, '/');
							}										
						}	
					}
					/*Dashrath- code end*/

					$hasSpace = $this->identity_db_manager->hasWorkspace($UserInfo['userId'], $config);
					
					//try teeme condition for guest users 
					$countWorkspace = $this->identity_db_manager->countWorkspace($UserInfo['userId'], $config);
					$workSpaces = $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $workPlaceId,$UserInfo['userId'], $config );
					
					if($countWorkspace==1 && $userGroup==0)
					{
						foreach($workSpaces as $keyVal=>$workSpaceData)
						{
							if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$UserInfo['userId'],$config) && $workSpaceData['status']>0)
							{
								if($workSpaceData['workSpaceId']==1)
								{
									$_SESSION['errorMsg'] = $this->lang->line('txt_No_Space_Assigned');	

									return 'no_space_assigned';			
									//redirect('/'.$contName, 'location');	
								}
							}
						}
					}
					//condition end
												
					if ($userGroup!=0 || ($userGroup==0 && $hasSpace>0))
					{
						if($userGroup!=0)
						{
							if ($UserInfo['needPasswordReset']==1)
							{
								$needPasswordReset =1;
							}
						}
					
						$_SESSION['errorMsg'] = '';
						$_SESSION['workPlaceId']				= $workPlaceId;
						$_SESSION['contName'] 					= $contName;
						
						if ($UserInfo['isPlaceManager']==1)
						{
							$_SESSION['workPlaceManagerName'] 		= $UserInfo['userName'];	
						}
						
						//Manoj: Set full name of placemanager
						$_SESSION['workPlaceManagerFullName'] 	= $UserInfo['firstName'].' '.$UserInfo['lastName'];
						$_SESSION['userId'] 					= $UserInfo['userId'];
						$_SESSION['userName'] 					= $UserInfo['userName'];
						$_SESSION['firstName'] 					= $UserInfo['firstName'];
						$_SESSION['lastName'] 					= $UserInfo['lastName'];
						$_SESSION['workPlaceManagerPassword']	= $UserInfo['password'];
						$_SESSION['photo'] 						= $UserInfo['photo'];
						$_SESSION['userGroup'] 					= $UserInfo['userGroup'];
						$_SESSION['lang']						= 'english';
						if($UserInfo['nickName']!='')
						{
							$_SESSION['userTagName'] 				= $UserInfo['nickName'];
						}
						else
						{
							$_SESSION['userTagName'] 				= $UserInfo['tagName'];
						}
						
						//Set cookie for placename
						setcookie('place',$contName);
						
						$_SESSION['editor_upload_path'] = 'teeme'.DIRECTORY_SEPARATOR.'workplaces'.DIRECTORY_SEPARATOR.$contName.DIRECTORY_SEPARATOR.'editor_uploads';
						
						
						//echo $_SESSION['editor_upload_path']; exit;
						
						// For server
						//$_SESSION['editor_upload_path'] = 'workplaces'.DIRECTORY_SEPARATOR.$contName.DIRECTORY_SEPARATOR.'editor_uploads';
						
					}
					else
					{
						$_SESSION['errorMsg'] = $this->lang->line('txt_No_Space_Assigned');

						return 'no_space_assigned';				
						//redirect('/'.$contName, 'location');	
					}
					
					$editor = $objIdentity->getUserConfigSettings($config);

					/*if(!empty($editor)){
						
						$defaultSpace = $editor['defaultSpace'];
						if($editor['editorOption']=='No'){
							setcookie('disableEditor',1,0,'/');
						}
						else{
							setcookie('disableEditor',0,0,'/');	
						}
					}
					else{
						if ($userGroup==0)
						{
							$defaultSpace = $hasSpace;
						}
						else
						{
							$defaultSpace = 0;
						}
						setcookie('disableEditor',0,0,'/');
					}*/
					$defaultSpace = $UserInfo['defaultSpace'];

					/*Added by Dashrath- getSpaceIdAndTypeByDefaultSpace*/
					if($defaultSpace != '' && $defaultSpace != 0)
					{
						$spaceDetails = $this->identity_db_manager->getSpaceIdAndTypeByDefaultSpace($defaultSpace);

						$defaultSpace = $spaceDetails['defaultWorkSpaceId'];
						$workSpaceType = $spaceDetails['defaultWorkSpaceType'];
					}
					else
					{
						$defaultSpace = 0;
						$workSpaceType = 1;
					}
					/*Dashrath- code end*/ 
					
					/*$objMemCache = new Memcached;
					$objMemCache->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/
					//Manoj: get memcache object
					$objMemCache=$objIdentity->createMemcacheObject();
					//echo count($objMemCache->getServerList()).'test'; exit;
					/*if(count($objMemCache->getServerList())==0)
					{
						$objIdentity->displayMemcachedError($this->config->item('memcache_host'), $this->config->item('port_no'));
					}*//*
					if(!$objMemCache->getServerStatus($this->config->item('memcache_host'),$this->config->item('port_no')))
					{
						$objIdentity->displayMemcachedError($this->config->item('memcache_host'), $this->config->item('port_no'));
					}
					*/

					$memCacheId = 'wp'.$_SESSION['workPlaceId'].'user'.$_SESSION['userId'];
					$value = $objMemCache->get($memCacheId);

					if(!$value)
					{						
						$objMemCache->set($memCacheId,$UserInfo);
					}

					//Added by Dashrath- update only login case
					if($cookieSet=='' || $loggedInToken=='')
					{							
						$objIdentity->updateLogin();
						$objIdentity->updateLoginTime();
					}
					//Dashrath- code end
						
					/*Manoj: update user timezone start here*/
					$timezoneDetails = $this->identity_db_manager->getTimezoneNames();
					//$timezoneName = trim($this->input->post('timezoneName'));
					//$timezoneName='Australia/Canberra';
					$timezoneArray = explode('/',$timezoneName);
					
					//Added by Dashrath- update only login case
					if($cookieSet=='' || $loggedInToken=='')
					{
						foreach($timezoneDetails as $timezoneData)
						{
							//echo $timezoneData['timezone_name'].'===='.$timezoneData['timezoneid'].'======'.$timezoneName;
							if(preg_match('/'.$timezoneArray[1].'/', $timezoneData['timezone_name']))
							{
								$this->identity_db_manager->updateUserTimeZone($_SESSION['userId'],$timezoneData['timezoneid']);
							}
						}
					}
					//Dashrath- code end
					/*Manoj: update user timezone end here*/
					
						//Manoj: get place and user timezone start
						//Changed by Dashrath- replace 0 to $config parameter 
						$UserPersonalInfo = $this->identity_db_manager->getUserDetailsByUsername($userName,$config,$workPlaceId);
						$placeTimezoneOffset = $this->identity_db_manager->get_timezone_offset($workPlaceData['placeTimezone'],$workPlaceData['companyName']);
						if($placeTimezoneOffset!='')
						{
							$_SESSION['placeTimezone'] 			= $placeTimezoneOffset;
						}
						
						$userTimezoneOffset = $this->identity_db_manager->get_timezone_offset($UserPersonalInfo['userTimezone']);
						if($userTimezoneOffset!='')
						{
							$_SESSION['userTimezone'] 			= $userTimezoneOffset;
						}
						else
						{
							$_SESSION['userTimezone'] 			= $placeTimezoneOffset;
						}
						if($_SESSION['placeTimezone']!='' && $_SESSION['userTimezone']!='')
						{
							$_SESSION['timeDiff'] = ($_SESSION['userTimezone'])-($_SESSION['placeTimezone']);
						}
						//Manoj: get place and user timezone end
					
					
					
					//$_SESSION['WPManagerAccess'] = $objIdentity->checkManager($_SESSION['userId'], $_SESSION['workPlaceId'], 1);
					//Changed by Dashrath- Add $config parameter
					if ($objIdentity->isPlaceManager($_SESSION['workPlaceId'],$_SESSION['userId'],$config)>0)
					{
						$_SESSION['WPManagerAccess'] = 1;
					}
					
					
						
					// Parv - Unlock all the locked leaves by this user
					$this->load->model('container/leaf');
					$this->load->model('dal/document_db_manager');
					$this->leaf->setLeafUserId($_SESSION['userId']);

					//Changed by Dashrath- Add $config parameter
					$this->document_db_manager->unlockLeafByUserId($this->leaf,$config);
					
					//check terms and condition check start
						
					if ($UserInfo['terms']==0)
					{
						$_SESSION['workPlaceIdTerms'] = $_SESSION['workPlaceId'];
						$_SESSION['userNameTerms'] = $_SESSION['userName']; 
						$_SESSION['userIdTerms'] = $_SESSION['userId'];
						$_SESSION['workPlaceManagerNameTerms'] = $_SESSION['workPlaceManagerName'];
						unset($_SESSION['workPlaceId']); 
						unset($_SESSION['userName']);
						unset($_SESSION['userId']);
						unset($_SESSION['workPlaceManagerName']);
						//redirect('terms_and_conditions', 'location');

						$redirectUrl = 'terms_and_conditions';
						return $redirectUrl;
					}
							
					//check terms and condition check end							
					
					if($needPasswordReset==1)
					{
						//redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
						//redirect('dashboard/password_reset/0/type/1', 'location');
						$redirectUrl = 'dashboard/password_reset/0/type/1';
						return $redirectUrl;
					}
					else
					{
						/* Added by Parv - email test start */
						
						/*$to      = 'parv.neema@teeme.net';
						$subject = $userName .' logged in';
						$message = 'username: ' .$userName .', password= '.$password;
						$headers = 'From: admin@teeme.net' . "\r\n" .'Reply-To: admin@teeme.net' . "\r\n" .'X-Mailer: PHP/' . phpversion();

						mail($to, $subject, $message, $headers);*/
						
						/* Added by Parv - email test end */
						
						//redirect('workspace_home2/updated_trees/'.$defaultSpace.'/type/1', 'location');
						
						//$workSpaces = $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
						
						if ($userGroup==0 && $hasSpace>0 && $defaultSpace==0)
						{
							foreach($workSpaces as $keyVal=>$workSpaceData)
							{
								if($workSpaceData['workSpaceId']!=1)
								{
									
									if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'],$config) && $workSpaceData['status']>0)
									{    
										// redirect('dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1', 'location');
										$redirectUrl = 'dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1';
										return $redirectUrl;
									}
									
								}
							}
						}
						
						if ($defaultSpace!=0)
						{
							/*Commented by Dashrath- Comment old if condition and add new if and else if condition below*/
							// if ($this->identity_db_manager->isWorkSpaceMember($defaultSpace,$_SESSION['userId']))
							// {    
							// 		redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');
							// }

							/*Added by Dashrath- replace if condition and add new else if condition*/
							if ($workSpaceType==1 && $this->identity_db_manager->isWorkSpaceMember($defaultSpace,$_SESSION['userId'],$config)==1)
							{    
								//redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');

								$redirectUrl = 'dashboard/index/'.$defaultSpace.'/type/1';
								return $redirectUrl;
							}
							else if($workSpaceType==2 && $this->identity_db_manager->isSubWorkSpaceMember($defaultSpace,$_SESSION['userId'],2,$config)==1)
							{
								//redirect('dashboard/index/'.$defaultSpace.'/type/2', 'location');

								$redirectUrl = 'dashboard/index/'.$defaultSpace.'/type/2';
								return $redirectUrl;
							}
							else
							{
								if ($userGroup!=0)
								{
									//redirect('dashboard/index/0/type/1', 'location');

									$redirectUrl = 'dashboard/index/0/type/1';
									return $redirectUrl;
								}
								else
								{
									foreach($workSpaces as $keyVal=>$workSpaceData)
									{
										if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) && $workSpaceData['status']>0)
										{    
											//redirect('dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1', 'location');

											$redirectUrl = 'dashboard/index/'.$workSpaceData['workSpaceId'].'/type/1';
											return $redirectUrl;
										}
									}
								}
							}
						}
						
						/*Commented by Dashrath- Add new code below with if else condtion*/
						//redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');

						/*Added by Dashrath- Add if else condition*/
						if ($workSpaceType==2)
						{
							//redirect('dashboard/index/'.$defaultSpace.'/type/2', 'location');

							$redirectUrl = 'dashboard/index/'.$defaultSpace.'/type/2';
							return $redirectUrl;
						}
						else
						{
							//redirect('dashboard/index/'.$defaultSpace.'/type/1', 'location');

							$redirectUrl = 'dashboard/index/'.$defaultSpace.'/type/1';
							return $redirectUrl;
						}
						/*Dashrath- code end*/
					}
				}
				else
				{
					$_SESSION['errorMsg'] = $this->lang->line('Error_invalid_password');

					return 'invalid_password';	
					//redirect('/'.$contName, 'location');
				}
			}
		}
		else
		{
			$_SESSION['errorMsg'] = $this->lang->line('msg_login_error');
			return 'login_error';	
			//redirect('/'.$contName, 'location');
		}	
	}
	/*Dashrath- logIn function end*/

	/*Added by Dashrath- loginByCookieDetails*/
	function loginByCookieDetails($cookieDetails, $workPlaceName='')
	{
		if($cookieDetails['keep_me_logged_in']!='' && $cookieDetails['user_detail']!='')
		{
			list ($userName, $workPlaceId, $timezoneName, $loggedInToken)  = explode(':', $cookieDetails['user_detail']);

			if($workPlaceId>0 && $userName!='' && $timezoneName!='' && $loggedInToken!='')
			{
				//get workPlaceDetails
				$workPlaceData = $this->identity_db_manager->getWorkPlaceDetails($workPlaceId);

				$place_name = mb_strtolower($workPlaceData['companyName']);

				//check workplace name
				if($workPlaceName!='')
				{
					if($place_name!=$workPlaceName)
					{
						return 'user_login';
					}
				}
				
				
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

				$contName = $workPlaceData['companyName'];
				$remember = '';
				$password = '';

				//call logIn function
				$res = $this->identity_db_manager->logIn($userName, $password, $workPlaceId, $contName, $remember, $timezoneName, 'cookie_set', $loggedInToken, $config);

				if($res=='place_not_active' || $res=='user_not_active' || $res=='no_space_assigned' || $res=='invalid_password' || $res=='login_error' || $res=='token_invaild')
		 		{
		 			$_SESSION['errorMsg'] = '';

					$memc=$this->identity_db_manager->createMemcacheObject();
					$memc->flush();

		 			// $this->load->view('user_login', $arrDetails);
		 			return 'user_login';
		 		}
		 		else
		 		{
		 			//redirect($res, 'location');
		 			return $res;
		 		}

			}
			else
			{
				$_SESSION['errorMsg'] = '';
				$memc=$this->identity_db_manager->createMemcacheObject();
				$memc->flush();

				// $this->load->view('user_login', $arrDetails);
				return 'user_login';
			}
		}
		else
		{
			$_SESSION['errorMsg'] = '';
			$memc=$this->identity_db_manager->createMemcacheObject();
			$memc->flush();

			// $this->load->view('user_login', $arrDetails);
			return 'user_login';
		}

	}
	/*Dashrath- loginByCookieDetails function end*/

	/*Added by Dashrath- documentAddPositionUpdate function start*/
	function documentAddPositionUpdate($treeId, $workSpaceId, $workSpaceType, $position=1)
	{
		$userId = $_SESSION['userId'];

		$query = $this->db->query("UPDATE teeme_tree SET `position`='$position' WHERE userId='$userId' AND id='$treeId' AND workspaces='$workSpaceId' AND workSpaceType='$workSpaceType'");
		
		if($query){
			return true;
		}
		else{
			return false;
		}
	}
	/*documentAddPositionUpdate function end*/

	/*Added by Dashrath- getTreeIdsByParentTreeId function start*/
	function getTreeIdsByParentTreeId($treeId)
	{
		$treeIds	= array();
	
		$query = $this->db->query( "SELECT id FROM teeme_tree WHERE parentTreeId=".$treeId);	
		 	
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				
				$treeIds[] 		= $row->id;	 
 			}
		} 
		return $treeIds;
	}
	/*getTreeIdsByParentTreeId function end*/


	/*Added by Dashrath : getLatestLeafNodeIdByNodeId function start*/
	function getLatestLeafNodeIdByNodeId($nodeId)
	{
		$this->load->model('dal/document_db_manager');

		for($i=0; $i<10000; $i++)
		{
			$successorsId = $this->document_db_manager->checkSuccessors($nodeId);

			if($successorsId>0)
			{
				$nodeId = $successorsId;
			}
			else
			{
				return $nodeId;
			}
		}

		// $node = array();

		// $query = $this->db->query('SELECT id, predecessor, successors FROM teeme_node WHERE id='.$nodeId);

		// foreach($query->result() as $row)
		// {
		// 	$node['id'] = $row->id;
		// 	$node['predecessor'] = $row->predecessor;
		// 	$node['successors'] = $row->successors;
		// }

		// if(count($node)>0)
		// {
		// 	if($node['successors'] && trim($node['successors'] != '0'))
		// 	{
		// 		echo 'succ='.$node['successors'];
		// 		$this->getLatestLeafNodeIdByNodeId($node['successors']);
		// 	}
		// 	else
		// 	{
		// 		echo ' nodeId='.$node['id'];
		// 		return $node['id'];	
		// 	}
		// }
	}
	/* getLatestLeafNodeIdByNodeId function end */

	/*This function is used for get feed data*/
	function getFeed($workSpaceId, $workSpaceType, $lastId, $limit)
	{

		$this->load->model('dal/notification_db_manager');   
   		$this->load->model('dal/identity_db_manager');  
        $this->load->model('dal/time_manager'); 
        $objIdentity    = $this->identity_db_manager;   
        $objTime    = $this->time_manager;
        $modeId = '1';

		$notificationContentArray1 = array();
        $notificationEventsData1 = $this->notification_db_manager->getFeedByWorkSpaceId($workSpaceId, $workSpaceType, $lastId, $limit);

        if(count($notificationEventsData1)>0)
        {
        	foreach($notificationEventsData1 as $notificationEventContent)
        	{

        		$objectHistory = $this->getFeed1($notificationEventContent, $workSpaceId, $workSpaceType, $lastId, $limit);

        		$notificationContentArray1[] = array(
        			'object_instance_id' => $notificationEventContent['object_instance_id'],
        			'notification_event_id' => $notificationEventContent['notification_event_id'],
        			'object_history' => $objectHistory,
        			'create_time' => $objectHistory[0]['create_time']
        		);
        	}
        }

        foreach ($notificationContentArray1 as $key => $node) 
        {
            $timestamps[$key]=strtotime($node['create_time']);
        }
        array_multisort($timestamps, SORT_DESC, $notificationContentArray1);

        // echo '<pre>';
        // print_r($notificationContentArray1);die;

        return $notificationContentArray1;

    }

	/*Added by Dashrath : getFeed function start*/
	/*This function is used for get feed data*/
	function getFeed1($notificationObjectDetails, $workSpaceId, $workSpaceType, $lastId, $limit)
	{

		$this->load->model('dal/notification_db_manager');   
   		$this->load->model('dal/identity_db_manager');  
        $this->load->model('dal/time_manager'); 
        $objIdentity    = $this->identity_db_manager;   
        $objTime    = $this->time_manager;
        $modeId = '1';

	
        // $notificationEventData = $this->notification_db_manager->getFeedByWorkSpaceId($workSpaceId, $workSpaceType, $notificationEventData['object_instance_id']);

        $notificationEventData = $this->notification_db_manager->getFeedByObjectInstanceId($notificationObjectDetails['object_instance_id'], $notificationObjectDetails['object_id'], $notificationObjectDetails['action_id'], $workSpaceId, $workSpaceType);


        foreach($notificationEventData as $notificationEventContent)
        {
            $object_instance_id=$notificationEventContent['object_instance_id'];
            $object_id=$notificationEventContent['object_id'];
            $action_id=$notificationEventContent['action_id'];

			$notificationEventsDataArray[$object_instance_id][$object_id][$action_id][] = array(
            'object_id' => $notificationEventContent['object_id'],
            'action_id' => $notificationEventContent['action_id'],
            'object_instance_id' => $notificationEventContent['object_instance_id'],
            'action_user_id' => $notificationEventContent['action_user_id'],
            'workSpaceId' => $notificationEventContent['workSpaceId'],
            'workSpaceType' => $notificationEventContent['workSpaceType'],
            'url' => $notificationEventContent['url'],
            'created_date' => $notificationEventContent['created_date'],
            'notification_data_id' => $notificationEventContent['notification_data_id'],
            'notification_event_id' => $notificationEventContent['notification_event_id']
    		);    
        }
             

        if(count($notificationEventsDataArray)>0)
        {
            foreach($notificationEventsDataArray as $key=>$objectInstanceData)
            {
                foreach($objectInstanceData as $objectInstanceValue)
                {
                	$notification_data_ids = [];
                    foreach($objectInstanceValue as $objectContent)
                    {
                        $objectContent=array_reverse($objectContent);
                        $i=0;
                        /*Changed by Dashrath- Add foreach loop for show all record for timeline and add if condition for check id in array*/
                        foreach($objectContent as $objectValue)
                        {
                        	if(!in_array($objectValue['notification_data_id'], $notification_data_ids) || $objectValue['notification_data_id']==0)
                        	{
                        		if($objectValue['notification_data_id']>0)
                        		{
                        			$notification_data_ids[]=$objectValue['notification_data_id'];
                        		}
                        	// if($objectValue['object_instance_id']!=0)
                        	// {
                        		$notification_event_id=$objectValue['notification_event_id'];
                        		$notification_data_id=$objectValue['notification_data_id'];
                        		$objectInstanceId=$objectValue['object_instance_id'];
                                $objectId=$objectValue['object_id'];
                                $actionId=$objectValue['action_id'];
                                $action_user_ids[]=$objectValue['action_user_id'];
                                $workSpaceId=$objectValue['workSpaceId'];
                                $workSpaceType=$objectValue['workSpaceType'];
                                $url=$objectValue['url'];
                                $created_date=$objectValue['created_date'];
                                $i++;
                                $action_count = $i;

                            	//notification start here
                                //Condition for object and action id start
                                $treeId='0';
                                $leafData='';
                                $treeContent='';
                                $talkContent='';
                                $treeName='';
                                $postFollowStatus='';
                                $personalize_status='';
                                $treeName1='';
                                $treeName2='';
                                $treeIcon1='';

                                if($objectId==1) //1 for tree
                                {
                                    $treeId=$objectInstanceId;  
                                    $treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
                                }
                                if($objectId==2) //2 for leaf
                                {   
                                    $treeId=$this->identity_db_manager->getTreeIdByNodeId_identity($objectInstanceId);  
                                    $leafData = $this->identity_db_manager->getNodeDetailsByNodeId($objectInstanceId);
                                    $treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);

                                    /*Added by Dashrath: code start */
                                    if($actionId!=17 && $actionId!=18 && $actionId!=9 && $actionId!=10)
									{
										
										if($notification_data_id>0)
                                    	{
                                    		$notificationDataId = $notification_data_id;
                                    	}
                                    	else
                                    	{
                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
                                    	}

										if($notificationDataId > 0)
										{
											$leafData['contents'] = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
										}
									}
									/*Dashrath: code end */
                                }
                                if($objectId==3) //3 for post
                                {   
                                    $treeId=0;
                                    $leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId);
                                    if($actionId==13)
                                    {
                                        $postFollowStatus = $this->notification_db_manager->getPostFollowStatus($userId,$objectInstanceId);
                                    }
                                }
                                /*4 for simple tag, 5 for action tag, 6 for contact tag, 7 for  	link */
                                if($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7)
                                {
                                    if($actionId==4 || $actionId==13)
                                    {
                                        if($notification_data_id>0)
                                    	{
                                    		$notificationDataId = $notification_data_id;
                                    	}
                                    	else
                                    	{
                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
                                    	}

                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
                                    }
                                    if($url=='')
                                    {
                                        $treeId=$objectInstanceId;
                                        $treeContent = $this->notification_db_manager->getTreeNameByTreeId($objectInstanceId);
                                    }
                                    else
                                    {
                                        $treeId=$this->identity_db_manager->getTreeIdByNodeId_identity($objectInstanceId);
                                        $leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,$objectId);
                                        if($treeId==0)
                                        {
                                            $postFollowStatus = $this->notification_db_manager->getPostFollowStatus($userId,$objectInstanceId);
                                            if($postFollowStatus==1)
                                            {
                                                $personalize_status='1';
                                            }
                                            $leafData = $this->notification_db_manager->getNodeDetailsByNodeId($objectInstanceId,'3');
                                            $treeType = 'post';  
                                            $treeName = 'post_tree.png';
                                        }
                                    }
                                }
                                //8 for talk
                                if($objectId==8)
                                {
									$treeId=$objectInstanceId;  
									$parentTreeId=$this->identity_db_manager->getParentTreeIdByTreeId($treeId);
									//$talkContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
									$talkContent = $this->notification_db_manager->getTreeNameByTreeId($parentTreeId);
                                    $talkContent=strip_tags($talkContent);
                                    if(strlen($talkContent) > 25)
                                    {
                                        $talkContent = substr($talkContent, 0, 25) . "..."; 
                                    }
                                }
                                //9 for file
                                if($objectId==9)
                                {
                                    // $fileName='';
                                    // $fileDetails = $this->notification_db_manager->getImportedFileNameById($objectInstanceId);
                                    // if($fileDetails['docCaption']!='')
                                    // {
                                    //     $fileName = $fileDetails['docCaption'];
                                    // }

                                    $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
										$summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);

									$fileName = $summarizeData;
                                }
                                if($objectId==14 || $objectId==1 || $objectId==2 || $objectId==3)
                                {
                                    if($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17)
                                    {
                                    	// $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
                                    	if($notification_data_id>0)
                                    	{
                                    		$notificationDataId = $notification_data_id;
                                    	}
                                    	else
                                    	{
                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
                                    	}
                                       
                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);
                                        $currentUserName='';
                                        $currentUserDetails = $this->identity_db_manager->getUserDetailsByUserId($userId);
                                        if($currentUserDetails['firstName']!='' && $currentUserDetails['lastName']!='')
                                        {
                                            $currentUserName = $currentUserDetails['firstName'].' '.$currentUserDetails['lastName'];
                                        }
                                        $summarizeData = str_replace($currentUserName,"You",$summarizeData);
                                        //echo $summarizeData; exit;
                                        if($summarizeData=='' && ($actionId==9 || $actionId==15 || $actionId==16 || $actionId==17))
                                        {
                                            $summarizeData='You';
                                        }
                                    }

                                    /*Added by Dashrath- get unassign users data*/
                                    if($actionId==10)
                                    {
                                    	// $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
                                    	if($notification_data_id>0)
                                    	{
                                    		$notificationDataId = $notification_data_id;
                                    	}
                                    	else
                                    	{
                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
                                    	}

                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);

                                    }

                                    if($actionId==18)
                                    {
                                    	// $notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);

                                    	if($notification_data_id>0)
                                    	{
                                    		$notificationDataId = $notification_data_id;
                                    	}
                                    	else
                                    	{
                                    		$notificationDataId = $this->notification_db_manager->getNotificationDataIdByInstanceId($objectInstanceId,$objectId,$actionId);
                                    	}

                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notificationDataId);

                                    }
                                    /*Dashrath- code end*/

                                    if($objectId!=2)
                                    {
                                        $treeId=$objectInstanceId;  
                                        $treeContent = $this->notification_db_manager->getTreeNameByTreeId($treeId);
                                    }
                                }
                                if($objectId==15 || $objectId==16)
                                {
                                    $memberName='';
                                    $memberDetails = $this->identity_db_manager->getUserDetailsByUserId($objectInstanceId);
                                    if($memberDetails['userTagName']!='')
                                    {
                                        $memberName = $memberDetails['userTagName'];
                                    }
                                }
                                
                                if($treeContent!='')
                                {
                                    $treeContent=strip_tags($treeContent);
                                    // if(strlen($treeContent) > 25)
                                    // {
                                    //     $treeContent = substr($treeContent, 0, 25) . "..."; 
                                    // }
                                    if(strlen($treeContent) > 50)
                                    {
                                        $treeContent = substr($treeContent, 0, 50) . "..."; 
                                    }
                                }                                       
                                if(count($leafData)>0)
                                {
                                    /*Added by Dashrath- Change condition for image,video,mp3 display in timeline*/
                                	$isFileContent = 0;
                                	if($leafData['contents']!='')
                                	{
                                		preg_match_all("#<img(.*?)\\/?>#",$leafData['contents'], $imgTags);
                                		if($imgTags[0])
                                		{
                                			
                                			preg_match( '@src="([^"]+)"@' , $leafData['contents'], $match );
	                                		if($match)
	                                		{
	                                			$imgPathInfo = explode('/', $match[1]);
	                                			$imgName = $imgPathInfo[count($imgPathInfo)-1];

	                                			$finalPath = $this->config->item('absolute_path').'workplaces/'.$_COOKIE['place'].'/editor_uploads//'.$imgName;
												
	                                			$imageInfo = getimagesize($finalPath);

	                                			$imgWidth = '150px;';

	                                			if(count($imageInfo)>0)
	                                			{
	                                				if($imageInfo[0]<=150)
		                                			{
		                                				$imgWidth = $imageInfo[0].'px;';
		                                			}
	                                			}

	                                			if($imgWidth==' px;' || $imgWidth=='px;')
	                                			{
	                                				$imgWidth = '150px;';
	                                			}

	                                			$leafData['contents'] = '<p><img src="'.$match[1].'" style="width: '.$imgWidth.'" class="fr-fil fr-dib"></p>';
	                                			
	          
	                                			// $leafData['contents'] = str_replace("100%",$imgWidth,$leafData['contents']);
	                                			$isFileContent = 1;
	                                		}

                                		} 
                                	}
                                	
                                    $leafdataContent=strip_tags($leafData['contents']);
                                    // if (strlen($leafdataContent) > 25) 
                                    // {
                                    //     $leafTitle = substr($leafdataContent, 0, 25) . "..."; 
                                    // }
                                    if (strlen($leafdataContent) > 1000) 
                                    {
                                        $leafTitle = substr($leafdataContent, 0, 1000) . "..."; 
                                    }
                                    else
                                    {
                                        $leafTitle = $leafdataContent;
                                    }
                                    if($leafTitle=='')
                                    {
                                    	if($isFileContent==1)
                                    	{
                                    		$leafTitle = $leafData['contents'];
                                    	}
                                    	else
                                    	{
                                        	$leafTitle = $this->lang->line('content_contains_only_image');
                                    	}
                                    }
                                    else
                                    {
                                    	if($isFileContent==1)
                                    	{
                                    		$leafTitle = $leafData['contents'];
                                    	}
                                    }
                                    /*Dashrath- code end*/
                                }
                                
                                //Condition for object and action id end
                                
                                if($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7)
                                {
                                    if($treeContent!='')
                                    {
                                        $leafTitle = $treeContent;
                                    }
                                }
                                
                                if(count($action_user_ids)>0)
                                {
                                    //Set notification dispatch data start
                                    if($workSpaceId==0)
                                    {
                                        //$workSpaceMembers = $this->notification_db_manager->getMySpaceSharedMembersByTreeId($treeId);
                                        if($workSpaceType == 0 || $workSpaceType == '')
                                        {                   
                                            $work_space_name = '';
                                        }
                                        else
                                        {
                                            $work_space_name = $this->lang->line('txt_My_Workspace');
                                        }
                                    }
                                    else
                                    {
                                    	$work_space_name = '';
                                        if($workSpaceType == 1 && is_numeric($workSpaceId))
                                        {                   
                                            $workSpaceDetails   = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
                                            $work_space_name = $workSpaceDetails['workSpaceName'];
                                        }
                                        else if($workSpaceType == 2 && is_numeric($workSpaceId))
                                        {               
                                            $workSpaceDetails   = $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceId);
                                            $work_space_name = $workSpaceDetails['subWorkSpaceName'];
                                        }
                                    }
                                    
                                    $getSummarizationUserIds = array_map("unserialize", array_unique(array_map("serialize", array_reverse($action_user_ids))));
                                    foreach($getSummarizationUserIds as $key =>$user_id)
                                    {
                                        if($user_id==$userId || $user_id==0)
                                        {
                                            unset($getSummarizationUserIds[$key]);
                                        }
                                    }
                                    $recepientUserName='';
                                                                    
                                    $i=0;
                                    $otherTxt='';
                                    if(count($getSummarizationUserIds)>2)
                                    {
                                        $totalUsersCount = count($getSummarizationUserIds)-2;   
                                        $otherTxt=str_replace('{userName}', $totalUsersCount ,$this->lang->line('txt_summarize_msg'));
                                    }
                                    foreach($getSummarizationUserIds as $user_id)
                                    {
                                        if($i<2)
                                        {
                                            $getUserName = $this->identity_db_manager->getUserDetailsByUserId($user_id);
                                            if($getUserName['userTagName']!='')
                                            {
                                                $recepientUserNameArray[] = $getUserName['userTagName'];
                                            }
                                        }
                                        $i++;
                                    }   
                                    $recepientUserName=implode(', ',$recepientUserNameArray).' '.$otherTxt; 
                                    unset($recepientUserNameArray);
                                    
                                   
                                    //get user language preference
                                    $userLanguagePreference=$this->identity_db_manager->getUserDetailsByUserId($userId);
                                    if(count($userLanguagePreference)>0 && $userLanguagePreference['notification_language_id']!=0)
                                    {
                                        $getLanguageName=$this->notification_db_manager->get_notification_language_name($userLanguagePreference['notification_language_id']);           
                                        $this->lang->load($getLanguageName.'_lang', $getLanguageName);
                                        $this->lang->is_loaded = array();   
                                        $notification_language_id=$userLanguagePreference['notification_language_id'];
                                            //$this->lang->language = array();
                                    }
                                    else
                                    {
                                        $languageName='english';
                                        $this->lang->load($languageName.'_lang', $languageName);
                                        $this->lang->is_loaded = array();   
                                        $notification_language_id='1';
                                    }
                                    
                                    
                                                                
                                    //get notification template using object and action id
                                    // $getNotificationTemplate=$this->notification_db_manager->get_notification_template($objectId, $actionId, '', 'Timeline');
                                    $getNotificationTemplate=$this->notification_db_manager->get_notification_template($objectId, $actionId, '');

                                    $getNotificationTemplate=trim($getNotificationTemplate);
                                    $tagType='';
                                    $userType='';
                                    $tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($treeId);

                                    /*Added by Dashrath- used in when get tree type val 2*/
                                    if($tree_type_val==2)
                                    {
                                    	$parentTreeId = 0;
	                                    $parentTreeId = $this->getParentTreeIdByTreeId($treeId);
	                                    if($parentTreeId>0)
	                                    {
	                                    	$tree_type_val=$this->identity_db_manager->getTreeTypeByTreeId($parentTreeId);
	                                    }
                                    }
                                    /*Dashrath- code end*/

                                    if ($tree_type_val==1){ $treeType = 'document'; $treeName = 'document_tree.png'; $treeName1 = 'icon_document.png';}
                                    if ($tree_type_val==3){ $treeType = 'discussion';  $treeName = 'discuss_tree.png'; $treeName1 = 'list-talk-icon.png';}
                                    if ($tree_type_val==4){ $treeType = 'task';    $treeName = 'task_tree.png'; $treeName1 = 'icon_task1.png';}
                                    if ($tree_type_val==6) { $treeType = 'notes';      $treeName = 'notes_tree.png';}   
                                    if ($tree_type_val==5) { $treeType = 'contact';  $treeName = 'contact_tree.png'; $treeName1 = 'contact_icon.png';}
                                    if ($objectId==3) { $treeType = 'post';  $treeName = 'post_tree.png'; $treeName1 = 'history-icon.png';}
                                    if($treeName!='')
                                    {
                                        $treeIcon='<img alt="image" title='.$treeType.' src="'.base_url().'images/tab-icon/'.$treeName.'"/>';
                                    }
                                    if($treeName1!='')
                                    {
                                        $treeIcon1='<img alt="image" title='.$treeType.' src="'.base_url().'images/'.$treeName1.'"/>';
                                    }

                                    $leafIcon='<img title="leaf" src="'.base_url().'images/tab-icon/leaf_icon.png"/>';
                                    if($objectId==4){ $tagType = 'simple tag'; }
                                    if($objectId==5){ $tagType = 'action tag'; }
                                    if($objectId==6){ $tagType = 'contact tag';}
                                    if($objectId==15 || $objectId==14 || $objectId==1 || $objectId==2){ $userType = 'user'; }
                                    if($objectId==16){ $userType = 'place manager'; }
                                    if(tagType!='')
                                    {
                                        $tagIcon='<img alt="image" title="'.$tagType.'" src="'.base_url().'images/tab-icon/tag_icon.png"/>';
                                    }
                                    $linkIcon='<img alt="image" title="link" src="'.base_url().'images/tab-icon/link_icon.png"/>';
                                    $talkIcon='<img alt="image" title="talk" src="'.base_url().'images/tab-icon/talk_tree.png"/>';
                                    $fileIcon='<img alt="image" title="file" src="'.base_url().'images/tab-icon/file_import.png"/>';
                                    if($userType!='')
                                    {
                                        $userIcon='<img alt="image" title="'.$userType.'" src="'.base_url().'images/tab-icon/user.png"/>';
                                    }
                                    $user_template = array("{username}", "{treeType}", "{spacename}", "{subspacename}", "{leafContent}", "{treeContent}", "{memberName}", "{fileName}", "{talkContent}", "{summarizeName}", "{leafIcon}", "{treeIcon}", "{tagIcon}", "{linkIcon}", "{talkIcon}", "{fileIcon}", "{userIcon}", "{content}", "{actionCount}");
                                    $user_translate_template   = array($recepientUserName, $treeType, $work_space_name, $work_space_name, $leafTitle, $treeContent, $memberName, $fileName, $talkContent, $summarizeData, $leafIcon, $treeIcon, $tagIcon, $linkIcon, $talkIcon, $fileIcon, $userIcon, $leafTitle, $action_count);
                                                                    
                                    $notificationContent=array();
                                    $notificationContent['data']=str_replace($user_template, $user_translate_template,$this->lang->line($getNotificationTemplate));
                                    
                                    
                                    if(($objectId =='2' && $actionId=='1') || $actionId=='4' || $actionId=='14' || $actionId=='5' || $actionId=='6')
                                    {
                                        $personalize_status ='';
                                        if($treeId != '' && $treeId != '0')
                                        {
                                            $objectFollowStatus = $this->identity_db_manager->get_follow_status($userId,$treeId);
                                        }
                                        if($objectFollowStatus['preference']==1)
                                        {
                                            $personalize_status='1';
                                        }
                                        
                                    }                                           
                                                                                
                                    if($actionId=='2' || $actionId=='11' || $actionId=='13')
                                    {
                                        $personalize_status ='';
                                        $originatorUserId=$this->notification_db_manager->get_object_originator_id($objectId,$objectInstanceId);
                                        if($treeId != '' && $treeId != '0')
                                        {
                                            $objectFollowStatus = $this->identity_db_manager->get_follow_status($userId,$treeId);
                                        }
                                        if($originatorUserId==$userId || $postFollowStatus==1 || $objectFollowStatus['preference']==1)
                                        {
                                            $personalize_status='1';
                                        }
                                        
                                    }

                                    $this->load->model('dal/profile_manager');

                                    //get online users
									$onlineUsers	= $objIdentity->getOnlineUsersByPlaceId();


                                    /*Added by Dashrath- Get talk comment data*/
                                    if($objectId==8 && $actionId==13)
                                    {
                                    	$notificationDataId = $notification_data_id;

                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notification_data_id);
                                        
                                        $summarizeData = str_replace("<p>","",$summarizeData);
                                        $summarizeData = str_replace("</p>","",$summarizeData);
                                    }
                                    //Get action tag edit or delete data*/
                                    if($objectId==5 && ($actionId==2 || $actionId==3))
                                    {
                                    	$notificationDataId = $notification_data_id;

                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notification_data_id);
                                    }
                                    //Get contact tag delete data*/
                                    if($objectId==6 && $actionId==3)
                                    {
                                    	$notificationDataId = $notification_data_id;

                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notification_data_id);
                                    }
                                    //Get simple tag delete data*/
                                    if($objectId==4 && ($actionId==3 || $actionId==1))
                                    {
                                    	$notificationDataId = $notification_data_id;

                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notification_data_id);
                                    }

                                    //Get folder create data*/
                                    if($objectId==17 && ($actionId==19 || $actionId==3))
                                    {
                                    	$notificationDataId = $notification_data_id;

                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notification_data_id);

                                        /*Added by Dashrath- trim docName*/
										if(strlen($summarizeData) > 50)
								        {
								            $summarizeData = substr($summarizeData, 0, 50) . "..."; 
								        }
										/*Dashrath- code end*/
                                    }

                                    //Get space add, edit, suspend, activate data*/
                                    if(($objectId==10 || $objectId==11) && ($actionId==1 || $actionId==2 || $actionId==7 || $actionId==8))
                                    {
                                    	$notificationDataId = $notification_data_id;

                                        $summarizeData = $this->notification_db_manager->getNotificationSummarizeData($notification_data_id);
                                    }

                                    //Get tree add, edit, start, stop data*/
                                    if($objectId==1 && ($actionId==1 || $actionId==2 || $actionId==5 || $actionId==6))
                                    {
                                    	$notificationDataId = $notification_data_id;

                                    	//if tree_type_val is 5 (contact tree)
                                    	if($tree_type_val==5)
                                    	{
                                    		$treeContent = $this->getTreeNameByTreeId($treeId);
                                    	}
                                    	else
                                    	{
                                    		$treeContent = $this->notification_db_manager->getNotificationSummarizeData($notification_data_id);
                                    	}
                                        
                                    }
                                    /*Dashrath- code end*/

									/*get feed title*/
									$feedTitle = '';
									$feedTitle = $this->getFeedTitle($objectId, $actionId, $tree_type_val);


									/*add tree name in title*/
									if($feedTitle!=$notificationContent['data'] && $treeContent!="" && $objectId!=1 && $objectId!=3 && $treeIcon1!='')
									{
										//$feedTitle = $feedTitle.' in '.$treeIcon1.' <b><i>'.$treeContent.'</i></b>';
										$feedTitle = $treeIcon1.' <b><i>'.$treeContent.'</i>: </b>'.$feedTitle;
									}
									else if($feedTitle!=$notificationContent['data'] && $treeContent!="" && $objectId==1 && $treeIcon1!='')
									{
										$feedTitle = $treeIcon1.' '.$feedTitle;
									}
									else if($feedTitle!=$notificationContent['data'] && $objectId==3 && $treeIcon1!='')
									{
										$feedTitle = $treeIcon1.' '.$feedTitle;
									}

									if($objectId==10 || $objectId==11)
								 	{
								 		$spaceIcon1='<img alt="image" title="space" src="'.base_url().'images/workspace_icon_new.png"/>';
								 		$feedTitle = $spaceIcon1.' '.$feedTitle;
								 	}
								 	else if($objectId==17)
								 	{
								 		$folderIcon1='<img alt="image" title="folder" src="'.base_url().'images/folder_icon_new.png"/>';
								 		$feedTitle = $folderIcon1.' '.$feedTitle;
								 	}
								 	else if($objectId==9)
								 	{
								 		$fileIcon1='<img alt="image" title="file" src="'.base_url().'images/manage_file.png"/>';
								 		
								 		$feedTitle = $fileIcon1.' '.$feedTitle;
								 	}
								 	else if($objectId==15 || $objectId==16)
								 	{
								 		$userIcon1='<img style="vertical-align: middle;" alt="image" title="file" src="'.base_url().'images/offline_user_backup.gif"/>';
								 		$feedTitle = $userIcon1.' '.$feedTitle;
								 	}



									//get tree name if $treeContent is blank 
									$treeName2= "";

									if($treeContent=="")
									{
										if(($objectId==4 || $objectId==5 || $objectId==6 || $objectId==7 ) && ($actionId==4 || $actionId==3))
										{
											//get tree id by node id
											$treeId2 = $this->getTreeIdByNodeId_identity($objectInstanceId);

											if($treeId2>0)
											{
												//get tree name by tree id
												$treeName2 = $this->getTreeNameByTreeId($treeId2);
											}

											//treeId 0 in post
											if($treeId2==0)
											{
												$treeName2 = $this->getLeafContentsByNodeId($objectInstanceId);

												if($treeName2!='')
				                                {
				                                    $treeName2=strip_tags($treeName2);
				                                    
				                                    if(strlen($treeName2) > 50)
				                                    {
				                                        $treeName2 = substr($treeName2, 0, 50) . "..."; 
				                                    }
				                                }    

												$treeIcon1='<img alt="image" title="post" src="'.base_url().'images/history-icon.png"/>';
											}
											
										}
										else if($objectId==8 && $actionId==13)
										{
											//when talk added
											$treeName2 = $talkContent;
										}
										
										if($feedTitle!=$notificationContent['data'] && $treeName2!="")
										{

											if($treeIcon1!='')
											{
												//$feedTitle = $feedTitle.' in '.$treeIcon1.' <b><i>'.$treeName2.'</i></b>';
												$feedTitle = $treeIcon1.' <b><i>'.$treeName2.'</i>: </b>'.$feedTitle;
											}
											else
											{
												//$feedTitle = $feedTitle.' in <b><i>'.$treeName2.'</i></b>';
												$feedTitle = '<b><i>'.$treeName2.'</i>: </b>'.$feedTitle;
											}

										}

									}
			
									/*get feed description*/
									$feedDescription = $this->getFeedDescription($objectId, $actionId, $treeContent, $leafTitle, $summarizeData, $notificationContent['data'], $memberName);

									$feedProfiledetail = array();
									$feedProfiledetail = $this->profile_manager->getUserDetailsByUserId($objectValue['action_user_id']);

									if(strlen($feedProfiledetail['userTagName']) > 18)
                                    {
                                        $feedProfiledetail['userTagName'] = substr($feedProfiledetail['userTagName'], 0, 18) . "..."; 
                                    }

									/*check user is online or offline used 1 for online and 0 for offline*/
									if (in_array($objectValue['action_user_id'],$onlineUsers))
								 	{
								 		$isOnline = 1;
								 	}
								 	else
								 	{
								 		$isOnline = 0;
								 	}


								 	//make icon url
								 	if($objectId==10 || $objectId==11)
								 	{
								 		$spaceIcon1='<img alt="image" title="space" src="'.base_url().'images/workspace_icon_new.png"/>';
								 		$iconUrl = $spaceIcon1;
								 	}
								 	else if($objectId==17)
								 	{
								 		$folderIcon1='<img alt="image" title="folder" src="'.base_url().'images/folder_icon_new.png"/>';
								 		$iconUrl = $folderIcon1;
								 	}
								 	else if($objectId==9)
								 	{
								 		$fileIcon1='<img alt="image" title="file" src="'.base_url().'images/manage_file.png"/>';
								 		
								 		$iconUrl = $fileIcon1;
								 	}
								 	else
								 	{
								 		$iconUrl = $treeIcon1;
								 	}

								 	$userActionContent = $this->getUserActionContent($objectId,$actionId, $feedProfiledetail['userTagName'], $tree_type_val);
                                      
                                    $notificationContentArray[] = array(
                                        'notification_data' => $notificationContent['data'],
                                        'url' => $url,
                                        'create_time' => $created_date,
                                        'objectId' => $objectId,
                                        'actionId' => $actionId,
                                        'personalize_status' => $personalize_status,
                                        'treeType' => $tree_type_val,
                                        'work_space_name' => $work_space_name,
                                        'tree_type_space_id' => $workSpaceId,
                                        'notification_event_id' => $notification_event_id,
                                        'action_user_id' => $objectValue['action_user_id'],
                                        'photo' => $feedProfiledetail['photo'],
                                        'userTagName' => $feedProfiledetail['userTagName'],
                                        'feedTitle' => $feedTitle,
                                        'isOnlie' => $isOnline,
                                        'feedDescription' => $feedDescription,
                                        'iconUrl' => $iconUrl,
                                        // 'feedActionUsersHistory' => $feedActionUsersHistory,
                                        'user_action_content' => $userActionContent

                                    );

                                    // echo '<pre>';
                                    // print_r($notificationContentArray);die;
                                        
                                    
                                }
                                    unset($action_user_ids);
                                //notification end here
                            }//if end
                        }//foreach end
                    }
                }
            }
        }
       
        foreach ($notificationContentArray as $key => $node) 
        {
            $timestamps[$key]=strtotime($node['create_time']) ;
        }
        array_multisort($timestamps, SORT_DESC, $notificationContentArray);

        return $notificationContentArray;
     
	}
	/*Dashrath : getFeed function end*/

	/*Added by Dashrath : getFeedTitle function start*/
	function getFeedTitle($objectId, $actionId, $tree_type_val)
	{
		//get object name
		$object = $this->getObjectNameByObjectId($objectId);

		//get action name
		$action = $this->getActionNameByActionId($actionId);

		//make feed title
		if($object=='tree' && $action=='add')
		{
			// $feedTitle = $this->lang->line('feed_txt_Tree_created');
			if($tree_type_val==1)
			{
				$feedTitle = $this->lang->line('feed_txt_Document_created');
			}
			else if($tree_type_val==3)
			{
				$feedTitle = $this->lang->line('feed_txt_Discussion_created');
			}
			else if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_created');
			}
			else if($tree_type_val==5)
			{
				$feedTitle = $this->lang->line('feed_txt_Contact_created');
			}
			else if($tree_type_val==6)
			{
				$feedTitle = $this->lang->line('feed_txt_Notes_created');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Tree_created');
			}
		}
		else if($object=='tree' && $action=='edit')
		{
			// $feedTitle = $this->lang->line('feed_txt_Tree_edited');
			if($tree_type_val==1)
			{
				$feedTitle = $this->lang->line('feed_txt_Document_edited');
			}
			else if($tree_type_val==3)
			{
				$feedTitle = $this->lang->line('feed_txt_Discussion_edited');
			}
			else if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_edited');
			}
			else if($tree_type_val==5)
			{
				$feedTitle = $this->lang->line('feed_txt_Contact_edited');
			}
			else if($tree_type_val==6)
			{
				$feedTitle = $this->lang->line('feed_txt_Notes_edited');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Tree_edited');
			}
		}
		else if($object=='tree' && $action=='new version')
		{
			// $feedTitle = $this->lang->line('feed_txt_Tree_new_version_created');
			if($tree_type_val==1)
			{
				$feedTitle = $this->lang->line('feed_txt_Document_new_version_created');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Tree_new_version_created');
			}
		}
		else if($object=='tree' && $action=='start')
		{
			// $feedTitle = $this->lang->line('feed_txt_Tree_started');
			if($tree_type_val==3)
			{
				$feedTitle = $this->lang->line('feed_txt_Discussion_started');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Tree_started');
			}
		}
		else if($object=='tree' && $action=='stop')
		{
			// $feedTitle = $this->lang->line('feed_txt_Tree_stopped');
			if($tree_type_val==3)
			{
				$feedTitle = $this->lang->line('feed_txt_Discussion_stopped');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Tree_stopped');
			}
		}
		else if($object=='tree' && $action=='move')
		{
			// $feedTitle = $this->lang->line('feed_txt_Tree_moved');
			if($tree_type_val==1)
			{
				$feedTitle = $this->lang->line('feed_txt_Document_moved');
			}
			else if($tree_type_val==3)
			{
				$feedTitle = $this->lang->line('feed_txt_Discussion_moved');
			}
			else if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_moved');
			}
			else if($tree_type_val==5)
			{
				$feedTitle = $this->lang->line('feed_txt_Contact_moved');
			}
			else if($tree_type_val==6)
			{
				$feedTitle = $this->lang->line('feed_txt_Notes_moved');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Tree_moved');
			}
		}
		else if($object=='tree' && $action=='share')
		{
			// $feedTitle = $this->lang->line('feed_txt_Tree_shared');
			if($tree_type_val==1)
			{
				$feedTitle = $this->lang->line('feed_txt_Document_shared');
			}
			else if($tree_type_val==3)
			{
				$feedTitle = $this->lang->line('feed_txt_Discussion_shared');
			}
			else if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_shared');
			}
			else if($tree_type_val==5)
			{
				$feedTitle = $this->lang->line('feed_txt_Contact_shared');
			}
			else if($tree_type_val==6)
			{
				$feedTitle = $this->lang->line('feed_txt_Notes_shared');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Tree_shared');
			}
		}
		else if($object=='tree' && $action=='unshare')
		{
			// $feedTitle = $this->lang->line('feed_txt_Tree_unshared');

			if($tree_type_val==1)
			{
				$feedTitle = $this->lang->line('feed_txt_Document_unshared');
			}
			else if($tree_type_val==3)
			{
				$feedTitle = $this->lang->line('feed_txt_Discussion_unshared');
			}
			else if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_unshared');
			}
			else if($tree_type_val==5)
			{
				$feedTitle = $this->lang->line('feed_txt_Contact_unshared');
			}
			else if($tree_type_val==6)
			{
				$feedTitle = $this->lang->line('feed_txt_Notes_unshared');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Tree_unshared');
			}
		}
		else if($object=='leaf' && $action=='add')
		{
			// $feedTitle = $this->lang->line('feed_txt_Leaf_added');
			// $feedTitle = $this->lang->line('feed_txt_Content_added');

			if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_added');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Content_added');
			}
		}
		else if($object=='leaf' && $action=='edit')
		{
			// $feedTitle = $this->lang->line('feed_txt_Leaf_edited');
			// $feedTitle = $this->lang->line('feed_txt_Content_edited');

			if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_edited');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Content_edited');
			}
		}
		else if($object=='leaf' && $action=='comment')
		{
			// $feedTitle = $this->lang->line('feed_txt_Leaf_commented');
			// $feedTitle = $this->lang->line('feed_txt_Content_commented');

			if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_commented');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Content_commented');
			}
		}
		else if($object=='leaf' && $action=='assign')
		{
			// $feedTitle = $this->lang->line('feed_txt_Leaf_assigned');
			// $feedTitle = $this->lang->line('feed_txt_Content_assigned');

			if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_assigned');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Content_assigned');
			}
		}
		else if($object=='leaf' && $action=='unassign')
		{
			// $feedTitle = $this->lang->line('feed_txt_Leaf_unassigned');
			// $feedTitle = $this->lang->line('feed_txt_Content_unassigned');

			if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_unassigned');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Content_unassigned');
			}
		}
		else if($object=='leaf' && $action=='delete')
		{
			// $feedTitle = $this->lang->line('feed_txt_Leaf_deleted');
			// $feedTitle = $this->lang->line('feed_txt_Content_deleted');

			if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_deleted');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Content_deleted');
			}
		}
		else if($object=='leaf' && $action=='move')
		{
			// $feedTitle = $this->lang->line('feed_txt_Leaf_moved');
			// $feedTitle = $this->lang->line('feed_txt_Content_moved');

			if($tree_type_val==4)
			{
				$feedTitle = $this->lang->line('feed_txt_Task_moved');
			}
			else
			{
				$feedTitle = $this->lang->line('feed_txt_Content_moved');
			}
		}
		else if($object=='leaf' && $action=='reserve')
		{
			// $feedTitle = $this->lang->line('feed_txt_Leaf_reserved');
			$feedTitle = $this->lang->line('feed_txt_Content_reserved');
		}
		else if($object=='leaf' && $action=='unreserve')
		{
			// $feedTitle = $this->lang->line('feed_txt_Leaf_unreserved');
			$feedTitle = $this->lang->line('feed_txt_Content_unreserved');
		}
		else if($object=='post' && $action=='add')
		{
			$feedTitle = $this->lang->line('feed_txt_Post_created');
		}
		else if($object=='post' && $action=='comment')
		{
			$feedTitle = $this->lang->line('feed_txt_Post_commented');
		}
		else if($object=='post' && $action=='share')
		{
			$feedTitle = $this->lang->line('feed_txt_Post_shared');
		}
		else if($object=='post' && $action=='unshare')
		{
			$feedTitle = $this->lang->line('feed_txt_Post_unshared');
		}
		else if($object=='post' && $action=='delete')
		{
			$feedTitle = $this->lang->line('feed_txt_Post_deleted');
		}
		else if($object=='simple tag' && $action=='add')
		{
			$feedTitle = $this->lang->line('feed_txt_Simple_tag_created');
		}
		else if($object=='simple tag' && $action=='apply')
		{
			$feedTitle = $this->lang->line('feed_txt_Simple_tag_applied');
		}
		else if($object=='simple tag' && $action=='delete')
		{
			$feedTitle = $this->lang->line('feed_txt_Simple_tag_deleted');
		}
		else if($object=='action tag' && $action=='apply')
		{
			$feedTitle = $this->lang->line('feed_txt_Action_tag_applied');
		}
		else if($object=='action tag' && $action=='edit')
		{
			$feedTitle = $this->lang->line('feed_txt_Action_tag_edited');
		}
		else if($object=='action tag' && $action=='delete')
		{
			$feedTitle = $this->lang->line('feed_txt_Action_tag_deleted');
		}
		else if($object=='action tag' && $action=='comment')
		{
			$feedTitle = $this->lang->line('feed_txt_Action_tag_commented');
		}
		else if($object=='contact tag' && $action=='apply')
		{
			$feedTitle = $this->lang->line('feed_txt_Contact_tag_applied');
		}
		else if($object=='contact tag' && $action=='delete')
		{
			$feedTitle = $this->lang->line('feed_txt_Contact_tag_deleted');
		}
		else if($object=='link' && $action=='apply')
		{
			$feedTitle = $this->lang->line('feed_txt_Link_applied');
		}
		else if($object=='link' && $action=='delete')
		{
			$feedTitle = $this->lang->line('feed_txt_Link_deleted');
		}
		else if($object=='talk' && $action=='comment')
		{
			$feedTitle = $this->lang->line('feed_txt_Talk_commented');
		}
		else if($object=='file' && $action=='import')
		{
			$feedTitle = $this->lang->line('feed_txt_File_imported');
		}
		else if($object=='file' && $action=='delete')
		{
			$feedTitle = $this->lang->line('feed_txt_File_deleted');
		}
		else if($object=='space' && $action=='add')
		{
			$feedTitle = $this->lang->line('feed_txt_Space_created');
		}
		else if($object=='space' && $action=='edit')
		{
			$feedTitle = $this->lang->line('feed_txt_Space_edited');
		}
		else if($object=='space' && $action=='suspend')
		{
			$feedTitle = $this->lang->line('feed_txt_Space_suspended');
		}
		else if($object=='space' && $action=='activate')
		{
			$feedTitle = $this->lang->line('feed_txt_Space_activated');
		}
		else if($object=='subspace' && $action=='add')
		{
			$feedTitle = $this->lang->line('feed_txt_Subspace_created');
		}
		else if($object=='subspace' && $action=='edit')
		{
			$feedTitle = $this->lang->line('feed_txt_Subspace_edited');
		}
		else if($object=='subspace' && $action=='suspend')
		{
			$feedTitle = $this->lang->line('feed_txt_Subspace_suspended');
		}
		else if($object=='subspace' && $action=='activate')
		{
			$feedTitle = $this->lang->line('feed_txt_Subspace_activated');
		}
		else if($object=='place' && $action=='add')
		{
			$feedTitle = $this->lang->line('feed_txt_Place_created');
		}
		else if($object=='place' && $action=='edit')
		{
			$feedTitle = $this->lang->line('feed_txt_Place_edited');
		}
		else if($object=='place' && $action=='suspend')
		{
			$feedTitle = $this->lang->line('feed_txt_Place_suspended');
		}
		else if($object=='place' && $action=='activate')
		{
			$feedTitle = $this->lang->line('feed_txt_Place_activated');
		}
		else if($object=='admin' && $action=='add')
		{
			$feedTitle = $this->lang->line('feed_txt_Admin_created');
		}
		else if($object=='admin' && $action=='edit')
		{
			$feedTitle = $this->lang->line('feed_txt_Admin_edited');
		}
		else if($object=='admin' && $action=='delete')
		{
			$feedTitle = $this->lang->line('feed_txt_Admin_deleted');
		}
		else if($object=='contributor' && $action=='assign')
		{
			$feedTitle = $this->lang->line('feed_txt_Contributor_assigned');
		}
		else if($object=='contributor' && $action=='unassign')
		{
			$feedTitle = $this->lang->line('feed_txt_Contributor_unassigned');
		}
		else if($object=='user' && $action=='add')
		{
			$feedTitle = $this->lang->line('feed_txt_User_added');
		}
		else if($object=='user' && $action=='edit')
		{
			$feedTitle = $this->lang->line('feed_txt_User_edited');
		}
		else if($object=='user' && $action=='suspend')
		{
			$feedTitle = $this->lang->line('feed_txt_User_suspended');
		}
		else if($object=='user' && $action=='activate')
		{
			$feedTitle = $this->lang->line('feed_txt_User_activated');
		}
		else if($object=='user' && $action=='delete')
		{
			$feedTitle = $this->lang->line('feed_txt_User_deleted');
		}
		else if($object=='place manager' && $action=='add')
		{
			$feedTitle = $this->lang->line('feed_txt_Place_manager_added');
		}
		else if($object=='place manager' && $action=='edit')
		{
			$feedTitle = $this->lang->line('feed_txt_Place_manager_edited');
		}
		else if($object=='place manager' && $action=='suspend')
		{
			$feedTitle = $this->lang->line('feed_txt_Place_manager_suspended');
		}
		else if($object=='place manager' && $action=='activate')
		{
			$feedTitle = $this->lang->line('feed_txt_Place_manager_activated');
		}
		else if($object=='folder' && $action=='create')
		{
			$feedTitle = $this->lang->line('feed_txt_Folder_created');
		}
		else if($object=='folder' && $action=='delete')
		{
			$feedTitle = $this->lang->line('feed_txt_Folder_deleted');
		}
		else
		{
			$feedTitle = $object.' '.$action;
		}
		
		//return feed title
		return $feedTitle;
	}
	/*Dashrath : getFeedTitle function end*/


	/*Added by Dashrath : getObjectNameByObjectId function start*/
	function getObjectNameByObjectId($objectId)
	{
		$objectName = '';
		/*get object name*/
		$query = $this->db->query('select name from teeme_notification_object WHERE id='.$objectId);					
		foreach($query->result() as $row)
		{
			$objectName = $row->name;
		}

		return $objectName;
	}
	/*Dashrath : getObjectNameByObjectId function end*/

	/*Added by Dashrath : getActionNameByActionId function start*/
	function getActionNameByActionId($actionId)
	{
		$actionName = '';
		/*get object name*/
		$query = $this->db->query('select name from teeme_notification_action WHERE id='.$actionId);					
		foreach($query->result() as $row)
		{
			$actionName = $row->name;
		}

		return $actionName;
	}
	/*Dashrath : getActionNameByActionId function end*/

	/*Added by Dashrath : getFeedDescription function start*/
	function getFeedDescription($objectId, $actionId, $treeContent, $leafTitle, $summarizeData, $notificationContentData,$memberName)
	{
		//get object name
		$object = $this->getObjectNameByObjectId($objectId);

		//get action name
		$action = $this->getActionNameByActionId($actionId);

		//make feed description
		if($object=='tree' && ($action=='add' || $action=='edit' || $action=='new version' || $action=='start' || $action=='stop' || $action=='move' || $action=='share' || $action=='unshare'))
		{
			$feedDescription = $treeContent;
		}
		else if($object=='leaf' && ($action=='add' || $action=='edit' || $action=='comment' || $action=='delete' || $action=='move' || $action=='reserve' || $action=='unreserve'))
		{
			$feedDescription = $leafTitle;
		}
		else if($object=='leaf' && ($action=='assign' || $action=='unassign'))
		{
			$feedDescription = $summarizeData;
		}
		else if($object=='post' && ($action=='add' || $action=='comment' || $action=='share' || $action=='unshare' || $action=='delete'))
		{
			$feedDescription = $leafTitle;
		}
		else if(($object=='simple tag' && ($action=='add' || $action=='apply' || $action=='delete')) || ($object=='action tag' && ($action=='apply' || $action=='edit' || $action=='delete' || $action=='comment')) || ($object=='contact tag' && ($action=='apply' || $action=='delete')))
		{
			 $summarizeData = str_replace('"','',$summarizeData);
			 $feedDescription = $summarizeData;
			
		}
		else if($object=='link' && ($action=='apply' || $action=='delete'))
		{
			$summarizeData = str_replace('"','',$summarizeData);
			$feedDescription = $summarizeData;
		}
		else if($object=='talk' && $action=='comment')
		{
			$feedDescription = $summarizeData;
		}
		else if(($object=='space' || $object=='subspace') && ($action=='add' || $action=='edit' || $action=='suspend' || $action=='activate'))
		{
			$feedDescription = $summarizeData;
		}
		else if($object=='contributor' && ($action=='assign' || $action=='unassign'))
		{
			$feedDescription = $summarizeData;
		}
		else if($object=='folder' && ($action=='create' || $action=='delete'))
		{
			$feedDescription = $summarizeData;
		}
		else if($object=='file' && ($action=='import' || $action=='delete'))
		{
			$summarizeData = preg_replace("/<img[^>]+\>/i", "", $summarizeData);
			$feedDescription = $summarizeData;
		}
		else if($object=='place manager' && ($action=='add' || $action=='edit' || $action=='suspend' || $action=='activate'))
		{
			$feedDescription = $memberName;
		}
		else if($object=='user' && ($action=='add' || $action=='edit' || $action=='suspend' || $action=='activate' || $action=='delete'))
		{
			$feedDescription = $memberName;
		}
		else
		{
			$feedDescription = $notificationContentData;
		}

		//if feed description is blank
		if($feedDescription=="")
		{
			$feedDescription = $notificationContentData;
		}

		//return feed description
		return $feedDescription;

	}
	/*Dashrath : getFeedDescription function end*/

	function getImportedUrlTitleById($id)
	{
	    $urlTitle='';

		$query="SELECT title FROM `teeme_links_url` WHERE id=".$id;

		$query=$this->db->query($query);
		
		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{	
					$urlTitle = $treeData->title;									
				}
			}
		}

		return $urlTitle;	
	}

	/*Added by Dashrath- getLinkedExternalFoldersByArtifactNodeId function start*/
	function getLinkedExternalFoldersByArtifactNodeId( $nodeId,$nodeType='',$treeId=0 )
	{
		$treeIds = array();
		if ($treeId!=0)
		{

			if ($nodeType)
			{
				$q ='SELECT a.id as folderId, a.name as folderName FROM teeme_folders a, teeme_links_folder b,teeme_node c WHERE a.id=b.linkedFolderId AND c.treeIds=\''.$treeId.'\' AND b.artifactId=\''.$nodeId.'\' AND b.artifactId=c.treeIds AND b.artifactType = '.$nodeType.' ORDER BY a.name';
				
			}
			else
			{
				$q = 'SELECT a.id as folderId, a.name as folderName FROM teeme_folders a, teeme_links_folder b,teeme_node c WHERE a.id=b.linkedFolderId AND c.treeIds=\''.$treeId.'\' AND b.artifactId=\''.$nodeId.'\' AND b.artifactId=c.treeIds ORDER BY a.name';
			}
			$query = $this->db->query($q);
			
		}
		else
		{
			if ($nodeType)
				$query = $this->db->query('SELECT a.id as folderId, a.name as folderName FROM teeme_folders a, teeme_links_folder b WHERE a.id=b.linkedFolderId AND b.artifactId=\''.$nodeId.'\' AND b.artifactType = '.$nodeType.' ORDER BY a.name');
			else
				$query = $this->db->query('SELECT a.id as folderId, a.name as folderName FROM teeme_folders a, teeme_links_folder b WHERE a.id=b.linkedFolderId AND b.artifactId=\''.$nodeId.'\' ORDER BY a.name');
		}	

		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['folderId'] = $treeData->folderId;
					$treeIds[$i]['folderName'] = $treeData->folderName;
					$i++;
				}
			}
		}
		
		return $treeIds;
	}
	/*Dashrath : getLinkedExternalFoldersByArtifactNodeId function end*/

	/*Added by Dashrath- getCurrentLinkedExternalFoldersByArtifactNodeId function start*/
	function getCurrentLinkedExternalFoldersByArtifactNodeId( $nodeId,$nodeType,$lastLogin )
	{
		$treeIds = array();
		
		$query = $this->db->query('SELECT a.id as folderId, a.name as folderName FROM teeme_folders a, teeme_links_folder b WHERE a.id=b.linkedFolderId AND b.artifactId=\''.$nodeId.'\' AND b.artifactType = '.$nodeType.' AND (b.createdDate >\''.$lastLogin.'\') ORDER BY a.name');
	
		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['folderId'] = $treeData->folderId;
					$treeIds[$i]['folderName'] = $treeData->folderName;
					$i++;
				}
			}
		}

		return $treeIds;
	}
	/*Dashrath : getCurrentLinkedExternalFoldersByArtifactNodeId function end*/

	/*Added by Dashrath- getNotLinkedExternalFoldersByArtifactNodeId function start*/
	function getNotLinkedExternalFoldersByArtifactNodeId( $artifactType, $workspaceId, $workspaceType, $arrTreeIds )
	{
		$treeIds = array();
		$userId = $_SESSION['userId'];
		$where = '';
		if(count($arrTreeIds) > 0)
		{	
			$linkedIds 	= implode(',',$arrTreeIds);
			$where 		= ' id NOT IN('.$linkedIds.')';		
		}
		if($workspaceId == 0)
		{	
			$query = $this->db->query('SELECT id as folderId, name as folderName FROM teeme_folders WHERE userId='.$userId.' AND workspaceId=\''.$workspaceId.'\' AND '.$where.' ORDER BY name');		
		}
		else
		{
			$query = $this->db->query('SELECT id as folderId, name as folderName FROM teeme_folders WHERE workspaceId=\''.$workspaceId.'\' AND workSpaceType = '.$workspaceType.' AND '.$where.' ORDER BY name');				
		}			
		if($query)
		{		
			if($query->num_rows() > 0)
			{
				$i = 0;
				foreach ($query->result() as $treeData)
				{										
					$treeIds[$i]['folderId'] = $treeData->folderId;
					$treeIds[$i]['folderName'] = $treeData->folderName;
					$i++;
				}
			}
		}
		return $treeIds;
	}
	/*Dashrath : getNotLinkedExternalFoldersByArtifactNodeId function end*/
	
	/*Added by Dashrath- removeExternalFolderLinks function start*/
	function removeExternalFolderLinks( $linkIds, $nodeId, $nodeType)
	{
		$folderIds = explode(',',$linkIds);
		$status = false;
		if(count($folderIds)>0)
		{
			foreach($folderIds as $folderId)
			{
				if (!empty($folderId))
				{
					$query = $this->db->query('DELETE FROM teeme_links_folder WHERE linkedFolderId='.$folderId.' AND artifactId='.$nodeId.' AND artifactType='.$nodeType);
					if($query)
					{
						$status = true;
					}	
					else
					{
						$status = false;
					}
				}			
			}
		}
		
		return $status;
	}
	/*Dashrath : removeExternalFolderLinks function end*/

	/*Added by Dashrath- addExternalFolderLinks function start*/
	function addExternalFolderLinks( $linkIds, $nodeId, $nodeType,$ownerId)
	{
		$folderIds = explode(',',$linkIds);
		$status = false;
		if(count($folderIds)>0)
		{
			foreach($folderIds as $folderId)
			{
			
				$query = $this->db->query('INSERT INTO teeme_links_folder(linkedFolderId, artifactId, artifactType,createdDate,ownerId) VALUES('.$folderId.','.$nodeId.','.$nodeType.',NOW(),'.$ownerId.')');	
				if($query)
				{
					$status = true;
				}	
				else
				{
					$status = false;
				}			
			}
		}
		
		return $status;
	}
	/*Dashrath : addExternalFolderLinks function end*/

	/*Added by Dashrath- getUserActionContent function start*/
	function getUserActionContent($objectId, $actionId, $userTagName, $tree_type_val)
	{
		//get obect action title
		$title = $this->getFeedTitle($objectId, $actionId, $tree_type_val);

		if($title!='')
        {
        	$title = ucfirst($title);
        	$userActionContent = $title.' by '.$userTagName.' at ';
        }
		
		//return feed title
		return $userActionContent;
	}
	/*Dashrath : getUserActionContent function end*/

	/*Added by Dashrath- getLeafContentsByNodeId function start*/
	public function getLeafContentsByNodeId($nodeId)
	{
		$leafContents = '';
		if($nodeId != NULL)
		{
			// Get information of particular document
			$query = $this->db->query('SELECT contents 

										FROM teeme_leaf 

										WHERE nodeId='.$nodeId);
			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $leafData)
				{	
					$leafContents = $leafData->contents;
					
				}

			}

		}
		return $leafContents;
	}
	/*Dashrath : getLeafContentsByNodeId function end*/

    /*Added by Dashrath : function folderRename start*/
	public function folderRename($oldFolderName, $newFolderName, $workSpaceId, $workSpaceType, $workPlaceName)
	{

		if (PHP_OS=='Linux')
		{
			$workPlaceRootDir   = $this->config->item('absolute_path').'workplaces';			
			$workPlaceDir		= $this->config->item('absolute_path').'workplaces'.DIRECTORY_SEPARATOR.$workPlaceName;
			$workSpaceMainDir	= $workPlaceDir.DIRECTORY_SEPARATOR.'workspaces';

			if($workSpaceType==2)
			{
				$workSpaceSubDir	= $workSpaceMainDir.DIRECTORY_SEPARATOR.'sws'.$workSpaceId;
			}
			else
			{
				$workSpaceSubDir	= $workSpaceMainDir.DIRECTORY_SEPARATOR.'ws'.$workSpaceId;
			}

			if($workSpaceId > 0)
			{
				if($workSpaceType==2)
				{
					$docOldPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR.$oldFolderName.DIRECTORY_SEPARATOR;

					$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR.$newFolderName.DIRECTORY_SEPARATOR;
				}
				else
				{
					$docOldPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR.$oldFolderName.DIRECTORY_SEPARATOR;

					$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR.$newFolderName.DIRECTORY_SEPARATOR;
				}	
			}
			else
			{

				$docOldPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR.$oldFolderName.DIRECTORY_SEPARATOR;

				$docPath		= "workplaces".DIRECTORY_SEPARATOR.$workPlaceName.DIRECTORY_SEPARATOR."workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR.$newFolderName.DIRECTORY_SEPARATOR;	
			}
		
		}
		else
		{
			$workPlaceRootDir   = $this->config->item('absolute_path').'\workplaces';			
			$workPlaceDir		= $this->config->item('absolute_path').'\workplaces\\'.$workPlaceName;
			$workSpaceMainDir	= $workPlaceDir.'\\workspaces';

			if($workSpaceType==2)
			{
				$workSpaceSubDir	= $workSpaceMainDir.'\\sws'.$workSpaceId;
			}
			else
			{
				$workSpaceSubDir	= $workSpaceMainDir.'\\ws'.$workSpaceId;
			}

			if($workSpaceId > 0)
			{
				if($workSpaceType==2)
				{
					$docOldPath		= "workplaces/".$workPlaceName."/workspaces/sws$workSpaceId/".$oldFolderName."/";

					$docPath		= "workplaces/".$workPlaceName."/workspaces/sws$workSpaceId/".$newFolderName."/";
				}
				else
				{
					$docOldPath		= "workplaces/".$workPlaceName."/workspaces/ws$workSpaceId/".$oldFolderName."/";

					$docPath		= "workplaces/".$workPlaceName."/workspaces/ws$workSpaceId/".$newFolderName."/";
				}
			}
			else
			{
				$docOldPath		= "workplaces/".$workPlaceName."/workspaces/wsuser$_SESSION[userId]/".$oldFolderName."/";

				$docPath		= "workplaces/".$workPlaceName."/workspaces/wsuser$_SESSION[userId]/".$newFolderName."/";
			}
		}
		
		$oldPath	= $this->config->item('absolute_path').$docOldPath;

		$newPath	= $this->config->item('absolute_path').$docPath;

		if(is_dir($oldPath))
		{
			if(rename($oldPath, $newPath))
			{
				return "true";
			}
			else
			{
				return "false";
			}
		}
		else
		{
			return "false";
		}
	}
	/*Dashrath : folderRename function end*/

	/*Added by Dashrath : function updateFolder start*/
	function updateFolder($oldFolderName, $newFolderName, $workSpaceId, $workSpaceType)
	{
		$strResultSQL = "UPDATE teeme_folders SET name='".$newFolderName."' WHERE name='".$oldFolderName."' AND workSpaceId = '".$workSpaceId."' AND workSpaceType='".$workSpaceType."'";
		$bResult = $this->db->query($strResultSQL);
		
		if($bResult)
		{
			$newDocPath = $this->getNewDocPath($workSpaceId, $workSpaceType, $newFolderName);
			
			$folderId = $this->checkFolderNameById($newFolderName, $workSpaceId, $workSpaceType, $_SESSION['userId']);

			$strResultSQL1 = "UPDATE teeme_external_docs SET path='".$newDocPath."' WHERE folderId=".$folderId." AND workSpaceId = '".$workSpaceId."' AND workSpaceType='".$workSpaceType."'";
			$bResult1 = $this->db->query($strResultSQL1);

			return "true";
		}		
		else
		{
			return "false";
		}
	}
	/*Dashrath : updateFolder function end*/

	/*Added by Dashrath- getRootFolderDetails function start*/
	function getRootFolderDetails($workSpaceId, $workSpaceType)
	{
		$arrDocDetails = array();		
		
		$folder=array();
		$userId = $_SESSION['userId'];
						
		if($workSpaceId == 0)
		{	
			$query = $this->db->query('SELECT * FROM teeme_folders  WHERE workSpaceId=0 AND userId ='.$userId.' ORDER BY id ASC LIMIT 1');
		}
		else	
		{
			$query = $this->db->query('SELECT * FROM teeme_folders WHERE workSpaceId='.$workSpaceId.' AND workSpaceType='.$workSpaceType.' ORDER BY id ASC LIMIT 1');
		}

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				$arrDocDetails['folderId'] 		= $row->id;
				$arrDocDetails['parentId'] 		= $row->parentId;	
				$arrDocDetails['name']	 		= $row->name;	
				$arrDocDetails['workSpaceId'] 	= $row->workSpaceId;
				$arrDocDetails['workSpaceType'] = $row->workSpaceType;	
				$arrDocDetails['userId'] 		= $row->userId;		
				$arrDocDetails['createdDate']	= $row->createdDate;

				//get editFolderName
				$arrDocDetails['editFolderName'] = $this->identity_db_manager->characterLimiter($row->name, 12,'workspacename');

			}
		}
		
		return $arrDocDetails;
	}
	/*Dashrath- getRootFolderDetails function end*/	

	/*Added by Dashrath- getTotalFeedCount function start*/
	function getTotalFeedCount ($workSpaceId, $workSpaceType)
	{
		// $query = $this->db->query("SELECT count(id) AS total FROM teeme_notification_events");

		if($workSpaceId==0)
		{
			$query = $this->db->query("SELECT count(id) AS total FROM teeme_notification_events WHERE workSpaceId = '".$workSpaceId."' AND workSpaceType = '".$workSpaceType."' AND action_user_id='".$_SESSION['userId']."'");
		}
		else
		{
			$query = $this->db->query("SELECT count(id) AS total FROM teeme_notification_events WHERE workSpaceId = '".$workSpaceId."' AND workSpaceType = '".$workSpaceType."'");
		}
		

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{	
				return $row->total;				
			}		
		}		
		return 'null';
	}
	/*Dashrath- getTotalFeedCount function end*/

	/*Added by Dashrath- getFoldersCount function start*/
	function getFoldersCount ($workSpaceId, $workSpaceType)
	{
		$totalFolders = 0;

		if($workSpaceId > 0)
		{
			$userId = $_SESSION['userId'];

			if($workSpaceId == 0)
			{
				$query = $this->db->query('SELECT count(id) AS total FROM teeme_folders a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId=0 AND a.userId='.$userId);
			}
			else
			{
				$query = $this->db->query('SELECT count(id) AS total FROM teeme_folders a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.userId!='.$userId);
			}
			

			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$totalFolders = $row->total;				
				}		
			}	
		}

		return $totalFolders;
	}
	/*Dashrath- getFoldersCount function end*/

	/*Added by Dashrath- getFilesCount function start*/
	function getFilesCount ($workSpaceId, $workSpaceType)
	{
		$totalFiles = 0;

		if($workSpaceId > 0)
		{

			$userId = $_SESSION['userId'];

			if($workSpaceId == 0)
			{
				$query = $this->db->query('SELECT count(docId) AS total FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId=0 AND a.userId='.$userId);
			}
			else
			{
				$query = $this->db->query('SELECT count(docId) AS total FROM teeme_external_docs a, teeme_users b WHERE a.userId = b.userId AND a.workSpaceId='.$workSpaceId.' AND a.workSpaceType='.$workSpaceType.' AND a.userId!='.$userId);
			}

			if($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{	
					$totalFiles = $row->total;				
				}		
			}		
		}

		return $totalFiles;
	}
	/*Dashrath- getFilesCount function end*/	

	public function getTaskStatus($taskId)

	{

		$status = 0;

		$query = $this->db->query('SELECT status FROM teeme_activity_completion_status WHERE activityId='.$taskId);

		

		if($query->num_rows() > 0)

		{

			$tmpData 	= $query->row();

			$status = $tmpData->status;		

		}

		return $status;

	}

	/*Added by Dashrath- start getNodePredecessorIdByNodeId function*/
	public function getNodePredecessorIdByNodeId($treeId,$nodeId)
	{
		$predecessor = 0;
		if($treeId!='' && $nodeId!='')
		{
			$query = "SELECT predecessor FROM teeme_node where treeIds=".$treeId." AND id=".$nodeId." AND successors='0' LIMIT 1";
			
			$query = $this->db->query($query);
			
			if($query)
			{
				if($query->num_rows() == 1)
				{
					foreach ($query->result() as $nodeData)
					{	
						$predecessor = $nodeData->predecessor;
					}
					
				}					
			}
		}

		return $predecessor;
	}
	/*Dashrath- getNodePredecessorIdByNodeId function end*/

	/*Added by Dashrath- start getDraftLeafsByTreeId function*/
	public function getDraftLeafsByTreeId($treeId)
	{
		$tree = array();		
		$query = $this->db->query('SELECT a.leafParentId, a.type, a.status, a.userId,a.leafStatus, c.tagName, c.nickName, a.createdDate,a.editedDate, a.contents, a.latestContent, a.version as leafVersion, a.lockedStatus, a.userLocked, b.predecessor, b.successors, b.leafId, b.tag, b.treeIds, b.nodeOrder, b.starttime, b.endtime, b.version, b.id as nodeId1, a.id as leafId1, c.firstName, c.userName, c.lastName FROM teeme_leaf a, teeme_node b, teeme_users c WHERE a.userId=c.userId AND a.id=b.leafId AND b.treeIds='.$treeId.' AND a.leafStatus="draft" ORDER BY b.nodeOrder');

		$this->load->model('dal/document_db_manager');

		foreach($query->result() as $docData)
		{
			$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $docData->nodeOrder);

			$draftResUserIds = array();

			$draftReservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);

			foreach($draftReservedUsers  as $draftResUserData)
			{
				$draftResUserIds[] = $draftResUserData['userId']; 
			}

			if(count($draftResUserIds) > 0)
			{
				if(in_array($_SESSION['userId'], $draftResUserIds))
				{
					$tree[] = $docData;
				}

			}
			else if($docData->userId == $_SESSION['userId'])
			{
				$tree[] = $docData;
			}
			// else
			// {
			// 	$tree[] = $docData;
			// }
		}	

		// echo '<pre>';
		// print_r($tree);die;

		return $tree;	
	}
	/*Dashrath- getDraftLeafsByTreeId function end*/

	/*Added by Dashrath- start getDraftLeafTitleContent function*/
	public function getDraftLeafTitleContent($content)
	{

		$isFileContent = 0;
		if($content!='')
    	{
    		preg_match_all("#<img(.*?)\\/?>#",$content, $imgTags);
    		if($imgTags[0])
    		{
    			
    			preg_match( '@src="([^"]+)"@' , $content, $match );
        		if($match)
        		{
        			$imgPathInfo = explode('/', $match[1]);
        			$imgName = $imgPathInfo[count($imgPathInfo)-1];

        			$finalPath = $this->config->item('absolute_path').'workplaces/'.$_COOKIE['place'].'/editor_uploads//'.$imgName;
					
        			$imageInfo = getimagesize($finalPath);

        			$imgWidth = '150px;';

        			if(count($imageInfo)>0)
        			{
        				if($imageInfo[0]<=150)
            			{
            				$imgWidth = $imageInfo[0].'px;';
            			}
        			}

        			if($imgWidth==' px;' || $imgWidth=='px;')
        			{
        				$imgWidth = '150px;';
        			}

        			$content_new = '<p><img src="'.$match[1].'" style="width: '.$imgWidth.'" class="fr-fil fr-dib"></p>';

        			$isFileContent = 1;
        		}

    		} 
    	}
    	
    	$leafdataContent=strip_tags($content);

        if (strlen($leafdataContent) > 25) 
        {
            $leafTitle = substr($leafdataContent, 0, 25) . "..."; 
        }
        else
        {
            $leafTitle = $leafdataContent;
        }

        if($leafTitle=='')
        {
        	if($isFileContent==1)
        	{
        		$leafTitle = $content_new;
        	}
        	else
        	{
            	$leafTitle = $this->lang->line('content_contains_only_image');
        	}
        }
        else
        {
        	if($isFileContent==1)
        	{
        		$leafTitle = $content_new;
        	}
        }

        return $leafTitle;
	}
	/*Dashrath- getDraftLeafTitleContent function end*/

	/*Added by Dashrath : function checkFolderNameAlreadyExists start*/
	public function checkFolderNameAlreadyExists($name, $workSpaceId, $workSpaceType, $userId)
	{
		$folderId = 0;

		if($workSpaceId > 0)
		{
			$query = $this->db->query('SELECT id FROM teeme_folders WHERE name="'.$name.'" AND workSpaceId ="'.$workSpaceId.'" AND workSpaceType ="'.$workSpaceType. '"');
		}
		else
		{
			$query = $this->db->query('SELECT id FROM teeme_folders WHERE name="'.$name.'" AND workSpaceId =0 AND workSpaceType ="'.$workSpaceType. '" AND userId ="'.$userId.'"');
		}
				
		foreach($query->result() as $row)
		{
			$folderId	= $row->id;

		}	

		return $folderId;
		
	}
	/*Dashrath- checkFolderNameAlreadyExists function end*/


	/*Added by Dashrath : function updateFolderNameByFolderId start*/
	function updateFolderNameByFolderId($oldFolderName, $newFolderName, $workSpaceId, $workSpaceType,$folderId,$newDocPath)
	{
		$strResultSQL = "UPDATE teeme_folders SET name='".$newFolderName."' WHERE id=".$folderId." AND name='".$oldFolderName."' AND workSpaceId = '".$workSpaceId."' AND workSpaceType='".$workSpaceType."'";
		$bResult = $this->db->query($strResultSQL);

		if($this->db->affected_rows() > 0)
		{
			$strResultSQL1 = "UPDATE teeme_external_docs SET path='".$newDocPath."' WHERE folderId=".$folderId." AND workSpaceId = '".$workSpaceId."' AND workSpaceType='".$workSpaceType."'";
			$bResult1 = $this->db->query($strResultSQL1);

			return "true";
		}		
		else
		{
			return "false";
		}
	}
	/*Dashrath : updateFolderNameByFolderId function end*/

	/**
	* This method will be used to delete the folder from the database.
 	* @return The staus of delete
	*/
	public function deleteFolderById($folderId)
	{			
		$query = $this->db->query('DELETE FROM teeme_folders WHERE id='.$folderId);
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
	* This method will be used to delete the folder files from the database.
 	* @return The staus of delete
	*/
	public function deleteFilesByFolderId($folderId)
	{			
		$query = $this->db->query('DELETE FROM teeme_external_docs WHERE folderId='.$folderId);
		if($query)
		{
			return true;
		}
		else
		{
			return false;	
		}		
	}

	/*Added by Dashrath : function getNewDocPath start*/
	function getNewDocPath($workSpaceId, $workSpaceType, $newFolderName)
	{
		if (PHP_OS=='Linux')
		{
			if($workSpaceId > 0)
			{
				if($workSpaceType==2)
				{
					$newDocPath 	= "workspaces".DIRECTORY_SEPARATOR."sws$workSpaceId".DIRECTORY_SEPARATOR.$newFolderName.DIRECTORY_SEPARATOR;
				}
				else
				{
					$newDocPath 		= "workspaces".DIRECTORY_SEPARATOR."ws$workSpaceId".DIRECTORY_SEPARATOR.$newFolderName.DIRECTORY_SEPARATOR;
				}
			}
			else
			{
				$newDocPath 		= "workspaces".DIRECTORY_SEPARATOR."wsuser$_SESSION[userId]".DIRECTORY_SEPARATOR.$newFolderName.DIRECTORY_SEPARATOR;
			}
		
		}
		else
		{
			if($workSpaceId > 0)
			{
				if($workSpaceType==2)
				{
					$newDocPath 		= "workspaces/sws$workSpaceId/".$newFolderName."/";
				}
				else
				{
					$newDocPath 		= "workspaces/ws$workSpaceId/".$newFolderName."/";
				}
			}
			else
			{
				$newDocPath 		= "workspaces/wsuser$_SESSION[userId]/".$newFolderName."/";
			}
		}

		return $newDocPath;
	}
	/*Dashrath : getNewDocPath function end*/

	/*Added by Dashrath : function getFolderOrignatorIdByFolderId start*/
	public function getFolderOrignatorIdByFolderId($folderId)
	{
		$orignatorId = 0;
		if($folderId > 0)
		{
			$query = $this->db->query('SELECT userId FROM teeme_folders WHERE id ="'.$folderId.'"');
			
			foreach($query->result() as $row)
			{
				$orignatorId	= $row->userId;

			}	
		} 
		return $orignatorId;
	}
	/*Dashrath : getFolderOrignatorIdByFolderId function end*/

	public function updateSharedTreeStatusSession($treeId)
	{
		$this->load->model('dal/identity_db_manager');
		if ($this->identity_db_manager->isShared($treeId))
		{
			$sharedMembers = $this->identity_db_manager->getSharedMembersByTreeId($treeId);	
			if (in_array($_SESSION['userId'],$sharedMembers))
			{
				$_SESSION['shareTreeStatus'.$treeId.$_SESSION['userId']] = 'share';		
			}
			else
			{
				$_SESSION['shareTreeStatus'.$treeId.$_SESSION['userId']] = 'unshare';
			}
		}
	}

	/* Added by Dashrath: deleteTaskAndSubTask function used for delete task and subtask*/
	public function deleteTaskAndSubTask($nodeId, $taskType)
	{	
		$this->load->model('dal/task_db_manager');

		if($taskType == 'task')
		{
			$this->db->trans_begin();

			//discard task
			$dResult1  = $this->db->query('UPDATE teeme_leaf SET leafStatus="discarded" WHERE nodeId='.$nodeId);			
			if($dResult1)
			{	
				$query = $this->db->query("select * from teeme_node where id=".$nodeId);

				foreach ($query->result() as $row)
				{
					$successors=trim($row->successors);
				}

				if($successors)
				{
					$arrIds = explode(',',$successors);

					foreach($arrIds as $val)
					{
						$result  = $this->db->query('UPDATE teeme_node SET predecessor=0 WHERE id='.$val);
				
						if($result)
						{
							$result2  = $this->db->query('UPDATE teeme_leaf SET leafStatus="discarded" WHERE nodeId='.$val);
						}	
					}

					$bResult = $this->db->query("update teeme_node set successors='0' where id=".$nodeId);
				}
						
			}

			if($this->db->trans_status()=== FALSE)
			{
				$this->db->trans_rollback();
				return false;
			}
			else
			{
				$this->db->trans_commit();
				return true;
			}			
			
		}
		else
		{
			//task node id
			$parentNodeId = $this->task_db_manager->checkPredecessor($nodeId);

			$this->db->trans_begin();

			$query = $this->db->query("select * from teeme_node where id=".$parentNodeId);

			foreach ($query->result() as $row)
			{
				$successors=trim($row->successors);
			}

			if($successors)
			{
				$sArray=array();
				$sArray1=array();
				$sArray=explode(',',$successors);

				foreach ($sArray as $val) 
				{
					if($nodeId != $val)
					{
						$sArray1[] = $val;
					}
				}

				if(count($sArray1) > 0)
				{
					$successors=implode(',',$sArray1);
				}
				else
				{
					$successors=0;
				}	
			}
			else
			{
				$successors=0;
			}

			$bResult = $this->db->query("update teeme_node set successors='".$successors."' where id=".$parentNodeId);		

			if($bResult)
			{		
				$result  = $this->db->query('UPDATE teeme_node SET predecessor=0 WHERE id='.$nodeId);
				
				if($result)
				{
					$result2  = $this->db->query('UPDATE teeme_leaf SET leafStatus="discarded" WHERE nodeId='.$nodeId);
				}									
	
				if($this->db->trans_status()=== FALSE)
				{
					$this->db->trans_rollback();
					return false;
				}
				else
				{
					$this->db->trans_commit();
					return true;
				}		
			}	
			else
			{
				return false;
			}
		}				
	}
	/*Dashrath : code end*/
}