<?php
//Start showing of version history
?>
<div class="install_fail"></div>
<?php
if($version_history!='')
{
?>
        <p class="update_header"><?php echo $this->lang->line('update_history_txt'); ?></p>
		<span class="error cancelNotifyTxt"></span>
        <hr class="hr_dotted" />
        <div class="versionHistory" style="font-size:1.1em; width:100%;">
         <table width="100%">
		 <tr class="update_head"> 
            <td><?php echo $this->lang->line('version_number_txt'); ?></td>
            <td><?php echo $this->lang->line('update_date_txt'); ?></td>
            <td><?php echo $this->lang->line('update_result_txt'); ?></td>
			<td><?php echo $this->lang->line('notification_time_txt'); ?></td>
			<td><?php echo $this->lang->line('txt_Action'); ?></td>
         </tr>
          
            <?php 
	//print_r($version_history);
	
	foreach($version_history as $ver_number)
	{
		if($ver_number['updateResult']=='downloaded')
		{
			$version_no=$ver_number['versionNumber'];
		}
	}
	
	foreach($version_history as $ver_details)
	{
	?><tr class="update_detail">
            <td><?php echo $ver_details['versionNumber']; ?></td>
            <td><?php echo $this->time_manager->getUserTimeFromGMTTime($ver_details['updateDate'], 'm-d-Y h:i A');?></td>
            <td><?php if($ver_details['updateResult']=='downloaded'){echo 'downloaded';}else{ ?><span style="color:#099731"><?php echo $ver_details['updateResult'];?></span><?php } ?></td>
			<td><?php if($ver_details['notify_date']!='0000-00-00 00:00:00'){echo $this->time_manager->getUserTimeFromGMTTime($ver_details['notify_date'], 'm-d-Y h:i A');}else{echo '';} ?></td>
			
			<?php 
			
			if($ver_details['updateResult']=='downloaded')
			{
				?>
				<td>
				<span style="float:left; display:none;" <?php if($version_no==$ver_details['versionNumber']) { ?> class="no_install" <?php } ?> ><a onclick="install_update('<?php echo $ver_details['versionNumber']; ?>')" id="install_update1" >Install Now</a></span>
				<?php
				if($ver_details['notify']=='1')
				{
				?>
				<span style="float:left;width:60%;">
				<a class="install_option" onclick="cancel_notification('<?php echo $ver_details['versionNumber']; ?>')"><?php echo $this->lang->line('cancel_notification_txt'); ?></a>
				</span>
				<?php
				}
				?>
				</td>
				<?php
			} 
			else
			{
				//echo 'Installed';
			}
			?>
			
			</tr>
			
            <?php	
			
	}
?>
          </table>
        </div>
        <?php
}
else
{
?>
        <p><?php echo $this->lang->line('version_Record_Not_Found');?></p>
        <?php	
}
//End of version history
?>