<?php /*Copyright � 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/

class timeline_db_manager extends CI_Model

{ 

	public function __construct()
	{   
		//Parent class constructor
		parent::__construct();
	}
	
	public function insert_timeline($treeId,$content,$userId,$createdDate,$predecessor=0,$successors=0,$workSpaceId,$workSpaceType,$recipients='',$tag='',$authors='',$status=1,$type=1,$nodeOrder=0)
	{

		if ($nodeOrder==0)

		{

			$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",'".$workSpaceId."',".$workSpaceType.")");

		}

		else

		{

			$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,nodeOrder,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",".$nodeOrder.",'".$workSpaceId."',".$workSpaceType.")");

		}

		
		$nodeId=$this->db->insert_id();

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId) values 

		(".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.")");

		$leafId=$this->db->insert_id();	

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);
		
		
		//$query = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId) VALUES ('".$nodeId."','".$userId."')");
		
		//$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$userId."')");
		
		if(!is_array($recipients))
		{
			$recipients .= ", ".$_SESSION['userId'];
		}
		
		if(!empty($recipients))
		{
			//echo $recipients;
			//exit;
			if($workSpaceId==0){
			
				$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$recipients."')");
			
				/*$recipients=explode(',',$recipients);	

				foreach($recipients as $recipientsUserId)
				{ 
					if($recipientsUserId && $_SESSION['userId']!=$recipientsUserId)
					{
						$query = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId) VALUES ('".$nodeId."','".$recipientsUserId ."')");
					}		
				}*/

			}

			else{
				
				$recipientsId='';
				$recipients_count=0;
				foreach($recipients as $recipientsUserId)
				{ 
					if($recipientsUserId['userId'])
					{
						if ($recipients_count==0){
							$recipientsId = $recipientsUserId['userId'];
						}
						else{
							$recipientsId .= ",".$recipientsUserId['userId'];
						}	
						$recipients_count++;
					   //$query = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId) VALUES ('".$nodeId."','".$recipientsUserId['userId']."')");
					}		
				}
				$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$recipientsId."')");

			}

		}

		//$query = $this->db->query("update teeme_leaf_tree set updates=updates+1 where tree_id=".$treeId);

		//$this->insertDiscussionLeafView($leafId, $userId);

		return $nodeId;

	}
	
	public function get_timeline($treeId,$workSpaceId,$workSpaceType,$allSpace=0,$user_id=0)
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
		//allspace 1 for all space and 2 for public space
		if($allSpace=='1')
		{
			//$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate FROM teeme_node a, teeme_leaf b, teeme_wall_recipients r WHERE r.recipientId ='".$_SESSION['userId']."' and r.commentId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.editedDate DESC");
			/*Changed by Dashrath- Add b.leafStatus in query for delete feature */
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId!=1 ORDER BY b.editedDate DESC");
		
		}
		else if($allSpace=='2')
		{
			/*Changed by Dashrath- Add b.leafStatus in query for delete feature */
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='0' and a.workSpaceType='0' ORDER BY b.editedDate DESC");
		}
		else if($allSpace=='3')
		{
			/*Changed by Dashrath- Add b.leafStatus in query for delete feature */
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_bookmark c WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and c.node_id=a.id and c.bookmarked=1 and c.user_id='".$_SESSION['userId']."' ORDER BY c.bookmark_date DESC");
			//echo $query; exit;
		}
		else
		{
			/*Changed by Dashrath- Add b.leafStatus in query for delete feature */
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' ORDER BY b.editedDate DESC");

		}
			

			foreach($query->result() as $disData)
			{

				$tree[] = $disData;

			}			

		if(count($tree) > 0)

		{

			$i=0;

			

			foreach ($tree as $row)

			{
			
				if($allSpace!='2' && $allSpace!='3' && $row->workSpaceType!=0)
				{
				
					$members = array();			
					$postQuery = $this->db->query("SELECT members FROM teeme_posts_shared WHERE postId='".$row->id."'");	
			
					if($postQuery->num_rows()> 0)
					{
						foreach($postQuery->result() as $rowData)
						{
							$members = explode (",",$rowData->members);
						}
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
				else
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



		

		return $treeData;	

	}
	
	public function insertTimelineComment($pnodeId,$content,$userId,$createdDate,$treeId,$workSpaceId,$workSpaceType,$tag='',$authors='',$status=1,$type=1)

	{
	
		//Manoj: transaction begin here
		$this->db->trans_begin();

		$query = $this->db->query("insert into teeme_node  (predecessor,successors,treeIds,workSpaceId,workSpaceType) values ('".$pnodeId."',0,".$treeId.",".$workSpaceId.",".$workSpaceType.")");

		$nodeId=$this->db->insert_id();

	

		//arun-change in query for add new feild in leaf table edited date.
		//Manoj: replace mysql_escape_str function
		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId) values (".$type.",'".$this->db->escape_str($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.")");

		

		$leafId=$this->db->insert_id();

		

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);

		
		$query = $this->db->query("select * from teeme_node  where id=".$pnodeId);

		foreach ($query->result() as $row)

		{

			$successors=trim($row->successors);

		}

		if($successors){

			$sArray=array();

			$sArray=explode(',',$successors);

			

			$sArray[count($sArray)]=$nodeId;

			

			$successors=implode(',',$sArray);

		}else{

			$successors=$nodeId;

		}

		$query = $this->db->query("update teeme_node set successors='".$successors."' where id=".$pnodeId);
		
		$query = $this->db->query("update teeme_leaf set editedDate='".$createdDate."' where nodeId=".$pnodeId);
				
		//$this->insertDiscussionLeafView($leafId, $userId);
		
		//Manoj: Checking transaction status here
		
		if($this->db->trans_status()=== FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return $nodeId;
		}		

		//return $nodeId;

	}
	
	//Get Comment topic title start
	
	public function getTimelinePostTitle($pId){

		$treeData	= array();

	

		$query = $this->db->query( "SELECT a.contents as contents, a.userId as userId, a.createdDate as createdDate FROM teeme_leaf a, teeme_node b WHERE b.id=a.nodeId AND b.id=".$pId);		

		if($query->num_rows() > 0)

		{

			 $row=$query->result();

			foreach ($query->result() as $row)

			{

				$treeData['userId'] = $row->userId;	
				$treeData['contents'] = $row->contents;	
				$treeData['createdDate'] = $row->createdDate;	
				

			}

		}					

		return $treeData;	

	

	}

	//Get comment topic title end
	
	//Insert post change details start
	
	public function add_post_change_details($change_type,$change_date,$node_id,$change_user_id,$space_id,$space_type)
	{

		$post_change_query = $this->db->query("insert into teeme_post_change(change_type,change_date,node_id,change_user_id,space_id,space_type) values ('".$change_type."','".$change_date."',".$node_id.",".$change_user_id.",'".$space_id."',".$space_type.")");

		if($post_change_query)
		{
			return true;
		}
	}
	
	//Insert post change details end
	
	//Get post change details start
	
	public function get_post_change_details($node_id)
	{

		$get_post_change_query = $this->db->query("SELECT a.change_type as change_type, DATE_FORMAT(a.change_date, '%Y-%m-%d %H:%i:%s') as change_date, a.change_user_id as change_user_id FROM teeme_post_change a WHERE a.node_id ='".$node_id."' ORDER BY a.change_date DESC LIMIT 1");

		if($get_post_change_query->num_rows() > 0)

		{

			$row=$get_post_change_query->result();

			foreach ($get_post_change_query->result() as $row)

			{

				$postChangeData['change_type'] = $row->change_type;	
				$postChangeData['change_date'] = $row->change_date;	
				$postChangeData['change_user_id'] = $row->change_user_id;	
				
			}

		}					

		return $postChangeData;
	}
	
	//Get post change details end
	
	//Add post bookmark start
	
	public function add_bookmark($nodeId,$userId,$postbookmarkCreatedDate)
	{

		$get_bookmark_status = $this->db->query("SELECT bookmarked FROM teeme_bookmark WHERE node_id ='".$nodeId."' AND user_id ='".$userId."'");
		
		if($get_bookmark_status->num_rows()==1)
		{
			foreach ($get_bookmark_status->result() as $row)
			{
				if($row->bookmarked==1)
				{
					$query = $this->db->query("UPDATE teeme_bookmark SET `bookmarked`='0', bookmark_date='".$postbookmarkCreatedDate."' WHERE node_id='".$nodeId."' AND user_id ='".$userId."'");
				}	
				else
				{
					$query = $this->db->query("UPDATE teeme_bookmark SET `bookmarked`='1', bookmark_date='".$postbookmarkCreatedDate."' WHERE node_id='".$nodeId."' AND user_id ='".$userId."'");
				}
			}
			
		}
		else
		{
			$query = $this->db->query("insert into teeme_bookmark(node_id,user_id,bookmark_date) values ('".$nodeId."','".$userId."','".$postbookmarkCreatedDate."')");
		}

		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//Add post bookmark end
	
	//Get bookmarked posts by user id start
	
	public function get_bookmark_by_user($userId)
	{
	
		$bookmarkedPostData	= array();
		
		$get_bookmarked_posts = $this->db->query("SELECT node_id FROM teeme_bookmark WHERE user_id ='".$userId."' AND bookmarked=1");

		if($get_bookmarked_posts->num_rows() > 0)

		{
			$i=0;

			foreach ($get_bookmarked_posts->result() as $row)
			{

				$bookmarkedPostData[] = $row->node_id;	
					
			}

		}					

		return $bookmarkedPostData;
	}
	
	//Get bookmarked posts by user id end

	//Add post recipients start here
	function add_post_recipients($nodeId,$recipients,$workSpaceId)
	{
		if($nodeId!='')
		{
			if($workSpaceId==0){

				//$recipients=explode(',',$recipients);	
				$query = "INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$recipients."')";
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
		else
		{
			return false;
		}
	}
	
	public function isPostShared ($nodeId)
	{
	
		$members = array();			
		$query = $this->db->query("SELECT * FROM teeme_posts_shared WHERE postId='".$nodeId."'");	

		if($query->num_rows()> 0)
		{
			return true;
		}	
		
		return false;	
	}
	public function update_post_recipients($nodeId,$recipients,$workSpaceId)
	{
		if($nodeId!='')
		{
			if($workSpaceId==0)
			{
				$query = "UPDATE teeme_posts_shared SET members='".$recipients."' WHERE postId='".$nodeId."'";
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
	
	//Add post recipients end here
	
	//Manoj: Change post order when add tag and link
	
	public function change_post_order($nodeId,$createdDate)
	{
		if($nodeId!='' && $createdDate!='')
		{
			$query = "update teeme_leaf set editedDate='".$createdDate."' where nodeId=".$nodeId;
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
	//Manoj: Code end

	public function insert_timeline_web($treeId,$content,$userId,$createdDate,$predecessor=0,$successors=0,$workSpaceId,$workSpaceType,$recipients='',$tag='',$authors='',$status=1,$type=1,$nodeOrder=0)
	{

		if ($nodeOrder==0)

		{

			$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",'".$workSpaceId."',".$workSpaceType.")");

		}

		else

		{

			$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,nodeOrder,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",".$nodeOrder.",'".$workSpaceId."',".$workSpaceType.")");

		}

		
		$nodeId=$this->db->insert_id();

		//Manoj: replace mysql_escape_str function

		$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId) values 

		(".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.")");

		$leafId=$this->db->insert_id();	

		$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);
		
		
		//$query = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId) VALUES ('".$nodeId."','".$userId."')");
		
		//$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$userId."')");
		
		if($workSpaceId==0)
		{
			//$recipients .= ",".$_SESSION['userId'];
			if (empty($recipients)){
				$recipients = $_SESSION['userId'];
			}
			else{
				$recipients .= ",".$_SESSION['userId'];
			}
		}
		
		
		if(!empty($recipients))
		{
			//echo $recipients;
			//exit;
			if($workSpaceId==0){
			
				$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$recipients."')");
			
				/*$recipients=explode(',',$recipients);	

				foreach($recipients as $recipientsUserId)
				{ 
					if($recipientsUserId && $_SESSION['userId']!=$recipientsUserId)
					{
						$query = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId) VALUES ('".$nodeId."','".$recipientsUserId ."')");
					}		
				}*/

			}

			else{
				
				$recipientsId='';
				$recipients_count=0;
				foreach($recipients as $recipientsUserId)
				{ 
					if($recipientsUserId['userId'])
					{
						if ($recipients_count==0){
							$recipientsId = $recipientsUserId['userId'];
						}
						else{
							$recipientsId .= ",".$recipientsUserId['userId'];
						}	
						$recipients_count++;
					   //$query = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId) VALUES ('".$nodeId."','".$recipientsUserId['userId']."')");
					}		
				}
				$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$recipientsId."')");

			}

		}

		//$query = $this->db->query("update teeme_leaf_tree set updates=updates+1 where tree_id=".$treeId);

		//$this->insertDiscussionLeafView($leafId, $userId);

		return $nodeId;

	}

	public function get_timeline_web($treeId,$workSpaceId,$workSpaceType,$allSpace=0,$user_id=0)
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
		//allspace 1 for all space and 2 for public space
		if($allSpace=='1')
		{
			//$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate FROM teeme_node a, teeme_leaf b, teeme_wall_recipients r WHERE r.recipientId ='".$_SESSION['userId']."' and r.commentId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.editedDate DESC");
			/*Changed by Dashrath- Add b.leafStatus in query for delete feature */
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId!=1 ORDER BY b.editedDate DESC");
		
		}
		else if($allSpace=='2')
		{
			/*Changed by Dashrath- Add b.leafStatus in query for delete feature */
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='0' and a.workSpaceType='0' ORDER BY b.editedDate DESC");
		}
		else if($allSpace=='3')
		{
			/*Changed by Dashrath- Add b.leafStatus in query for delete feature */
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_bookmark c WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and c.node_id=a.id and c.bookmarked=1 and c.user_id='".$_SESSION['userId']."' ORDER BY c.bookmark_date DESC");
			//echo $query; exit;
		}
		else
		{
			/*Changed by Dashrath- Add b.leafStatus in query for delete feature */
			//$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' ORDER BY b.editedDate DESC");
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and (b.userId=".$_SESSION['userId']." and (LENGTH(r.members)=1 and FIND_IN_SET(".$profileUserId.",r.members)) or b.userId=".$profileUserId." and (LENGTH(r.members)=1 and FIND_IN_SET(".$_SESSION['userId'].",r.members))) ORDER BY b.editedDate DESC");

		}
			

			foreach($query->result() as $disData)
			{

				$tree[] = $disData;

			}			

		if(count($tree) > 0)

		{

			$i=0;

			

			foreach ($tree as $row)

			{
			
				if($allSpace!='2' && $allSpace!='3' && $row->workSpaceType!=0)
				{
				
					$members = array();			
					$postQuery = $this->db->query("SELECT members FROM teeme_posts_shared WHERE postId='".$row->id."'");	
			
					if($postQuery->num_rows()> 0)
					{
						foreach($postQuery->result() as $rowData)
						{
							$members = explode (",",$rowData->members);
						}
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
				else
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



		

		return $treeData;	

	}
}