<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ 

$position=0;
$userDetails	= 	$this->chat_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);
?>
<?php
	$realtimeChatDivIds = array();
	//echo $realTimeDivIds;
	$totalNodes = array();
	if(count($arrDiscussions) > 0)
	{ ?>

<div style="width:100%;">
  <?php
  		//echo '<pre>';
  		//print_r($arrDiscussions); exit;
					 
		foreach($arrDiscussions as $keyVal=>$arrVal)
		{
		   
			$totalNodes[] = $arrVal['nodeId'];
			$userDetails1	= 	$this->chat_db_manager->getUserDetailsByUserId($arrVal['userId']);			
			$checksucc 		=	$this->chat_db_manager->checkSuccessors($arrVal['nodeId']);			
			$this->chat_db_manager->insertDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);			
			$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrVal['nodeId'],$_SESSION['userId']);
			
				if($arrVal['predecessor'] > 0)
				{
					$chatBgColor = 'chatBgColor1';
				}
				else
				{
					$chatBgColor = 'chatBgColor2';
				}

				//Added by Dashrath- remove chatBgColor class for new ui
				$chatBgColor = '';

	$realtimeChatDivIds=explode(",",$realTimeDivIds);
	//print_r($realtimeChatDivIds);
	if(!in_array($arrVal['nodeId'],$realtimeChatDivIds))	
	{
	
			if ($arrVal['chatSession']==0)
			{
		?>
	<!--Manoj: chat_block padding left default 80-->
  
  <!-- Added by Dashrath- for div seperator -->
  <div class="treeLeafRowStyle2"> </div>

  <!-- Changed by Dashrath- change margin-top:1% to 0% for new ui -->
  <!-- Changed by Dashrath- change padding-left 0px to 45 for new ui -->
  <div id="chat_block<?php echo $arrVal['nodeId'];?>" style="margin-top:0%; padding-left:<?php if ($arrVal['predecessor']>0) {echo 45; }?>px; border-bottom:1px dotted #ffffff" class="treeLeafRowStyle" tabindex="0">
  	<!--Changed by Dashrath- add float: left; in inline css for image stretch issue-->
    <div id="<?php echo $position++;?>" style="padding-left:10px; float: left;" class="<?php echo $chatBgColor;?> handCursor" <?php if($arrVal['predecessor'] == 0) { if($timmer) { ?> onclick= "showReply(0,<?php echo $arrVal['nodeId'];?>),nodeId=<?php echo $arrVal['nodeId'];?>;parent.replay_target=0;$('.button01').focus(); real_time_chat_order(<?php echo $treeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['predecessor'];?>,<?php echo $arrVal['nodeId'];?>);"  <?php }} else {if($timmer) { ?> onclick="showReply(0,<?php echo $arrVal['predecessor'];?>),nodeId=<?php echo $arrVal['predecessor'];?>; parent.replay_target=0;$('.button01').focus(); real_time_chat_order(<?php echo $treeId;?>,<?php echo $workSpaceId;?>,<?php echo $workSpaceType;?>,<?php echo $arrVal['predecessor'];?>,<?php echo $arrVal['nodeId'];?>);" <?php  }} ?> >

    	<!--Commented by Dashrath- add new code below with if else condition-->
    	<?php //echo stripslashes($arrVal['contents']); ?> 

    	<!-- Added by Dashrath- add for remove delete content  -->
	    <?php 
	      if($arrVal['leafStatus'] !='deleted'){
	        /*Commented old code and add new code below for audio icon show when content is audio*/
	        // echo stripslashes($arrVal['contents']);

	        /*Added by Dashrath- Add if else condition for show audio icon when content is audio*/
			$audioContainsMatch1 = (bool) preg_match('/class="[^"]*\baudioRecordTxt\b[^"]*"/', $arrVal['contents']);
			$audioContainsMatch2 = (bool) preg_match( '/<audio/', $arrVal['contents']);
			
			if($audioContainsMatch1 && $audioContainsMatch2)
			{
			?>	
				<span class="cursor" onclick="audioContentHideShow('<?php echo $arrVal['nodeId'];?>')">
					<img src="<?php echo  base_url(); ?>images/audio_content_icon.png" alt="Audio" title="Audio">
				</span>
				<span id='audio_contents<?php echo $arrVal['nodeId'];?>' style="display: none;"><?php echo stripslashes($arrVal['contents']);?></span>
			<?php
			}
			else
			{
				echo stripslashes($arrVal['contents']);
			}
			/*Dashrath- code end*/
	      }else{ ?>
	       <span class="clearedLeafContent"><?php echo $this->lang->line('txt_content_deleted'); ?></span> 
	     <?php } ?>
	    <!-- Dashrath : code end -->
	</div>

	<!--Added by Dashrath- div clear because float left use in above div -->
	<div class="clr"></div>
	<!--Dashrath- code end-->

  <div id="normalView<?php echo $arrVal['nodeId'];?>" style="width:<?php echo $this->config->item('page_width')-130;?>px; padding-left:10px; display:none;" class="<?php echo $chatBgColor;?> handCursor">
    <?php 					
					if($arrVal['predecessor'] == 0)
					{
						if($timmer){?>
    <a href="javascript:void(0);" ><?php echo $this->lang->line('txt_Reply');?></a>
    <?php }
					}
					else
					{
						if($timmer){?>
    <a href="javascript:void(0);" ><?php echo $this->lang->line('txt_Reply');?></a>
    <?php }
					}
					?>
  </div>
  <div style="width:100%;" <?php //padding-left:10px;?> class="<?php echo $chatBgColor;?> handCursor">
    <?php 				
			if($arrVal['predecessor'] > 0)
			{
				$top = $this->chat_db_manager->getTopicByNodeId($treeId, $arrVal['predecessor']);
				
				$pos = strpos($top,"<img");
				$con = $this->identity_db_manager->formatContent($top,0,1);
				if($pos){
					 if(trim(strip_tags($con))){
						$con=strip_tags($con);
					 }
					 else{
						$con= "<a href='#chat_block".$arrVal['predecessor']."'>The content contains only image/audio/video</a>";
					 }
				}
				else
			?>
    <?php 
    /*Changed by Dashrath- Check if condition for hide content if content status is deleted*/
    if($arrVal['leafStatus'] !='deleted')
    {
    	echo '<div style="float:left"  ><i><font style="text-aligh:left; padding-left:10px;" size="1">'.$this->lang->line('txt_Topic').': '.$con.'</font></i></div>'; 
    }
    ?>
    <?php
			}
			?>
    <div style="float:right; margin-right:5px;" ><font color="#006699" size="1"><i><?php echo $userDetails1['userTagName'] .'  '.$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], 'm-d-Y h:i A') ;?></i></font></div>
    <div class="clr"></div>
    <div style="float:left;">
      <?php			
			$arrparent=  $this->chat_db_manager->getPerentInfo($arrVal['nodeId']);			
			?>
    </div>
  </div>
  <?php
		
			} // end if
			else
			{
				if ($arrVal['chatSession']==2)
					$chatSessionBGColor = 'chatSessionBGStop';
				else
					$chatSessionBGColor = 'chatSessionBGStart';
			?>
  <div style="width:100%;" <?php //margin-left:10px; ?> class="<?php echo $chatSessionBGColor; ?>">
    <?php 
									if ($arrVal['chatSession']==2)
									{
										echo $this->lang->line('txt_Stopped_At') .' ' .$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], 'm-d-Y h:i A') ;
									}
									else
									{
										echo $this->lang->line('txt_Started_At') .' ' .$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], 'm-d-Y h:i A') ;
									}
								?>
  </div>
  <?php	
			}
			?>
</div>
<?php
		}
			
		}
		?>
</div>
<?php
	}
?>
<?php 
$totalNodes[] = 0;

?>
<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
<a id="focusDown" href="javascript:void(0);" style="color:#FFFFFF;">&nbsp;</a>
<input type="hidden" id="status1" value="<?php echo $status;?>">