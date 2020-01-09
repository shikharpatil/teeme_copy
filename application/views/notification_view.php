<?php if($scroll==0) { ?>
<!--Added by Dashrath- Add if condition for hide div for load data on scroll -->
<div class="notificationContent" id="notificationContent">
<?php } ?>
		
		<?php if(count($notificationData)>0)
		{ 
			foreach($notificationData as $notification)
			{	
				$imgName='';
				$imageName='';
				
				if ($notification['treeType']==1) $imgName = 'document_tree.png'; 
				if ($notification['treeType']==3) $imgName = 'discuss_tree.png';	
				if ($notification['treeType']==4) $imgName = 'task_tree.png';	
				if ($notification['treeType']==6) $imgName = 'notes_tree.png';	
				if ($notification['treeType']==5) $imgName = 'contact_tree.png';
				if ($notification['treeType']=='' && $notification['objectId']=='3') $imgName = 'post_tree.png';
				if ($notification['objectId']=='8') $imgName = 'talk_tree.png';	
				if ($notification['objectId']=='14' || $notification['objectId']=='15' || $notification['objectId']=='16') $imgName = 'user.png';	
				if ($notification['objectId']=='9') $imgName = 'file_import.png';	
				if ($notification['objectId']=='5' && $notification['actionId']=='13') $imgName = '';	
				if ($notification['objectId']=='1') $imageName = 'tree_icon.png';
				if ($notification['objectId']=='2') $imageName = 'leaf_icon.png';
				if ($notification['objectId']=='4' || $notification['objectId']=='5' || $notification['objectId']=='6') $imageName = 'tag_icon.png';
				if ($notification['objectId']=='7') $imageName = 'link_icon.png';
				
				//echo $notification['tree_type_space_id'].'==';
				if($notification['tree_type_space_id']!='')
				{
					$spaceTreeDetails = $this->identity_db_manager->get_space_tree_type_id($notification['tree_type_space_id']);
				}
				//space tree code start
				/*if(in_array($notification['treeType'],$spaceTreeDetails) || $notification['tree_type_space_id']==0 || $notification['work_space_name']=='Try Teeme' || $notification['tree_type_space_id']=='') 
				{ */
				
				if($modeId=='6')
				{
					if($notification['personalize_status']==1)
					{
						
			?>
			<div class="notification_url notfi_<?php echo $notification['notification_dispatch_id']; ?>" onClick="notificationContentHighlight('<?php echo $notification['notification_dispatch_id'];?>')">
			
			<?php
			if($imageName!='')
			{/*
			?>
			<div style="margin-bottom:8px;">
			<img src="<?php echo base_url();?>images/tab-icon/<?php echo $imageName; ?>" />
			</div>
			<?php
			*/}
			?>
			
			<a class="notificatonUrl" <?php if ($notification['url']!=''){ ?> href="<?php echo base_url().$notification['url']; ?>" <?php } ?> target="_blank"><?php echo $notification['notification_data']; ?></a>
			<p class="postTimeStamp"><span><?php echo $this->time_manager->getUserTimeFromGMTTime($notification['create_time'],$this->config->item('date_format')); ?></span>
			<span>
			<?php
			if($imgName!='')
			{
			?>
			<?php /*?><img src="<?php echo base_url();?>images/tab-icon/<?php echo $imgName; ?>" class="notificationTreeIcon" /><?php */?>
			<?php
			}
			?>
			</span>
			<?php
			if($notification['work_space_name']!='')
			{
			?>
			<span class="notificationSpaceName"><?php echo $notification['work_space_name']; ?></span>
			<?php
			}
			?>
			<?php if($notification['personalize_status']==1){ ?> 
			<span style="margin-left:10px; padding:1px 4px; background:#294277; color:#fff;">
			<?php echo $this->lang->line('txt_personalize_email_notification'); ?>
			</span>
			<?php } ?>
			</p>
			</div>
			<?php
					}
				}
				else
				{
					?>
					<div class="notification_url notfi_<?php echo $notification['notification_dispatch_id']; ?>" id="<?php echo $notification['notification_dispatch_id']; ?>" onClick="notificationContentHighlight('<?php echo $notification['notification_dispatch_id'];?>')">
					
					<?php
					if($imageName!='')
					{/*
					?>
					<div style="margin-bottom:8px;">
					<img src="<?php echo base_url();?>images/tab-icon/<?php echo $imageName; ?>" />
					</div>
					<?php
					*/}
					?>
					
					<a class="notificatonUrl" <?php if ($notification['url']!=''){ ?> href="<?php echo base_url().$notification['url']; ?>" <?php } ?> target="_blank">
					<?php echo $notification['notification_data']; ?>
					</a>
					<p class="postTimeStamp">
					<span><?php echo $this->time_manager->getUserTimeFromGMTTime($notification['create_time'],$this->config->item('date_format')); ?></span>
					<span>
					<?php
					if($imgName!='')
					{
					?>
					<?php /*?><img src="<?php echo base_url();?>images/tab-icon/<?php echo $imgName; ?>" class="notificationTreeIcon" /><?php */?>
					<?php
					}
					?>
					</span>
					<?php
					if($notification['work_space_name']!='')
					{
					?>
					<span class="notificationSpaceName"><?php echo $notification['work_space_name']; ?></span>
					<?php
					}
					?>
					<?php if($notification['personalize_status']==1){ ?> 
					<span style="margin-left:10px; padding:1px 4px; background:#294277; color:#fff;"><?php echo $this->lang->line('txt_personalize_email_notification'); ?></span>
					<?php } ?></p>
					</div>
					<?php
				}
				//} //space tree type code end
			}
		?>
		<?php }
		else { ?>
		<?php echo $this->lang->line('txt_notification_not_found');
		}
		?>
<?php if($scroll==0) { ?>
<!--Added by Dashrath- Add if condition for hide div for load data on scroll -->		
</div>
<?php } ?>