<?php
			//print_r($realTimeTimelineDivIds);exit;
			$arrparent=  $this->chat_db_manager->getPerentInfo($nodeId);
			
			$rowColor3='rowColor3';
			$rowColor4='rowColor4';	
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
					
					if ($arrDiscussions['nodeId'] == $this->uri->segment(8))
						$nodeBgColor = 'nodeBgColorSelect';
					else
						$nodeBgColor = ($j % 2) ? $rowColor3 : $rowColor4;	 		
					?>
			<?php $realTimeTimelineCommentDivIds=explode(",",$realTimeTimelineDivIds); 
			//print_r($realTimeTimelineCommentDivIds); echo $arrDiscussions['nodeId']; exit;
			if(!in_array($arrDiscussions['nodeId'],$realTimeTimelineCommentDivIds))	
			{
			?>		
			<div id="<?php echo $position++;?>" style="width:100%;float:left;padding-left:0%;padding-top:20px;" onClick="clickNodesOptions(<?php echo $arrDiscussions['nodeId'];?>)"  class="<?php echo $nodeBgColor."1";?> handCursor" >
		  	
			 <!--Add comment profile pic start-->
  <div style="width:94%; word-wrap:break-word; padding:2%;" class="<?php echo $nodeBgColor;?>" >
  <div id='leaf_contents<?php echo $arrDiscussions['nodeId'];?>' style="float:left; width:100%; overflow:hidden;">
              <?php  echo $arrDiscussions['contents'];?>
  </div> 
  
  <div style="font-size:14px; padding-top:7%;" class="<?php echo $nodeBgColor;?> commenterTalk TalktxtComments">
		<?php /*?><p><b><?php echo strip_tags($TimelineProfileCommentdetail['firstName'].' '.$TimelineProfileCommentdetail['lastName'],'<b><em><span><img>'); ?></b></p><?php */?>
		<?php echo '<span>'.$userDetails['userTagName'].'</span>&nbsp;&nbsp;<span>'.$this->time_manager->getUserTimeFromGMTTime($arrDiscussions['DiscussionCreatedDate'],$this->config->item('date_format')).'</span>'; ?>
	</div>
	
	</div>
	
  	<!--Add comment profile pic end-->
		  	
		  
            <!-- display none -->
            <div class="clr"></div>
            
			
		 
           </div>
		  <?php  } ?>
		  <div style="clear:both;"></div>
          <?php
					$counter++;
					$j++;
				
				
		}		
}
?>
<input type="hidden" id="totalTimelineCommentNodes<?php echo $nodeId; ?>" value="<?php echo implode(',',$totalTimelineCommentNodes);?>">