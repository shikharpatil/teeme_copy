<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

/***********************************************************************************************************

	*  *  *  *  *  *  *  *  *  *  *   I D E AV A T E   S O L U T I O N S   *  *  *  *  *  *  *  *   *

	************************************************************************************************************

	* Filename				: read_unread.php 

	* Description 		  	: to handel read unread

 	* Global Variables	  	: 

	* 

	* Modification Log

	* 	Date                	 Author                       		Description

	* ---------------------------------------------------------------------------------------------------------

	* 02-12-2008				Vinaykant						Added New function called add_user_unread($workspaceId, $workplaceId, $leafId).			

	**********************************************************************************************************/



/**

* A PHP class to access teeme work place, work space and users database with convenient methods

* with various operation Add, update, delete & retrieve teeme work place, work space and user details

* @author   Ideavate Solutions (www.ideavate.com)

*/

class read_unread extends CI_Model

{	



	/**

	* This is the constructor of user DB Manager that call the contstructor of the Parent Class.

	*/

	public function __construct()

	{   

		//Parent class constructor.

		parent::__construct();

	}	

	/* This function is for add new record in unread table for  all the  users belongs to particular workspace when new leaf added in particular workplace -> workspace

	By Vinay kant	

	*/

	public function add_user_unread($workspaceId, $workplaceId, $leafId){

		$sql_alluser="SELECT a.* FROM  teeme_users a, `teeme_work_space_members` b WHERE a.userId=b.workSpaceUserId and a.workPlaceId=".$workplaceId." and b.workSpaceId=".$workspaceId;

		$query = $this->db->query($sql_alluser);

		if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$strResultSQL = 'INSERT INTO 

									teeme_leaf_unread

									( 

										leafId, UserId, workPlaceId, workSpaceId 

									)

								VALUES

									(

										'.$leafId.','.$row->userId.', '.$workplaceId.','.$workspaceId.'

									)';

					$rs = $this->db->query($strResultSQL);

									

				}

			}

		

	}



	/* This function is for add new record in unread table for each leaf  belongs to particular workspace when new user added in particular workplace -> workspace

	By Vinay kant	

	*/

	public function add_leaf_unread($workspaceId, $workplaceId, $userId){

		$sql_alluser="SELECT a.* FROM  teeme_users a, `teeme_work_space_members` b WHERE a.userId=b.workSpaceUserId and a.workPlaceId=".$workplaceId." and b.workSpaceId=".$workspaceId;

		$query = $this->db->query($sql_alluser);

		if($query->num_rows() > 0)

			{

				foreach ($query->result() as $row)

				{	

					$strResultSQL = 'INSERT INTO 

									teeme_leaf_unread

									( 

										leafId, UserId, workPlaceId, workSpaceId 

									)

								VALUES

									(

										'.$leafId.','.$userId.', '.$workplaceId.','.$workspaceId.'

									)';

					$rs = $this->db->query($strResultSQL);

									

				}

			}

		

	}



/* This function is for delete record in unread table for leaf and user  in particular workplace -> workspace once user view then leaf.

	By Vinay kant	

	*/

	public function make_read($workspaceId, $workplaceId, $userId, $leafId){

		

		$strResultSQL = 'delete from teeme_leaf_unread where leafId='.$leafId.' and  UserId='.$userId.' and workPlaceId='.$workplaceId.' and workSpaceId= '.$workspaceId;

		$rs = $this->db->query($strResultSQL);

		

	}

}