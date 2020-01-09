<?php if(count($notificationData)>0)
		{ 
			foreach($notificationData as $notification)
			{	
			?>
			<div class="notification_url">
			<a class="notificatonUrl" <?php if ($notification['notification_data']['url']!=''){ ?> href="<?php echo $notification['notification_data']['url']; ?>" <?php } ?> ><?php echo $notification['notification_data']['data']; ?></a>
			<p class="postTimeStamp"><?php echo $this->time_manager->getUserTimeFromGMTTime($notification['create_time'],$this->config->item('date_format')); ?></p>
			</div>
			<?php
			}
		}
?>
		