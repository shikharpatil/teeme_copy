<?php 
if(count($draftLeafs) > 0) 
{
?>
<div>
	<span id="notRightSideBarCloseIcon" onclick="hideNotificationSidebar()"><img src="<?php echo  base_url(); ?>images/close.png"></span>
</div>
<div class="notfiDivBot">
	<!--Added by Dashrath- used for leaf content heighlight-->
	<input type="hidden" name="previousClickId" id="previousClickId" value="0" />
	<input type="hidden" name="previousLeafContentId" id="previousLeafContentId" value="0" />
	<input type="hidden" name="previousPredecessorId" id="previousPredecessorId" value="0" />
	<input type="hidden" name="dataType" id="dataType" value="draftleaf" />
	<!--Dashrath- code end-->

	<div>
		<p class="draftContentHeading">
			<?php echo $this->lang->line('txt_Your_Drafts');?>
		</p>
	</div>
	<div class="rightSideContentDiv">
		<?php
		$i=1;
		foreach($draftLeafs as $draftLeafDetail)
		{
		?>
			<div class="all_notification_url timelineHandCursor" id="draft_leaf_content_<?php echo $i;?>" <?php if ($draftLeafDetail->nodeId1 > 0){ ?> onClick="draftLeafContentHighlight('<?php echo $draftLeafDetail->nodeId1;?>', '<?php echo $i; ?>')" <?php } ?>>
				<a class="timelineContentClick" >
					
					<?php
					if($draftLeafDetail->contents != '')
					{
						$leafContents = $this->identity_db_manager->getDraftLeafTitleContent($draftLeafDetail->contents);

						echo $leafContents; 
					}
					?>
				</a>

				<p class="postTimeStamp">
					<span>
						<?php echo $this->time_manager->getUserTimeFromGMTTime($draftLeafDetail->createdDate,$this->config->item('date_format')); ?>
					</span>
				</p>
			</div>
		<?php
		$i++;
		}
		?>
	</div>	
</div>

<?php 
}
else
{
	echo 0;
}
?>
  	
