<style type="text/css">
<!--
.style1 {
	font-size: 10px
}
.style2 {
	font-size: 11px
}
.style4 {
	font-size: 11px;
	font-weight: bold;
}
-->
</style>
<script>
	var baseUrl='<?php echo base_url();?>';
	var lastframeid=0;
	var rameid=0;

	function blinkIt() {
	 if (!document.all) return;
	 else {
	   for(i=0;i<document.all.tags('blink').length;i++){
		  s=document.all.tags('blink')[i];
		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';
	   }
	 }
	}
 	
	var mystart='<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d h:i A');?>';
	var myend='<?php echo $this->time_manager->getUserTimeFromGMTTime($this->time_manager->getGMTTime(), 'Y-m-d h:i A');?>';
	function changes_date(newsdate,newedate){
		mystart=newsdate;
		myend=newedate;
	}
	function compareDates (dat1, dat2) {
	   var date1, date2;
	   var month1, month2;
	   var year1, year2;
	   value1 = dat1.substring (0, dat1.indexOf (" "));
	  value2 = dat2.substring (0, dat2.indexOf (" "));
	  time1= dat1.substring (1, dat1.indexOf (" "));
	  time2= dat2.substring (1, dat2.indexOf (" "));
	  
	  hours1= time1.substring (0, time1.indexOf (":"));
	  minites1= time1.substring (1, time1.indexOf (":"));
	  
	  hours2= time2.substring (0, time2.indexOf (":"));
	  minites2= time2.substring (1, time2.indexOf (":"));
	  
   year1 = value1.substring (0, value1.indexOf ("-"));
   month1 = value1.substring (value1.indexOf ("-")+1, value1.lastIndexOf ("-"));
   date1 = value1.substring (value1.lastIndexOf ("-")+1, value1.length);

   year2 = value2.substring (0, value2.indexOf ("-"));
   month2 = value2.substring (value2.indexOf ("-")+1, value2.lastIndexOf ("-"));
   date2 = value2.substring (value2.lastIndexOf ("-")+1, value2.length);

   if (year1 > year2) return 1;
   else if (year1 < year2) return -1;
   else if (month1 > month2) return 1;
   else if (month1 < month2) return -1;
   else if (date1 > date2) return 1;
   else if (date1 < date2) return -1;
   else if (hours1 > hours2) return 1;
   else if (hours1 < hours2) return -1;
   else if (minites1 > minites2) return 1;
   else if (minites1 < minites2) return -1;
   else return 0;
} 

	var baseUrl='<?php echo base_url();?>';
	var lastframeid=0;
	var rameid=0;
	function blinkIt() {
	 if (!document.all) return;
	 else {
	   for(i=0;i<document.all.tags('blink').length;i++){
		  s=document.all.tags('blink')[i];
		  s.style.visibility=(s.style.visibility=='visible')?'hidden':'visible';
	   }
	 }
	 //Add SetTimeOut 
	 setTimeout("blinkIt()", 500);
	}
	function showFocus()
	{
	//setInterval('blinkIt()',500);
	//Add SetTimeOut 
	setTimeout("blinkIt()", 500);

	}
	function validate_dis(replyDiscussion,formname){
	var error='';

	if(getvaluefromEditor(replyDiscussion) == ''){
		error+='<?php echo $this->lang->line('msg_enter_comment');?>';
	}

	if(error==''){
		formname.submit();
	}else{
		jAlert(error);
	}
	
}
</script>
<?php /*?><script language="JavaScript1.2">mmLoadMenus();</script><?php */?>
</head><body style="background-color:#FFFFFF;">

<!-- Main menu -->
<?php
			$workSpaces 				= $this->identity_db_manager->getWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
			$workSpaceDetails			= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			
			if ($this->uri->segment(8))
				$latestVersion 			= $this->discussion_db_manager->getTreeLatestVersionByTreeId($this->uri->segment(8));
				
			$details['workSpaces']		= $workSpaces;
			$details['workSpaceId'] 	= $workSpaceId;
			if($workSpaceId > 0)
			{				
				$details['workSpaceName'] 	= $workSpaceDetails['workSpaceName'];
			}
			else
			{
				$details['workSpaceName'] 	= $this->lang->line('txt_Me');	
			}
			 ?>
<!-- Main menu -->
<?php	
	$focusId = 2;
	$totalNodes = array();
	$rowColor1='rowColor3';
	$rowColor2='rowColor4';	
	
	$stack=$_SESSION['commentIdContainer'];
	if(count($arrDiscussions) > 0)
	{	
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{		
			//Manoj: Comment below code for getting all content of current talk
			if(!(in_array($arrVal['nodeId'],$stack)))
			{
			
			array_push($stack,$arrVal['nodeId']);
			
			$userDetails			= $this->discussion_db_manager->getUserDetailsByUserId($arrVal['userId']);				
			$checksucc 				= $this->discussion_db_manager->checkSuccessors($arrVal['nodeId']);
			$this->discussion_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);			
			$viewCheck=$this->discussion_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);		
			$nodeBgColor = ($_SESSION['i'] % 2) ? $rowColor1 : $rowColor2;
	
		?>
<div id="latestcontent<?php echo $arrVal['leafId'];?>" class="<?php echo $nodeBgColor;?>" style="padding:0% 2% 0% 2%;">
  <div style="float:left;width:100%;" >
    <?php
                        echo stripslashes($arrVal['contents']);
                ?>
  </div>
  
  <!--End of changed by Surbhi IV-->
  <div class="<?php echo $nodeBgColor;?> commenterTalk TalktxtComments">
    <?php 
			//.$this->lang->line('txt_Date').':'
            echo '<span>'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;&nbsp;<span>'.$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'],$this->config->item('date_format')).'</span>';
            ?>
  </div>
  <div class="clr"></div>
</div>
<?php
			$focusId = $focusId+2;
			$_SESSION['i']=$_SESSION['i']+1;
			
			}
		}
		
		$_SESSION['commentIdContainer']=$stack;
	}
?>
<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
<script>
function reply(id,focusId)
{
	whofocus=focusId;	
	frameIndex = focusId;
	var divid='reply_teeme'+id;
	document.getElementById(divid).style.display='';

}
function reply_close(id){
	divid='reply_teeme'+id;
 	document.getElementById(divid).style.display='none';
}
function newTopic(id,focusId,position)
{

	whofocus=focusId;	
	frameIndex = focusId;
	var divid='newTopic'+id;
	document.getElementById(divid).style.display='';
	

}
function newTopicClose(id){
	divid='newTopic'+id;
 	document.getElementById(divid).style.display='none';
}
function vksfun(focusId){
whofocus=focusId;
}
</script> 
<script>
		// Parv - Keep Checking for tree updates every 5 second
		<!--Updated by Surbhi IV-->
		//setInterval("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,1,'')", 10000);
		
		//Add SetTimeOut 
		setTimeout("checktreeUpdateCount(<?php echo $treeId; ?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,1,'')", 20000);
		
		<!--End of Updated by Surbhi IV-->
</script> 