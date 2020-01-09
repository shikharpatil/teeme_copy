<div class="talkTreeComments<?php echo $nodeId; ?> talkTreeComments">
<div class="timeline_comments_box<?php echo $nodeId; ?>">
 <?php

			$arrparent=  $this->chat_db_manager->getPerentInfo($nodeId);
			
			$rowColor3='rowColor3';
			$rowColor4='rowColor4';	
			$j = 1;
			
			if($arrparent['successors'])
			{	
				$totalTimelineCommentNodes = array();
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				//$sArray=array_reverse($sArray);
				$counter=0;
				while($counter < count($sArray))
				{
					$arrDiscussions	= $this->chat_db_manager->getPerentInfo($sArray[$counter]);	
					$totalTimelineCommentNodes[] = $arrDiscussions['nodeId'];
					$userDetails = $this->discussion_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$TimelineProfileCommentdetail = $this->profile_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$totalNodes[] = $arrDiscussions['nodeId'];	 
					$userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$checksucc 		= $this->chat_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
					$this->chat_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 
					$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
					
					if ($arrDiscussions['nodeId'] == $this->uri->segment(8))
						$nodeBgColor = 'nodeBgColorSelect';
					else
						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;	 		
					?>
					<?php /*onClick="clickNodesOptions(<?php echo $arrDiscussions['nodeId'];?>)"*/ ?>
			<div id="<?php echo $position++;?>" style="width:100%;float:left;padding-left:0%;padding-top:20px;" class="<?php echo $nodeBgColor."1";?> handCursor" >
		  	
			 <!--Add comment profile pic start-->
  <div style="width:94%; word-wrap:break-word; padding:2%;" class="<?php echo $nodeBgColor;?>" >
  
  
							<?php
								/*if ($TimelineProfileCommentdetail['photo']!='noimage.jpg')
								{
							?>
									<img src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="30" height="30" id="imgName"> 
                          	<?php
								}
								else
								{
							?>
									<img src="<?php echo base_url();?>images/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="30" height="30" id="imgName"> 
							<?php
								}*/
							?>
	
	
	 <div id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>'  style="float:left; width:100%; overflow:hidden;">
	
              <?php  echo $arrDiscussions['contents'];?>
    </div>
	<div style="font-size:13px; padding-top:7%;" class="<?php echo $nodeBgColor;?> commenterTalk TalktxtComments ">
		<?php /*?><p><b><?php echo strip_tags($TimelineProfileCommentdetail['firstName'].' '.$TimelineProfileCommentdetail['lastName'],'<b><em><span><img>'); ?></b></p><?php */?>
		<?php echo '<span>'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;<span>'.$this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format')).'</span>'; ?>
	</div>
	</div>
	
  	<!--Add comment profile pic end-->
		  	
		 
            <!-- display none -->
            <div class="clr"></div>
            
			
		 
           </div>
		  <div style="clear:both;"></div>
          <?php
					$counter++;
					$j++;
				}
				
		}		
?>

</div>
<input type="button" style="opacity:0;" class="focusText" value="focus"/>
<div id="reply_teeme0">
<?php
$this->load->helper('form'); 
$attributes = array('name' => 'form'.$arrVal['nodeId'], 'id' => 'form'.$nodeId, 'method' => 'post', 'enctype' => 'multipart/form-data');	
echo form_open('', $attributes);
?>

<textarea name="replyTimelineComment<?php echo $nodeId;?>" id="replyTimelineComment<?php echo $nodeId; ?>"></textarea>
<div id="focusDiv"></div>
<br />
<div style="padding-left:2%; margin-bottom:9%;">
        <input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Comment');?>" onClick="insertTimelineComment('<?php echo $nodeId; ?>');" style="float:left;" >
		<input type="reset" name="Cancelbutton" value="<?php echo $this->lang->line('txt_Cancel');?>" style="float:left; margin-left:1%;" >
</div>
<input name="reply" type="hidden" id="reply" value="1">
<input name="editStatus" type="hidden" id="editStatus" value="0">
<input name="editorname1" id="editorname1" type="hidden"  value="replyTimelineComment<?php echo $nodeId; ?>">
<input name="nodeId" type="hidden" id="nodeId" value="<?php echo $nodeId; ?>">
<input name="vks" type="hidden" id="vks" value="1">
<input name="chat_view" type="hidden" id="chat_view" value="1">
<input name="treeId" type="hidden" id="treeId" value="<?php echo '0'; ?>">
<input type="hidden" name="workSpaceId" value="<?php echo $workSpaceId;?>" id="workSpaceId">
<input type="hidden" name="workSpaceType" value="<?php echo $workSpaceType;?>" id="workSpaceType">
</form>
</div>
</div>
<script>

chnage_textarea_to_editor('replyTimelineComment<?php echo $nodeId;?>','talk');

setInterval("postCommentRefresh<?php echo $nodeId;?>('<?php echo $nodeId;?>')", 10000);

//Add SetTimeOut 
//setTimeout("postCommentRefresh<?php echo $nodeId;?>('<?php echo $nodeId;?>')", 10000);

var http2 = getHTTPObjectm();

function postCommentRefresh<?php echo $nodeId; ?>(nodeId){
		
		var realTimeTimelineDivIds;
		
		var treeId='0';
		
		var workSpaceId = '<?php echo $workSpaceId;?>';
		var workSpaceType = '<?php echo $workSpaceType;?>';
		
		if(document.getElementById("totalTimelineCommentNodes"+nodeId))
		{
			realTimeTimelineDivIds=document.getElementById('totalTimelineCommentNodes'+nodeId).value;
		}
		
		url='<?php echo base_url();?>post/getRealTimePostComment/'+treeId+'/1/'+nodeId+'/'+workSpaceId+'/'+workSpaceType+'?realTimeTimelineDivIds='+realTimeTimelineDivIds;
	
		http2.open("GET", url, true); 
		http2.onreadystatechange = handleHttpResponsem2<?php echo $nodeId; ?>; 
		http2.send(null);
}
function handleHttpResponsem2<?php echo $nodeId; ?>() 
{    
	if(http2.readyState == 4 || http2.readyState == 0) { 
		if(http2.status==200) { 
			var results=http2.responseText;
			
				//alert(results);
				
				$("#totalTimelineCommentNodes<?php echo $nodeId; ?>").remove();
				$(".timeline_comments_box<?php echo $nodeId; ?>").append(results);				
				
				//$("#totalTalkNodes<?php echo $this->uri->segment(3);?>").remove();
			
				//$("#talk_msg<?php echo $this->uri->segment(3);?>").append(results);
				//Add SetTimeOut 
				//setTimeout("postCommentRefresh<?php echo $nodeId;?>('<?php echo $nodeId;?>')", 10000);
				
		}
		
	}
	if(http2.status === 0)
	{
		//document.getElementById('talk_msg<?php //echo $this->uri->segment(3);?>').innerHTML += http2.responseText+'aborted';
	}
}

</script>
<input type="hidden" id="totalTimelineCommentNodes<?php echo $nodeId; ?>" value="<?php echo implode(',',$totalTimelineCommentNodes);?>">