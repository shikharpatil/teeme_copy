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

				while($counter < count($sArray))
				{
					$arrDiscussions	= $this->chat_db_manager->getPerentInfo($sArray[$counter]);	
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
					else{
						$nodeBgColor = "postWebChatBoxOthers";
					}	 		
					?>
			<?php $realTimeTimelineCommentDivIds=explode(",",$realTimeTimelineDivIds); 
			//print_r($realTimeTimelineCommentDivIds); echo $arrDiscussions['nodeId']; exit;
			if(!in_array($arrDiscussions['nodeId'],$realTimeTimelineCommentDivIds))	
			{
				if($_SESSION['userId']==$arrDiscussions['userId'] && $reatTimeStatus=='false')
				{
			?>		
			<!--<div id="<?php echo $position++;?>" style="width:94%;float:left;padding-left:0%;padding-top:20px;" onClick=""  class="<?php echo $nodeBgColor."1";?> handCursor">-->
			<div id="comment<?php echo $arrDiscussions['nodeId'];?>" class="<?php echo $nodeBgColor;?>">
		  	
			 <!--Add comment profile pic start-->
  <div class="commentUserName">
  <div>
  <div class="flLt">
							<?php
								if ($TimelineProfileCommentdetail['photo']!='noimage.jpg' && $TimelineProfileCommentdetail['photo']!='')
								{
							?>
									<img class="rounded_profile_pic"  src="<?php echo base_url();?>workplaces/<?php echo $workPlaceDetails['companyName'];?>/user_profile_pics/<?php echo $TimelineProfileCommentdetail['photo'];?>" border="0"  width="35" height="35" id="imgName"> 
                          	<?php
								}
								else
								{
							?>
									<img class="rounded_profile_pic"  src="<?php echo base_url();?>images/noimage.jpg" border="0"  width="35" height="35" id="imgName"> 
							<?php
								}
							?>
	</div>
	<div style="float:left; margin-left:5px; font-size:0.8em;">
		<div><b><?php echo strip_tags($TimelineProfileCommentdetail['userTagName'],'<b><em><span><img>'); ?></b></div>
		<div class="postCommentTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format')); ?></div>
	</div>
	</div>
	<div>
			
	</div>
	</div>
	
  	<!--Add comment profile pic end-->
		  	
		<div id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>' class="contentContainer <?php //echo ($viewTags[0]['systemTag']==1)?$viewTags[0]['tagName']."_systemTag":"";?>  commentUserNameContents"  style="font-size:0.8em;text-align:justify; width:68%; overflow:hidden;" >
              <?php  echo $arrDiscussions['contents'];?>
        </div>
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
							<!-- Nested comment end 01-->
							<!-- delete button start 03 -->
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
							<!-- delete button end 03-->
		</div>
        <div class="clr"></div>
            
			
		 
           </div>
		   <div style="clear:both;"></div>
		  <?php  
		  		}
				//check realtime status
			} 
		  ?>
		  
          <?php
					$counter++;
					$j++;
				
				
		}		
}
?>
<?php ?><input type="hidden" id="totalTimelineCommentNodes<?php echo $nodeId; ?>" value="<?php echo implode(',',$totalTimelineCommentNodes);?>"><?php ?>