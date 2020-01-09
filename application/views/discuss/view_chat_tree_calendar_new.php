<?php  /*Copyright © 2008-2014. Team Beyond Borders Pty Ltd. All rights reserved.*/ 

$position=0;
$userDetails	= 	$this->chat_db_manager->getUserDetailsByUserId($arrDiscussionDetails['userId']);
?>
<?php
	$totalNodes = array();
	//echo '<pre>';
	//print_r($arrDiscussions);exit;
	if(count($arrDiscussions) > 0)
	{ ?>

<div style="width:100%;">
  <?php
					 
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

			if ($arrVal['chatSession']==0)
			{
		?>
  <div id="chat_block<?php echo $arrVal['nodeId'];?>" class="chat_box" style="padding-left:<?php if ($arrVal['predecessor']>0) {echo 80;}?>px; margin:10px 0px; border-bottom:1px dotted #ffffff" >
    <div id="<?php echo $position++;?>" style="" class="<?php echo $chatBgColor;?> handCursor" <?php if($arrVal['predecessor'] == 0) { if($timmer) { ?> onclick= "showReply(0,<?php echo $arrVal['nodeId'];?>),nodeId=<?php echo $arrVal['nodeId'];?>;parent.replay_target=0;$('.button01').focus();" <?php }} else {if($timmer) { ?> onclick="showReply(0,<?php echo $arrVal['predecessor'];?>),nodeId=<?php echo $arrVal['predecessor'];?>; parent.replay_target=0;$('.button01').focus();" <?php  }} ?> >
    <?php echo stripslashes($arrVal['contents']); 
	?>
	   <div style="float:right; margin-right:20px;" ><font color="#006699" size="1"><i><?php echo $userDetails1['userTagName'] .'  '.$this->time_manager->getUserTimeFromGMTTime($arrVal['DiscussionCreatedDate'], 'm-d-Y h:i A') ;?></i></font></div>
	   <div id="comment_section" style="background:#fff;">
	<?php
	
	//Manoj : code for added comment below perticular topic
	$arrparent=  $this->chat_db_manager->getPerentInfo($arrVal['nodeId']);
				
			if($arrparent['successors'])
			{
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				$counter=0;
				while($counter < count($sArray))
				{
				$arrDiscussions	= $this->chat_db_manager->getPerentInfo($sArray[$counter]);	
				?><div class="commentSec" style="margin-top:25px; padding-left:5%;"><div><?php echo $arrDiscussions['contents']; ?></div>
				
				  <div style="width:99%; padding-left:10px;" class="<?php echo $chatBgColor;?> handCursor">
    <?php 				
			if($arrDiscussions['predecessor'] > 0)
			{
				$top = $this->chat_db_manager->getTopicByNodeId($treeId, $arrDiscussions['predecessor']);
				
				$pos = strpos($top,"<img");
				$con = $this->identity_db_manager->formatContent($top,0,1);
				if($pos){
					 if(trim(strip_tags($con))){
						$con=strip_tags($con);
					 }
					 else{
						$con= "<a href='#chat_block".$arrDiscussions['predecessor']."'>The content contains only image/audio/video</a>";
					 }
				}
				else
			?>
    <!--<div style="float:left"  ><i><font style="text-aligh:left" size="1"><?php //echo $this->lang->line('txt_Topic').': '.$con; ?></font></i></div>-->
	<div style="float:right; margin-right:20px;" ><font color="#006699" size="1"><i><?php echo $userDetails1['userTagName'] .'  '.$this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'], 'm-d-Y h:i A') ;?></i></font></div></div>
    <div class="clr"></div>
    
  </div>
    <?php
			}
				$counter++;
			}
			}
					
			
	//Manoj: code end	
			
	
	?> 
	
	
	
	
	</div>
	</div>
	
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
  <div style="width:99%; padding-left:10px;" class="<?php echo $chatBgColor;?> handCursor">
   <div class="clr"></div>
    <div style="float:left;">
      <?php			
			$arrparent=  $this->chat_db_manager->getPerentInfo($arrVal['nodeId']);			
			?>
    </div>
  </div>
  <div class="clr"></div>
<?php /*?><div style="float:left; height:30px; width:100%;">
            <div style="margin-top:12px;border-bottom:1px dotted gray;margin-left:5%"></div>
  </div><?php */?>
  <?php
		
			} // end if
			else
			{
				if ($arrVal['chatSession']==2)
					$chatSessionBGColor = 'chatSessionBGStop';
				else
					$chatSessionBGColor = 'chatSessionBGStart';
			?>
  <div style="width:97%; margin-left:30px;" class="<?php echo $chatSessionBGColor; ?>">
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
		?>
</div>

<?php
	}
?>
<?php 
$totalNodes[] = 0;

?>
<input type="hidden" class="currentChatId" id="<?php echo $arrVal['nodeId'];?>">
<input type="hidden" id="totalNodes" value="<?php echo implode(',',$totalNodes);?>">
<a id="focusDown" href="javascript:void(0);" style="color:#FFFFFF;">&nbsp;</a>
<input type="hidden" id="status1" value="<?php echo $status;?>">
