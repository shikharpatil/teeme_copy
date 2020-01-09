<?php 
$tagId = $this->uri->segment(8);//tag type id
$treeId = $this->uri->segment(3);
$tagType = $this->uri->segment(9);
$usr = $this->uri->segment(10);
$workSpaceId = $this->uri->segment(4);		
$workSpaceType = $this->uri->segment(6);


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

/*$memc = new Memcached;
$memc->addServer($this->config->item('memcache_host'),$this->config->item('port_no'));*/	

//Manoj: get memcache object	
$memc=$this->identity_db_manager->createMemcacheObject();

$memCacheId = 'wp'.$_SESSION['workPlaceId'].'contact'.$treeId;	

$memc->delete($memCacheId); 
$value = $memc->get( $memCacheId );


if(!$value)
{	
	$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,  $workSpaceId, $workSpaceType);		

	$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
	$value = $memc->get($memCacheId);

		if ($value == '')
		{
			$value = $contactNotes;
		}
}
				
if ($value)
{	

	// tempary code //
	$contactNotes=$this->contact_list->getlatestContactNote($treeId, $start=0,$userId,$workSpaceId, $workSpaceType);		

	$memc->set($memCacheId, $contactNotes, MEMCACHE_COMPRESSED);	
	$value = $memc->get($memCacheId);

		if ($value == '')
		{
			$value = $contactNotes;
		}
	// tempary code //	
	$ContactNotes = $value;				
}
$Contactdetail = $this->contact_list->getlatestContactDetails($treeId);
	

if(!empty($_SESSION['tagLeaves']))
{
	$attachedTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($treeId, 1);

	$details=$this->chat_db_manager->getPerentInfo($treeId);
	if(!empty($attachedTags) && (in_array($Contactdetail['userId'],$_SESSION['usrLeaves']) || !$_SESSION['usrLeaves'])){

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

<div class="seedBgColor" style="margin:3px;">
  <?php 
				echo '<a href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.strip_tags($Contactdetail['firstname'].' '.$Contactdetail['lastname']).'</a>';
				?>
</div>
<?php
		}
	}
	
	if(count($ContactNotes) > 0)
	{
		$i=1;
		foreach($ContactNotes as $keyVal=>$arrVal)
		{
			$attachedTags 		= $this->tag_db_manager->getLeafTagsByLeafIds($arrVal['nodeId'], 2);
			
			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);
			
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

						<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#contactLeafContent<?php echo $arrVal["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],1000,1);*/ echo stripslashes(substr($arrVal['contents'],0,1000)); ?> </a>

  <?php
                       // echo '<a href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent($arrVal['contents'],1000,1).'</a>';
                        ?>
  <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['orderingDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
				}
			}
		}
	}
}
else{
	if(in_array($Contactdetail['userId'],$_SESSION['usrLeaves'])){
		?>
<div class="seedBgColor" style="margin:3px;">
  <?php 
            echo '<a href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$treeId.' style="text-decoration:none; color:#000;">'.strip_tags($Contactdetail['firstname'].' '.$Contactdetail['lastname']).'</a>';
            ?>
</div>
<?php
	}
	

	if(count($ContactNotes) > 0)
	{
		$i=1;
		foreach($ContactNotes as $keyVal=>$arrVal)
		{
			$userDetails1	= 	$this->notes_db_manager->getUserDetailsByUserId($arrVal['userId']);	
		
			if(in_array($arrVal['userId'],$_SESSION['usrLeaves'])){
				$nodeBgColor = ($i%2)?'row1':'row2';
				$i++;?>
<div class="<?php echo $nodeBgColor;?> views_div">
	
					<a style="text-decoration:none; color:#000;" href="<?php echo base_url();?>contact/contactDetails/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/?node=<?php echo $arrVal["nodeId"];?>#contactLeafContent<?php echo $arrVal["nodeId"];?>"> <?php /*echo $this->identity_db_manager->formatContent($arrVal['contents'],1000,1);*/ echo stripslashes(substr($arrVal['contents'],0,1000)); ?> </a>

  <?php
  	
                    //echo '<a href='.base_url().'contact/contactDetails/'.$treeId.'/'.$workSpaceId.'/type/'.$workSpaceType.'/1/'.$arrVal["nodeId"].' style="text-decoration:none; color:#000;">'.$this->identity_db_manager->formatContent( $arrVal['contents'] ,1000,1).'</a>';
                    ?>
  <div class="userLabel"><?php echo  $userDetails1['userTagName']."&nbsp;&nbsp;"; ?> &nbsp; <?php echo $this->time_manager->getUserTimeFromGMTTime($arrVal['orderingDate'], $this->config->item('date_format')); ?> </div>
</div>
<?php
			}
		}
	}
	
}?>
