<?php 
	$typeForActive = $this->uri->segment(1);
	$option = $this->uri->segment(7);

	$day = date('d');
	$month 	= date('m');
	$year = date('Y'); 
?>
<div class="commonSeedHeader" >

    <ul>
		<li>
			<a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/1" title="<?php echo $this->lang->line('txt_Task');?>" >
			<?php 
			if($typeForActive=='view_task' &&  ($option==1 || $option ==''))
			{ 
			?>
				<img src="<?php echo base_url();?>images/icon_task_sel.png"  class="seedTopMenuBar" />
			<?php
			}
			else
			{
			?>
				<img src="<?php echo base_url();?>images/icon_task.png"  class="seedTopMenuBar" />
			<?php
			}
			?>
			</a>
		</li>

		<li class="time-view">
    		<a onclick="getTimelineData('<?php echo $workSpaceId;?>', '<?php echo $workSpaceType;?>', '<?php echo $treeId;?>', 'task')" title="<?php echo $this->lang->line('txt_Timeline');?>" >
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

		<li class="task-calendar">
			<a href="<?php echo base_url()?>calendar/index/1/<?php echo $day;?>/<?php echo $month;?>/<?php echo $year;?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/4/<?php echo $treeId;?>" title="<?php echo $this->lang->line('txt_Calendar');?>"  ><span></span>
			<?php 
			if($typeForActive=='calendar')
			{ 
			?>
				<img src="<?php echo base_url();?>images/tab-icon/cal-sel.png"  class="seedTopMenuBar" />
			<?php
			}
			else
			{
			?>
				<img src="<?php echo base_url();?>images/tab-icon/cal.png"  class="seedTopMenuBar" />
			<?php
			}
			?>
			</a>
		</li>

		
        <li class="task-search">
        	<a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/4" title="<?php echo $this->lang->line('txt_Task_Search');?>" >
        	<?php 
			if($typeForActive=='view_task' && $option==4)
			{ 
			?>
				<img src="<?php echo base_url();?>images/tab-icon/task-search_sel.png"  class="seedTopMenuBar" />
			<?php
			}
			else
			{
			?>
				<img src="<?php echo base_url();?>images/tab-icon/task-search.png"  class="seedTopMenuBar" />
			<?php
			}
			?>
        	</a>
       	</li>

    	<?php
		if (($workSpaceId==0))
		{
		?>
         	<li class="share-view">
         		<a href="<?php echo base_url()?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>/6" title="<?php echo $this->lang->line('txt_Share');?>">
         			
				<?php 
				if($typeForActive=='view_task' && $option==6)
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
		<li id="treeUpdate" class="update-view" title="<?php echo $this->lang->line('txt_Update_Version'); ?>" >
		</li>       

		<li style="float:right;" class="seedHeaderUpdateIcon">
			<img id="updateImage" title="<?php echo $this->lang->line('txt_Update');?>" src="<?php echo base_url()?>images/new-version.png" onclick='window.location="<?php echo base_url(); ?>view_task/node/<?php echo $treeId;?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType;?>"' class="seedHeaderSyncIcon" >
		</li>
		
		<?php 
		/*Code for follow button*/
			$treeDetails['seedId']=$treeId;
			$treeDetails['treeName']='task';	
			$this->load->view('follow_object',$treeDetails); 
		/*Code end*/
		?>
	</ul>
	<div class="clr"></div>
</div>