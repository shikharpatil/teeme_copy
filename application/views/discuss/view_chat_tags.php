<?php

$tagId = $this->uri->segment(8);//tag type id
$treeId = $this->uri->segment(3);
$tagType = $this->uri->segment(9);
$usr = $this->uri->segment(10);

if(!$tagType && !$usr)unset($_SESSION['tagLeaves']);


if(isset($_GET['rem']) && $_GET['rem']==1){
	if($tagType==2){//simple tag
		unset($_SESSION['tagLeaves'][1][$tagId]);
		if(empty($_SESSION['tagLeaves'][1])){
			unset($_SESSION['tagLeaves'][1]);
		}
	}
	elseif($tagType==3){//action tag
		unset($_SESSION['tagLeaves'][2][$tagId]);
		if(empty($_SESSION['tagLeaves'][2])){
			unset($_SESSION['tagLeaves'][2]);
		}
	}
	else{
		unset($_SESSION['tagLeaves'][3][$tagId]);
		if(empty($_SESSION['tagLeaves'][3])){
			unset($_SESSION['tagLeaves'][3]);
		}
	}
}

else if((!isset($_GET['rem']) || $_GET['rem']!=1) && $tagId){
	if($tagType==2){//simple tag
		$_SESSION['tagLeaves'][1][$tagId]=$tagId;
	}
	elseif($tagType==3){//action tag
		$_SESSION['tagLeaves'][2][$tagId]=$tagId;
	}
	else{
		$_SESSION['tagLeaves'][3][$tagId] = $tagId;
	}

}
if(empty($_SESSION['usrLeaves']) || $usr==''){
	unset($_SESSION['usrLeaves']);
}
if($usr!=0 && !$_GET['remUsr']){
	//comment this line for multiple user select 
	unset($_SESSION['usrLeaves']);
	$_SESSION['usrLeaves'][$usr]=$usr;
}

if(isset($_GET['remUsr']) && $_GET['remUsr']!=0){
	unset($_SESSION['usrLeaves'][$usr]);
}

if(!empty($_SESSION['tagLeaves']))
{
	$attachedTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($treeId, 1);

	$details=$this->chat_db_manager->getPerentInfo($treeId);
	if(!empty($attachedTags) && (in_array($arrDiscussionDetails['userId'],$_SESSION['usrLeaves']) || !$_SESSION['usrLeaves'])){

		$arrTag=array();
		$flag=1;//for checking nonexistent tag in node
		foreach($attachedTags['simple'] as $val){
			$arrTag[]=$val['tag'];
		}
		$a = array_diff($_SESSION['tagLeaves'][1],$arrTag);
		if(empty($a)){
			$flag=0;	
		}
		
		if($flag==0){
			$arrTag=array();
			foreach($attachedTags['response'] as $val){
				$arrTag[]=$val['tagId'];
			}
			$a = array_diff($_SESSION['tagLeaves'][2],$arrTag);
			if(empty($a)){
				$flag=0;	
			}
			else{
				$flag=1;
			}
		}
		
		if($flag==0){
			$arrTag=array();
			foreach($attachedTags['contact'] as $val){
				$arrTag[]=$val['tag'];
			}
			$a = array_diff($_SESSION['tagLeaves'][3],$arrTag);
			if(empty($a)){
				$flag=0;	
			}
			else{
				$flag=1;
			}
		}
		
		
		if($flag==0){?>

<div class="seedBgColor" style="margin:3px;">
  <?php
  			/*$this->identity_db_manager->formatContent($arrDiscussionDetails['name'],1000,1)*/
			echo '<a href='.base_url().'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrDiscussionDetails['name'],0,1000)).'</a>';?>
</div>
<?php
		}
	}
	
	if(count($arrDiscussions) > 0)
	{
		$i=1;
		/*Start tags filter*/
	
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{
			
			$attachedTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($arrVal['nodeId'], 2);
			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			$arrTag=array();
	
			if(!empty($attachedTags) && (in_array($arrVal['userId'],$_SESSION['usrLeaves']) || !$_SESSION['usrLeaves'])){
				$arrTag=array();
				$flag=1;//for checking nonexistent tag in node
				foreach($attachedTags['simple'] as $val){
					$arrTag[]=$val['tag'];
				}
				$a = array_diff($_SESSION['tagLeaves'][1],$arrTag);
				if(empty($a)){
					$flag=0;	
				}
				
				if($flag==0){
					$arrTag=array();
					foreach($attachedTags['response'] as $val){
						$arrTag[]=$val['tagId'];
					}
					$a = array_diff($_SESSION['tagLeaves'][2],$arrTag);
					if(empty($a)){
						$flag=0;	
					}
					else{
						$flag=1;
					}
				}
				
				if($flag==0){
					$arrTag=array();
					foreach($attachedTags['contact'] as $val){
						$arrTag[]=$val['tag'];
					}
					$a = array_diff($_SESSION['tagLeaves'][3],$arrTag);
					if(empty($a)){
						$flag=0;	
					}
					else{
						$flag=1;
					}
				}
				
				
				if($flag==0){
				$nodeBgColor = ($i%2)?'row1':'row2';
				$i++;?>
<div class="<?php echo $nodeBgColor;?> views_div">

							<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/?node=<?php echo $arrVal["nodeId"];?>#discussLeafContent<?php echo $arrVal["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],1000,1);*/ echo stripslashes(substr($arrVal['contents'],0,1000)); ?> </a>

  <?php
							//echo '<a href='.base_url().'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent( $arrVal['contents'] ,1000,1).'</a>';
						?>
  <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
				}
			}//comments in discuss
			$arrparent=  $this->chat_db_manager->getPerentInfo($arrVal['nodeId']);
			
			if($arrparent['successors'])
			{
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				$counter=0;
				
				foreach($sArray as $val)
				{
					$arrDiscussions	= $this->chat_db_manager->getPerentInfo($val);		
					$userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$checksucc 		= $this->chat_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
					$this->chat_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 
					$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
					
					$attachedTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($arrDiscussions['nodeId'], 2);
					$arrTag=array();
				
					if(!empty($attachedTags) && (in_array($arrDiscussions['userId'],$_SESSION['usrLeaves']) || !$_SESSION['usrLeaves'])){
						$arrTag=array();
						$flag=1;//for checking nonexistent tag in node
						foreach($attachedTags['simple'] as $val){
							$arrTag[]=$val['tag'];
						}
						$a = array_diff($_SESSION['tagLeaves'][1],$arrTag);
						if(empty($a)){
							$flag=0;	
						}
						
						if($flag==0){
							$arrTag=array();
							foreach($attachedTags['response'] as $val){
								$arrTag[]=$val['tagId'];
							}
							$a = array_diff($_SESSION['tagLeaves'][2],$arrTag);
							if(empty($a)){
								$flag=0;	
							}
							else{
								$flag=1;
							}
						}
						
						if($flag==0){
							$arrTag=array();
							foreach($attachedTags['contact'] as $val){
								$arrTag[]=$val['tag'];
							}
							$a = array_diff($_SESSION['tagLeaves'][3],$arrTag);
							if(empty($a)){
								$flag=0;	
							}
							else{
								$flag=1;
							}
						}
						
						
						
						if($flag==0){
						$nodeBgColor = ($i%2)?'row1':'row2';
						$i++;?>
<div class="<?php echo $nodeBgColor;?> views_div">

							<a style="text-decoration:none; margin-left:3%;color:#000;" href="<?php echo base_url();?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/?node=<?php echo $arrDiscussions["nodeId"];?>#discussCommentLeafContent<?php echo $arrDiscussions["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent($arrDiscussions['contents'],1000,1);*/ echo stripslashes(substr($arrDiscussions['contents'],0,1000)); ?> </a>
							
  <?php
								//echo '<a href='.base_url().'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrDiscussions["nodeId"].' style="text-decoration:none;margin-left:3%; color:#000;">'.$this->identity_db_manager->formatContent($arrDiscussions['contents'],1000,1).'</a>';
								?>
  <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
						}
					}
					
				}
			}
	
		}
		/*End tags filter*/
	}
	
}
else{
	$details=$this->chat_db_manager->getPerentInfo($treeId);
	
	if(in_array($arrDiscussionDetails['userId'],$_SESSION['usrLeaves'])){
		?>
<div class="seedBgColor" style="margin:3px;">
  <?php
  		/*$this->identity_db_manager->formatContent($arrDiscussionDetails['name'],1000,1)*/
		echo '<a href='.base_url().'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.stripslashes(substr($arrDiscussionDetails['name'],0,1000)).'</a>';?>
</div>
<?php
	}
	
	/*Start User Filter*/
		$i=1;
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{
			
			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			if(in_array($arrVal['userId'],$_SESSION['usrLeaves']) && $arrVal['contents']!="Stopped" && $arrVal['contents']!="Started"){
				$nodeBgColor = ($i%2)?'row1':'row2';
				$i++;?>
<div class="<?php echo $nodeBgColor;?> views_div">

							<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/?node=<?php echo $arrVal["nodeId"];?>#discussLeafContent<?php echo $arrVal["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],1000,1);*/ echo stripslashes(substr($arrVal['contents'],0,1000)); ?> </a>

  <?php
							//echo '<a href='.base_url().'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrVal['contents'],1000,1).'</a>';
						?>
  <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
			}//comments in discuss
			$arrparent=  $this->chat_db_manager->getPerentInfo($arrVal['nodeId']);
			
			if($arrparent['successors'])
			{
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				$counter=0;
				
				foreach($sArray as $val)
				{
					
					$arrDiscussions	= $this->chat_db_manager->getPerentInfo($val);		
					$userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$checksucc 		= $this->chat_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
					$this->chat_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 
					$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
					
					$attachedTags 	= $this->tag_db_manager->getLeafTagsByLeafIds($arrDiscussions['nodeId'], 2);
					$arrTag=array();
				
					if(in_array($arrDiscussions['userId'],$_SESSION['usrLeaves']) && $arrDiscussions['contents']!="Stopped" && $arrDiscussions['contents']!="Started"){
						$nodeBgColor = ($i%2)?'row1':'row2';
						$i++;?>
<div class="<?php echo $nodeBgColor;?> views_div">

						<a style="text-decoration:none; margin-left:3%;color:#000;" href="<?php echo base_url();?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1/?node=<?php echo $arrDiscussions["nodeId"];?>#discussCommentLeafContent<?php echo $arrDiscussions["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent($arrDiscussions['contents'],1000,1);*/ echo stripslashes(substr($arrDiscussions['contents'],0,1000)); ?> </a>
	
  <?php
							//echo '<a href='.base_url().'view_chat/chat_view/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrDiscussions["nodeId"].' style="text-decoration:none; margin-left:3%;color:#000;">'.$this->identity_db_manager->formatContent($arrDiscussions['contents'],1000,1).'</a>';?>
  <div class="userLabel"><?php echo  $userDetails['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
					}
					
				}
			}
	
		}
		
		
	/*End user filter*/
}
?>
