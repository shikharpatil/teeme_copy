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
	
	public function insertTimelineComment($pnodeId,$content,$userId,$createdDate,$treeId,$workSpaceId,$workSpaceType,$tag='',$authors='',$status=1,$type=1,$mainPostNodeId='')

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

		
		$query = $this->db->query("select * from teeme_node where id=".$pnodeId);

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

			if ($mainPostNodeId>0){
				$query = $this->db->query("select * from teeme_node where id=".$mainPostNodeId);

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
		
				$query = $this->db->query("update teeme_node set successors='".$successors."' where id=".$mainPostNodeId);
			}
				
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
		if($get_post_change_query->num_rows() > 0){
			$row=$get_post_change_query->result();
			foreach ($get_post_change_query->result() as $row){
				$postChangeData['change_type'] = $row->change_type;	
				$postChangeData['change_date'] = $row->change_date;	
				$postChangeData['change_user_id'] = $row->change_user_id;				
			}
			return $postChangeData;
		}					
		else{
			return 0;
		}		
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

	public function insert_timeline_web($treeId,$content,$userId,$createdDate,$predecessor=0,$successors=0,$workSpaceId,$workSpaceType,$arrAllRecipientIds='',$tag='',$authors='',$status=1,$type=1,$nodeOrder=0,$post_type_id='-1',$post_type_object_id='-1',$delivery_status_id='1',$seen_status='0',$data='',$is_forward=0,$post_status='publish',$is_draft=0,$post_id=0,$disable_interactions=0)
	{
		$nodeIds=array();
		$leafIds=array();
		$nodeIdsRecipients=array();
		$leafIdsRecipients=array();
		//echo "<li>recipients= " .$recipients;exit;
		//echo "<li>post_type_id= " .$post_type_id;exit;
		//echo "<li>workspaceid= " .$workSpaceId;exit;
		//echo "<pre>"; print_r(explode(",",$recipients));exit;
		//$this->load->model('dal/notification_db_manager');	
		//$this->load->model('dal/profile_manager');
		//$followers = $this->notification_db_manager->getFollowersByOjectId(10, $post_type_object_id);
		//$arrPlaceUsers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
		//echo "<pre>follower"; print_r($followers);
		//echo "<pre>placeusers"; print_r($arrPlaceUsers);exit;
		//echo "<pre>recipients"; print_r($arrRecipients);exit;
		//echo "<li>individual recipients count= " .count($arrAllRecipientIds['recipientIds']);
		//echo "<li>space recipients count= " .count($arrAllRecipientIds['spaceIds']);
		//echo "<li>is_forward= " .$is_forward;exit;
		//exit;

		if(!empty($userId)){
			$this->db->trans_begin();
			if ($is_draft!=1){
				if($is_forward==1)
				{
					// for multiple users recipients
					if(count($arrAllRecipientIds['recipientIds']>0))
					{
						$i=0;
						foreach($arrAllRecipientIds['recipientIds'] as $recipientsUserId)
						{
							// forwarded post in every user's myspace is added as new post in their myspace
							if ($nodeOrder==0){
								$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",'".$workSpaceId."',".$workSpaceType.")");
							}
							else{
								$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,nodeOrder,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",".$nodeOrder.",'".$spaceId."',".$workSpaceType.")");
							}		
							$nodeId=$this->db->insert_id();
				
							$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId,leafStatus) values 
							(".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.",'".$post_status."')");
				
							$leafId=$this->db->insert_id();	
				
							$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);
							// Parv: insert leaf meta data
							if ($leafId>0){
								$query = $this->db->query("insert into teeme_leaf_meta(leaf_id,meta_key,meta_value) values ('".$leafId."','interactions','".$disable_interactions."')");
							}
							$nodeIdsRecipients[$i]=$nodeId;
							$leafIdsRecipients[$i]=$leafId;
							$i++;
						}
					}
					// For multiple spaces
					if(count($arrAllRecipientIds['spaceIds'])>0)
					{	
						$i=0;
						foreach($arrAllRecipientIds['spaceIds'] as $spaceId)
						{
							// forwarded post in every space is added as new post in that space
							if ($nodeOrder==0){
								$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",'".$spaceId."',".$workSpaceType.")");
							}
							else{
								$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,nodeOrder,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",".$nodeOrder.",'".$spaceId."',".$workSpaceType.")");
							}		
							$nodeId=$this->db->insert_id();
				
							$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId,leafStatus) values 
							(".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.",'".$post_status."')");
				
							$leafId=$this->db->insert_id();	
				
							$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);
							// Parv: insert leaf meta data
							if ($leafId>0){
								$query = $this->db->query("insert into teeme_leaf_meta(leaf_id,meta_key,meta_value) values ('".$leafId."','interactions','".$disable_interactions."')");
							}
							$nodeIds[$i]=$nodeId;
							$leafIds[$i]=$leafId;
							$i++;
								
						}
					}
				}
				else
				{
					if ($nodeOrder==0){
						$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",'".$workSpaceId."',".$workSpaceType.")");
					}
					else{
						$query = $this->db->query("insert into teeme_node(predecessor,successors,treeIds,nodeOrder,workSpaceId,workSpaceType) values ('".$predecessor."','".$successors."',".$treeId.",".$nodeOrder.",'".$workSpaceId."',".$workSpaceType.")");
					}		
					$nodeId=$this->db->insert_id();
		
					$query = $this->db->query("insert into teeme_leaf  (type,authors,status,userId,createdDate,editedDate,contents,nodeId,leafStatus) values 
					(".$type.",'".addslashes ($authors)."',".$status.",".$userId.",'".$createdDate."','".$createdDate."','".$this->db->escape_str($content)."',".$nodeId.",'".$post_status."')");
		
					$leafId=$this->db->insert_id();	
		
					$query = $this->db->query("update teeme_node set leafId=".$leafId." where id=".$nodeId);
					// Parv: insert leaf meta data
					if ($leafId>0){
						$query = $this->db->query("insert into teeme_leaf_meta(leaf_id,meta_key,meta_value) values ('".$leafId."','interactions','".$disable_interactions."')");
					}
				}
				
			}else if ($is_draft==1 && $post_id>0){
				if ($post_status=="publish"){
					$q = "UPDATE teeme_leaf SET contents='".$this->db->escape_str($content)."',leafStatus='".$post_status."' WHERE nodeId=".$post_id;
				}else{
					$q = "UPDATE teeme_leaf SET contents='".$this->db->escape_str($content)."' WHERE nodeId=".$post_id;
				}				
				$query = $this->db->query($q);
				$nodeId = $post_id; 
				$q2 = "UPDATE teeme_leaf_meta SET meta_value='".$disable_interactions."' WHERE leaf_id='".$post_id."' AND meta_key='interactions'";
				$query = $this->db->query($q2);
					if (!$query){
						$query = $this->db->query("insert into teeme_leaf_meta(leaf_id,meta_key,meta_value) values ('".$post_id."','interactions','".$disable_interactions."')");
					}				
			}


			//$query = $this->db->query("INSERT INTO teeme_wall_recipients(commentId,recipientId) VALUES ('".$nodeId."','".$userId."')");			
			//$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$userId."')");
			/*
			if($workSpaceId==0)
			{
				$recipients .= ",".$_SESSION['userId'];
				if (empty($recipients)){
					$recipients = $_SESSION['userId'];
				}
				else{
					$recipients .= ",".$_SESSION['userId'];
				}
			}
			
			if (empty($recipients)){
				$recipients = $_SESSION['userId'];
			}
			*/
			//echo "<li>recipients= " .$recipients; echo "<li>workspaceid= " .$workSpaceId; exit;
			
			//if(!empty($recipients))
			//{
				/*
				if($workSpaceId==0){			
					$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$recipients."')");
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
						}		
					}
					$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$recipientsId."')");
				}
				$query = $this->db->query("INSERT INTO teeme_posts_shared (postId,members) VALUES ('".$nodeId."','".$recipients."')");
				*/
				// If it's a draft edit, we first remove the old participant entries before adding the latest ones.
				if ($is_draft==1 && $post_id>0){
					$query = $this->db->query("DELETE FROM teeme_post_web_post_store WHERE post_id=".$post_id);
				}
				// If one-to-one
				if ($post_type_id==1){
					if($is_forward==0){
						$values = array();
						/*
						$arrPlaceUsers = array();
						$this->load->model('dal/profile_manager');
						$arrPlaceUsers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
							foreach($arrPlaceUsers  as $keyVal=>$arrVal){
								if ($post_type_object_id!=''){
									if(in_array($arrVal['userId'],$arrRecipients)){
										$values[] = "('".$nodeId."','".$post_type_id."','".$arrVal['userId']."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
									else{
										$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
								else if ($post_type_object_id=='') {
									if(in_array($arrVal['userId'],$arrRecipients)){
										$values[] = "('".$nodeId."','".$post_type_id."','".$arrVal['userId']."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 							
									}
									else {
										$values[] = "('".$nodeId."','".$post_type_id."','".$userId."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
							}
						*/	

						$this->load->model('dal/notification_db_manager');	
						$followers = array();
						$followers = $this->notification_db_manager->getFollowersByOjectId(15, $post_type_object_id);
						foreach($followers as $recipientsUserId)
						{ 
							if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$_SESSION['userId']){
								$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
							}	
						}
						$values[] = "('".$nodeId."','".$post_type_id."','".$userId."','".$userId."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 						
						/*
						if ($userId!=$recipients){
							$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$recipients."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
						}
						$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$userId."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
						*/
					}
					// For multiple individual recipients
					if(count($arrAllRecipientIds['recipientIds'])>0){
						$arrPlaceUsers = array();
						$this->load->model('dal/profile_manager');
						//if ($workSpaceId>0){
						if ($post_type_object_id>0){
							$arrPlaceUsers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
							foreach($arrPlaceUsers  as $keyVal=>$arrVal){
								if(in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])){
									if ($workSpaceId>0){
										$values[] = "('".$nodeId."','".$post_type_id."','".$arrVal['userId']."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
									else {
										$values[] = "('".$nodeId."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
								else if ((!in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])) && (!in_array($arrVal['userId'],$arrSpaceRecipientIds))) {
									if ($workSpaceId>0){
										$values[] = "('".$nodeId."','".$post_type_id."','".$userId."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 							
									}
									else{
										$values[] = "('".$nodeId."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
							}							
						}
						else{
							foreach($arrAllRecipientIds['recipientIds'] as $recipientsUserId){
								if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$userId){
									$values[] = "('".$nodeId."','".$post_type_id."','0','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 								
								}
							}
						}
					}
					// For multiple spaces
					if(count($arrAllRecipientIds['spaceIds'])>0){
						$this->load->model('dal/identity_db_manager');	
						foreach($arrAllRecipientIds['spaceIds'] as $spaceId){
							$arrSpaceRecipients = array();
							$arrSpaceRecipients = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($spaceId);
							// Space members are recipients by default
							foreach($arrSpaceRecipients as $recipientsUserId)
							{ 
								//if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$_SESSION['userId']){
								if($recipientsUserId['userId']>0){
									$values[] = "('".$nodeId."','".$post_type_id."','".$spaceId."','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
								}	
							}	
						}
					}
					$val = implode(',', $values);
					$q = "INSERT INTO teeme_post_web_post_store (post_id,post_type_id,post_type_object_id,participant_id,sender_id,delivery_status_id,seen_status,sent_timestamp,data) VALUES $val";
					$query = $this->db->query($q);
				}
				else if ($post_type_id==2 || $post_type_id==5 || $post_type_id==10){		
					$post_type_id=2;// If a post is initiated from 'home' or 'draft' menu, we treat it as a space post				
					//if ($workSpaceId>0){
					if($is_forward==0){
						if ($post_type_object_id>0){
							$this->load->model('dal/identity_db_manager');	
							$arrSpaceRecipients = array();
							$arrSpaceRecipientIds = array();
							$arrSpaceRecipients = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($post_type_object_id);

							// Space members are recipients by default
							foreach($arrSpaceRecipients as $recipientsUserId)
							{ 
								if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$_SESSION['userId']){
									$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
								}	
								$arrSpaceRecipientIds[] = $recipientsUserId['userId'];
							}
							/*
							$this->load->model('dal/notification_db_manager');	
							$followers = array();
							$arrSpaceRecipientIds = array();
							$followers = $this->notification_db_manager->getFollowersByOjectId(10, $post_type_object_id);
							// Non-space members who are followers are also recipients
							foreach($followers as $recipientsUserId)
							{ 
								if($recipientsUserId['userId']>0){
									$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
								}	
								$arrSpaceRecipientIds[] = $recipientsUserId['userId'];
							}
							*/
							//Current user himself is a recipient
							$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$userId."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
							$arrSpaceRecipientIds[] = $userId;
						}
						else {
							$values[] = "('".$nodeId."','".$post_type_id."','0','".$userId."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
							$arrSpaceRecipientIds[] = $userId;
						}
					}
					// For multiple individual recipients
					if(count($arrAllRecipientIds['recipientIds'])>0){
						$arrPlaceUsers = array();
						$this->load->model('dal/profile_manager');
						//if ($workSpaceId>0){
						if ($post_type_object_id>0){
							$arrPlaceUsers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
							$i=0;
							foreach($arrPlaceUsers  as $keyVal=>$arrVal){
								if(in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])){
									if ($workSpaceId>0){
										$values[] = "('".$nodeIdsRecipients[$i]."','".$post_type_id."','".$arrVal['userId']."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
									else {
										$values[] = "('".$nodeIdsRecipients[$i]."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
								else if ((!in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])) && (!in_array($arrVal['userId'],$arrSpaceRecipientIds))) {
									if ($workSpaceId>0){
										$values[] = "('".$nodeIdsRecipients[$i]."','".$post_type_id."','".$userId."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 							
									}
									else{
										$values[] = "('".$nodeIdsRecipients[$i]."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
								$i++;
							}							
						}
						else{
							$i=0;
							foreach($arrAllRecipientIds['recipientIds'] as $recipientsUserId){
								if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$userId){
									$values[] = "('".$nodeIdsRecipients[$i]."','".$post_type_id."','0','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 								
								}
								$i++;
							}
						}
					}
					// For multiple spaces
					if(count($arrAllRecipientIds['spaceIds'])>0){
						$this->load->model('dal/identity_db_manager');	
						$i=0;
						foreach($arrAllRecipientIds['spaceIds'] as $spaceId){
							$arrSpaceRecipients = array();
							$arrSpaceRecipients = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($spaceId);
							// Space members are recipients by default
							foreach($arrSpaceRecipients as $recipientsUserId)
							{ 
								//if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$_SESSION['userId']){
								if($recipientsUserId['userId']>0){
									$values[] = "('".$nodeIds[$i]."','".$post_type_id."','".$spaceId."','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
								}	
							}
							$i++;	
						}
					}
					$val = implode(',', $values);
					$q = "INSERT INTO teeme_post_web_post_store (post_id,post_type_id,post_type_object_id,participant_id,sender_id,delivery_status_id,seen_status,sent_timestamp,data) VALUES $val";
					$query = $this->db->query($q);				
				}
				else if ($post_type_id==3){
					if($is_forward==0){
						$this->load->model('dal/identity_db_manager');
						$arrSubSpaceRecipients = array();
						$arrSubSpaceRecipientIds = array();
						$arrSubSpaceRecipients = $this->identity_db_manager->getSubWorkSpaceMembersBySubWorkSpaceId($post_type_object_id);
						foreach($arrSubSpaceRecipients as $recipientsUserId)
						{ 
							if($recipientsUserId['userId']>0){
								$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
							}	
							//$arrSubSpaceRecipientIds[] = $recipientsUserId['userId'];
						}
					}
					// For multiple individual recipients
					if(count($arrAllRecipientIds['recipientIds'])>0){
						$arrPlaceUsers = array();
						$this->load->model('dal/profile_manager');
						//if ($workSpaceId>0){
						if ($post_type_object_id>0){
							$arrPlaceUsers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
							foreach($arrPlaceUsers  as $keyVal=>$arrVal){
								if(in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])){
									if ($workSpaceId>0){
										$values[] = "('".$nodeId."','".$post_type_id."','".$arrVal['userId']."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
									else {
										$values[] = "('".$nodeId."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
								else if ((!in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])) && (!in_array($arrVal['userId'],$arrSpaceRecipientIds))) {
									if ($workSpaceId>0){
										$values[] = "('".$nodeId."','".$post_type_id."','".$userId."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 							
									}
									else{
										$values[] = "('".$nodeId."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
							}							
						}
						else{
							foreach($arrAllRecipientIds['recipientIds'] as $recipientsUserId){
								if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$userId){
									$values[] = "('".$nodeId."','".$post_type_id."','0','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 								
								}
							}
						}
					}
					// For multiple spaces
					if(count($arrAllRecipientIds['spaceIds'])>0){
						$this->load->model('dal/identity_db_manager');	
						foreach($arrAllRecipientIds['spaceIds'] as $spaceId){
							$arrSpaceRecipients = array();
							$arrSpaceRecipients = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($spaceId);
							// Space members are recipients by default
							foreach($arrSpaceRecipients as $recipientsUserId)
							{ 
								//if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$_SESSION['userId']){
								if($recipientsUserId['userId']>0){
									$values[] = "('".$nodeId."','".$post_type_id."','".$spaceId."','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
								}	
							}	
						}
					}
					$val = implode(',', $values);
					$q = "INSERT INTO teeme_post_web_post_store (post_id,post_type_id,post_type_object_id,participant_id,sender_id,delivery_status_id,seen_status,sent_timestamp,data) VALUES $val";
					$query = $this->db->query($q);				
				}
				else if ($post_type_id==7){
					if($is_forward==0){
						$values = array();
						$arrPlaceUsers = array();
						$this->load->model('dal/profile_manager');
						$arrPlaceUsers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
							foreach($arrPlaceUsers  as $keyVal=>$arrVal){
								if ($post_type_object_id!=''){
									if(in_array($arrVal['userId'],$arrRecipients)){
										$values[] = "('".$nodeId."','".$post_type_id."','".$arrVal['userId']."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
									else{
										$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
								else if ($post_type_object_id=='') {
									if(in_array($arrVal['userId'],$arrRecipients)){
										$values[] = "('".$nodeId."','".$post_type_id."','".$arrVal['userId']."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 							
									}
									else {
										$values[] = "('".$nodeId."','".$post_type_id."','".$userId."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
							}
					}
					// For multiple individual recipients
					if(count($arrAllRecipientIds['recipientIds'])>0){
						$arrPlaceUsers = array();
						$this->load->model('dal/profile_manager');
						//if ($workSpaceId>0){
						if ($post_type_object_id>0){
							$arrPlaceUsers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
							foreach($arrPlaceUsers  as $keyVal=>$arrVal){
								if(in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])){
									if ($workSpaceId>0){
										$values[] = "('".$nodeId."','".$post_type_id."','".$arrVal['userId']."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
									else {
										$values[] = "('".$nodeId."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
								else if ((!in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])) && (!in_array($arrVal['userId'],$arrSpaceRecipientIds))) {
									if ($workSpaceId>0){
										$values[] = "('".$nodeId."','".$post_type_id."','".$userId."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 							
									}
									else{
										$values[] = "('".$nodeId."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
							}							
						}
						else{
							foreach($arrAllRecipientIds['recipientIds'] as $recipientsUserId){
								if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$userId){
									$values[] = "('".$nodeId."','".$post_type_id."','0','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 								
								}
							}
						}
					}
					// For multiple spaces
					if(count($arrAllRecipientIds['spaceIds'])>0){
						$this->load->model('dal/identity_db_manager');	
						foreach($arrAllRecipientIds['spaceIds'] as $spaceId){
							$arrSpaceRecipients = array();
							$arrSpaceRecipients = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($spaceId);
							// Space members are recipients by default
							foreach($arrSpaceRecipients as $recipientsUserId)
							{ 
								//if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$_SESSION['userId']){
								if($recipientsUserId['userId']>0){
									$values[] = "('".$nodeId."','".$post_type_id."','".$spaceId."','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
								}	
							}	
						}
					}
					$val = implode(',', $values);
					$q = "INSERT INTO teeme_post_web_post_store (post_id,post_type_id,post_type_object_id,participant_id,sender_id,delivery_status_id,seen_status,sent_timestamp,data) VALUES $val";
					$query = $this->db->query($q);
				}
				else if ($post_type_id==9){	
					if($is_forward==0){						
						$arrPlaceUsers = array();
						$this->load->model('dal/profile_manager');					
						$arrPlaceUsers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
							
						if (count($arrPlaceUsers)>0 && $workSpaceId>0){
								foreach($arrPlaceUsers  as $keyVal=>$arrVal){
									$values[] = "('".$nodeId."','".$post_type_id."','".$post_type_object_id."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
								}					
						}
					}
					// For multiple individual recipients
					if(count($arrAllRecipientIds['recipientIds'])>0){
						$arrPlaceUsers = array();
						$this->load->model('dal/profile_manager');
						//if ($workSpaceId>0){
						if ($post_type_object_id>0){
							$arrPlaceUsers = $this->profile_manager->getAllUsersByWorkPlaceId($_SESSION['workPlaceId']);
							foreach($arrPlaceUsers  as $keyVal=>$arrVal){
								if(in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])){
									if ($workSpaceId>0){
										$values[] = "('".$nodeId."','".$post_type_id."','".$arrVal['userId']."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
									else {
										$values[] = "('".$nodeId."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
								else if ((!in_array($arrVal['userId'],$arrAllRecipientIds['recipientIds'])) && (!in_array($arrVal['userId'],$arrSpaceRecipientIds))) {
									if ($workSpaceId>0){
										$values[] = "('".$nodeId."','".$post_type_id."','".$userId."','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 							
									}
									else{
										$values[] = "('".$nodeId."','".$post_type_id."','0','".$arrVal['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
									}
								}
							}							
						}
						else{
							foreach($arrAllRecipientIds['recipientIds'] as $recipientsUserId){
								if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$userId){
									$values[] = "('".$nodeId."','".$post_type_id."','0','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 								
								}
							}
						}
					}
					// For multiple spaces
					if(count($arrAllRecipientIds['spaceIds'])>0){
						$this->load->model('dal/identity_db_manager');	
						foreach($arrAllRecipientIds['spaceIds'] as $spaceId){
							$arrSpaceRecipients = array();
							$arrSpaceRecipients = $this->identity_db_manager->getWorkSpaceMembersByWorkSpaceId($spaceId);
							// Space members are recipients by default
							foreach($arrSpaceRecipients as $recipientsUserId)
							{ 
								//if($recipientsUserId['userId']>0 && $recipientsUserId['userId']!=$_SESSION['userId']){
								if($recipientsUserId['userId']>0){
									$values[] = "('".$nodeId."','".$post_type_id."','".$spaceId."','".$recipientsUserId['userId']."','".$userId."','".$delivery_status_id."','".$seen_status."','".$createdDate."','".$this->db->escape_str($data)."')"; 	
								}	
							}	
						}
					}
					$val = implode(',', $values);
					$q = "INSERT INTO teeme_post_web_post_store (post_id,post_type_id,post_type_object_id,participant_id,sender_id,delivery_status_id,seen_status,sent_timestamp,data) VALUES $val";
					$query = $this->db->query($q);				
				}
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
		}	

		//$query = $this->db->query("update teeme_leaf_tree set updates=updates+1 where tree_id=".$treeId);

		//$this->insertDiscussionLeafView($leafId, $userId);
		
		//return $nodeId;

	}

	// 1 for add, 0 for remove
	public function add_remove_post_participant($post_type_id='-1',$post_type_object_id='-1',$arrMemberIds='',$add=1){
		$arrPostIds = array();
		$data='';
		//$this->load->model('dal/identity_db_manager');
		$this->load->model('dal/time_manager');
		$createdDate=$this->time_manager->getGMTTime();
		$q = "SELECT DISTINCT post_id,sender_id FROM teeme_post_web_post_store WHERE post_type_id='".$post_type_id."' AND post_type_object_id='".$post_type_object_id."'";
		$query = $this->db->query($q);
		$i=0;
			foreach($query->result() as $row){		
				$arrPost[$i]['post_id']=$row->post_id;	
				$arrPost[$i]['sender_id']=$row->sender_id;	
				$i++;			
			}	
			if($add==1){
				foreach($arrPost as $arrKey=>$arrVal){
					foreach($arrMemberIds as $member_id){
						$values[] = "('".$arrVal['post_id']."','".$post_type_id."','".$post_type_object_id."','".$member_id."','".$arrVal['sender_id']."','1','0','".$createdDate."','".$this->db->escape_str($data)."')"; 				
					}	
				}	
				$val = implode(',', $values);
				$q = "INSERT INTO teeme_post_web_post_store (post_id,post_type_id,post_type_object_id,participant_id,sender_id,delivery_status_id,seen_status,sent_timestamp,data) VALUES $val";
				$query = $this->db->query($q);	
			}
			elseif($add==0){
				foreach($arrMemberIds as $member_id){
					$q = "DELETE FROM teeme_post_web_post_store WHERE post_type_id='".$post_type_id."' AND post_type_object_id='".$post_type_object_id."' AND participant_id='".$member_id."'";
					$query = $this->db->query($q);
				}
			}
	}

	public function get_timeline_web($treeId,$workSpaceId,$workSpaceType,$allSpace=0,$user_id=0,$post_type_id='-1',$post_type_object_id='-1')
	{
		$treeId = '0';	
		$treeData	= array();
		$tree = array();	
		/*
		if($user_id!='' && $user_id !=0)
		{
			$profileUserId = $user_id;
		}	
		
		else
		{
			$profileUserId = $_SESSION['userId'];
		}
		//allspace 1 for all space and 2 for public space
		if($allSpace=='1') // for all spaces
		{
			//Changed by Dashrath- Add b.leafStatus in query for delete feature
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId!=1 ORDER BY b.editedDate DESC");
		
		}
		else if($allSpace=='2') // for public
		{
			//Changed by Dashrath- Add b.leafStatus in query for delete feature
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='0' and a.workSpaceType='0' ORDER BY b.editedDate DESC");
		}
		else if($allSpace=='3') // for bookmark
		{
			//Changed by Dashrath- Add b.leafStatus in query for delete feature
			$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_bookmark c WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and c.node_id=a.id and c.bookmarked=1 and c.user_id='".$_SESSION['userId']."' ORDER BY c.bookmark_date DESC");
		}
		else
		{
			//Changed by Dashrath- Add b.leafStatus in query for delete feature
			//$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' ORDER BY b.editedDate DESC");
			if ($profileUserId>0){
				$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and (b.userId=".$_SESSION['userId']." and (LENGTH(r.members)=1 and FIND_IN_SET(".$profileUserId.",r.members)) or b.userId=".$profileUserId." and (LENGTH(r.members)=1 and FIND_IN_SET(".$_SESSION['userId'].",r.members))) ORDER BY b.editedDate DESC");
			}
			else if ($workSpaceId>0){
				$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' ORDER BY b.editedDate DESC");
			}
		}
		foreach($query->result() as $disData){
			$tree[] = $disData;
		}	

		if(count($tree) > 0){
			$i=0;
			foreach ($tree as $row){			
				if($allSpace!='2' && $allSpace!='3' && $row->workSpaceType!=0 && $profileUserId>0)
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

							//Added by Dashrath- Add leafStatus in array
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

					//Added by Dashrath- Add leafStatus in array
					$treeData[$i]['leafStatus']  		= $row->leafStatus;
	
					$i++;
				}

 			}

		}
		*/
		/*
		// if one-to-one
		if ($post_type_id==1) {
			
			//if ($user_id!=$post_type_object_id){
				//$q = "SELECT COUNT(id) as row_count FROM teeme_post_web_post_store WHERE post_type_id=1 AND ((participant_id='".$post_type_object_id."' AND sender_id='".$user_id."') OR (participant_id='".$user_id."' AND sender_id='".$post_type_object_id."'))";
			//}
			//else{
				//$q = "SELECT COUNT(id) as row_count FROM teeme_post_web_post_store WHERE post_type_id=1 AND participant_id='".$user_id."' AND sender_id='".$user_id."' AND post_type_object_id='".$user_id."'";
			//}
			
			$q = "SELECT COUNT(id) as row_count FROM teeme_post_web_post_store WHERE (post_type_id=1 OR post_type_id=5) AND post_type_object_id='".$post_type_object_id."' AND seen_status=0";
			$query = $this->db->query($q);		
		}
		else if ($post_type_id==2) {
			$q = "SELECT COUNT(id) as row_count FROM teeme_post_web_post_store WHERE post_type_id=2 AND post_type_object_id='".$post_type_object_id."' AND participant_id='".$user_id."' AND seen_status=0";
			$query = $this->db->query($q);
		}
		else if ($post_type_id==3) {
			$q = "SELECT COUNT(id) as row_count FROM teeme_post_web_post_store WHERE post_type_id=3 AND post_type_object_id='".$post_type_object_id."' AND participant_id='".$user_id."' AND seen_status=0";
			$query = $this->db->query($q);
		}
		else if ($post_type_id==5) {
			$q = "SELECT COUNT(id) as row_count FROM teeme_post_web_post_store WHERE participant_id='".$user_id."' AND seen_status=0";
			$query = $this->db->query($q);
		}
		else if ($post_type_id==6) {
			//$q = "SELECT COUNT(a.id) as row_count FROM teeme_node a, teeme_leaf b, teeme_bookmark c WHERE b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND c.node_id=a.id AND c.bookmarked=1 AND c.user_id='".$_SESSION['userId']."' ORDER BY c.bookmark_date DESC";
			$q = "SELECT COUNT(a.id) as row_count FROM teeme_node a, teeme_leaf b, teeme_bookmark c, teeme_post_web_post_store d WHERE b.id=a.leafId AND b.id=d.post_id AND a.leafId=d.post_id AND c.node_id=d.post_id AND d.participant_id='".$_SESSION['userId']."' AND d.seen_status=0 AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND c.node_id=a.id AND c.bookmarked=1 AND c.user_id='".$_SESSION['userId']."' ORDER BY c.bookmark_date DESC";
			$query = $this->db->query($q);
		}
		else if ($post_type_id==7){
			//$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='0' and a.workSpaceType='0' ORDER BY b.editedDate DESC");
			$q = "SELECT COUNT(a.id) as row_count FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=7 AND c.participant_id='".$user_id."' AND b.id=a.leafId AND (a.predecessor='0' or a.predecessor='') AND a.treeIds=".$treeId." AND a.workSpaceId='0' AND a.workSpaceType='0' AND c.seen_status=0 ORDER BY b.editedDate DESC";
			$query = $this->db->query($q);
		}
		foreach($query->result() as $row){		
			$row_count = $row->row_count;													
		}	
		*/
		//echo "<li>row= " .$row_count; exit;
		//if($row_count>0){
			if ($post_type_id==1) {
				/*
				if ($user_id==$post_type_object_id){
					$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=1  AND (c.participant_id='".$post_type_object_id."' AND c.sender_id='".$user_id."' AND c.post_type_object_id='".$user_id."') AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.userId=".$_SESSION['userId']." ORDER BY b.editedDate DESC";
				}
				else {
					$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=1  AND ((c.participant_id='".$post_type_object_id."' AND c.sender_id='".$user_id."') OR (c.participant_id='".$user_id."' AND c.sender_id='".$post_type_object_id."')) AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND (b.userId=".$_SESSION['userId']." OR b.userId='".$post_type_object_id."') ORDER BY b.editedDate DESC";
				}
				*/
				//$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND (c.post_type_id=1 OR c.post_type_id=5)  AND c.post_type_object_id='".$post_type_object_id."' AND c.participant_id='".$post_type_object_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." ORDER BY b.editedDate DESC";
				//$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=1  AND (c.participant_id='".$post_type_object_id."' AND c.sender_id='".$post_type_object_id."') AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.userId=".$post_type_object_id." AND c.seen_status=0 ORDER BY b.editedDate DESC";
				$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=1 AND c.participant_id='".$post_type_object_id."' AND c.sender_id='".$post_type_object_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.userId=".$post_type_object_id." AND b.leafStatus='publish' AND c.seen_status=0 ORDER BY b.editedDate DESC";

			}
			else if ($post_type_id==2) {
				if ($post_type_object_id>0){
					$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=2  AND c.participant_id='".$user_id."' AND c.post_type_object_id='".$post_type_object_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.seen_status=0 ORDER BY b.editedDate DESC";
				}
				else{
					//$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=2  AND c.participant_id='".$user_id."' AND c.sender_id='".$user_id."' AND c.post_type_object_id='".$post_type_object_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND c.seen_status=0 ORDER BY b.editedDate DESC";
					$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=2  AND c.participant_id='".$user_id."' AND c.post_type_object_id='".$post_type_object_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.seen_status=0 ORDER BY b.editedDate DESC";
				}
				//echo "<pre>"; print_r($query2->result());exit;
			}
			else if ($post_type_id==3) {
				if ($post_type_object_id>0){
					$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=3  AND c.participant_id='".$user_id."' AND c.post_type_object_id='".$post_type_object_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.seen_status=0 ORDER BY b.editedDate DESC";
				}
				else{
					$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=3  AND c.participant_id='".$user_id."' AND c.sender_id='".$user_id."' AND c.post_type_object_id='".$post_type_object_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.seen_status=0 ORDER BY b.editedDate DESC";
				}		
			}
			else if ($post_type_id==5) {
				$arrPostIds = array();
				$this->load->model('dal/identity_db_manager');
				$q = "SELECT post_id,post_type_id,post_type_object_id,sender_id FROM teeme_post_web_post_store WHERE participant_id='".$user_id."' AND seen_status=0";
				$query = $this->db->query($q);
					foreach($query->result() as $row){		
						if($row->post_type_id==9){
							$objectFollowStatus=$this->identity_db_manager->get_follow_status($user_id,$row->post_type_object_id,'',10);
							if($objectFollowStatus['preference'] || $this->identity_db_manager->isWorkSpaceMember($row->post_type_object_id,$user_id)){
								$arrPostIds[]=$row->post_id;
							}
						}else if($row->post_type_id==2 && $row->post_type_object_id==0 && $row->sender_id!=$user_id){
							$objectFollowStatus=$this->identity_db_manager->get_follow_status($user_id,$row->sender_id,'',15);
							if($objectFollowStatus['preference']){
								$arrPostIds[]=$row->post_id;
							}							
						}
						else{
							$arrPostIds[]=$row->post_id;
						}
					}	
				//echo "<pre>"; print_r(array_unique($arrPostIds)); exit;
				$q2 = "SELECT DISTINCT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.participant_id='".$user_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.seen_status=0";			
				if(count($arrPostIds)>0){
					$postIds = implode(",",$arrPostIds);
					$q2 .= " AND c.post_id IN ($postIds)";
				}
				$q2 .= " ORDER BY b.editedDate DESC";
			}
			else if ($post_type_id==6) {
				//$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b, teeme_bookmark c WHERE b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND c.node_id=a.id AND c.bookmarked=1 AND c.user_id='".$_SESSION['userId']."' ORDER BY c.bookmark_date DESC";
				$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, d.post_type_id, d.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_bookmark c, teeme_post_web_post_store d WHERE b.id=a.leafId AND b.id=d.post_id AND a.leafId=d.post_id AND c.node_id=d.post_id AND d.participant_id='".$_SESSION['userId']."' AND d.seen_status=0 AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.node_id=a.id AND c.bookmarked=1 AND c.user_id='".$_SESSION['userId']."' ORDER BY c.bookmark_date DESC";
			}
			else if ($post_type_id==7){
				$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=7 AND c.participant_id='".$user_id."' AND b.id=a.leafId AND (a.predecessor='0' or a.predecessor='') AND a.treeIds=".$treeId." AND a.workSpaceId='0' AND a.workSpaceType='0' AND b.leafStatus='publish' AND c.seen_status=0 ORDER BY b.editedDate DESC";
			}	
			else if ($post_type_id==8){
				//$query = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='0' and a.workSpaceType='0' ORDER BY b.editedDate DESC");
				$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.seen_status, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.participant_id='".$user_id."' AND b.id=a.leafId AND (a.predecessor='0' or a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.seen_status=1 ORDER BY b.editedDate DESC";
			}
			else if ($post_type_id==9) {
				if ($post_type_object_id>0){
					$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=9  AND c.participant_id='".$user_id."' AND c.post_type_object_id='".$post_type_object_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.seen_status=0 ORDER BY b.editedDate DESC";
				}
				else{
					$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.post_type_id=9  AND c.participant_id='".$user_id."' AND c.sender_id='".$user_id."' AND c.post_type_object_id='".$post_type_object_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.seen_status=0 ORDER BY b.editedDate DESC";
				}
				//echo "<pre>"; print_r($query2->result());exit;
			}	
			else if ($post_type_id==10){
				$q2 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus, c.post_type_id, c.post_type_object_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND b.userId='".$user_id."' AND c.participant_id='".$user_id."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='draft' AND c.seen_status=0 GROUP BY c.post_id";			
				$q2 .= " ORDER BY b.editedDate DESC";
			}	
				$query2 = $this->db->query($q2);
			//echo $q2; exit;
			//echo "<pre>"; print_r($query2->result());exit;
			//echo $post_object_id;exit;
			if($query2->num_rows()>0){
				$i=0;
				foreach($query2->result() as $row){		
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
					$treeData[$i]['leafStatus']  		= $row->leafStatus;
					$treeData[$i]['seen_status']  		= $row->seen_status;	
					$treeData[$i]['post_type_id']  		= $row->post_type_id;
					$treeData[$i]['post_type_object_id'] = $row->post_type_object_id;
					$treeData[$i]['interactions'] = $this->getLeafMeta($row->leafId,'interactions');
					//$treeData[$i]['disable_interactions'] = $arrLeafMeta['interactions'];
					$i++;											
				}
				return $treeData;	
			}	
		//}

		return $treeData;	

	}
	public function getUserActivePostsByUserId ($userId=0,$active_view='',$workSpaceId=0,$workSpaceType=1,$search='')
	{
		/*
		$id = array();
		$userActivePostsDetails = array();
		$q1 = "select least(participant_id, sender_id) as user_1, greatest(participant_id, sender_id) as user_2, max(id) as last_id, max(sent_timestamp) as last_timestamp from teeme_post_web_post_store WHERE 1 IN (participant_id,sender_id) AND post_type_id=1 group by least(participant_id, sender_id), greatest(participant_id, sender_id) ORDER BY last_timestamp DESC";
		$q2 = "SELECT `id`, `post_id`, `post_type_id`, `post_type_object_id`, `participant_id`, `sender_id`, `delivery_status_id`, `seen_status`, `sent_timestamp`, `data` FROM `teeme_post_web_post_store` 
		WHERE (post_type_id=2 AND participant_id=1) 
		OR (post_type_id=3 AND participant_id=1)  
		GROUP BY post_type_id,post_type_object_id
		ORDER BY sent_timestamp DESC";
		
		$query1 = $this->db->query($q1);
		$query2 = $this->db->query($q2);
		foreach($query1->result() as $row){
			$id[] = $row->last_id;
		}
		foreach($query2->result() as $row){
			$id[] = $row->id;
		}		
		$ids = implode(",",$id);
		$q3 = "SELECT id, post_id, post_type_id, post_type_object_id, sent_timestamp FROM teeme_post_web_post_store WHERE id IN ($ids)";
		$query3 = $this->db->query($q3);
		echo $q3;
		echo "<pre>"; print_r($query3->result()); exit;
		*/
		$arrPostIds = array();
		$this->load->model('dal/identity_db_manager');
		// This will give us unique participants of one-to-one chats
		/*
		$q1 = "select DISTINCT a.participant_id FROM teeme_post_web_post_store AS a, teeme_post_web_post_store AS b WHERE a.post_type_id=1 and a.post_id=b.post_id AND (a.participant_id=$userId OR b.participant_id=$userId)";
		$query1 = $this->db->query($q1);
			if ($query1->num_rows() > 1) {
				$arrParticipantIds = array();
				foreach($query1->result() as $row){
					if ($row->participant_id!=$userId){
						$arrParticipantIds[] = $row->participant_id;
					}					
				}				
				foreach($arrParticipantIds as $key=>$value){
					// This will give us the last post ids from chats between a users and it's participants
					$q2 = "select MAX(post_id) as post_id from teeme_post_web_post_store WHERE participant_id=$userId AND post_id IN (SELECT post_id FROM teeme_post_web_post_store WHERE post_type_id=1 AND participant_id=$value)";
					$query2 = $this->db->query($q2);
					if ($query2->num_rows() > 0) {	
						foreach($query2->result() as $row){
							$arrPostIds[] = $row->post_id;											
						}	
					}
				}

			}
			// This will give unique space ids
			$q3 = "SELECT DISTINCT post_type_object_id FROM `teeme_post_web_post_store` WHERE participant_id=$userId AND post_type_id=2 ORDER by sent_timestamp DESC";
			$query3 = $this->db->query($q3);
				if ($query3->num_rows() > 0) {
					$arrSpaceIds = array();
					foreach($query3->result() as $row){
							$arrSpaceIds[] = $row->post_type_object_id;										
					}	
					foreach($arrSpaceIds as $key=>$value){
						// This will give us the last post ids from chats between a users and it's participants
						$q4 = "select MAX(post_id) as post_id from teeme_post_web_post_store WHERE participant_id=$userId AND post_id IN (SELECT post_id FROM teeme_post_web_post_store WHERE post_type_id=2 AND post_type_object_id=$value)";
						$query4 = $this->db->query($q4);
						if ($query4->num_rows() > 0) {	
							foreach($query4->result() as $row){
								$arrPostIds[] = $row->post_id;											
							}	
						}
					}				
				}

			// This will give unique subspace ids
			$q5 = "SELECT DISTINCT post_type_object_id FROM `teeme_post_web_post_store` WHERE participant_id=$userId AND post_type_id=3 ORDER by sent_timestamp DESC";
			$query5 = $this->db->query($q5);
				if ($query5->num_rows() > 0) {
					$arrSubSpaceIds = array();
					foreach($query5->result() as $row){
							$arrSubSpaceIds[] = $row->post_type_object_id;										
					}	
					foreach($arrSubSpaceIds as $key=>$value){
						// This will give us the last post ids from chats between a users and it's participants
						$q6 = "select MAX(post_id) as post_id from teeme_post_web_post_store WHERE participant_id=$userId AND post_id IN (SELECT post_id FROM teeme_post_web_post_store WHERE post_type_id=3 AND post_type_object_id=$value)";
						$query6 = $this->db->query($q6);
						if ($query6->num_rows() > 0) {	
							foreach($query6->result() as $row){
								$arrPostIds[] = $row->post_id;											
							}	
						}
					}				
				}
			*/
			
			if($workSpaceType==1 && $active_view=='space'){
				//$q = "SELECT post_id FROM teeme_post_web_post_store WHERE participant_id='".$userId."' AND seen_status=0 AND post_type_id=2 AND post_type_object_id=$workSpaceId ORDER BY post_id DESC";
				$q = 'SELECT DISTINCT b.id as post_id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE (c.post_id=a.id OR c.post_id=a.predecessor) AND c.participant_id='.$userId.' AND (b.id=a.leafId OR b.id=a.predecessor) AND a.treeIds=0 AND c.seen_status=0 AND c.post_type_id=2 AND c.post_type_object_id='.$workSpaceId.' AND c.post_type_object_id=a.workSpaceId AND b.leafStatus=\'publish\'';
				if ($search!=''){
					$q .= ' AND b.contents LIKE (\'<p>'.$search.'%\')';
				}
				$q .= ' ORDER BY b.editedDate DESC';
			}
			else{
				//$q = "SELECT post_id FROM teeme_post_web_post_store WHERE participant_id='".$userId."' AND seen_status=0 ORDER BY post_id DESC";
				
				$q = 'SELECT DISTINCT a.post_id FROM teeme_post_web_post_store a, teeme_leaf b WHERE a.participant_id='.$userId.' AND a.seen_status=0 AND a.post_id=b.id AND b.leafStatus=\'publish\'';
				if ($search!=''){
					$q .= ' AND b.contents LIKE (\'<p>'.$search.'%\')';
				}
				$q .= ' ORDER BY a.post_id DESC';
				
			}

			$query = $this->db->query($q);
			//echo $q; exit;

			if ($query->num_rows() > 0) {	
				foreach($query->result() as $row){
					$arrPostIds[] = $row->post_id;											
				}	
			}
			
			//arsort($arrPostIds);
			$userActivePostsDetails = array();
			$i=0;
			//echo "<pre>count= ". count($arrPostIds); exit;
			//echo "<pre>"; print_r($arrPostIds); exit;
			if (count($arrPostIds)>0){
				foreach($arrPostIds as $key=>$value){
					//$post_ids = implode(',', $arrPostIds);
					if($workSpaceType==1 && $active_view=='space'){
						$q7 = "SELECT * FROM teeme_post_web_post_store WHERE participant_id=$userId AND seen_status=0 AND post_type_id=2 AND post_type_object_id=$workSpaceId AND post_id=$value";
						//$q7 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus,c.* FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE (c.post_id=a.id OR c.post_id=a.predecessor) AND c.participant_id='".$userId."' AND (b.id=a.leafId OR b.id=a.predecessor) AND a.treeIds=0 AND c.seen_status=0 AND c.post_type_id=2 AND c.post_type_object_id=$workSpaceId AND c.post_type_object_id=a.workSpaceId ORDER BY b.editedDate DESC";

					}else{
						$q7 = "SELECT * FROM teeme_post_web_post_store WHERE participant_id=$userId AND seen_status=0 AND post_id=$value";
						//$q7 = "SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate, b.leafStatus,c.* FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE (c.post_id=a.id OR c.post_id=a.predecessor) AND c.participant_id='".$userId."' AND (b.id=a.leafId OR b.id=a.predecessor) AND a.treeIds=0 AND c.seen_status=0 ORDER BY c.post_id DESC";
					}
					
					$query7 = $this->db->query($q7);	
					//echo "<li>".$q7;
					//echo "<pre>"; print_r($query7->result()); exit;
		
					if($query7->num_rows()){					
						foreach($query7->result() as $row){
							//$userActivePostsDetails[] = $row;
							//if ($row->post_type_id==1 || $row->post_type_id==5){
								
								/*
								if($row->sender_id!=$row->participant_id){
									$userActivePostsDetails[$i]['sender_id']=$row->sender_id;
								}
								else if($row->post_type_object_id!=$row->participant_id){
									$userActivePostsDetails[$i]['sender_id']=$row->post_type_object_id;
								}
								else if($row->post_type_object_id==$row->participant_id && $row->sender_id==$row->participant_id && $row->sender_id==$row->post_type_object_id){
									$userActivePostsDetails[$i]['sender_id']=$row->post_type_object_id;
								}
								*/
								//$userActivePostsDetails[$i]['unseen_post_count']=$this->getUnseenPostCount($userId,$userActivePostsDetails[$i]['post_type_id'],$userActivePostsDetails[$i]['sender_id']);
								if ($row->post_type_id==1 || $row->post_type_id==5){
									$userActivePostsDetails[$i]['post_type_id']=$row->post_type_id;
									$userActivePostsDetails[$i]['sender_id']=$row->sender_id;
									$userDetails = $this->identity_db_manager->getUserDetailsByUserId($userActivePostsDetails[$i]['sender_id']);
									$userActivePostsDetails[$i]['sender_user_id']=$userActivePostsDetails[$i]['sender_id'];
									$userActivePostsDetails[$i]['sender_name']= $userDetails['userTagName'];
									$userActivePostsDetails[$i]['photo']= $userDetails['photo'];
									$userActivePostsDetails[$i]['last_post_id']=$row->post_id;
									$lastPostData = $this->identity_db_manager->formatContent($this->identity_db_manager->getLeafContentsByNodeId($userActivePostsDetails[$i]['last_post_id']),45,1);
									$userActivePostsDetails[$i]['last_post_data']=$lastPostData;
									$userActivePostsDetails[$i]['last_post_timestamp']=$row->sent_timestamp;
									$userActivePostsDetails[$i]['seen_status']=$row->seen_status;
									$nodeDetails = $this->identity_db_manager->getNodeworkSpaceDetails($row->post_id);
									//echo "<pre>"; print_r($nodeDetails);exit;
										if ($nodeDetails['workSpaceType']==1){
											if($nodeDetails['workSpaceId']>0){
												$spaceDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($nodeDetails['workSpaceId']);
												$userActivePostsDetails[$i]['space_name']= $spaceDetails['workSpaceName'];
											}
											else{
												$userActivePostsDetails[$i]['space_name']="My Space";
											}
										}elseif ($nodeDetails['workSpaceType']==2){
											if($nodeDetails['workSpaceId']>0){
												$subSpaceDetails = $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($nodeDetails['workSpaceId']);
												$userActivePostsDetails[$i]['space_name']= $subSpaceDetails['subWorkSpaceName'];
											}
											else{
												$userActivePostsDetails[$i]['space_name']="My Space";
											}
										}
									$postChangeDetails = $this->get_post_change_details($userActivePostsDetails[$i]['last_post_id']);
										if($postChangeDetails['change_type']==2){
											$userActivePostsDetails[$i]['change_detail'] = 'New comment';
										}else if($postChangeDetails['change_type']==3){
											$userActivePostsDetails[$i]['change_detail'] = 'New tag';
										}else if($postChangeDetails['change_type']==4){
											$userActivePostsDetails[$i]['change_detail'] = 'New link';
										}else{
											$userActivePostsDetails[$i]['change_detail'] = 'New post';
										}
									//$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/one/'.$row->post_type_object_id.'#form'.$userActivePostsDetails[$i]['last_post_id'];
									$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/home#form'.$userActivePostsDetails[$i]['last_post_id'];
								}
								if ($row->post_type_id==2){
									$userActivePostsDetails[$i]['post_type_id']=$row->post_type_id;
									$userActivePostsDetails[$i]['sender_id']=$row->sender_id;
									$userDetails = $this->identity_db_manager->getUserDetailsByUserId($userActivePostsDetails[$i]['sender_id']);
									$userActivePostsDetails[$i]['sender_user_id']=$userActivePostsDetails[$i]['sender_id'];
									$userActivePostsDetails[$i]['sender_name']= $userDetails['userTagName'];
									$userActivePostsDetails[$i]['photo']= $userDetails['photo'];
									$userActivePostsDetails[$i]['last_post_id']=$row->post_id;
									$lastPostData = $this->identity_db_manager->formatContent($this->identity_db_manager->getLeafContentsByNodeId($userActivePostsDetails[$i]['last_post_id']),45,1);
									//$lastPostData = $this->identity_db_manager->formatContent($row->contents,45,1);
									$userActivePostsDetails[$i]['last_post_data']=$lastPostData;
									$userActivePostsDetails[$i]['last_post_timestamp']=$row->sent_timestamp;
									$userActivePostsDetails[$i]['seen_status']=$row->seen_status;
										if($row->post_type_object_id>0){
											$spaceDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($row->post_type_object_id);
											$userActivePostsDetails[$i]['space_name']= $spaceDetails['workSpaceName'];
										}
										else{
											$userActivePostsDetails[$i]['space_name']="My Space";
										}
									$postChangeDetails = $this->get_post_change_details($userActivePostsDetails[$i]['last_post_id']);
										if($postChangeDetails['change_type']==2){
											$userActivePostsDetails[$i]['change_detail'] = 'New comment';
										}else if($postChangeDetails['change_type']==3){
											$userActivePostsDetails[$i]['change_detail'] = 'New tag';
										}else if($postChangeDetails['change_type']==4){
											$userActivePostsDetails[$i]['change_detail'] = 'New link';
										}else{
											$userActivePostsDetails[$i]['change_detail'] = 'New post';
										}
									//$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/space/'.$row->post_type_object_id.'#form'.$userActivePostsDetails[$i]['last_post_id'];
									$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/home#form'.$userActivePostsDetails[$i]['last_post_id'];
								}
								if ($row->post_type_id==3){
									$userActivePostsDetails[$i]['post_type_id']=$row->post_type_id;
									$userActivePostsDetails[$i]['sender_id']=$row->sender_id;
									$userDetails = $this->identity_db_manager->getUserDetailsByUserId($userActivePostsDetails[$i]['sender_id']);
									$userActivePostsDetails[$i]['sender_user_id']=$userActivePostsDetails[$i]['sender_id'];
									$userActivePostsDetails[$i]['sender_name']= $userDetails['userTagName'];
									$userActivePostsDetails[$i]['photo']= $userDetails['photo'];
									$userActivePostsDetails[$i]['last_post_id']=$row->post_id;
									$lastPostData = $this->identity_db_manager->formatContent($this->identity_db_manager->getLeafContentsByNodeId($userActivePostsDetails[$i]['last_post_id']),45,1);
									$userActivePostsDetails[$i]['last_post_data']=$lastPostData;
									$userActivePostsDetails[$i]['last_post_timestamp']=$row->sent_timestamp;
									$userActivePostsDetails[$i]['seen_status']=$row->seen_status;
									$subSpaceDetails = $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($row->post_type_object_id);
									$userActivePostsDetails[$i]['space_name']= $subSpaceDetails['subWorkSpaceName'];
									$postChangeDetails = $this->get_post_change_details($userActivePostsDetails[$i]['last_post_id']);
										if($postChangeDetails['change_type']==2){
											$userActivePostsDetails[$i]['change_detail'] = 'New comment';
										}else if($postChangeDetails['change_type']==3){
											$userActivePostsDetails[$i]['change_detail'] = 'New tag';
										}else if($postChangeDetails['change_type']==4){
											$userActivePostsDetails[$i]['change_detail'] = 'New link';
										}else{
											$userActivePostsDetails[$i]['change_detail'] = 'New post';
										}
										//$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/subspace/'.$row->post_type_object_id.'#form'.$userActivePostsDetails[$i]['last_post_id'];
										$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/home#form'.$userActivePostsDetails[$i]['last_post_id'];

								}
								if ($row->post_type_id==7){
									$userActivePostsDetails[$i]['post_type_id']=$row->post_type_id;
									$userActivePostsDetails[$i]['sender_id']=$row->sender_id;
									$userDetails = $this->identity_db_manager->getUserDetailsByUserId($userActivePostsDetails[$i]['sender_id']);
									$userActivePostsDetails[$i]['sender_user_id']=$userActivePostsDetails[$i]['sender_id'];
									$userActivePostsDetails[$i]['sender_name']= $userDetails['userTagName'];
									$userActivePostsDetails[$i]['photo']= $userDetails['photo'];
									$userActivePostsDetails[$i]['last_post_id']=$row->post_id;
									$lastPostData = $this->identity_db_manager->formatContent($this->identity_db_manager->getLeafContentsByNodeId($userActivePostsDetails[$i]['last_post_id']),45,1);
									$userActivePostsDetails[$i]['last_post_data']=$lastPostData;
									$userActivePostsDetails[$i]['last_post_timestamp']=$row->sent_timestamp;
									$userActivePostsDetails[$i]['seen_status']=$row->seen_status;
									$userActivePostsDetails[$i]['space_name']="Public";
									$postChangeDetails = $this->get_post_change_details($userActivePostsDetails[$i]['last_post_id']);
										if($postChangeDetails['change_type']==2){
											$userActivePostsDetails[$i]['change_detail'] = 'New comment';
										}else if($postChangeDetails['change_type']==3){
											$userActivePostsDetails[$i]['change_detail'] = 'New tag';
										}else if($postChangeDetails['change_type']==4){
											$userActivePostsDetails[$i]['change_detail'] = 'New link';
										}else{
											$userActivePostsDetails[$i]['change_detail'] = 'New post';
										}
									//$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/public/'.$row->post_type_object_id.'#form'.$userActivePostsDetails[$i]['last_post_id'];
									$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/home#form'.$userActivePostsDetails[$i]['last_post_id'];
								}
								if($row->post_type_id==9){
									$objectFollowStatus=$this->identity_db_manager->get_follow_status($row->participant_id,$row->post_type_object_id,'',10);
									if($objectFollowStatus['preference'] || $this->identity_db_manager->isWorkSpaceMember($row->post_type_object_id,$row->participant_id)){
										$userActivePostsDetails[$i]['post_type_id']=$row->post_type_id;
										$userActivePostsDetails[$i]['sender_id']=$row->sender_id;
										$userDetails = $this->identity_db_manager->getUserDetailsByUserId($userActivePostsDetails[$i]['sender_id']);
										$userActivePostsDetails[$i]['sender_user_id']=$userActivePostsDetails[$i]['sender_id'];
										$userActivePostsDetails[$i]['sender_name']= $userDetails['userTagName'];
										$userActivePostsDetails[$i]['photo']= $userDetails['photo'];
										$userActivePostsDetails[$i]['last_post_id']=$row->post_id;
										$lastPostData = $this->identity_db_manager->formatContent($this->identity_db_manager->getLeafContentsByNodeId($userActivePostsDetails[$i]['last_post_id']),45,1);
										$userActivePostsDetails[$i]['last_post_data']=$lastPostData;
										$userActivePostsDetails[$i]['last_post_timestamp']=$row->sent_timestamp;
										$userActivePostsDetails[$i]['seen_status']=$row->seen_status;
										$spaceDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($row->post_type_object_id);
										$userActivePostsDetails[$i]['space_name']= $spaceDetails['workSpaceName'];
										$postChangeDetails = $this->get_post_change_details($userActivePostsDetails[$i]['last_post_id']);
											if($postChangeDetails['change_type']==2){
												$userActivePostsDetails[$i]['change_detail'] = 'New comment';
											}else if($postChangeDetails['change_type']==3){
												$userActivePostsDetails[$i]['change_detail'] = 'New tag';
											}else if($postChangeDetails['change_type']==4){
												$userActivePostsDetails[$i]['change_detail'] = 'New link';
											}else{
												$userActivePostsDetails[$i]['change_detail'] = 'New post';
											}
										//$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/space_ex/'.$row->post_type_object_id.'#form'.$userActivePostsDetails[$i]['last_post_id'];
										$userActivePostsDetails[$i]['url'] = 'post/web/'.$workSpaceId.'/'.$workSpaceType.'/home#form'.$userActivePostsDetails[$i]['last_post_id'];
									}
								}
							//}
							/*
							if ($row->post_type_id==2){
								$userActivePostsDetails[$i]['post_type_id']=$row->post_type_id;
								$userActivePostsDetails[$i]['sender_id']=$row->post_type_object_id;
								//$userActivePostsDetails[$i]['sender_id']=$row->sender_id;
								$spaceDetails = $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($userActivePostsDetails[$i]['sender_id']);
								$userActivePostsDetails[$i]['sender_name']=$spaceDetails['workSpaceName'];
								$userActivePostsDetails[$i]['sender_user_id']=$row->sender_id;
								$userDetails = $this->identity_db_manager->getUserDetailsByUserId($userActivePostsDetails[$i]['sender_user_id']);
								$userActivePostsDetails[$i]['photo']= 'noimage.jpg';
								$userActivePostsDetails[$i]['last_post_id']=$row->post_id;
								$lastPostData = $this->identity_db_manager->formatContent($userDetails['userTagName'].': '.$this->identity_db_manager->getLeafContentsByNodeId($userActivePostsDetails[$i]['last_post_id']),35,1);
								$userActivePostsDetails[$i]['last_post_data']=$lastPostData;
								$userActivePostsDetails[$i]['last_post_timestamp']=$row->sent_timestamp;
								$userActivePostsDetails[$i]['seen_status']=$row->seen_status;
								//$userActivePostsDetails[$i]['unseen_post_count']=$this->getUnseenPostCount($userId,$userActivePostsDetails[$i]['post_type_id'],$userActivePostsDetails[$i]['sender_id']);
							}
							if ($row->post_type_id==3){
								$userActivePostsDetails[$i]['post_type_id']=$row->post_type_id;
								$userActivePostsDetails[$i]['sender_id']=$row->post_type_object_id;
								//$userActivePostsDetails[$i]['sender_id']=$row->sender_id;
								$subSpaceDetails = $this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($userActivePostsDetails[$i]['sender_id']);
								$userActivePostsDetails[$i]['sender_name']=$subSpaceDetails['subWorkSpaceName'];
								$userActivePostsDetails[$i]['sender_user_id']=$row->sender_id;
								$userDetails = $this->identity_db_manager->getUserDetailsByUserId($userActivePostsDetails[$i]['sender_user_id']);
								$userActivePostsDetails[$i]['photo']= 'noimage.jpg';
								$userActivePostsDetails[$i]['last_post_id']=$row->post_id;
								$lastPostData = $this->identity_db_manager->formatContent($userDetails['userTagName'].': '.$this->identity_db_manager->getLeafContentsByNodeId($userActivePostsDetails[$i]['last_post_id']),35,1);
								$userActivePostsDetails[$i]['last_post_data']=$lastPostData;
								$userActivePostsDetails[$i]['last_post_timestamp']=$row->sent_timestamp;
								$userActivePostsDetails[$i]['seen_status']=$row->seen_status;
								//$userActivePostsDetails[$i]['unseen_post_count']=$this->getUnseenPostCount($userId,$userActivePostsDetails[$i]['post_type_id'],$userActivePostsDetails[$i]['sender_id']);
							}	
							*/
							$i++;										
						}
						
					}					
				}
			}
			//echo "<li>count= " .count($userActivePostsDetails);
			//echo "<pre>"; print_r($userActivePostsDetails);exit;
			//echo "<pre>"; print_r($arrPostIds);print_r($query7->result());exit;

			return $userActivePostsDetails;	

	}

	public function getUnseenPostCount ($user_id=0, $post_type_id=0,$post_type_object_id=0){
		$row_count=0;
		if($post_type_id==1){
			$q = "SELECT COUNT(a.id) as row_count FROM `teeme_post_web_post_store` AS a, teeme_post_web_post_store AS b WHERE a.post_type_id=1 AND a.participant_id=$user_id AND a.seen_status=0 AND a.post_id=b.post_id AND b.participant_id=$post_type_object_id";
			$query = $this->db->query($q);
			foreach($query->result() as $row){		
				$row_count = $row->row_count;													
			}	
		}
		if($post_type_id==2 || $post_type_id==3){
			$q = "SELECT COUNT(a.id) as row_count FROM `teeme_post_web_post_store` AS a WHERE a.participant_id=$user_id AND a.post_type_id=$post_type_id AND a.post_type_object_id=$post_type_object_id AND a.seen_status=0";
			$query = $this->db->query($q);
			foreach($query->result() as $row){		
				$row_count = $row->row_count;													
			}	
		}
		return $row_count;
	}

	public function updateUnseenCount($user_id=0, $post_type_id=0,$post_type_object_id=0,$seen_status_new=1){
		$seen_status_new = $seen_status_new;
		if ($seen_status_new==1){$seen_status_old=0;} else{$seen_status_old=1;}
		if($post_type_id==1){
			//$q = "SELECT COUNT(a.id) as row_count FROM `teeme_post_web_post_store` AS a, teeme_post_web_post_store AS b WHERE a.post_type_id=1 AND a.participant_id=$user_id AND a.seen_status=0 AND a.post_id=b.post_id AND b.participant_id=$post_type_object_id";
			$q = "UPDATE teeme_post_web_post_store SET seen_status=$seen_status_new WHERE post_type_id=1 AND participant_id=$user_id AND seen_status=$seen_status_old AND (sender_id=$post_type_object_id OR post_type_object_id=$post_type_object_id)";
			$query = $this->db->query($q);
			/*
			foreach($query->result() as $row){		
				$row_count = $row->row_count;													
			}
			*/	
		}
		if($post_type_id==2 || $post_type_id==3){
			//$q = "SELECT COUNT(a.id) as row_count FROM `teeme_post_web_post_store` AS a WHERE a.participant_id=$user_id AND a.post_type_id=$post_type_id AND a.post_type_object_id=$post_type_object_id AND a.seen_status=0";
			$q = "UPDATE teeme_post_web_post_store SET seen_status=$seen_status_new WHERE post_type_id=$post_type_id AND participant_id=$user_id AND seen_status=$seen_status_old AND post_type_object_id=$post_type_object_id";
			$query = $this->db->query($q);
			//echo "<li>".$q; echo "<li>" .$query->num_rows(); echo "<li>" .$query->result(); exit;
			/*
			foreach($query->result() as $row){		
				$row_count = $row->row_count;													
			}
			*/	
		}		
	}

	public function updatePostSeenStatus($post_id=0, $user_id=0, $seen_status=1){
		$seen_status_new = $seen_status;
			if ($seen_status_new==1){$seen_status_old=0;} else{$seen_status_old=1;}
		$q = "UPDATE teeme_post_web_post_store SET seen_status=$seen_status_new WHERE post_id=$post_id AND participant_id=$user_id AND seen_status=$seen_status_old";
		$query = $this->db->query($q);	
		return $q;
			if($query->result()){
				return 1;
			}
			else{
				return 0;
			}
	}

	public function getPostCountTimeline($workSpaceId, $workSpaceType, $treeId=0, $postType='')
	{
		//$mergePostArray=array();
		//echo $postType; exit;
		if($postType=='my'){
			$post_type_id=1;
		}
		elseif ($postType=='space' && $workSpaceType==1){
			$post_type_id=2;
		}elseif ($postType=='space' && $workSpaceType==2){
			$post_type_id=3;
		}elseif ($postType=='bookmark'){
			$post_type_id=6;
		}elseif ($postType=='public'){
			$post_type_id=7;
		}elseif ($postType=='parked'){
			$post_type_id=8;
		}elseif ($postType=='draft'){
			$post_type_id=10;
		}

		if($workSpaceId >= 0)
		{
		
			//Fetch space post count			
			//$result_count1 = $this->db->query("SELECT a.id FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='".$workSpaceId."' and a.workSpaceType='".$workSpaceType."' ORDER BY b.editedDate DESC");
				if($postType=='my'){
					$q = "SELECT a.id FROM `teeme_post_web_post_store` AS a WHERE a.post_type_id=$post_type_id AND a.participant_id='".$_SESSION['userId']."' AND a.sender_id='".$_SESSION['userId']."' AND a.seen_status=0 GROUP BY a.post_id";
					$result_count1 = $this->db->query($q);
					//echo "<pre>result= "; print_r($q); exit;
				}	
				elseif($postType=='space'){
					if($workSpaceId == 0){
						//$q = "SELECT a.id FROM `teeme_post_web_post_store` AS a WHERE a.sender_id='".$_SESSION['userId']."' AND a.post_type_object_id=0 AND a.participant_id='".$_SESSION['userId']."' AND a.seen_status=0 GROUP BY a.post_id";
						$q = "SELECT a.id FROM `teeme_post_web_post_store` AS a WHERE a.post_type_object_id=0 AND a.participant_id='".$_SESSION['userId']."' AND a.seen_status=0 GROUP BY a.post_id";
					}else{
						$q = "SELECT a.id FROM `teeme_post_web_post_store` AS a WHERE a.post_type_id=$post_type_id AND a.post_type_object_id=$workSpaceId AND a.participant_id='".$_SESSION['userId']."' AND a.seen_status=0 GROUP BY a.post_id";
					}
					$result_count1 = $this->db->query($q);
					//echo "<pre>result= "; print_r($result_count1->result()); exit;
				}elseif($postType=='all')
				{
					//$result_count1 = $this->db->query("SELECT a.workSpaceId as workSpaceId, a.workSpaceType as workSpaceType, a.id, a.successors, a.predecessor, a.nodeOrder, b.id as leafId, b.authors, b.userId, b.contents, DATE_FORMAT(b.createdDate, '%Y-%m-%d %H:%i:%s') as TimelineCreatedDate FROM teeme_node a, teeme_leaf b, teeme_posts_shared r WHERE r.postId =a.id and b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." ORDER BY b.editedDate DESC");
					$arrPostIds = array();
					$this->load->model('dal/identity_db_manager');
					$q = "SELECT post_id,post_type_id,post_type_object_id FROM teeme_post_web_post_store WHERE participant_id='".$_SESSION['userId']."' AND seen_status=0";
					$query = $this->db->query($q);
						foreach($query->result() as $row){		
							if($row->post_type_id==9){
								$objectFollowStatus==$this->identity_db_manager->get_follow_status($_SESSION['userId'],$row->post_type_object_id,'',10);
								if($objectFollowStatus['preference'] || $this->identity_db_manager->isWorkSpaceMember($row->post_type_object_id,$_SESSION['userId'])){
									$arrPostIds[]=$row->post_id;
								}
							}else{
								$arrPostIds[]=$row->post_id;
							}
						}
					//$q = "SELECT a.id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.participant_id='".$_SESSION['userId']."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND c.seen_status=0";
					$q2 = "SELECT DISTINCT a.id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND c.participant_id='".$_SESSION['userId']."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='publish' AND c.seen_status=0";							
					if(count($arrPostIds)>0){
						$postIds = implode(",",$arrPostIds);
						$q2 .= " AND c.post_id IN ($postIds)";
					}
					$result_count1 = $this->db->query($q2);
				}elseif($postType=='bookmark')
				{
					$q = "SELECT a.id as row_count FROM teeme_node a, teeme_leaf b, teeme_bookmark c, teeme_post_web_post_store d WHERE b.id=a.leafId AND b.id=d.post_id AND a.leafId=d.post_id AND c.node_id=d.post_id AND d.participant_id='".$_SESSION['userId']."' AND d.seen_status=0 AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND c.node_id=a.id AND c.bookmarked=1 AND c.user_id='".$_SESSION['userId']."' AND b.leafStatus='publish' ORDER BY c.bookmark_date DESC";
					$result_count1 = $this->db->query($q);
				}elseif($postType=='public'){
					//$result_count1 = $this->db->query("SELECT a.id FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId AND (a.predecessor='0' or a.predecessor='') AND a.treeIds=".$treeId." AND a.workSpaceId='0' AND a.workSpaceType='0' ORDER BY b.editedDate DESC");
					//echo "<pre>result1= "; print_r($result_count1->result()); exit;
					$q = "SELECT a.id FROM `teeme_post_web_post_store` AS a WHERE a.post_type_id=$post_type_id AND a.participant_id='".$_SESSION['userId']."' AND a.seen_status=0 GROUP BY a.post_id";
					$result_count1 = $this->db->query($q);
				}elseif($postType=='parked'){
					$q = "SELECT a.id FROM `teeme_post_web_post_store` AS a WHERE a.participant_id='".$_SESSION['userId']."' AND a.seen_status=1 GROUP BY a.post_id";
					$result_count1 = $this->db->query($q);
				}elseif($postType=='draft'){
					$q2 = "SELECT DISTINCT a.id FROM teeme_node a, teeme_leaf b, teeme_post_web_post_store c WHERE c.post_id=a.id AND b.userId='".$_SESSION['userId']."' AND c.participant_id='".$_SESSION['userId']."' AND b.id=a.leafId AND (a.predecessor='0' OR a.predecessor='') AND a.treeIds=".$treeId." AND b.leafStatus='draft' AND c.seen_status=0";							
					$result_count1 = $this->db->query($q2);
				}



			//Fetch public post count			
			//$result_count2 = $this->db->query("SELECT COUNT(a.id) as total FROM teeme_node a, teeme_leaf b WHERE b.id=a.leafId and (a.predecessor='0' or a.predecessor='') and a.treeIds=".$treeId." and a.workSpaceId='0' and a.workSpaceType='0' ORDER BY b.editedDate DESC");
			/*
			if($result_count1){
				$mergePostArray=array_merge($result_count1->result(),$result_count2->result());
			}
			*/
			//echo "<li>query= " .$q;
			//echo "<pre>result= "; print_r($result_count1->result()); exit;
			
			//return $mergePostArray;
					/*
					if($postType=='')
					{
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
					*/
					//else if($postType=='space' || $postType=='all')
					if($postType!='')
					{
						if($result_count1)
						{
							if($result_count1->num_rows() > 0)
							{	
								/*
								$total=0;
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
								*/
								return $result_count1->num_rows();	
							}					
						}
						else
						{
							return false;
						}
					}
					/*
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
					*/
		}			
		return 0;				
	}

	public function getPostParticipants($post_id=0){
		$arrMemberParticipantIds = array();
		$arrSpaceParticipantIds = array();
		$arrParticipantIds = array();
		$q = "SELECT * FROM teeme_post_web_post_store WHERE post_id='".$post_id."'";
		$query = $this->db->query($q);
			foreach($query->result() as $row){	
				if($row->post_type_id==2 && $row->post_type_object_id==0 && $row->post_type_id!=7){
					$arrMemberParticipantIds[] = $row->participant_id;
				}
				elseif($row->post_type_id==2 && $row->post_type_object_id>0 && $row->post_type_id!=7){
					$arrSpaceParticipantIds[] = $row->post_type_object_id;
				}
			}	
		$arrParticipantIds['memberCount'] = count(array_unique($arrMemberParticipantIds));
		$arrParticipantIds['spaceCount'] = count(array_unique($arrSpaceParticipantIds));
		$arrParticipantIds['members'] = array_values(array_unique($arrMemberParticipantIds));
		$arrParticipantIds['spaces'] = array_values(array_unique($arrSpaceParticipantIds));
		return $arrParticipantIds;
	}

	public function deleteDraft($post_id=0){
		$this->db->trans_begin();
		$q = "UPDATE teeme_leaf SET leafStatus='deleted' WHERE nodeId='".$post_id."'";
		$query = $this->db->query($q);		

		$q2 = "DELETE FROM teeme_post_web_post_store WHERE post_id='".$post_id."'";
		$query = $this->db->query($q2);	

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

	public function getLeafMeta($leaf_id=0,$meta_key='',$meta_value=''){
		//$arrLeafMeta = array();
		$q = "SELECT * FROM teeme_leaf_meta WHERE leaf_id='".$leaf_id."'";
			if ($meta_key!=''){
				$q .= " AND meta_key='".$meta_key."'";
			}
			if ($meta_value!=''){
				$q .= " AND meta_key='".$meta_value."'";
			}
		$query = $this->db->query($q);
		//echo $q; exit;
		foreach($query->result() as $row)
		{
			$leafMetaValue = $row->meta_value;
		}	
		if ($leafMetaValue!=''){
			return $leafMetaValue;
		}
		else{
			return 0;
		}
		
	}
}