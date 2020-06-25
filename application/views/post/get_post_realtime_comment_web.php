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
								if ($TimelineProfileCommentdetail['photo']!='')
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
		<p><a style="color:#000;" href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>/0/0/<?php echo $TimelineProfileCommentdetail['userId']; ?>"><b><?php echo strip_tags($TimelineProfileCommentdetail['userTagName'],'<b><em><span><img>'); ?></b></a></p>
		<p class="postCommentTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format')); ?></p>
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
	              <?php  echo $arrDiscussions['contents'];?>
	            </span>
	            <span id="delete_content_show_<?php echo $arrDiscussions['leafId'];?>" style="display: none;" class="clearedLeafContent">
		    		<?php echo $this->lang->line('txt_content_deleted'); ?>
		    	</span>
            </div>
            <!-- display none -->

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
			<!-- delete button end-->
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
				
				
		}		
}
?>
<input type="hidden" id="totalTimelineCommentNodes<?php echo $nodeId; ?>" value="<?php echo implode(',',$totalTimelineCommentNodes);?>">