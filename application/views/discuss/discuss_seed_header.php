<?php 
	$typeForActive = $this->uri->segment(1);
	$nodeType = $this->uri->segment(2);
	$option = $this->uri->segment(7);
?>
<div class="commonSeedHeader">
  	<ul>
    	<li>
    		<a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('disucssion');?>" >
    			<?php 
				if(($typeForActive=='view_chat' && $option==1) || ($typeForActive=='view_chat' && $nodeType=='node1' && $option=='') || ($typeForActive=='view_chat' && $option=='' && $option!=2 && $option!=3 && $option!=4 && $option!=5))
				{ 
				?>
					<img src="<?php echo base_url();?>images/tab-icon/discuss-view-sel.png"  class="seedTopMenuBar" />
				<?php
				}
				else
				{
				?>
					<img src="<?php echo base_url();?>images/tab-icon/discuss-view.png"  class="seedTopMenuBar" />
				<?php
				}
				?>
    		</a>
    	</li>
    	<li class="time-view-o">
    		<a onclick="getTimelineData('<?php echo $workSpaceId;?>', '<?php echo $workSpaceType;?>', '<?php echo $treeId;?>', 'discuss','<?php echo $option;?>')" title="<?php echo $this->lang->line('txt_Timeline');?>">
    			<?php 
				if($typeForActive=='tree_timeline')
				{ 
				?>
					<img src="<?php echo base_url();?>images/timeline_icon_sel.png"  class="seedTopMenuBar" />
				<?php
				}
				else
				{
				?>
					<img src="<?php echo base_url();?>images/timeline_icon_new.png"  class="seedTopMenuBar" />
				<?php
				}
				?>
    		</a>
    	</li>

    	<?php 
    	if($typeForActive=='view_chat' && $nodeType=='node1')
    	{
    	?>
	    	<li class="stop-time-view">
	    		<a href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Time');?>">
	    			<?php 
					if($typeForActive=='view_chat' && $nodeType=='node1' && $option=='4')
					{ 
					?>
						<!-- <img src="<?php echo base_url();?>images/tab-icon/time-view-sel.png"  class="seedTopMenuBar" /> -->
						<img src="<?php echo base_url();?>images/tab-icon/real_time_icon_sel.png"  class="seedTopMenuBar" />
					<?php
					}
					else
					{
					?>
						<!-- <img src="<?php echo base_url();?>images/tab-icon/time-view.png"  class="seedTopMenuBar" /> -->
						<img src="<?php echo base_url();?>images/tab-icon/real_time_icon.png"  class="seedTopMenuBar" />
					<?php
					}
					?>
	    		</a>
	    	</li>
	    <?php
		}
		else
		{
		?>
	    	<li class="time-view-o">
	    		<a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/2" title="<?php echo $this->lang->line('txt_Real_Time');?>">
	    			<?php 
					if($typeForActive=='view_chat' && $option==2)
					{ 
					?>
						<!-- <img src="<?php echo base_url();?>images/tab-icon/time-view-sel.png"  class="seedTopMenuBar" /> -->
						<img src="<?php echo base_url();?>images/tab-icon/real_time_icon_sel.png"  class="seedTopMenuBar" />
					<?php
					}
					else
					{
					?>
						<!-- <img src="<?php echo base_url();?>images/tab-icon/time-view.png"  class="seedTopMenuBar" /> -->
						<img src="<?php echo base_url();?>images/tab-icon/real_time_icon.png"  class="seedTopMenuBar" />
					<?php
					}
					?>
	    		</a>
	    	</li>
	    <?php
		}
		?>
    	
	    <?php
		if (($workSpaceId==0))
		{
		?>
			<?php 
	    	if($typeForActive=='view_chat' && $nodeType=='node1')
	    	{
	    	?>
				<li class="share-view">
				 	<a href="<?php echo base_url()?>view_chat/node1/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" >
				 		<?php 
						if($typeForActive=='view_chat' && $option==5)
						{ 
						?>
							<img src="<?php echo base_url();?>images/share_sel_16_16.png"  class="seedTopMenuBar" />
						<?php
						}
						else
						{
						?>
							<img src="<?php echo base_url();?>images/share_icon_16_16.png"  class="seedTopMenuBar" />
						<?php
						}
						?>
				 	</a>
				</li>

			<?php
			}
			else
			{
			?>

			    <li  class="share-view">
			    	<a href="<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/5" title="<?php echo $this->lang->line('txt_Share');?>" >
			    		<?php 
						if($typeForActive=='view_chat' && $option==5)
						{ 
						?>
							<img id="shareUpdateImage" src="<?php echo base_url();?>images/share_sel_16_16.png"  class="seedTopMenuBar" />
						<?php
						}
						else
						{
						?>
							<img id="shareUpdateImage" src="<?php echo base_url();?>images/share_icon_16_16.png"  class="seedTopMenuBar" />
						<?php
						}
						?>
			    	</a>
			    </li>
			<?php
			}
			?>
	    <?php
		}
		?>

		<!-- Added by Dashrath- check tree start or stop 1 for start and 0 for stop-->
    	<?php 
		if($arrDiscussionDetails["status"]==1)
		{
		?>
	    	<li id="treeUpdate" class="seedHeaderUpdateIcon">
	    		<img id="updateImage" title="<?php echo $this->lang->line('txt_Update');?>" src="<?php echo base_url()?>images/new-version.png" onclick="window.location=('<?php echo base_url()?>view_chat/chat_view/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1')" class="seedHeaderSyncIcon" >
	    	</li>
			<?php 
			/*Code for follow button*/
				$treeDetails['seedId']=$treeId;
				$treeDetails['treeName']='chat';	
				$this->load->view('follow_object',$treeDetails); 
			/*Code end*/
			?>	
		<?php
	    }
	    ?>
  	</ul>
  	<div class="clr"></div>
</div>