<?php
			//print_r($realTimeTimelineDivIds);exit;
			//$arrparent=  $this->chat_db_manager->getPerentInfo($nodeId);
			
			//$rowColor3='rowColor3';
			//$rowColor4='rowColor4';	
			$j = 1;
			
			if($arrparent['successors'])
			{	
				$realTimeTimelineCommentDivIds = array();
				$totalTimelineCommentNodes = array();
				$sArray=array();
				$sArray=explode(',',$arrparent['successors']);
				//$sArray=array_reverse($sArray);
				$counter=0;
				// while($counter < count($sArray))
				// {
					// $arrDiscussions	= $this->chat_db_manager->getPerentInfo($sArray[$count]);	
					$latest=max($sArray);
					$arrDiscussions	= $this->chat_db_manager->getPerentInfo($latest);	
					$totalTimelineCommentNodes[] = $arrDiscussions['nodeId'];
					$TimelineProfileCommentdetail = $this->profile_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$totalNodes[] = $arrDiscussions['nodeId'];	 
					$userDetails	= $this->chat_db_manager->getUserDetailsByUserId($arrDiscussions['userId']);
					$checksucc 		= $this->chat_db_manager->checkSuccessors($arrDiscussions['nodeId']);				
					$this->chat_db_manager->insertDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);				 
					$viewCheck=$this->chat_db_manager->checkDiscussionLeafView($arrDiscussions['nodeId'],$_SESSION['userId']);
					/*
					if ($arrDiscussions['nodeId'] == $this->uri->segment(8))
						$nodeBgColor = 'nodeBgColorSelect';
					else
						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;	 
					*/	
					if ($arrDiscussions['userId']==$_SESSION['userId']){
						$nodeBgColor = "postWebChatBoxSelf";
					}
					elseif ($arrDiscussions['userId']>0){
						$nodeBgColor = "postWebChatBoxOthers";
					}
					else{
						$nodeBgColor = "postWebChatBoxSystem";
					}	
					?>
			<?php $realTimeTimelineCommentDivIds=explode(",",$realTimeTimelineDivIds); 
			//print_r($realTimeTimelineCommentDivIds); echo $arrDiscussions['nodeId']; exit;
			if(!in_array($arrDiscussions['nodeId'],$realTimeTimelineCommentDivIds))	
			{
				/*if($_SESSION['userId']!=$arrDiscussions['userId'] && $reatTimeStatus=='true')
				{*/
			?>
			<!--Changed by Dashrath- change width 94% to 100% in inline css-->		
			<!--<div id="<?php echo $position++;?>" style="width:100%;float:left;padding-left:0%;padding-top:20px;" onClick=""  class="<?php echo $nodeBgColor."1";?> handCursor">-->
			<div id="comment<?php echo $arrDiscussions['nodeId'];?>" class="<?php echo $nodeBgColor;?>">
		  	
			 <!--Add comment profile pic start-->
  <div style="width:30%;" class="commentUserName">
  <div>
  <div style="float:left;">
							<?php
								if ($TimelineProfileCommentdetail['photo']!='noimage.jpg' && $TimelineProfileCommentdetail['photo']!='')
								{
							?>
									<img class="rounded_profile_pic" src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="35" height="35" id="imgName"> 
                          	<?php
								}
								else
								{
							?>
									<img class="rounded_profile_pic" src="<?php echo base_url();?>images/noimage.jpg" border="0"  width="35" height="35" id="imgName"> 
							<?php
								}
							?>
	</div>
	<div style="float:left; margin-left:5px; font-size:0.8em;">
		<div><a style="color:#000;" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $TimelineProfileCommentdetail['userId']; ?>"><b><?php echo strip_tags($TimelineProfileCommentdetail['userTagName'],'<b><em><span><img>'); ?></b></a></div>
		<div class="postCommentTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format')); ?></div>
	</div>
	</div>
	<div>
			
	</div>
	</div>
	
  	<!--Add comment profile pic end-->
		  
		  <!--Added by Dashrath- clr div for image stretch issue-->
		  <div class="clr"></div>

		  <!--Changed by Dashrath- remove width:68% from div inline css for image stretch issue-->
		  <div id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>' class="contentContainer <?php //echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>  "  style="font-size:0.8em;text-align:justify; overflow:hidden;" >

			  	<span id="delete_content_hide_<?php echo $arrDiscussions['leafId'];?>" style="display: inline;">
				  <?php
					if ($arrDiscussions['predecessor']>0 && $arrDiscussions['predecessor']!=$nodeId)
					{
						?>
						<a onclick="focusComment('comment<?php echo $arrDiscussions['predecessor']; ?>',<?php echo $nodeId ;?>);" href="javascript:void(0);">>>quoted</a>
						<?php
					}
						// echo stripslashes($arrDiscussions['contents']);            ?>
	              <?php  echo $arrDiscussions['contents'];?>
	            </span>
	            <span id="delete_content_show_<?php echo $arrDiscussions['leafId'];?>" style="display: none;" class="clearedLeafContent">
		    		<?php echo $this->lang->line('txt_content_deleted'); ?>
		    	</span>
            </div>
            <!-- display none -->
			<div>
			<!-- Nested comment start 01 -->
			<span id="nestedCommentLeafSpan<?php echo $arrDiscussions['nodeId'];?>">
				<span id="nestedCommentLeafIcon<?php echo $arrDiscussions['leafId'];?>">
					<?php 
					if(($arrDiscussions['leafStatus'] != 'deleted'))
					{ 
					?>
						
						<a href="javascript:void(0)" onClick="openNestedCommentEditor('<?php echo $arrDiscussions['leafId']; ?>')" title="<?php echo $this->lang->line('txt_comment'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/subtask-icon_new.png" alt="<?php echo $this->lang->line("txt_comment"); ?>" title="<?php echo $this->lang->line("txt_comment"); ?>">
						</a>
						
					<?php 
					} 
					?>
				</span>
			</span>
            <!-- delete button start-->
      		<span class="postCommentDelete" id="deleteLeafSpan<?php echo $arrDiscussions['nodeId'];?>">
      			<span id="deleteLeafIcon<?php echo $arrDiscussions['leafId'];?>">
					<?php 
					if(($arrDiscussions['leafStatus'] != 'deleted') && ($arrDiscussions['userId'] == $_SESSION['userId']))
					{ 
					?>
						
						<a href="javascript:void(0)" onClick="deleteLeaf('<?php echo $arrDiscussions['leafId']; ?>','<?php echo $workSpaceId; ?>','<?php echo $workSpaceType; ?>','<?php echo $treeId; ?>', 'post_comment')" title="<?php echo $this->lang->line('txt_delete'); ?>" border="0" ><img src="<?php echo  base_url(); ?>images/trash.gif" alt="<?php echo $this->lang->line("txt_del"); ?>" title="<?php echo $this->lang->line("txt_delete"); ?>" border="0">
						</a>
						
					<?php 
					} 
					?>
				</span>
			</span>
			</div>
			<!-- delete button end-->
			<!-- Nested comment textarea start here-->
			<div id="nestedCommentTextBox<?php echo $arrDiscussions['nodeId']; ?>" class="CommentTextBox<?php echo $arrDiscussions['nodeId']; ?> commentEditorWrapper" style="display:none;">
				<!--Changed by Dashrath- add handCursor class in div for editor content line spacing issue-->
				<div class="handCursor">
				<textarea class="postCommentTextBox" name="replyTimelineComment<?php echo $arrDiscussions['nodeId']; ?>" id="replyTimelineComment<?php echo $arrDiscussions['nodeId']; ?>"></textarea>
				</div>
				<div style="margin-top:8px;">
				<input type="button" name="Replybutton" value="<?php echo $this->lang->line('txt_Comment');?>" onClick="insertPostComment('<?php echo $arrDiscussions['nodeId']; ?>','<?php echo $nodeId; ?>','1');" style="float:left;">
				<input type="reset" name="Cancelbutton" value="<?php echo $this->lang->line('txt_Cancel');?>" style="float:left; margin-left:1%;"  onclick="cancelPostEditor('<?php echo $arrDiscussions['nodeId']; ?>','1');">
				<input type="hidden" id="totalTimelineCommentNodes<?php echo $arrDiscussions['nodeId']; ?>" value="<?php echo implode(',',$totalTimelineCommentNodes);?>">
				<div class="clr"></div>
				<div id="commentLoader<?php echo $arrDiscussions['nodeId']; ?>"></div>
				</div>
			</div>
			<!--Nested comment end here-->
            <div class="clr"></div>
            
			
		 
           </div>
		   <div style="clear:both;"></div>
		  <?php  
		  		/*}*/
				//check real time status
			}
		  ?>
		  
          <?php
					$counter++;
					$j++;
				
				
		// }		
}
?>
<input type="hidden" id="totalTimelineCommentNodes<?php echo $nodeId; ?>" value="<?php echo implode(',',$totalTimelineCommentNodes);?>">