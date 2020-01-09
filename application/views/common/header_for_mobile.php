<?php $this->load->view('common/view_head.php');
?>
<meta name="apple-mobile-web-app-capable" content="yes" />
<!--Manoj: Reduced user scalable 0 from 1 -->
<!--<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=10.0; user-scalable=0;" />-->
<div id="header-container_for_mobile">
  <div id="header">
    <div id="left_for_mobile">
      <ul>
        <li id="logoImg"><a href="<?php echo base_url().'dashboard/index/'.$workSpaceId.'/type/1';?>" id="logoImgA"><img src="<?php echo base_url();?>images/logo1_for_mobile.png" style="width:21px;" /></a></li>
        <li><img src="<?php echo base_url();?>images/sep.png" /></li>
        <li>
          <?php   
		if (isset($_SESSION['userId']) && !isset($_SESSION['workPlacePanel']))
		{   
			$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceId);
			$workSpaceDetails 		= $this->identity_db_manager->getWorkSpaceDetailsByWorkSpaceId($workSpaceId);
			$workSpaces 			= $this->identity_db_manager->getAllWorkSpacesByWorkPlaceId( $_SESSION['workPlaceId'],$_SESSION['userId'] );
		?>
		 <select name="spaceSelect" id="spaceSelect" onChange="javascript:goWorkSpace(this);" class="selbox-min_for_mobile" >
            <?php 
		if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
		{
                    
		?>
        <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>
        <option value="0" <?php if($workSpaceId == 0) echo 'selected';?>><?php echo $this->lang->line('txt_My_Workspace');?></option>
        
        <?php
        $i = 1;

		foreach($workSpaces as $keyVal=>$workSpaceData)
		{				
			if($workSpaceData['workSpaceName']=='Learn Teeme'){
				$s=$keyVal;
			}
			else{
				if($workSpaceData['workSpaceManagerId'] == 0)
				{
					$workSpaceManager = $this->lang->line('txt_Not_Assigned');
				}
				else
				{					
					$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
					$workSpaceManager = $arrUserDetails['userName'];
				}
				
/*                              	if (($this->identity_db_manager->isPlaceManager($_SESSION['workPlaceId'],$_SESSION['userId']) == $_SESSION['userId']) && ($this->identity_db_manager->isDefaultPlaceManagerSpace($workSpaceData['workSpaceId'],$_SESSION['workPlaceId'])))
                                {  
                                    $enable_disable = '';
                                }*/
                                   
                                if (($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) || ($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) 
                                {    
                                    $enable_disable = '';
                                }
								else
								{
									//$enable_disable = 'disabled';
									$enable_disable = 'none';
								}
								if ($workSpaceData['status']>0)
								{
									 if ($this->identity_db_manager->isDefaultPlaceManagerSpace($workSpaceData['workSpaceId'],$_SESSION['workPlaceId']))
									 {
										if (($this->identity_db_manager->isPlaceManager($_SESSION['workPlaceId'],$_SESSION['userId']) == $_SESSION['userId']))
										{
											if($enable_disable!='none')
											{
								?>
											<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?> <?php echo $enable_disable;?>><?php echo $workSpaceData['workSpaceName'];?></option>	
								<?php	
											}
										}
									 }
									 else
									 {
									 	if($enable_disable!='none')
										{
									?>
									<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?> <?php echo $enable_disable;?>><?php echo $workSpaceData['workSpaceName'];?></option>
					<?php
										}
									}
								}
				$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
				//if(count($subWorkspaceDetails) > 0 && $workSpaceType == 1 && $workSpaceId > 0)
				//if(($workSpaceId > 0))
				if(count($subWorkspaceDetails) > 0)
				{
					foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
					{	
						if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
						{		
							if($workSpaceData['subWorkSpaceManagerId'] == 0)
							{
								$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
							}
							else
							{					
								$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
								$subWorkSpaceManager = $arrUserDetails['userName'];
							}
						}
						if ($workSpaceData['status']>0)
						{
							if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))
							{
						?>
						<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
						<?php
							}
						}
					}
				}
			}
		 }
		 //learn teeme check not applying working on it
		 if(isset($s)){
			$workSpaceData=$workSpaces[$s];
			if($workSpaceData['workSpaceManagerId'] == 0)
			{
				$workSpaceManager = $this->lang->line('txt_Not_Assigned');
			}
			else
			{					
				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
				$workSpaceManager = $arrUserDetails['userName'];
			}
			
				if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) || $this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))
				{
			?>
			<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>
			<?php	 
		 		}
		 }
	  }
	else
	{
	?>
            <?php /*?><option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option><?php */?>
            <?php
    $i = 1;

		foreach($workSpaces as $keyVal=>$workSpaceData)
		{				
			if($workSpaceData['workSpaceManagerId'] == 0)
			{
				$workSpaceManager = $this->lang->line('txt_Not_Assigned');
			}
			else
			{					
				$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
				$workSpaceManager = $arrUserDetails['userName'];
			}
			if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']) && $workSpaceData['status']>0)
			{
				if($workSpaceData['workSpaceId']!=1)
				{
			?>
				<option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>
				<?php
				}
			}
			$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
		
			if(count($subWorkspaceDetails) > 0)
			{
				foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
				{	
					if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
					{		
						if($workSpaceData['subWorkSpaceManagerId'] == 0)
						{
							$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
						}
						else
						{					
							$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
							$subWorkSpaceManager = $arrUserDetails['userName'];
						}
					}
					if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2) && $workSpaceData['status']>0)
					{
						?>
						<option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
						<?php
					}
				}
			}
		}
    
	}
    ?>
          </select>
		
        <?php /*?>  <select name="spaceSelect" id="spaceSelect" onChange="javascript:goWorkSpace(this);" class="selbox-min_for_mobile" >
            <?php 
	if($this->identity_db_manager->getUserGroupByMemberId($_SESSION['userId'])!=0)
	{
	?>
            <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
            <option value="0" <?php if($workSpaceId == 0) echo 'selected';?>><?php echo $this->lang->line('txt_My_Workspace');?></option>
            <?php
	$i = 1;

	foreach($workSpaces as $keyVal=>$workSpaceData)
	{				
		if($workSpaceData['workSpaceManagerId'] == 0)
		{
			$workSpaceManager = $this->lang->line('txt_Not_Assigned');
		}
		else
		{					
			$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
			$workSpaceManager = $arrUserDetails['userName'];
		}
		?>
            <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?><?php if (!($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId'])) && !($this->identity_db_manager->checkManager($_SESSION['userId'],$workSpaceData['workSpaceId'],3))) echo 'disabled';?>><?php echo $workSpaceData['workSpaceName'];?></option>
            <?php
		$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
		
			if(count($subWorkspaceDetails) > 0)
			{
				foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
				{	
					if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
					{		
						if($workSpaceData['subWorkSpaceManagerId'] == 0)
						{
							$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
						}
						else
						{					
							$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
							$subWorkSpaceManager = $arrUserDetails['userName'];
						}
					}
				?>
            <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?><?php if (!($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))) echo 'disabled';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
            <?php
				}
			}
	}
    }
	else
	{
	?>
            <option value=""><?php echo $this->lang->line('txt_Select_Workspace');?></option>
            <?php
    $i = 1;

	foreach($workSpaces as $keyVal=>$workSpaceData)
	{				
		if($workSpaceData['workSpaceManagerId'] == 0)
		{
			$workSpaceManager = $this->lang->line('txt_Not_Assigned');
		}
		else
		{					
			$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['workSpaceManagerId']);
			$workSpaceManager = $arrUserDetails['userName'];
		}
		if ($this->identity_db_manager->isWorkSpaceMember($workSpaceData['workSpaceId'],$_SESSION['userId']))
		{
		?>
            <option value="<?php echo $workSpaceData['workSpaceId'];?>" <?php if($workSpaceData['workSpaceId'] == $workSpaceId && $workSpaceType!=2) echo 'selected';?>><?php echo $workSpaceData['workSpaceName'];?></option>
            <?php
		}
		$subWorkspaceDetails 	= $this->identity_db_manager->getSubWorkSpacesByWorkSpaceId($workSpaceData['workSpaceId']);
	
			if(count($subWorkspaceDetails) > 0)
			{
				foreach($subWorkspaceDetails as $keyVal=>$workSpaceData)
				{	
					if (($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'])))	
					{		
						if($workSpaceData['subWorkSpaceManagerId'] == 0)
						{
							$subWorkSpaceManager = $this->lang->line('txt_Not_Assigned');
						}
						else
						{					
							$arrUserDetails = $this->identity_db_manager->getUserDetailsByUserId($workSpaceData['subWorkSpaceManagerId']);
							$subWorkSpaceManager = $arrUserDetails['userName'];
						}
					}
					if ($this->identity_db_manager->isSubWorkSpaceMember($workSpaceData['subWorkSpaceId'],$_SESSION['userId'],2))
					{
				?>
            <option value="s,<?php echo $workSpaceData['subWorkSpaceId'];?>" <?php if($workSpaceData['subWorkSpaceId'] == $workSpaceId && $workSpaceType==2) echo 'selected';?>><?php echo ' >>> <b>' .$workSpaceData['subWorkSpaceName'] .'</b>';?></option>
            <?php
					}
				}
			}
	}
    
	}
    ?>
          </select><?php */?>
          <?php
}
?>
        </li>
      </ul>
    </div>
    <div id="right_for_mobile">
      <ul>
       <?php /*?> <li id="imgUsername" style="display:none;">
          <?php
			if(isset($_SESSION['workPlaceManagerName']) && $_SESSION['workPlaceManagerName']!='' && $_SESSION['workPlacePanel'] != 1)
			{
			?>
          <a  href="<?php echo base_url();?>profile/index/<?php echo $_SESSION['userId'];?>/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>">
          <?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); 
	
			?>
          <?php if(isset($_SESSION['photo']) && $_SESSION['photo']!='noimage.jpg'){ ?>
          <img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >
          <?php } ?>
          <?php
			  echo $this->lang->line('txt_Hi').", ";	
			  
			  echo $_SESSION['firstName'] .' '.$_SESSION['lastName'] ; ?>
          </a>
          <?php
			}
			else if ($_SESSION['workPlacePanel'] == 1)
			{
			?>
          <?php if(isset($_SESSION['photo']) && $_SESSION['photo']!='noimage.jpg'){ ?>
          <img class="clsHeaderUserImage" src="<?php echo base_url();?>images/user_images/<?php echo $_SESSION['photo'];?>" >
          <?php } ?>
          <?php echo $this->lang->line('txt_Hi');?>,
          <?php $tmp = explode('@',$_SESSION['workPlaceManagerName']); echo ucfirst($tmp[0]);?>
          <?php
			}
			?>
        </li><?php */?>
         <?php
			
				if ($_SESSION['workPlacePanel'] == 1)
				{
			?>
        <?php /*?><li  class="unbordered"  style="padding-right:0px;"><?php echo "Hi , ".$_SESSION['workPlaceManagerName'];?> |</li><?php */?>
        <?php
				}?>
        <li class="unbordered notify_icon_for_mob" style="padding-right:15px;">
          
		  <?php
			
				if ($_SESSION['workPlacePanel'] == 1)
				{
			?>
          <a href="<?php echo base_url();?>admin/admin_logout/place_manager"><img class="log-out_image_for_mobile" src="<?php echo base_url();?>images/logout_for_mobile.png" style="padding-left:0px;" ></a>
          <?php	
				}
				else if(isset($_SESSION['userId']) && $_SESSION['userId']!='')
				{ 
			?>
			
			<!--For notification icon-->
					
					<?php /*?><a href="#" id="notificationLink" class="flLt">
				  	<img src="<?php echo base_url();?>images/notification.png" class="setting_img_for_mobile" title="Notification" style=""/>  
				  	</a>					
					<div id="notificationContainer">
					<div id="notificationTitle"><?php echo $this->lang->line('txt_notifications'); ?></div>
					<div id="notificationsBody" class="notifications">
						<div class="notificationContent">
							<?php echo $this->lang->line('txt_notification_not_found'); ?>
						</div>
					</div>
					<div id="notificationFooter"><a href="<?php echo base_url(); ?>notifications/settings/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>" style="color:#000;"><?php echo $this->lang->line('txt_see_all'); ?></a></div>
					</div><?php */?>
					
			<!--Notification icon end-->
			
			<!--For notification icon-->
					<?php //$temp=  (is_numeric($total_notification) && $total_notification>0)?$total_notification:"0"; ?>
					<div class="notify_box" style="float:left;">
					<a id="notificationLink" class="" onclick="seenAllNotification()">
				  	<img src="<?php echo base_url();?>images/notification.png" class="setting_img_for_mobile"  title="Notification" style="margin-top:0px;cursor:pointer;height:19px;border:0px;" />  
				  	</a>	
					<span class="button__badge" id='notificationCount' style="display:none;"><?php //echo $temp; ?></span>
					</div>				
					<div id="notificationContainer">
					<div id="notificationTitle"><?php echo $this->lang->line('txt_notifications'); ?></div>
					<div id="allNotificationData">
					<div id="notificationsBody" class="notifications">
						<div class="notificationContent">
							<div class="notifyLoader"></div>
							<?php /*if(count($notificationData)>0)
							{ 
							 	foreach($notificationData as $notification)
								{	
									?>
									<div class="notification_url">
										<?php echo $notification['notification_data']; ?>
									</div>
									<?php
								}
							?>
							<?php }
							else { ?>
							<?php echo $this->lang->line('txt_notification_not_found');
							}*/
							 ?>
						</div>
					</div>
					<?php /*?><span id="loading"><img src="<?php echo base_url();?>images/loader-64x/ajax-loader.gif"  style="margin:4px; cursor:pointer; height:12px; border:0px;" /> </span><?php */?>
					</div>
					<div id="notificationFooter"><a href="<?php echo base_url(); ?>notifications/setDispatchNotification/<?php echo $workSpaceId;?>/<?php echo $workSpaceType; ?>" style="color:#000;"><?php echo $this->lang->line('txt_see_all'); ?></a></div>
					</div>
					
					<!--Notification icon end-->
			
			<!--Manoj: added task calendar icon-->
			<?php /*?><a href="<?php echo base_url();?>calendar/index/1/<?php echo date("d/m/Y"); ?>/<?php echo $workSpaceId;?>/<?php echo $workSpaceType;?>/0/0" class="flLt">
          		<img src="<?php echo base_url();?>images/task_calendar.png"  class="setting_img_for_mobile" title="Calendar"  />  
          	</a> 
		    <!--Task icon view end-->
			
            <a href="<?php echo base_url();?>preference/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>" id="config" class="flLt">
          <img src="<?php echo base_url();?>images/settings.png"  title="Preferences" class="setting_img_for_mobile"  />  
          </a> 
          <!--Manoj: Replace admin with instance in logout url-->
          <a href="<?php echo base_url();?>instance/admin_logout/work_place"  class="flLt"><span id="logoutTxt" style="display:none;"><?php echo $this->lang->line('txt_Sign_Out');?></span> <img class="log-out_image_for_mobile" src="<?php echo base_url();?>images/logout_for_mobile.png" ></a><?php */?>
          
          <?php
				}
				
				$def = ($this->uri->segment(1)=='manage_workplace' || $this->uri->segment(1)=='edit_workspace')?1:(($this->uri->segment(1)=='create_workspace')?2:(($this->uri->segment(1)=='view_workplace_members' || $this->uri->segment(1)=='edit_workplace_member')?3:(($this->uri->segment(1)=='add_workplace_member')?4:($this->uri->segment(1)=='metering')?5:6)));
			?>
        </li>
      </ul>
    </div>
    <div class="clr"></div>
	<!--Timeline post icon start-->
			
				<?php /*?><a href="<?php echo base_url();?>post/index/<?php echo $workSpaceId;?>/type/<?php echo $workSpaceType; ?>/<?php echo $workSpaceId; ?>/<?php echo $workSpaceType; ?>">
				  	<img src="<?php echo base_url();?>images/post_notify.png"  title="Post" style="cursor:pointer;height:26px;border:0px;" /> 
				</a><?php */?>
			
			<!--Timeline post icon end-->
  </div>
</div>
<div style="">
  <div id="divMessageNotification" style="float:right; margin-left:10px;">&nbsp;</div>
  <div id="wallAlert" style="float:right;margin-left:10px;">&nbsp;</div>
</div>
<br />
  <script type="text/javascript">
$(document).ready(function() {
    $('#jsddm4').jcarousel({
		start:<?php echo $def;?>,
		visible:3,
		scroll:1,
	});
		window.addEventListener("orientationchange", function() {
	});
});

</script> 