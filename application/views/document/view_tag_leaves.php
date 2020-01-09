<?php

$tagId = ($_GET['tagId'])?$_GET['tagId']:0;
$treeId = ($_GET['treeId'])?$_GET['treeId']:0;
$tagType = ($_GET['tagType'])?$_GET['tagType']:0;
$usr = ($_GET['usr'])?$_GET['usr']:0;
$curVersion=($_GET['curVersion'])?$_GET['curVersion']:0;

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

if(empty($_SESSION['usrLeaves']) && $usr==''){
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
	if(!empty($attachedTags) && (in_array($arrDocumentDetails['userId'],$_SESSION['usrLeaves']) || !$_SESSION['usrLeaves'])){

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
			?>
<div class="seedBgColor views_div">
  <?php 
  				/*$this->identity_db_manager->formatContent($arrDocumentDetails['name'],1000,1)*/
                  echo '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1" style="text-decoration:none; color:#000;">'.stripslashes(substr($arrDocumentDetails['name'],0,1000)).'</a>';
            ?>
</div>
<?php
		}
	}
	
		
	if(count($documentDetails) > 0)
	{	
		$i=1;
		$sArray=array();
		$nodes=array();
		foreach($documentDetails as $keyVal=>$arrVal)
		{
		
			//Add draft reserved users condition
				$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($arrVal['leafId']);
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $arrVal['nodeOrder']);	
				$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($treeId, $leafParentData['parentLeafId'],$_SESSION['userId']);
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}
			//Code end	
			if(((in_array($_SESSION['userId'], $resUserIds)) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish')
			{
		
			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			
			$attachedTags = $this->tag_db_manager->getLeafTagsByLeafIds($arrVal['nodeId'], 2);
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
				$flag;
				
				if($flag==0){
					$nodes[]=$arrVal["nodeId"];
					$nodeBgColor = ($i%2)?'row1':'row2';
					$i++;?>
<div class="<?php echo $nodeBgColor;?> views_div">

					<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&node=<?php echo $arrVal["nodeId"];?>#docLeafContent<?php echo $arrVal["nodeId"];?>"><?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],1000,1);*/  echo stripslashes(substr($arrVal['contents'],0,1000)); ?></a>
					
  <?php
					//echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$arrVal["nodeId"].'&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1 style="text-decoration:none; color:#000;">'. $this->identity_db_manager->formatContent($arrVal['contents'],1000,1).'</a>';?>
  <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
				}?>
<?php
			}
			?>
<?php
			$_SESSION['success'] = 0;
			$checkSuccessor =  $this->document_db_manager->getSuccessors($arrVal['nodeId']);

			if ($checkSuccessor != 0)
			{
				$sArray=array_unique(explode(',',$checkSuccessor));
			}
			
			}//Code end
			
		}
		$sArray= array_diff($sArray,$nodes);
		foreach($sArray as $val)
		{
				$arrDocuments	= $this->document_db_manager->getPerentInfo($val);
				
				//Add draft reserved users condition
				$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($arrDocuments['leafId']);
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($arrDocuments['treeIds'], $arrDocuments['nodeOrder']);	
				$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($arrDocuments['treeIds'], $leafParentData['parentLeafId'],$_SESSION['userId']);
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}
			//Code end	
			if(((in_array($_SESSION['userId'], $resUserIds)) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish')
			{
				
				$totalNodes[] = $arrDocuments['nodeId'];	 
	
				$userDetails	= $this->document_db_manager->getUserDetailsByUserId($arrDocuments['userId']);
				$checksucc 		= $this->document_db_manager->checkSuccessors($arrDocuments['nodeId']);				

				$attachedTags 	= $this->tag_db_manager->getLeafTagsByLeafIds($arrDocuments['nodeId'], 2);
				$arrTag=array();

				if(!empty($attachedTags) && (in_array($arrDocuments['userId'],$_SESSION['usrLeaves']) || !$_SESSION['usrLeaves'])){
					$arrTag=array();
					$flag=1;//for checking non-existent tag in node
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

				<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&node=<?php echo $arrDocuments["nodeId"];?>#docLeafContent<?php echo $arrDocuments["nodeId"];?>"><?php /*echo $this->identity_db_manager->formatContent($arrDocuments['contents'],1000,1);*/ echo stripslashes(substr($arrDocuments['contents'],0,1000)); ?></a>
				
  <?php 
						//echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$arrDocuments["nodeId"].'&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1 style="text-decoration:none; color:#000;">'. $this->identity_db_manager->formatContent($arrDocuments['contents'],1000,1) .'</a>';
					
					?>
  <div class="userLabel"><?php echo  $userDetails['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrDocuments['DiscussionCreatedDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
					}
				}
				}//Code end			
			}
		
	}
		 
	
}
else{
	$details=$this->chat_db_manager->getPerentInfo($treeId);

	if(in_array($arrDocumentDetails['userId'],$_SESSION['usrLeaves']))
	{?>
<div class="seedBgColor views_div">
  <?php 
            echo '<a href="'.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1" style="text-decoration:none; color:#000;">'./*$this->identity_db_manager->formatContent($arrDocumentDetails['name'],1000,1)*/  stripslashes(substr($arrDocumentDetails['name'],0,1000)).'</a>';
     ?>
</div>
<?php
	}
	$nodes=array();
	
	if(count($documentDetails) > 0)
	{	
		$sArray=array();
		$i=1;
		foreach($documentDetails as $keyVal=>$arrVal)
		{
			//Add draft reserved users condition
				$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($arrVal['leafId']);
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($treeId, $arrVal['nodeOrder']);	
				$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($treeId, $leafParentData['parentLeafId'],$_SESSION['userId']);
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}
			//Code end	
			if(((in_array($_SESSION['userId'], $resUserIds)) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish')
			{
					
			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	
			if(in_array($arrVal['userId'],$_SESSION['usrLeaves'])){
				$nodes[]=$arrVal["nodeId"];
				$nodeBgColor = ($i%2)?'row1':'row2';
				$i++;?>
<div class="<?php echo $nodeBgColor;?> views_div">

				<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&node=<?php echo $arrVal["nodeId"];?>#docLeafContent<?php echo $arrVal["nodeId"];?>"><?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],1000,1);*/  echo stripslashes(substr($arrVal['contents'],0,1000)); ?></a>
				
  <?php
					//echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$arrVal["nodeId"].'&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1 style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrVal['contents'],1000,1).'</a>';
					?>
  <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
			}
		 
		 	$checkSuccessor =  $this->document_db_manager->getSuccessors($arrVal['nodeId']);
			if ($checkSuccessor != 0)
			{
				$sArray=array_unique(explode(',',$checkSuccessor));
			}
			
			}//Code end
		}
		
		$sArray=array_diff($sArray,$nodes);
		
		foreach($sArray as $val)
		{
			$arrDocuments	= $this->document_db_manager->getPerentInfo($val);
			
			//Add draft reserved users condition
				$docLeafStatus = $this->document_db_manager->getLeafStatusByLeafId($arrDocuments['leafId']);
				$leafParentData = $this->document_db_manager->getLeafParentIdByNodeOrder($arrDocuments['treeIds'], $arrDocuments['nodeOrder']);	
				$emptyReservedList = $this->document_db_manager->getUserNonContReserveStatus($arrDocuments['treeIds'], $leafParentData['parentLeafId'],$_SESSION['userId']);
				//Get reserved users
				$reservedUsers = '';
				$reservedUsers 	= $this->document_db_manager->getDocsReservedUsers($leafParentData['parentLeafId']);
				$resUserIds = array();			
				foreach($reservedUsers  as $resUserData)
				{
					$resUserIds[] = $resUserData['userId']; 
				}
			//Code end	
			if(((in_array($_SESSION['userId'], $resUserIds)) && $docLeafStatus != 'discarded') || $docLeafStatus == 'publish')
			{
			
			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrDocuments['userId']);	
			
			$totalNodes[] = $arrDocuments['nodeId'];

			$userDetails	= $this->document_db_manager->getUserDetailsByUserId($arrDocuments['userId']);
			$checksucc 		= $this->document_db_manager->checkSuccessors($arrDocuments['nodeId']);				

			$attachedTags 	= $this->tag_db_manager->getLeafTagsByLeafIds($arrDocuments['nodeId'], 2);
			$arrTag=array();

			if(in_array($arrDocuments['userId'],$_SESSION['usrLeaves']) && $arrDocuments['treeIds']==$treeId){//treeId condition to avoid showing false leaves in session variable
				$nodeBgColor = ($i%2)?'row1':'row2';
				$i++;?>
<div class="<?php echo $nodeBgColor;?> views_div">


				<a style="text-decoration:none; color:#000;margin-left:3%;" href="<?php echo base_url();?>view_document/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?treeId=<?php echo $treeId;?>&doc=exist&node=<?php echo $arrDocuments["nodeId"];?>#docLeafContent<?php echo $arrDocuments["nodeId"];?>"><?php /*echo $this->identity_db_manager->formatContent($arrDocuments['contents'],1000,1);*/  echo stripslashes(substr($arrDocuments['contents'],0,1000)); ?></a>
				
  <?php 
					//echo '<a href='.base_url().'view_document/index/'.$workSpaceId.'/type/'.$workSpaceType.'/?treeId='.$treeId.'&doc=exist&node='.$arrDocuments["nodeId"].'&tagId='.$tagId.'&curVersion='.$curVersion.'&option=1 style="text-decoration:none; color:#000;margin-left:3%;">'.$this->identity_db_manager->formatContent($arrDocuments['contents'],1000,1).'</a>';
				?>
  <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrDocuments['DiscussionCreatedDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
			}
			}//Code end
		}
	}
}
?>
