<?php /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

class tree_notification_manager extends CI_Model
{	

#Insert new leaf notification  
	public function insert_leaf_contents($nodeId,$workSpaceMembersId,$treeId,$CurrentUserId)
	{
		foreach($workSpaceMembersId as $userId)
		{
			if($userId!=$CurrentUserId)
			{
				$query = $this->db->query("insert into teeme_tree_notify (`nodeId` , `userId` , `treeId`) values ('".$nodeId."','".$userId."','".$treeId."')");
			}
		}
			if ($query)
			return 1;
			else
			return 0;
	}

#Insert new tree notification  
	public function insert_tree_contents($treeId,$workSpaceMembersId,$CurrentUserId)
	{
		foreach($workSpaceMembersId as $userId)
		{
			if($userId!=$CurrentUserId)
			{
				$query = $this->db->query("insert into teeme_tree_notify (`userId` , `treeId`) values ('".$userId."','".$treeId."')");
			}
		}
			if ($query)
			return 1;
			else
			return 0;
	}
	
	
#Insert new tag notification  
	public function insert_new_tag($tagType,$tag,$workSpaceMembersId,$CurrentUserId)
	{
		foreach($workSpaceMembersId as $userId)
		{
			if($userId!=$CurrentUserId)
			{
				$tagQuery = $this->db->query("insert into teeme_tree_notify (`userId` , `tagType`,`tag`) values ('".$userId."','".$tagType."','".$tag."')");
			}
		}
			if ($tagQuery)
			return 1;
			else
			return 0;
	}

#this method is used to get count of notification
	public function countNotification($userId,$workSpaceId,$workSpaceType)
	{
		 $CountQuery = $this->db->query("SELECT a.id FROM teeme_tree_notify a LEFT JOIN teeme_tree b ON a.treeId=b.id WHERE a.userId='".$userId."' AND b.workSpaces='".$workSpaceId."' AND b.workSpaceType='".$workSpaceType."' AND notifyStatus='1'" );
		 if($CountQuery)
		 {
		 $TotalCount=$CountQuery->num_rows();
		 return $TotalCount;
		 }
		 
		 else
		 return 0;
	}	
	
	
#this method is used to get tree contents 
	public function getAllContents($userId,$workSpaceId,$workSpaceType)
	{
		$getAllContent=$this->db->query("SELECT d.contents, a.name FROM teeme_tree a LEFT JOIN teeme_tree_notify b ON b.treeId = a.id LEFT JOIN teeme_node c ON b.nodeId = c.id LEFT JOIN teeme_leaf d ON c.leafId=d.id WHERE b.userId = '".$userId."' AND a.workSpaces='".$workSpaceId."' AND a.workSpaceType='".$workSpaceType."' AND notifyStatus='1'");
	
		if($getAllContent->num_rows()> 0)
		{
			$allLeafs=$getAllContent->result();
			
			/*$query1 = $this->db->query("UPDATE teeme_tree_notify SET notifyStatus='0' WHERE userId = '".$userId."'");
			if($query1)
			{*/
				return $allLeafs;
			/*}*/
			
    	}
		else
		{
			return false;
		}
	}
	

}