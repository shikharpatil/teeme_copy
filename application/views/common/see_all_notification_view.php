<div>
		<span id="notRightSideBarCloseIcon" onclick="hideNotificationSidebar()"><img src="<?php echo  base_url(); ?>images/close.png"></span>
</div>
<!--Manoj: notification tab start from here-->
<div id="notificationSection">

	<!--Added by Dashrath- used for notification content heighlight-->
	<input type="hidden" name="previousNotficationClickId" id="previousNotficationClickId" value="0" />
	<input type="hidden" name="dataType" id="dataType" value="notification" />
	<!--Dashrath- code end-->

	<div class="notification_head">
		<h2><?php echo $this->lang->line('txt_your_notification'); ?></h2>
	</div>
	
	<!--Workspace list start here-->
	<div style="height:50;margin-top: 0px;" class="prof_txt">
	
	<?php /*?> <div class="prof_left" style="width:0% !important; float:left; margin: 18px 6px 15px 0; " align="left"><?php //echo $this->lang->line('txt_Select_Workspace');?></div><?php */?>
<?php 		

if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

{

?>
          <div style="float:left; height:30px;">

       	<?php
		
		//$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);

		//$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);

		//$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
		
		//print_r($workSpaces);
		//print_r($notificationSpaces);
		//exit;
		?>

      <select name="spaceSelect" class="selbox-min" style="padding:0px; width: 140px;" id="spaceNotifications" onchange="getSpaceNotifications()">

        

        <option value=""><?php echo $this->lang->line('txt_all_space');?></option>

       <?php /*?> <option value="0"><?php echo $this->lang->line('txt_My_Workspace');?></option><?php */?>

<?php

	$i = 1;

	foreach($notificationSpaces as $keyVal=>$workSpaceData)
	{	
			if($workSpaceData['workSpaceType']=='1')
			{
				if($workSpaceData['workSpaceId']==0)
				{
					$workspacename['workSpaceName']= $this->lang->line('txt_My_Workspace');
				}
				else
				{
					$workspacename=$this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceData['workSpaceId']);
				}
				?>
				<option value="<?php echo $workSpaceData['workSpaceId'];?>" ><?php echo $workspacename['workSpaceName'];?></option>
				<?php
			}
			else if($workSpaceData['workSpaceType']=='2')
			{
				$subworkspacename=$this->identity_db_manager->getSubWorkSpaceDetailsBySubWorkSpaceId($workSpaceData['workSpaceId']);
				?>
				<option value="<?php echo $workSpaceData['workSpaceId'];?>" ><?php echo $subworkspacename['subWorkSpaceName'];?></option>
				<?php
			}			

	}


?>

      </select>

          </div>
		  <?php  } ?>

    	</div>
		
	<div style="height:50;margin-top: 0px;" class="prof_txt">
	
	 <div class="prof_left" style="width:0% !important; float:left; margin: 18px 6px 15px 0; " align="left"><?php //echo $this->lang->line('txt_select_notification_mode');?></div>

      <div style="float:left; height:30px;">

      <select name="modeSelect" class="selbox-min" style="padding:0px;width: 140px; <?php if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)

{ echo 'margin-left:5px'; } ?> " id="modeNotifications" onchange="getSpaceNotifications()">
			<!--Modes id 5=all 6=personalize-->
     		<option value="5"><?php echo $this->lang->line('txt_all_notification');?></option>
			<option value="6"><?php echo $this->lang->line('txt_personalize_email_notification');?></option>

      </select>
<!--id="modeNotifications" onchange="getSpaceNotifications()"-->
      </div>
	</div>
	<div class="clr"></div>

	<!--Workspace list end here-->
	
	
	<div style="margin-top:20px; padding:0px !important" id="allNotificationsBody">
		<?php if(count($notificationData)>0)
		{ 
			foreach($notificationData as $notification)
			{	
				$imgName='';
				$imageName='';
				
				if ($notification['objectId']=='1') $imageName = 'tree_icon.png';
				if ($notification['objectId']=='2') $imageName = 'leaf_icon.png';
				if ($notification['objectId']=='4' || $notification['objectId']=='5' || $notification['objectId']=='6') $imageName = 'tag_icon.png';
				if ($notification['objectId']=='7') $imageName = 'link_icon.png';
				
				if($notification['tree_type_space_id']!='')
			{
				$spaceTreeDetails = $this->identity_db_manager->get_space_tree_type_id($notification['tree_type_space_id']);
			}
			//space tree code start
			/*if(in_array($notification['treeType'],$spaceTreeDetails) || $notification['tree_type_space_id']==0 || $notification['work_space_name']=='Try Teeme' || $notification['tree_type_space_id']=='') 
			 {*/
			?>
			<div class="all_notification_url notfi_<?php echo $notification['notification_dispatch_id']; ?>" id="<?php echo $notification['notification_dispatch_id']; ?>" onClick="notificationContentHighlight('<?php echo $notification['notification_dispatch_id'];?>')">
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
			<p class="postTimeStamp">
			<span>
			<?php echo $this->time_manager->getUserTimeFromGMTTime($notification['create_time'],$this->config->item('date_format')); ?>
			</span>
			<?php
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
						
			?>
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
				<?php  echo $this->lang->line('txt_personalize_email_notification'); ?>
			</span>
			<?php } ?>
			</p>
			</div>
			<?php 
			//}
			}
		?>
		<?php }
		else 
		{ ?>
			<?php echo $this->lang->line('txt_notification_not_found');
		}
		?>
	</div>

	<!-- Added by Dashrath- Add div for scroll loader-->
	<div class="scrollNotifyLoader"></div>

</div>
<!--Manoj: notification tab end here-->